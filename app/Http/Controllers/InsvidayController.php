<?php
namespace App\Http\Controllers;

use App\Models\InsvidayRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InsvidayController extends Controller
{
    public function show(Request $request)
    {
        $reg  = \App\Models\InsvidayRegistration::where('user_id', $request->user()->id)->first();
        $step = $reg ? ($reg->status === 'approved' ? 3 : 2) : 1;

        // Daftar tanggal (sekaligus penanda dibuka/ditutup)
        $dates = [
            // BATCH 1 (dibuka)
            ['date' => '2025-11-08', 'label' => '8 November 2025', 'open' => true],
            ['date' => '2025-11-09', 'label' => '9 November 2025', 'open' => true],
            // BATCH 2 (ditutup)
            ['date' => '2025-11-29', 'label' => '29 November 2025', 'open' => false],
            ['date' => '2025-11-30', 'label' => '30 November 2025', 'open' => false],
            // BATCH 3 (ditutup)
            ['date' => '2025-12-20', 'label' => '20 Desember 2025', 'open' => false],
            ['date' => '2025-12-21', 'label' => '21 Desember 2025', 'open' => false],
        ];

        // Map tanggal -> link WA (kalau mau beda per “batch”)
        $waByDate = [
            '2025-10-25' => 'https://its.id/m/INSVIDAY2026Batch1',
            '2025-10-26' => 'https://its.id/m/INSVIDAY2026Batch1',
            '2025-11-29' => 'https://its.id/m/INSVIDAY2026Batch2',
            '2025-11-30' => 'https://its.id/m/INSVIDAY2026Batch2',
            '2025-12-20' => 'https://its.id/m/INSVIDAY2026Batch3',
            '2025-12-21' => 'https://its.id/m/INSVIDAY2026Batch3',
        ];

        // Tentukan link WA untuk user (kalau sudah pilih visit_date & approved)
        $waLink = $reg && $reg->visit_date
            ? ($waByDate[$reg->visit_date->format('Y-m-d')] ?? null)
            : null;

        return view('events.insviday', compact('reg','step','dates','waLink'));
    }

public function apply(Request $request)
{
    $userId = $request->user()->id;

    if (\App\Models\InsvidayRegistration::where('user_id', $userId)->exists()) {
        return redirect()->route('events.insviday')->with('status','Kamu sudah mendaftar. Menunggu verifikasi admin.');
    }

    // Daftar tanggal yang diizinkan + mana yang terbuka
    $allowed = [
        '2025-11-08' => true,  // open
        '2025-11-09' => true,  // open
        '2025-11-29' => false, // closed
        '2025-11-30' => false, // closed
        '2025-12-20' => false, // closed
        '2025-12-21' => false, // closed
    ];

    $data = $request->validate([
        'full_name'      => ['required','string','max:120'],
        'whatsapp'       => ['required','regex:/^62[0-9]{6,15}$/'],
        'school'         => ['required','string','max:150'],
        'visit_date'     => ['required','date'],
        'payment_method' => ['required','in:ShopeePay,BRI,BCA,QRIS,Lainnya'],
        'payment_proof'  => ['required','image','mimes:jpg,jpeg,png','max:5120'],
        'gdrive_link'    => ['required','url'],
    ]);

    $vd = \Illuminate\Support\Carbon::parse($data['visit_date'])->format('Y-m-d');

    // valid tanggal & status open
    if (!array_key_exists($vd, $allowed)) {
        return back()->withErrors(['visit_date'=>'Tanggal tidak valid.'])->withInput();
    }
    if ($allowed[$vd] === false) {
        return back()->withErrors(['visit_date'=>'Tanggal tersebut belum dibuka.'])->withInput();
    }

    // simpan bukti bayar
    $file = $request->file('payment_proof');
    $name = \Illuminate\Support\Str::of("INSVIDAY_BAYAR_{$data['full_name']}_{$data['school']}_{$vd}")
                ->ascii()->replace(' ','_')->append('.'.$file->getClientOriginalExtension());
    $path = $file->storeAs('public/insviday/payments', $name);

    \App\Models\InsvidayRegistration::create([
        'user_id'            => $userId,
        'full_name'          => $data['full_name'],
        'whatsapp'           => $data['whatsapp'],
        'school'             => $data['school'],
        'visit_date'         => $vd,
        'payment_method'     => $data['payment_method'],
        'payment_proof_path' => $path,
        'gdrive_link'        => $data['gdrive_link'],
        'status'             => 'pending',
    ]);

    return redirect()->route('events.insviday')->with('status','Pendaftaran terkirim. Menunggu verifikasi admin.');
    }
}
