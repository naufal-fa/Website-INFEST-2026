@extends('layouts.app')

@section('title', 'INSVIDAY — Coming Soon')

@section('content')
  <div class="mb-6 flex items-center justify-between gap-3">
    <div>
      <nav class="text-xs text-gray-500">
        <ol class="flex items-center gap-1">
          <li><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>
          <li>/</li>
          <li><span class="text-gray-700">Events</span></li>
          <li>/</li>
          <li><span class="text-gray-900 font-medium">INSVIDAY</span></li>
        </ol>
      </nav>
      <h1 class="mt-2 text-2xl font-semibold text-gray-900">INSVIDAY</h1>
      <p class="mt-1 text-sm text-gray-600 animate-slide-up delay-300">Halaman event INSVIDAY — informasi umum, agenda, FAQ, dan pendaftaran.</p>
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
                  “Instrumentation Visit Day” merupakan serangkaian acara dari INSHOW, sekaligus acara pembuka dari INFEST 2026. Kegiatan ini dirancang khusus untuk memperkenalkan Departemen Teknik Instrumentasi, Institut Teknologi Sepuluh Nopember. Acara ini memberikan kesempatan besar kepada siswa dan siswi  SMA/SMK se-derajat seluruh Indonesia untuk mendapatkan pengetahuan tentang keilmuan Instrumentasi, prospek kerja, dan kesempatan untuk belajar di laboratorium Teknik Instrumentasi ITS serta pengalaman seru menjelajahi kampus ITS.
                </p>
            </div>
        </x-glass-card>
    </div>

    {{-- FAQ (revisi) --}}
  <div id="faq" class="mt-6 animate-float-in delay-1300">
    <x-glass-card title="FAQ INSHOW" subtitle="Pertanyaan yang sering diajukan">
      <div class="space-y-3">

        {{-- Q1 --}}
        <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
          <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
            <h3 class="font-medium text-gray-900">Q1: INSVIDAY itu apa sih?</h3>
            <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>
          </summary>
          <div class="px-4 pb-4 text-sm text-gray-700">
            <p>
              INSVIDAY adalah “Instrumentation Visit Day” merupakan serangkaian acara dari INSHOW, sekaligus acara pembuka dari INFEST 2026. Kegiatan ini dirancang khusus untuk memperkenalkan Departemen Teknik Instrumentasi, Institut Teknologi Sepuluh Nopember.
            </p>
          </div>
        </details>

        {{-- Q2 --}}
        <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
          <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
            <h3 class="font-medium text-gray-900">Q2: Apa benefitnya mengikuti INSVIDAY?</h3>
            <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>
          </summary>
          <div class="px-4 pb-4 text-sm text-gray-700">
            <p>Tentunya mendapat banyak informasi dan wawasan baru seputar tema yang akan dipaparkan, menjadi ladang mencari relasi, dan juga e-sertifikat peserta.</p>
          </div>
        </details>

        {{-- Q3 --}}
        <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
          <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
            <h3 class="font-medium text-gray-900">Q3: Kapan dan dimana INSVIDAY akan berlangsung?</h3>
            <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>
          </summary>
          <div class="px-4 pb-4 text-sm text-gray-700">
            <p>Kegiatan ini akan berlangsung selama 3 batch sesuai yang telah ditentukan, yaitu Batch 1 tanggal 22 - 23 November 2025, Batch 2 tanggal 13 - 14 Desember 2025, Batch 3 tanggal 13 - 14 Januari 2025 di Departemen Teknik Instrumentasi ITS Kampus ITS Sukolilo, Surabaya.</p>
          </div>
        </details>

        {{-- Q4 --}}
        <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
          <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
            <h3 class="font-medium text-gray-900">Q4: Bagaimana/apa saja kegiatan yang ada di INSVIDAY?</h3>
            <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>
          </summary>
          <div class="px-4 pb-4 text-sm text-gray-700">
            <p>
              Apa ajaa yaaa? Penasaran kan? tentunya akan ada kunjungan ke Departemen Teknik Instrumentasi ITS dan kalian akan merasakan pengalaman berkuliah di sana. Serta akan ada kunjungan ke 4 laboratorium Teknik Instrumentasi.
            </p>
          </div>
        </details>

        {{-- Q5 --}}
        <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
          <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
            <h3 class="font-medium text-gray-900">Q5: Bagaimana cara mendaftar INSVIDAY ini?</h3>
            <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>
          </summary>
          <div class="px-4 pb-4 text-sm text-gray-700">
            <p>Klik link yang ada di bio Instagram kita, lalu klik pendaftaran talkshow, nantinya akan masuk ke web infest kemudian pilih pendaftaran INSVIDAY.</p>
          </div>
        </details>

        {{-- Q6 --}}
        <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
          <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
            <h3 class="font-medium text-gray-900">Q6: Apakah ada persyaratan khusus yang harus dipenuhi sebagai peserta?</h3>
            <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>
          </summary>
          <div class="px-4 pb-4 text-sm text-gray-700">
            <p>Tidak ada. Kegiatan ini dapat diikuti oleh semua pelajar SMA/sederajat dari seluruh Indonesia. Peserta hanya diwajibkan untuk mengisi website pendaftaran dan mengisinya sesuai perintah, untuk info selanjutnya siilakan cek di Instagram @infest.its.</p>
          </div>
        </details>

        {{-- Q7 --}}
        <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
          <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
            <h3 class="font-medium text-gray-900">Q7: Apakah Insviday INFEST ini berbayar?</h3>
            <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>
          </summary>
          <div class="px-4 pb-4 text-sm text-gray-700">
            <p>Iya, pada Insviday tahun ini terdapat HTM sebesar Rp. 35.000, Tapi tenang aja sobat infest, karena dengan HTM tersebut teman-teman sudah mendapatkan konsumsi dan merch!!</p>
          </div>
        </details>

        {{-- Q8 --}}
        <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
          <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
            <h3 class="font-medium text-gray-900">Q8: Ada dresscode nya gak min?</h3>
            <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>
          </summary>
          <div class="px-4 pb-4 text-sm text-gray-700">
            <p>Untuk dresscodenya menggunakan seragam identitas sekolah masing-masing ya.</p>
          </div>
        </details>

        {{-- Q9 --}}
        <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
          <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
            <h3 class="font-medium text-gray-900">Q9: Barang apa yang perlu dibawa saat INSVIDAY?</h3>
            <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>
          </summary>
          <div class="px-4 pb-4 text-sm text-gray-700">
            <p>Peserta diharapkan membawa alat tulis dan buku catatan untuk mencatat materi yang disampaikan pada saat kegiatan dan kunjungan laboratorium.</p>
          </div>
        </details>

        {{-- Q10 --}}
        <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
          <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
            <h3 class="font-medium text-gray-900">Q10: Bagaimana saya bisa menghubungi panitia jika memiliki pertanyaan tambahan?</h3>
            <svg class="mt-1 h-5 w-5 shrink-0 text-gray-500 transition-transform group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
            </svg>
          </summary>
          <div class="px-4 pb-4 text-sm text-gray-700">
            <p>Jika peserta kegiatan memiliki pertanyaan tambahan, maka dapat langsung menghubungi Contact Person yang tertera pada poster kegiatan.</p>
          </div>
        </details>

        {{-- Q11 --}}
        <details class="group rounded-xl border border-white/30 bg-white/60 backdrop-blur">
          <summary class="flex cursor-pointer items-start justify-between gap-3 px-4 py-3">
            <h3 class="font-medium text-gray-900">Q11: Di mana mendapatkan info INSVIDAY INFEST 2026?</h3>
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
