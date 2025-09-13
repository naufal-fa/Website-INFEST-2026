@extends('layouts.landing')

@section('title', 'INFEST 2026 — Under Maintenance')

@section('content')
  <div class="text-center">
    {{-- Logo besar dengan efek floating --}}
    <div class="mx-auto w-56 sm:w-72 md:w-96 lg:w-[28rem]">
      <img
        src="{{ asset('images/logo.png') }}"
        alt="{{ config('app.name') }} logo"
        class="floating-logo mx-auto w-full h-auto select-none"
        draggable="false"
      >
    </div>

    {{-- Pesan maintenance + CTA --}}
    <h1 class="mt-10 text-2xl sm:text-3xl font-semibold text-gray-900">
      Halaman utama sedang
      <span class="rounded-lg bg-yellow-100 px-2 py-0.5 text-yellow-800">under maintenance</span>
    </h1>
    <p class="mt-2 text-sm text-gray-600">
      Namun kalian tetap bisa mendaftar langsung ke lombanya. 👇
    </p>

    <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
      <a href="{{ route('events.income') }}#daftar"
         class="rounded-xl bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white hover:bg-black focus:ring-2 focus:ring-gray-300">
        Daftar INCOME
      </a>
      <a href="{{ route('events.income') }}"
         class="rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-900 hover:bg-gray-50">
        Lihat Info INCOME
      </a>
    </div>
  </div>
@endsection
