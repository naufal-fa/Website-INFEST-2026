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

        $query = IncomeRegistration::query()
            ->with(['submission'])
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

        $fileName = 'income_registrations_'.now()->format('Ymd_His').'.csv';

        return response()->streamDownload(function () use ($query) {
            $out = fopen('php://output', 'w');
            fputcsv($out, [
                'ID','Team','Leader','Email','WA','Sekolah','Status Tim',
                'Subtema','Judul Karya','Abstrak URL','Komitmen URL','Submitted At',
                'Requirements Link','Created At'
            ]);

            $query->chunk(500, function ($rows) use ($out) {
                foreach ($rows as $r) {
                    $s = $r->submission;
                    fputcsv($out, [
                        $r->id,
                        $r->team_name,
                        $r->leader_name,
                        $r->leader_email,
                        $r->leader_whatsapp,
                        $r->school,
                        strtoupper($r->status ?? 'N/A'),
                        $s->subtheme ?? '',
                        $s->title ?? '',
                        $s?->abstract_path ? url(str_replace('public/','storage/',$s->abstract_path)) : '',
                        $s?->commitment_path ? url(str_replace('public/','storage/',$s->commitment_path)) : '',
                        $s?->submitted_at?->format('Y-m-d H:i:s'),
                        $r->requirements_link,
                        $r->created_at?->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($out);
        }, $fileName, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}