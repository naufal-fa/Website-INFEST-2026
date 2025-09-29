<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InsvidayRegistration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InsvidayAdminController extends Controller
{
    // GET /admin/insviday/registrations
    public function index(Request $request)
    {
        $query = InsvidayRegistration::query();

        // Filters
        if ($search = trim($request->get('q', ''))) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('school', 'like', "%{$search}%")
                  ->orWhere('whatsapp', 'like', "%{$search}%")
                  ->orWhere('gdrive_link', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($from = $request->get('from')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->get('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        if ($visit = $request->get('visit_date')) {
            $query->whereDate('visit_date', '=', $visit);
        }

        // Sort
        $sort = $request->get('sort', 'created_desc');
        match ($sort) {
            'created_asc'  => $query->orderBy('created_at', 'asc'),
            'visit_asc'    => $query->orderBy('visit_date', 'asc'),
            'visit_desc'   => $query->orderBy('visit_date', 'desc'),
            'name_asc'     => $query->orderBy('full_name', 'asc'),
            'name_desc'    => $query->orderBy('full_name', 'desc'),
            default        => $query->orderBy('created_at', 'desc'),
        };

        $regs = $query->paginate(20)->withQueryString();

        // Jika ingin gunakan Blade khusus admin, kirimkan $regs dan $filters
        return view('admin.insviday.index', [
            'regs' => $regs,
            'filters' => [
                'q' => $search ?? '',
                'status' => $status ?? '',
                'from' => $from ?? '',
                'to' => $to ?? '',
                'visit_date' => $visit ?? '',
                'sort' => $sort,
            ]
        ]);
    }

    // POST /admin/insviday/registrations/{id}/approve
    public function approve(InsvidayRegistration $registration, Request $request)
    {
        $registration->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $request->user()->id,
        ]);

        // (opsional) ubah role user jadi 'peserta' bila perlu:
        // $registration->user?->syncRoles(['peserta']);

        return back()->with('ok', 'Pendaftaran disetujui.');
    }

    // POST /admin/insviday/registrations/{id}/reject
    public function reject(InsvidayRegistration $registration, Request $request)
    {
        // (opsional) validasi alasan
        $request->validate([
            'reason' => ['nullable', 'string', 'max:500']
        ]);

        $registration->update([
            'status' => 'rejected',
            // (opsional) simpan catatan: tambah kolom reason jika ingin persist
            // 'reject_reason' => $request->input('reason')
        ]);

        return back()->with('ok', 'Pendaftaran ditolak.');
    }

    // GET /admin/insviday/registrations/export
    public function export(Request $request): StreamedResponse
    {
        $qStatus = $request->get('status');
        $qVisit  = $request->get('visit_date');
    
        $fileName = 'insviday_registrations_'.now()->format('Ymd_His').'.csv';
        $delimiter = ';'; // Excel-ID friendly
    
        $query = \App\Models\InsvidayRegistration::query()
            ->when($qStatus, fn($qq) => $qq->where('status', $qStatus))
            ->when($qVisit,  fn($qq) => $qq->whereDate('visit_date', $qVisit))
            ->orderBy('created_at', 'asc');
    
        return response()->streamDownload(function () use ($query, $delimiter) {
            $out = fopen('php://output', 'w');
    
            // Tulis BOM agar Excel deteksi UTF-8
            echo "\xEF\xBB\xBF";
    
            // Header kolom (urut rapi)
            $headers = [
                'No',
                'Nama Lengkap',
                'WhatsApp',
                'Sekolah',
                'Tanggal Kunjungan',
                'Metode Bayar',
                'Link GDrive',
                'URL Bukti Bayar',
                'Dibuat Pada',
            ];
            fputs($out, implode($delimiter, $headers)."\r\n");
    
            $rowNo = 0;
    
            $sanitize = function ($v) {
                // Hilangkan newline & sematkan trim
                $v = is_string($v) ? trim(preg_replace("/\s+/u", ' ', $v)) : $v;
                return $v;
            };
            $asText = function ($v) {
                // Agar “62xxxx” tidak jadi 6.2E+… di Excel
                if ($v === null || $v === '') return '';
                return '="'.str_replace('"', '""', $v).'"';
            };
            $urlPublic = function (?string $storagePath) {
                return $storagePath
                    ? url(str_replace('public/', 'storage/app/private/public/', $storagePath))
                    : '';
            };
            $dmy = function ($date) {
                return $date ? \Illuminate\Support\Carbon::parse($date)->format('d/m/Y') : '';
            };
            $dmyhis = function ($dateTime) {
                return $dateTime ? \Illuminate\Support\Carbon::parse($dateTime)->format('d/m/Y H:i') : '';
            };
    
            $query->chunk(500, function ($rows) use (&$rowNo, $out, $delimiter, $sanitize, $asText, $urlPublic, $dmy, $dmyhis) {
                foreach ($rows as $r) {
                    $rowNo++;
    
                    $fields = [
                        $rowNo,
                        $sanitize($r->full_name),
                        $asText($r->whatsapp), // Excel-safe
                        $sanitize($r->school),
                        $dmy($r->visit_date),
                        $sanitize($r->payment_method),
                        $sanitize($r->gdrive_link),
                        $urlPublic($r->payment_proof_path),
                        $dmyhis($r->created_at),
                    ];
    
                    // Tulis manual pakai delimiter agar seragam (bukan fputcsv default)
                    $line = collect($fields)->map(function ($v) use ($delimiter) {
                        // Escape delimiter & kutip ganda
                        $s = (string) $v;
                        if (str_contains($s, $delimiter) || str_contains($s, '"')) {
                            $s = '"'.str_replace('"', '""', $s).'"';
                        }
                        return $s;
                    })->implode($delimiter);
    
                    fputs($out, $line."\r\n");
                }
            });
    
            fclose($out);
        }, $fileName, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
            'Cache-Control'       => 'no-store, no-cache, must-revalidate, max-age=0',
        ]);
    }
}
