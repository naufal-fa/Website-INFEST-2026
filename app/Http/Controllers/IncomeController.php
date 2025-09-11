<?php

namespace App\Http\Controllers;

use App\Models\IncomeTeam;
use App\Models\IncomeAbstract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IncomeController extends Controller
{
    // Tampilkan halaman dengan step sesuai status DB
    public function show(Request $request)
    {
        $userId = Auth::id();
        $team = IncomeTeam::with('submission')->where('user_id', $userId)->first();

        // Hitung step dari DB
        if (!$team) {
            $initialStep = 1;
        } elseif (!$team->submission) {
            $initialStep = 2;
        } else {
            $initialStep = 3;
        }

        // Simpan team_id ke session agar form step 2 aman dipakai
        if ($team) {
            $request->session()->put('income_team_id', $team->id);
        }

        return view('events.income', compact('initialStep', 'team'));
    }

    // Step 1: pendaftaran
    public function register(Request $request)
    {
        $userId = Auth::id();

        // Jika sudah ada tim untuk user ini → tolak re-register
        $existing = IncomeTeam::where('user_id', $userId)->first();
        if ($existing) {
            return redirect()
                ->route('events.income')
                ->with('status', 'Kamu sudah mendaftar. Lanjutkan ke unggah abstrak.')
                ->with('income_step', 2);
        }

        $data = $request->validate([
            'team_name'        => ['required','string','max:100','unique:income_teams,team_name'],
            'leader_name'      => ['required','string','max:100'],
            'member_name'      => ['nullable','string','max:100'],
            'school'           => ['required','string','max:150'],
            'leader_whatsapp'  => ['required','regex:/^62[0-9]{6,15}$/'],
            'leader_email'     => ['required','email','max:150','unique:income_teams,leader_email'],
            'requirements_link'=> ['required','url','max:255'],
        ]);

        $team = IncomeTeam::create($data + [
            'user_id'       => $userId,
            'registered_at' => now(),
        ]);

        $request->session()->put('income_team_id', $team->id);

        return redirect()
            ->route('events.income')
            ->with('status', 'Pendaftaran berhasil. Silakan unggah abstrak.')
            ->with('income_step', 2);
    }

    // Step 2: unggah abstrak
    public function submitAbstract(Request $request)
    {
        $request->validate([
            'subtheme'        => ['required','in:Renewable energy,Kesehatan,Sistem Otomasi,Pertanian,Lingkungan'],
            'title'           => ['required','string','max:300'],
            'abstract_file'   => ['required','file','mimes:pdf,doc,docx','max:5120'],
            'commitment_file' => ['required','file','mimes:pdf,doc,docx','max:5120'],
        ]);

        // Selalu tarik tim dari DB berdasarkan user login (lebih aman dari session)
        $team = IncomeTeam::where('user_id', Auth::id())->first();
        if (!$team) {
            return redirect()
                ->route('events.income')
                ->withErrors(['team' => 'Kamu belum melakukan pendaftaran tim.'])
                ->with('income_step', 1);
        }

        $title = trim($request->title);
        $firstThree = collect(preg_split('/\s+/', $title, -1, PREG_SPLIT_NO_EMPTY))->take(3)->implode(' ');

        $mk = fn(string $prefix, string $ext) =>
            preg_replace('/\s+/u', '_',
                preg_replace('/[^\pL\pN _.-]+/u', '', "{$prefix}_{$team->leader_name}_{$team->school}_{$firstThree}_{$request->subtheme}")
            ) . ".{$ext}";

        $abs = $request->file('abstract_file');
        $com = $request->file('commitment_file');

        $absName = $mk('ABSTRAK INCOME', strtolower($abs->getClientOriginalExtension()));
        $comName = $mk('SURAT KOMITMEN', strtolower($com->getClientOriginalExtension()));

        $absPath = $abs->storeAs('public/income/abstracts', $absName);
        $comPath = $com->storeAs('public/income/commitments', $comName);

        IncomeAbstract::updateOrCreate(
            ['team_id' => $team->id],
            [
                'subtheme'        => $request->subtheme,
                'title'           => $title,
                'abstract_path'   => $absPath,
                'commitment_path' => $comPath,
                'submitted_at'    => now(),
            ]
        );

        return redirect()
            ->route('events.income')
            ->with('status', 'Abstrak & surat komitmen berhasil diunggah. 👍')
            ->with('income_step', 3);
    }
}
