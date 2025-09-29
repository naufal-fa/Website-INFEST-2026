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
        $fileName = 'insviday_registrations_'.now()->format('Ymd_His').'.csv';

        $query = InsvidayRegistration::query();

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($visit = $request->get('visit_date')) {
            $query->whereDate('visit_date', $visit);
        }

        $query->orderBy('created_at', 'asc');

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            // Header CSV
            fputcsv($out, [
                'ID','Nama','WA','Sekolah','Tanggal Kunjungan','Metode Bayar',
                'Status','Approved At','Approved By','GDrive','Bukti Pembayaran URL','Dibuat'
            ]);

            $query->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $r) {
                    fputcsv($out, [
                        $r->id,
                        $r->full_name,
                        $r->whatsapp,
                        $r->school,
                        optional($r->visit_date)->format('Y-m-d'),
                        $r->payment_method,
                        strtoupper($r->status),
                        optional($r->approved_at)->format('Y-m-d H:i:s'),
                        optional($r->approver)->name,
                        $r->gdrive_link,
                        $r->payment_proof_path ? url(str_replace('public/','storage/',$r->payment_proof_path)) : '',
                        $r->created_at?->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($out);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
