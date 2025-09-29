@extends('layouts.app')

@section('title', 'INSVIDAY — Event')

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
                { src: '{{ asset('images/insviday/DSC_3955.JPG') }}', alt: 'Dokumentasi INSVIDAY 1' },
                { src: '{{ asset('images/insviday/DSC_4204.JPG') }}', alt: 'Dokumentasi INSVIDAY 2' },
                { src: '{{ asset('images/insviday/IMG_1127.JPG') }}', alt: 'Dokumentasi INSVIDAY 3' },
                { src: '{{ asset('images/insviday/IMG_1178.JPG') }}', alt: 'Dokumentasi INSVIDAY 4' },
                { src: '{{ asset('images/insviday/IMG_2041.JPG') }}', alt: 'Dokumentasi INSVIDAY 5' },
                { src: '{{ asset('images/insviday/IMG_6253.JPG') }}', alt: 'Dokumentasi INSVIDAY 6' },
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
                    “Instrumentation Visit Day” atau dikenal sebagai INSVIDAY merupakan serangkaian acara yang terdiri dari sesi sehari menjadi mahasiswa Teknik Instrumentasi ITS dengan merasakan diajar oleh Dosen, melaksanakan praktikum di laboratorium, serta berkeliling di Kampus ITS. Kegiatan ini dirancang khusus untuk memperkenalkan Departemen Teknik Instrumentasi, Institut Teknologi Sepuluh Nopember. Acara ini memberikan kesempatan besar kepada siswa dan siswi  SMA/SMK se-derajat seluruh Indonesia untuk mendapatkan pengetahuan tentang keilmuan Instrumentasi, prospek kerja, dan kesempatan untuk belajar di laboratorium Teknik Instrumentasi ITS serta pengalaman seru menjelajahi kampus ITS.
                </p>
            </div>
        </x-glass-card>
    </div>

    {{-- PENDAFTARAN INSVIDAY --}}
    <div x-data="{ step: {{ $step }} }" x-cloak class="mt-6 animate-float-in delay-700">
      <x-glass-card title="" subtitle="">
        {{-- STEP 1: Form Pendaftaran --}}
        <section x-show="step===1">
          <h3 class="text-lg font-semibold text-gray-900">Pendaftaran INSVIDAY</h3>
          <p class="mt-1 text-sm text-gray-700">Isi identitas dan unggah bukti pembayaran. Dokumen lain unggah ke satu folder Google Drive lalu tempelkan link-nya di bawah.</p>

          <form method="POST" action="{{ route('events.insviday.apply') }}" enctype="multipart/form-data" class="mt-4 space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input name="full_name" value="{{ old('full_name') }}" required
                      class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5">
                @error('full_name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
              </div>
              <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">No. WhatsApp (format 62…)</label>
                <input name="whatsapp" value="{{ old('whatsapp') }}" placeholder="62812xxxxxxx" required
                      class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5">
                @error('whatsapp') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                <p class="mt-1 text-xs text-gray-500">Contoh link chat: <span class="font-mono">https://wa.me/62xxxxxxxxxx</span></p>
              </div>
              <div class="sm:col-span-2">
                <label class="mb-1 block text-sm font-medium text-gray-700">Asal Sekolah</label>
                <input name="school" value="{{ old('school') }}" required
                      class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5">
                @error('school') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
              </div>
            </div>

            {{-- Pilihan Batch & Tanggal --}}
            <div>
              <label class="mb-1 block text-sm font-medium text-gray-700">Tanggal Kunjungan</label>
              <select name="visit_date" required
                      class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5">
                <option value="">-- Pilih Tanggal --</option>

                <optgroup label="Batch 1">
                  <option value="2025-11-08" @selected(old('visit_date')==='2025-11-08')>8 Novemer 2025</option>
                  <option value="2025-11-09" @selected(old('visit_date')==='2025-11-09')>9 November 2025</option>
                </optgroup>

                <optgroup label="Batch 2">
                  <option>29 November 2025</option>
                  <option>30 November 2025</option>
                </optgroup>

                {{-- <optgroup label="Batch 3 (Ditutup)" disabled>
                  <option disabled>20 Desember 2025</option>
                  <option disabled>21 Desember 2025</option>
                </optgroup> --}}
              </select>
              @error('visit_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
              <p class="mt-1 text-xs text-gray-500">Batch 3 akan dibuka menyusul.</p>
            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                <select name="payment_method" required
                        class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5">
                  <option value="">Pilih metode</option>
                    <option value="BNI" @selected(old('payment_method'))>BNI 1791801423 a/n : Riska Hidayati Laena</option>
                    <option value="BCA" @selected(old('payment_method'))>BCA 6730498495 RAFI MUHAMMAD ZHAFIR</option>
                </select>
                @error('payment_method') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                <p class="mt-1 text-xs text-gray-500">Tambahkan 1 rupiah, misal: 30.001</p>
              </div>

              <div>
                <label class="mb-1 block text-sm font-medium text-gray-700">Bukti Pembayaran (JPG/PNG, maks 5MB)</label>
                <input type="file" name="payment_proof" accept=".jpg,.jpeg,.png" required
                      class="block w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5 file:mr-3 file:rounded-lg file:border-0 file:bg-gray-900 file:px-3 file:py-1.5 file:text-sm file:font-semibold file:text-white hover:file:bg-black">
                @error('payment_proof') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
              </div>
            </div>

            <div>
              <label class="mb-1 block text-sm font-medium text-gray-700">Link Google Drive (semua dokumen)</label>
              <input name="gdrive_link" value="{{ old('gdrive_link') }}" placeholder="https://drive.google.com/..." required
                    class="w-full rounded-xl border border-white/30 bg-white/60 px-4 py-2.5">
              <p class="mt-1 text-xs text-gray-500">
                Satukan di satu folder: <em>Kartu Tanda Pelajar</em>, <em>Bukti follow Instagram INFEST</em>, dan <em>Bukti follow Instagram Teknik Instrumentasi ITS</em>. Pastikan link dapat diakses (Anyone with the link).
              </p>
              @error('gdrive_link') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
              <button class="rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-black">
                Kirim Pendaftaran
              </button>
            </div>
          </form>
        </section>

        {{-- STEP 2: Menunggu Validasi Admin --}}
        <section x-show="step===2">
          <h3 class="text-lg font-semibold text-gray-900">Terima kasih sudah mendaftar! 🎉</h3>
          <p class="mt-1 text-sm text-gray-700">Gabung ke grup WhatsApp di bawah supaya tidak ketinggalan info.</p>
          <div class="mt-4 flex flex-wrap items-center gap-3">
          <a target="_blank" rel="noopener"
            href="{{ $waLink ?? '#' }}"
            class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-black {{ $waLink ? '' : 'pointer-events-none opacity-60' }}">
            Gabung Grup WhatsApp
          </a>
          </div>
          <div class="mt-4 text-sm text-gray-700">
            <p>Contact Person:</p>
            <ul class="mt-1 list-disc pl-5">
              <li>Selly — 0852-5791-7551</li>
              <li>Rizky — 0831-1776-2023</li>
            </ul>
          </div>

          @if($reg)
            <div class="mt-4 rounded-xl border border-white/30 bg-white/60 p-4 text-sm text-gray-700">
              <p><strong>Nama:</strong> {{ $reg->full_name }}</p>
              <p class="mt-1"><strong>WA:</strong> <a class="underline" target="_blank" href="https://wa.me/{{ $reg->whatsapp }}">{{ $reg->whatsapp }}</a></p>
              <p class="mt-1"><strong>Sekolah:</strong> {{ $reg->school }}</p>
              <p class="mt-1"><strong>Metode Bayar:</strong> {{ $reg->payment_method }}</p>
              <p class="mt-1">
                <strong>Tanggal:</strong>
                {{ optional($reg->visit_date)->timezone('Asia/Jakarta')->translatedFormat('d F Y') }}
              </p>
              <p class="mt-1"><strong>Bukti Bayar:</strong>
                <a class="underline" target="_blank" href="{{ asset('storage/app/private/' . $reg->payment_proof_path) }}">Lihat gambar</a>
              </p>
              <p class="mt-1"><strong>Link Drive:</strong> <a class="underline" href="{{ $reg->gdrive_link }}" target="_blank">{{ $reg->gdrive_link }}</a></p>
            </div>
          @endif
        </section>
      </x-glass-card>
    </div>

    {{-- POSTER --}}
    <div class="animate-float-in delay-1000 mt-6">
        <x-glass-card title="" subtitle="">
          <div class="mb-5">
              <img src="{{ asset('images/insviday/POSTER INSVIDAY.png') }}" alt="Poster INSVIDAY" srcset="">
          </div>
        </x-glass-card>
    </div>

    {{-- FAQ (revisi) --}}
  <div id="faq" class="mt-6 animate-float-in delay-1300">
    <x-glass-card title="FAQ INSVIDAY" subtitle="Pertanyaan yang sering diajukan">
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
INSVIDAY adalah “Instrumentation Visit Day” merupakan serangkaian acara yang terdiri dari sesi sehari menjadi mahasiswa Teknik Instrumentasi dengan merasakan diajar oleh Dosen, praktikum di laboratorium, serta berkeliling di ITS. INSVIDAY sekaligus sebagai acara pembuka dari INFEST 2026. Kegiatan ini dirancang khusus untuk memperkenalkan Departemen Teknik Instrumentasi, Institut Teknologi Sepuluh Nopember.
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
            <p>
              Kegiatan ini akan berlangsung selama 1 hari sesuai jadwal yang telah dipilih dan dilaksanakan di Departemen Teknik Instrumentasi ITS Kampus ITS Sukolilo, Surabaya. 
              <a href="https://maps.app.goo.gl/PiXQUhXj9dDqe4Bu7" target="_blank" rel="noopener noreferrer">https://maps.app.goo.gl/PiXQUhXj9dDqe4Bu7</a>
            </p>
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
            <p>Klik link yang ada di poster open registration, atau bisa juga mengikuti tutorial pendaftaran pada feeds Instagram @infest.its. Jika masih ada hal yang ingin ditanyakan, peserta dapat menghubungi Contact Person yang sudah disediakan😁🤙🏻</p>
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
            <p>Iya, Pada Insviday tahun ini terdapat HTM sebesar Rp. 30.000, Tapi tenang aja sobat infest, karena dengan HTM tersebut teman-teman sudah mendapatkan konsumsi dan merch!!</p>
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