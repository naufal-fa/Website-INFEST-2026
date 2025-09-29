<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomeTeam;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IncomeAdminController extends Controller
{
    // GET /admin/income/registrations
    public function index(Request $request)
    {
        $q      = trim($request->get('q', ''));
        $status = $request->get('status');      // status registrasi tim (mis: pending/submitted/approved/rejected)
        $theme  = $request->get('subtheme');    // filter subtema submission
        $hasSub = $request->get('has_submission'); // yes/no (ada submission abstrak?)

        $query = IncomeTeam::query()
            ->with(['submission']) // eager-load submission
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('team_name', 'like', "%{$q}%")
                      ->orWhere('leader_name', 'like', "%{$q}%")
                      ->orWhere('leader_email', 'like', "%{$q}%")
                      ->orWhere('school', 'like', "%{$q}%");
                });
            })
            ->when($status, fn($qq) => $qq->where('status', $status))
            ->when($theme,  fn($qq) => $qq->whereHas('submission', fn($s) => $s->where('subtheme', $theme)))
            ->when($hasSub === 'yes', fn($qq) => $qq->whereHas('submission'))
            ->when($hasSub === 'no',  fn($qq) => $qq->doesntHave('submission'))
            ->orderByDesc('created_at');

        $regs = $query->paginate(20)->withQueryString();

        return view('admin.income.index', [
            'regs' => $regs,
            'filters' => compact('q','status','theme','hasSub'),
            'subthemes' => ['Renewable energy','Kesehatan','Sistem Otomasi','Pertanian','Lingkungan'],
        ]);
    }

    // GET /admin/income/registrations/export
    public function export(Request $request): StreamedResponse
    {
        $q      = trim($request->get('q', ''));
        $status = $request->get('status');
        $theme  = $request->get('subtheme');
        $hasSub = $request->get('has_submission');
    
        $fileName  = 'income_registrations_'.now()->format('Ymd_His').'.csv';
        $delimiter = ';';
    
        $query = \App\Models\IncomeTeam::query()
            ->with('submission')
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(function ($w) use ($q) {
                    $w->where('team_name', 'like', "%{$q}%")
                      ->orWhere('leader_name', 'like', "%{$q}%")
                      ->orWhere('leader_email', 'like', "%{$q}%")
                      ->orWhere('school', 'like', "%{$q}%");
                });
            })
            ->when($status, fn($qq) => $qq->where('status', $status))
            ->when($theme,  fn($qq) => $qq->whereHas('submission', fn($s) => $s->where('subtheme', $theme)))
            ->when($hasSub === 'yes', fn($qq) => $qq->whereHas('submission'))
            ->when($hasSub === 'no',  fn($qq) => $qq->doesntHave('submission'))
            ->orderBy('created_at','asc');
    
        return response()->streamDownload(function () use ($query, $delimiter) {
            $out = fopen('php://output', 'w');
    
            // BOM UTF-8
            echo "\xEF\xBB\xBF";
    
            // Header kolom
            $headers = [
                'No',
                'Nama Tim',
                'Ketua Tim',
                'Email Ketua',
                'WA Ketua',
                'Sekolah',
                'Subtema',
                'Judul Karya',
                'URL Abstrak',
                'URL Surat Komitmen',
                'Waktu Submit Abstrak',
                'Link Persyaratan',
                'Tanggal Daftar',
            ];
            fputs($out, implode($delimiter, $headers)."\r\n");
    
            $rowNo = 0;
    
            $sanitize = function ($v) {
                $v = is_string($v) ? trim(preg_replace("/\s+/u", ' ', $v)) : $v;
                return $v;
            };
            $asText = function ($v) {
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
                    $s = $r->submission;
    
                    $fields = [
                        $rowNo,
                        $sanitize($r->team_name),
                        $sanitize($r->leader_name),
                        $sanitize($r->leader_email),
                        $asText($r->leader_whatsapp),
                        $sanitize($r->school),
                        $sanitize($s->subtheme ?? ''),
                        $sanitize($s->title ?? ''),
                        $urlPublic($s->abstract_path ?? null),
                        $urlPublic($s->commitment_path ?? null),
                        $dmyhis($s->submitted_at ?? null),
                        $sanitize($r->requirements_link),
                        $dmyhis($r->created_at),
                    ];
    
                    $line = collect($fields)->map(function ($v) use ($delimiter) {
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