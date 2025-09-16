<?php

namespace App\Http\Controllers;

use App\Models\InsvidayRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InsvidayController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        // Konfigurasi batch & tanggal kunjungan (untuk dropdown)
        $batches = [
            'BATCH 1' => ['2025-11-01', '2025-11-02'],
            'BATCH 2' => ['2025-11-29', '2025-11-30'],
            // BATCH 3 menyusul: tanggal belum fix
        ];

        // Logika buka BATCH 3: muncul setelah BATCH 1 & 2 selesai (>= 2025-12-01 Asia/Jakarta)
        $showBatch3 = now('Asia/Jakarta')->greaterThanOrEqualTo('2025-12-01 00:00:00');

        $reg = InsvidayRegistration::where('user_id', $user->id)->first();

        // Tentukan step dari DB
        // step 1 = identitas, step 2 = upload, step 3 = selesai
        if (!$reg)           $initialStep = 1;
        elseif (!$reg->docs) $initialStep = 2;
        else                 $initialStep = 3;

        return view('events.insviday', compact('reg', 'initialStep', 'batches', 'showBatch3'));
    }

    public function register(Request $request)
    {
        $user = $request->user();

        // Cegah daftar ulang
        if (InsvidayRegistration::where('user_id', $user->id)->exists()) {
            return redirect()->route('events.insviday')->with('status', 'Kamu sudah mendaftar. Lanjut unggah dokumen.')->with('step', 2);
        }

        $data = $request->validate([
            'full_name'   => ['required','string','max:120'],
            'whatsapp'    => ['required','regex:/^62[0-9]{6,15}$/'],
            'school'      => ['required','string','max:150'],
            'batch'       => ['required','in:BATCH 1,BATCH 2,BATCH 3'],
            'visit_date'  => ['required','date'],
        ]);

        // Validasi tanggal sesuai batch
        $allowed = [
            'BATCH 1' => ['2025-11-01','2025-11-02'],
            'BATCH 2' => ['2025-11-29','2025-11-30'],
            'BATCH 3' => [], // TBA, tidak boleh dipilih sampai dibuka
        ];
        if (!in_array($data['visit_date'], $allowed[$data['batch']] ?? [], true)) {
            return back()->withErrors(['visit_date' => 'Tanggal kunjungan tidak sesuai batch yang dipilih.'])->withInput();
        }

        // Blokir pemilihan BATCH 3 sebelum waktunya
        $nowJkt = now('Asia/Jakarta');
        if ($data['batch'] === 'BATCH 3' && $nowJkt->lt('2025-12-01 00:00:00')) {
            return back()->withErrors(['batch' => 'Pendaftaran Batch 3 belum dibuka.'])->withInput();
        }

        $reg = InsvidayRegistration::create([
            'user_id'    => $user->id,
            'full_name'  => $data['full_name'],
            'whatsapp'   => $data['whatsapp'],
            'school'     => $data['school'],
            'batch'      => $data['batch'],
            'visit_date' => $data['visit_date'],
            'registered_at' => now(),
        ]);

        return redirect()->route('events.insviday')->with('status', 'Data identitas tersimpan. Silakan unggah dokumen.')->with('step', 2);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'payment_method'    => ['required','in:Transfer,Tunai,Lainnya'],
            'student_card'      => ['required','file','mimes:jpg,jpeg,png,pdf','max:5120'],
            'payment_proof'     => ['required','file','mimes:jpg,jpeg,png,pdf','max:5120'],
            'proof_follow_infest' => ['required','file','mimes:jpg,jpeg,png,pdf','max:5120'],
            'proof_follow_ti'     => ['required','file','mimes:jpg,jpeg,png,pdf','max:5120'],
        ]);

        $reg = InsvidayRegistration::where('user_id', Auth::id())->first();
        if (!$reg) {
            return redirect()->route('events.insviday')->withErrors(['reg'=>'Kamu belum mengisi identitas pendaftaran.'])->with('step',1);
        }

        $mk = fn($prefix, $file) =>
            preg_replace('/\s+/u','_',
                preg_replace('/[^\pL\pN _.-]+/u','',
                    "{$prefix}_{$reg->full_name}_{$reg->school}_{$reg->batch}"
                )
            ).'.'.strtolower($file->getClientOriginalExtension());

        $p1 = $request->file('student_card')->storeAs('public/insviday/student_cards', $mk('KARTU_PELAJAR', $request->file('student_card')));
        $p2 = $request->file('payment_proof')->storeAs('public/insviday/payments',     $mk('BUKTI_PEMBAYARAN', $request->file('payment_proof')));
        $p3 = $request->file('proof_follow_infest')->storeAs('public/insviday/social', $mk('FOLLOW_INFEST', $request->file('proof_follow_infest')));
        $p4 = $request->file('proof_follow_ti')->storeAs('public/insviday/social',     $mk('FOLLOW_TI', $request->file('proof_follow_ti')));

        $reg->docs = [
            'student_card'  => $p1,
            'payment_proof' => $p2,
            'follow_infest' => $p3,
            'follow_ti'     => $p4,
        ];
        $reg->payment_method = $request->input('payment_method');
        $reg->docs_submitted_at = now();
        $reg->save();

        // (opsional) jadikan peserta:
        // $request->user()->syncRoles(['peserta']);

        if ($request->expectsJson()) {
            return response()->json(['ok'=>true]);
        }

        return redirect()->route('events.insviday')->with('status', 'Dokumen berhasil diunggah.')->with('step',3);
    }
}
