@extends('layouts.app')

@section('title', 'INSHOW — Coming Soon')

@section('content')
  {{-- Breadcrumb + Header --}} 
  <div class="mb-6 flex items-center justify-between gap-3">
    <div>
      <nav class="text-xs text-gray-500">
        <ol class="flex items-center gap-1">
          <li><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>
          <li>/</li>
          <li><span class="text-gray-700">Events</span></li>
          <li>/</li>
          <li><span class="text-gray-900 font-medium">INSHOW</span></li>
        </ol>
      </nav>
      <h1 class="mt-2 text-2xl font-semibold text-gray-900">INSHOW</h1>
      <p class="mt-1 text-sm text-gray-600">Halaman event INSHOW — Coming Soon.</p>
    </div>
  </div>

  <x-glass-card title="Coming Soon" subtitle="Halaman sedang disiapkan">
    <div class="grid gap-4 md:grid-cols-3">
      <div class="md:col-span-2">
        <p class="text-sm text-gray-700">
          Informasi lengkap mengenai INSHOW sedang kami siapkan. Pantau terus kanal resmi:
        </p>
        <ul class="mt-3 space-y-2 text-sm text-gray-700">
          <li>Instagram: <a href="https://instagram.com/infest.its" target="_blank" class="underline font-medium">@infest.its</a></li>
          <li>TikTok: <span class="font-medium">infest.its</span></li>
          <li>LinkedIn/YouTube: <span class="font-medium">Instrumentation Festival</span></li>
        </ul>
      </div>

      {{-- Placeholder shimmer --}}
      <div class="rounded-2xl border border-white/30 bg-white/60 p-4 animate-pulse">
        <div class="h-3 w-24 rounded bg-gray-300/70"></div>
        <div class="mt-3 h-2 w-full rounded bg-gray-200/80"></div>
        <div class="mt-2 h-2 w-5/6 rounded bg-gray-200/80"></div>
        <div class="mt-2 h-2 w-4/6 rounded bg-gray-200/80"></div>
        <div class="mt-4 h-24 w-full rounded-xl bg-gray-200/80"></div>
      </div>
    </div>
  </x-glass-card>
@endsection
