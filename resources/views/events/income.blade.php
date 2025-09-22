@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
    $now = Carbon::now('Asia/Jakarta');

    $items = [
        ['t' => 'Pendaftaran + Submit Abstrak — Batch 1', 'start' => Carbon::create(2025,9,14), 'end' => Carbon::create(2025,9,28)],
        ['t' => 'Pendaftaran + Submit Abstrak — Batch 2', 'start' => Carbon::create(2025,9,29), 'end' => Carbon::create(2025,10,13)],
        ['t' => 'Workshop',                               'start' => Carbon::create(2025,10,19), 'end' => Carbon::create(2025,10,19)],
        ['t' => 'Mentoring',                              'start' => Carbon::create(2025,11, 9), 'end' => Carbon::create(2025,11, 9)],
        ['t' => 'Pengumpulan Full Paper — Batch 1',       'start' => Carbon::create(2025,10,24), 'end' => Carbon::create(2025,11, 4)],
        ['t' => 'Pengumpulan Full Paper — Batch 2',       'start' => Carbon::create(2025,12,22), 'end' => Carbon::create(2026, 1, 3)],
        ['t' => 'Penjurian Full Paper',                   'start' => Carbon::create(2026, 1, 4), 'end' => Carbon::create(2026, 1, 6)],
        ['t' => 'Pengumuman Lolos Full Paper / Finalis',  'start' => Carbon::create(2026, 1, 9), 'end' => Carbon::create(2026, 1, 9)],
        ['t' => 'Technical Meeting',                      'start' => Carbon::create(2026, 1,11), 'end' => Carbon::create(2026, 1,11)],
        ['t' => 'Pengumpulan Poster',                     'start' => Carbon::create(2026, 1,18), 'end' => Carbon::create(2026, 1,19)],
        ['t' => 'Vote Poster',                            'start' => Carbon::create(2026, 1,22), 'end' => Carbon::create(2026, 1,28)],
        ['t' => 'Pengumpulan PPT',                        'start' => Carbon::create(2026, 1,29), 'end' => Carbon::create(2026, 2, 3)],
        ['t' => 'Grand Final',                            'start' => Carbon::create(2026, 2,14), 'end' => Carbon::create(2026, 2,14)],
    ];

    $formatRange = function (Carbon $s, Carbon $e) {
        if ($s->equalTo($e)) return $s->isoFormat('D MMMM Y');
        if ($s->month === $e->month && $s->year === $e->year) {
        return $s->isoFormat('D').'–'.$e->isoFormat('D MMMM Y');
        }
        return $s->isoFormat('D MMM Y').' – '.$e->isoFormat('D MMM Y');
    };

    $step = session('income_step') ?? ($initialStep ?? 1);
@endphp

@extends('layouts.app')

@section('title', 'INCOME — Event')

@section('content')
  {{-- Breadcrumb + Header --}}
  <div class="mb-6 flex items-center justify-between gap-3 animate-fade-in">
    <div>
      <nav class="text-xs text-gray-500">
        <ol class="flex items-center gap-1">
          <li><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>
          <li>/</li>
          <li><span class="text-gray-700">Events</span></li>
          <li>/</li>
          <li><span class="text-gray-900 font-medium">INCOME</span></li>
        </ol>
      </nav>
      <h1 class="mt-2 text-2xl font-semibold text-gray-900">INCOME</h1>
      <p class="mt-1 text-sm text-gray-600 animate-slide-up delay-300">Halaman event INCOME — informasi umum, agenda, FAQ, dan pendaftaran.</p>
    </div>
  </div>

    {{-- Grid: About & Highlight --}}
    <div class="animate-float-in delay-500">
        <x-glass-card title="Tentang Event" subtitle="Tujuan & target peserta">
        <div x-data="carousel({
                images: [
                { src: '{{ asset('images/income/DSC02267.JPG') }}', alt: 'Dokumentasi INCOME 1' },
                { src: '{{ asset('images/income/DSC02307.JPG') }}', alt: 'Dokumentasi INCOME 2' },
                { src: '{{ asset('images/income/DSC02315.JPG') }}', alt: 'Dokumentasi INCOME 3' },
                ],
                interval: 5000 // auto-slide 5 detik; set 0 untuk non-otomatis
            })"
            class="mb-5"
            >
            <div class="relative select-none">
                <div
                class="overflow-hidden rounded-2xl border border-white/30 bg-white/60 backdrop-blur"
                @touchstart.passive="onTouchStart($event)" @touchend.passive="onTouchEnd($event)"
                >
                {{-- Gunakan aspect ratio agar tinggi konsisten meski ukuran gambar beda --}}
                <div class="relative w-full aspect-[16/9]">
                    <template x-for="(img, i) in images" :key="i">
                    <img
                        x-show="index === i"
                        x-transition.opacity
                        :src="img.src" :alt="img.alt"
                        class="absolute inset-0 h-full w-full object-contain bg-neutral-100"
                        loading="lazy"
                        draggable="false"
                    >
                    </template>
                </div>
                </div>

                {{-- Tombol prev/next --}}
                <button
                type="button" @click="prev"
                class="absolute left-2 top-1/2 -translate-y-1/2 inline-flex h-9 w-9 items-center justify-center rounded-full
                        bg-white/80 shadow ring-1 ring-black/5 hover:bg-white"
                aria-label="Sebelumnya"
                >
                <svg class="h-5 w-5 text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/>
                </svg>
                </button>
                <button
                type="button" @click="next"
                class="absolute right-2 top-1/2 -translate-y-1/2 inline-flex h-9 w-9 items-center justify-center rounded-full
                        bg-white/80 shadow ring-1 ring-black/5 hover:bg-white"
                aria-label="Berikutnya"
                >
                <svg class="h-5 w-5 text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                </svg>
                </button>

                {{-- Dots indikator --}}
                <div class="absolute inset-x-0 bottom-2 flex items-center justify-center gap-2">
                <template x-for="(img, i) in images" :key="'dot'+i">
                    <button
                    type="button" @click="go(i)"
                    class="h-1.5 w-4 rounded-full transition"
                    :class="index===i ? 'bg-gray-900' : 'bg-gray-400/60 hover:bg-gray-500/70'"
                    :aria-label="`Ke slide ${i+1}`"
                    ></button>
                </template>
                </div>
            </div>
            </div>
            <div class="prose prose-sm max-w-none text-gray-700">
                <p>
                    INCOME merupakan kompetisi dalam bidang Karya Tulis Ilmiah yang ditujukan kepada siswa/siswi SMA/SMK sederajat untuk meningkatkan kreativitas dan inovasi dalam bidang Instrumentasi. INCOME membawakan tema “Youth Collaboration dan Innovation to Achieve SDGs 2030” dan dari tema tersebut memiliki beberapa subtema yaitu Renewable energy, Kesehatan, Sistem Otomasi, Pertanian, dan Lingkungan. Perlombaan dilakukan dengan beranggotakan maksimal 2 orang dalam satu tim. Peserta  melalui beberapa tahap penilaian mulai dari tahap seleksi abstrak, seleksi full paper, dan presentasi. Pada perlombaan ini, tahap presentasi dilakukan secara Offline.
                </p>
            </div>
        </x-glass-card>
    </div>
    
    {{-- Pendaftaran --}}
    <div x-data="{ step: {{ $step }} }" x-cloak class="mt-6 animate-float-in delay-900">
        <x-glass-card title="" subtitle="">
        {{-- STEP 1 --}}
        <section x-show="step===1">
        <h3 class="text-lg font-semibold text-gray-900">Pendaftaran INCOME</h3>
        <p class="mt-1 text-sm text-gray-700">Lakukan pendaftaran timmu.</p>
        @if(isset($team))
            <div class="rounded-xl border border-white/30 bg-white/60 p-5">
            <h3 class="text-lg font-semibold text-gray-900">Kamu sudah mendaftar ✅</h3>
            <p class="mt-1 text-sm text-gray-700">
                Tim: <strong>{{ $team->team_name }}</strong> — Ketua: {{ $team->leader_name }} ({{ $team->leader_email }})
            </p>
            <div class="mt-4">
                <button type="button" @click="step=2"
                class="rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-black">
                Lanjut ke Upload Abstrak
                </button>
            </div>
            </div>
        @else
        <form method="POST" action="{{ route('events.income.register') }}" class="space-y-5">
          @csrf
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="mb-1 block text-sm font-medium text-gray-700">Nama Tim</label>
              <input name="team_name" value="{{ old('team_name') }}" required
                    class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5 focus:border-gray-300 focus:ring-2 focus:ring-gray-200">
              @error('team_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label class="mb-1 block text-sm font-medium text-gray-700">Nama Ketua Tim</label>
              <input name="leader_name" value="{{ old('leader_name') }}" required
                    class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5 focus:border-gray-300 focus:ring-2 focus:ring-gray-200">
              @error('leader_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label class="mb-1 block text-sm font-medium text-gray-700">Nama Anggota Tim (opsional, 1 orang)</label>
              <input name="member_name" value="{{ old('member_name') }}"
                    class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5 focus:border-gray-300 focus:ring-2 focus:ring-gray-200">
              @error('member_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
              <label class="mb-1 block text-sm font-medium text-gray-700">Asal Sekolah</label>
              <input name="school" value="{{ old('school') }}" required
                    class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5 focus:border-gray-300 focus:ring-2 focus:ring-gray-200">
              @error('school') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
              <label class="mb-1 block text-sm font-medium text-gray-700">WhatsApp Ketua (62…)</label>
              <input name="leader_whatsapp" value="{{ old('leader_whatsapp') }}" required
                    class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5 focus:border-gray-300 focus:ring-2 focus:ring-gray-200" placeholder="62812xxxxxxx">
              @error('leader_whatsapp') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
              <label class="mb-1 block text-sm font-medium text-gray-700">Email Ketua</label>
              <input type="email" name="leader_email" value="{{ old('leader_email') }}" required
                    class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5 focus:border-gray-300 focus:ring-2 focus:ring-gray-200" placeholder="you@example.com">
              @error('leader_email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
          </div>

          <div>
            <label class="mb-1 block text-sm font-medium text-gray-700">Link Persyaratan (Google Drive)</label>
            <input name="requirements_link" value="{{ old('requirements_link') }}" required
                  class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5 focus:border-gray-300 focus:ring-2 focus:ring-gray-200"
                  placeholder="https://drive.google.com/…">
            <p class="mt-1 text-xs text-gray-500">Bukti: follow medsos, twibbon, IG story, share poster, Kartu Pelajar/SK aktif (gabung jadi satu folder/link).</p>
            @error('requirements_link') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
          </div>

          <div class="flex items-center gap-3 pt-2">
            <button class="rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-black focus:ring-2 focus:ring-gray-300">
              Kirim Pendaftaran
            </button>
          </div>
        </form>
        @endif
        </section>

        {{-- STEP 2: PENGUMPULAN FILE ABSTRAK --}}
        <section x-show="step===2">
        <h3 class="text-lg font-semibold text-gray-900">Upload File</h3>
        <p class="mt-1 text-sm text-gray-700">Lakukan upload berkas.</p>
        {{-- Jika sudah pernah submit, tampilkan badge info --}}
        @if(isset($team) && optional($team->submission)->id)
            <div class="mb-4 rounded-xl border border-white/30 bg-white/60 p-4 text-sm text-gray-700">
            Status: <span class="font-semibold text-green-700">Berhasil unggah</span> pada
            {{ optional($team->submission->submitted_at)->timezone('Asia/Jakarta')->format('d M Y H:i') }}.
            @if($team->submission->abstract_path)
                <a class="underline ml-1" href="{{ asset(str_replace('public/', 'storage/', $team->submission->abstract_path)) }}" target="_blank">Lihat Abstrak</a>
            @endif
            @if($team->submission->commitment_path)
                <a class="underline ml-2" href="{{ asset(str_replace('public/', 'storage/', $team->submission->commitment_path)) }}" target="_blank">Lihat Surat Komitmen</a>
            @endif
            </div>
        @endif

        <form x-data="incomeUploader()" x-on:submit.prevent="upload" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Pilih Sub Tema</label>
                <select x-model="form.subtheme" required
                        class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5 focus:border-gray-300 focus:ring-2 focus:ring-gray-200">
                <option value="">Pilih</option>
                <template x-for="s in subs" :key="s">
                    <option :value="s" x-text="s"></option>
                </template>
                </select>
                <p x-show="errors.subtheme" class="mt-1 text-xs text-red-600" x-text="errors.subtheme"></p>
            </div>

            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-medium text-gray-700">Judul Karya</label>
                <textarea x-model="form.title" rows="2" required
                        class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5 focus:border-gray-300 focus:ring-2 focus:ring-gray-200"
                        placeholder="Tulis judul karya..."></textarea>
                <p x-show="errors.title" class="mt-1 text-xs text-red-600" x-text="errors.title"></p>
            </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Abstrak --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Upload Dokumen Abstrak</label>
                <label class="block cursor-pointer rounded-xl border-2 border-dashed"
                    :class="files.abstract ? 'border-gray-400 bg-white/80' : 'border-gray-300 bg-white/60 hover:border-gray-400'">
                <input type="file" class="hidden" @change="pick($event,'abstract')" accept=".pdf,.doc,.docx" required>
                <div class="px-4 py-6 text-center">
                    <template x-if="!files.abstract">
                    <div class="text-sm text-gray-600">Drag & drop / klik untuk pilih file (PDF/DOC/DOCX, maks 5 MB)</div>
                    </template>
                    <template x-if="files.abstract">
                    <div class="text-sm">
                        <span class="font-medium text-gray-900" x-text="files.abstract.name"></span>
                        <span class="ml-1 text-gray-500" x-text="`(${(files.abstract.size/1024/1024).toFixed(2)} MB)`"></span>
                        <span class="ml-2 inline-flex items-center rounded-full bg-green-600 px-2 py-0.5 text-xs font-medium text-white" x-show="done.abstract">Uploaded</span>
                    </div>
                    </template>
                </div>
                </label>
                <p class="mt-2 text-xs text-gray-500">
                <strong>Format Penamaan:</strong><br>
                <code>ABSTRAK INCOME_Nama Ketua Tim_Asal Sekolah_3 Kata Pertama Judul Karya_Tema</code>
                </p>
                <p x-show="errors.abstract_file" class="mt-1 text-xs text-red-600" x-text="errors.abstract_file"></p>
            </div>

            {{-- Surat Komitmen --}}
            <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Upload Surat Komitmen</label>
                <label class="block cursor-pointer rounded-xl border-2 border-dashed"
                    :class="files.commitment ? 'border-gray-400 bg-white/80' : 'border-gray-300 bg-white/60 hover:border-gray-400'">
                <input type="file" class="hidden" @change="pick($event,'commitment')" accept=".pdf,.doc,.docx" required>
                <div class="px-4 py-6 text-center">
                    <template x-if="!files.commitment">
                    <div class="text-sm text-gray-600">Drag & drop / klik untuk pilih file (PDF/DOC/DOCX, maks 5 MB)</div>
                    </template>
                    <template x-if="files.commitment">
                    <div class="text-sm">
                        <span class="font-medium text-gray-900" x-text="files.commitment.name"></span>
                        <span class="ml-1 text-gray-500" x-text="`(${(files.commitment.size/1024/1024).toFixed(2)} MB)`"></span>
                        <span class="ml-2 inline-flex items-center rounded-full bg-green-600 px-2 py-0.5 text-xs font-medium text-white" x-show="done.commitment">Uploaded</span>
                    </div>
                    </template>
                </div>
                </label>
                <p class="mt-2 text-xs text-gray-500">
                <strong>Format Penamaan:</strong><br>
                <code>SURAT KOMITMEN_Nama Ketua Tim_Asal Sekolah_3 Kata Pertama Judul Karya_Tema</code>
                </p>
                <p x-show="errors.commitment_file" class="mt-1 text-xs text-red-600" x-text="errors.commitment_file"></p>
            </div>
            </div>

            {{-- Progress bar --}}
            <div class="mt-2" x-show="uploading">
            <div class="h-2 w-full overflow-hidden rounded-full bg-gray-200">
                <div class="h-2 bg-gray-900 transition-all" :style="`width:${progress}%`"></div>
            </div>
            <p class="mt-1 text-xs text-gray-600" x-text="`Mengunggah… ${progress}%`"></p>
            </div>

            <div class="flex items-center gap-3 pt-2">
            <button :disabled="uploading || !ready"
                    class="rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-black disabled:opacity-50">
                <span x-show="!uploading">Kirim Abstrak</span>
                <span x-show="uploading">Mengunggah…</span>
            </button>
            <a href="#faq" class="text-sm font-medium underline">Baca FAQ</a>
            </div>
        </form>
        </section>

        {{-- STEP 3: THANK YOU --}}
        <section x-show="step===3">
            <h3 class="text-lg font-semibold text-gray-900">Terima kasih sudah mendaftar! 🎉</h3>
            <p class="mt-1 text-sm text-gray-700">Tetap semangat dan pantau timeline. Gabung ke grup peserta di bawah supaya tidak ketinggalan info.</p>
            <div class="mt-4 flex flex-wrap items-center gap-3">
                <a target="_blank" rel="noopener"
                href="https://chat.whatsapp.com/JnoomYh3e7Q3tXw58uMu2q?mode=ems_share_t"
                class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-black">
                Gabung Grup WhatsApp
                </a>
            </div>
            <div class="mt-4 text-sm text-gray-700">
                <p>Contact Person:</p>
                <ul class="mt-1 list-disc pl-5">
                <li>Novia — 0878-7985-4365</li>
                <li>Nada — 0857-3338-8372</li>
                </ul>
            </div>
        </section>
        </x-glass-card>
    </div>

  {{-- Timeline --}}
    <div id="timeline" class="mt-6 animate-float-in delay-1100">
    <x-glass-card title="Timeline Kegiatan" subtitle="Pantau jadwal penting INCOME.">
        <ul class="relative ml-3">
        <span class="absolute left-[-1px] top-0 h-full w-px bg-gradient-to-b from-gray-300/70 via-gray-200/70 to-gray-300/70"></span>

        @foreach ($items as $i)
            @php
            $s = $i['start']; $e = $i['end'];
            $status = $now->lt($s) ? 'upcoming' : ($now->gt($e) ? 'done' : 'ongoing');
            $badgeText = ['upcoming' => 'Akan datang', 'ongoing' => 'Sedang berlangsung', 'done' => 'Selesai'][$status];
            $dot = $status === 'ongoing' ? 'bg-green-500' : ($status === 'upcoming' ? 'bg-blue-500' : 'bg-gray-400');
            $badge = $status === 'ongoing' ? 'bg-green-600' : ($status === 'upcoming' ? 'bg-blue-600' : 'bg-gray-500');
            @endphp

            <li class="relative pl-6 py-4">
            <span class="absolute left-[-6px] top-5 h-3 w-3 rounded-full ring-4 ring-white/70 {{ $dot }}"></span>
            <div class="rounded-xl border border-white/30 bg-white/60 backdrop-blur px-4 py-3">
                <div class="flex items-start justify-between gap-3">
                <div>
                    <p class="font-medium text-gray-900">{{ $i['t'] }}</p>
                    <p class="text-sm text-gray-600">{{ $formatRange($s, $e) }}</p>
                </div>
                <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-medium text-white {{ $badge }}">
                    {{ $badgeText }}
                </span>
                </div>
            </div>
            </li>
        @endforeach
        </ul>

        <div class="mt-4 flex flex-wrap items-center gap-3 text-xs text-gray-600">
        <div class="inline-flex items-center gap-2">
            <span class="inline-block h-2.5 w-2.5 rounded-full bg-green-500"></span> Sedang berlangsung
        </div>
        <div class="inline-flex items-center gap-2">
            <span class="inline-block h-2.5 w-2.5 rounded-full bg-blue-500"></span> Akan datang
        </div>
        <div class="inline-flex items-center gap-2">
            <span class="inline-block h-2.5 w-2.5 rounded-full bg-gray-400"></span> Selesai
        </div>
        </div>
    </x-glass-card>
    </div>

{{-- FAQ (revisi) --}}
<div id="faq" class="mt-6 animate-float-in delay-1300">
  <x-glass-card title="FAQ INCOME" subtitle="Pertanyaan yang sering diajukan">
    <div class="space-y-3">

      {{-- Q1 --}}
      <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
        <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
          <h3 class="font-medium text-gray-900">Q1: INCOME itu apa sih?</h3>
          <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-700">
          <p>
            INCOME merupakan sebuah kompetisi dalam bidang Karya Tulis Ilmiah yang ditujukan kepada siswa/siswi SMA/SMK sederajat untuk meningkatkan kreativitas dan inovasi dalam bidang Instrumentasi. INCOME membawakan tema
            <em>“Youth Collaboration and Innovation to Achieve SDGs 2030”</em> dan memiliki beberapa subtema. Perlombaan dilakukan dengan beranggotakan maksimal 2 orang dalam satu tim. Peserta melalui berbagai tahap penilaian mulai dari seleksi abstrak, seleksi full paper, dan presentasi. Pada perlombaan ini, tahap presentasi dilakukan secara <strong>offline</strong>.
          </p>
        </div>
      </details>

      {{-- Q2 --}}
      <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
        <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
          <h3 class="font-medium text-gray-900">Q2: Berapa banyak anggota dalam satu tim?</h3>
          <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-700">
          <p>Setiap tim hanya boleh beranggotakan <strong>maksimal dua orang</strong> (1 ketua dan 1 anggota).</p>
        </div>
      </details>

      {{-- Q3 --}}
      <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
        <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
          <h3 class="font-medium text-gray-900">Q3: Apa saja tahapan pelaksanaan INCOME 2026?</h3>
          <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-700">
          <ol class="list-decimal space-y-2 pl-5">
            <li><strong>Tahap Pengumpulan Abstrak</strong> — Setelah mendaftar, peserta mengumpulkan abstrak terbaiknya (gratis).</li>
            <li><strong>Tahap Seleksi Abstrak</strong> — Abstrak dinilai sesuai kriteria penjurian.</li>
            <li><strong>Tahap Pengumuman Lolos Abstrak</strong> — Peserta yang lolos melanjutkan ke tahap berikutnya.</li>
            <li><strong>Workshop</strong> — Kegiatan online untuk memperkuat pemahaman inovasi ilmiah.</li>
            <li><strong>Tahap Mentoring</strong> — Pendampingan oleh trainer keilmiahan ITS untuk mematangkan ide & karya.</li>
            <li><strong>Tahap Pengumpulan Full Paper</strong> — Peserta yang lolos abstrak mengirim full paper dengan pembayaran biaya pendaftaran sesuai waktu yang ditentukan.</li>
            <li><strong>Tahap Penjurian Full Paper</strong> — Penilaian full paper hingga tersisa <strong>10</strong> terbaik untuk maju ke babak final.</li>
            <li><strong>Tahap Pengumuman Finalis</strong> — Pengumuman 10 finalis berdasarkan penilaian dewan juri.</li>
            <li><strong>Tahap Technical Meeting</strong> — Pemberitahuan teknis jadwal presentasi finalis di Grand Final.</li>
            <li><strong>Tahap Pengumpulan Poster</strong> — Sebelum Grand Final, peserta wajib mengumpulkan poster.</li>
            <li><strong>Tahap Vote Poster</strong> — Voting poster dilakukan online melalui Instagram INFEST <strong>2026</strong> dan secara offline pada puncak acara.</li>
            <li><strong>Pengumpulan PPT Final</strong> — Sebelum Grand Final, peserta wajib mengumpulkan PPT Final.</li>
            <li><strong>Tahap Grand Final</strong> — Presentasi karya di depan juri; penentuan juara berdasarkan pertimbangan dewan juri.</li>
          </ol>
          <div class="mt-3 text-xs text-gray-500">
            Lihat jadwal di <a href="#timeline" class="font-medium underline hover:no-underline">Timeline</a> atau langsung <a href="#daftar" class="font-medium underline hover:no-underline">Daftar</a>.
          </div>
        </div>
      </details>

      {{-- Q4 --}}
      <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
        <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
          <h3 class="font-medium text-gray-900">Q4: Apa tema utama INCOME 2026?</h3>
          <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-700">
          <p>
            Tema: <em>“Youth Collaboration and Innovation to Achieve SDGs 2030”</em>, dengan subtema:
            Renewable energy, Kesehatan, Sistem Otomasi, Pertanian, dan Lingkungan.
          </p>
        </div>
      </details>

      {{-- Q5 --}}
      <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
        <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
          <h3 class="font-medium text-gray-900">Q5: Tujuan kegiatan INCOME 2026 apa saja?</h3>
          <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-700">
          <p>Mengembangkan karya tulis ilmiah pelajar SMA/SMK sederajat dengan gagasan kreatif dan orisinil, serta mencari generasi muda yang mampu mengimplementasikan ide instrumentasi untuk pemberdayaan masa depan dalam bentuk alat.</p>
        </div>
      </details>

      {{-- Q6 --}}
      <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
        <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
          <h3 class="font-medium text-gray-900">Q6: Bagaimana proses seleksi abstrak?</h3>
          <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-700">
          <p>Abstrak dinilai sesuai kriteria yang ditentukan; peserta yang memenuhi kriteria akan maju ke tahap pengumpulan full paper.</p>
        </div>
      </details>

      {{-- Q7 --}}
      <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
        <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
          <h3 class="font-medium text-gray-900">Q7: Bagaimana proses seleksi full paper?</h3>
          <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-700">
          <p>Full paper dinilai sesuai kriteria yang ditentukan hingga tersisa <strong>sepuluh</strong> karya terbaik yang maju ke babak final.</p>
        </div>
      </details>

      {{-- Q8 --}}
      <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
        <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
          <h3 class="font-medium text-gray-900">Q8: Bagaimana proses voting poster?</h3>
          <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-700">
          <p>Voting poster dilakukan <strong>online</strong> melalui Instagram INFEST 2026 dan <strong>offline</strong> pada hari H puncak acara INFEST 2026.</p>
        </div>
      </details>

      {{-- Q9 --}}
      <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
        <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
          <h3 class="font-medium text-gray-900">Q9: Apakah INCOME INFEST ini berbayar?</h3>
          <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-700">
          <p>Ya, <strong>berbayar</strong> tetapi hanya jika <strong>lolos seleksi abstrak</strong>.</p>
        </div>
      </details>

      {{-- Q10 --}}
      <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
        <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
          <h3 class="font-medium text-gray-900">Q10: Bagaimana menghubungi panitia?</h3>
          <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-700">
          <p>Hubungi Contact Person berikut:</p>
          <ul class="mt-1 list-disc pl-5">
            <li>Novia — <a class="underline" href="tel:+6287879854365">0878-7985-4365</a></li>
            <li>Nada  — <a class="underline" href="tel:+6285733388372">0857-3338-8372</a></li>
          </ul>
        </div>
      </details>

      {{-- Q11 --}}
      <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
        <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
          <h3 class="font-medium text-gray-900">Q11: Di mana mendapatkan info INCOME INFEST 2026?</h3>
          <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
          </svg>
        </summary>
        <div class="px-4 pb-4 text-sm text-gray-700">
          <ul class="space-y-1">
            <li>Instagram: <a class="underline" href="https://instagram.com/infest.its" target="_blank" rel="noopener">@infest.its</a></li>
            <li>TikTok: <span class="font-medium">infest.its</span></li>
            <li>LinkedIn: <span class="font-medium">Instrumentation Festival</span></li>
            <li>YouTube: <span class="font-medium">Instrumentation Festival</span></li>
          </ul>
        </div>
      </details>

    </div>
  </x-glass-card>
</div>

@endsection
