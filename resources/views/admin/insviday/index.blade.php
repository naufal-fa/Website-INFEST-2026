@extends('layouts.app')

@section('title','Admin • Rekap INSVIDAY')

@section('content')
  {{-- Header --}}
  <div class="mb-6 flex items-center justify-between gap-3">
    <div>
      <nav class="text-xs text-gray-500">
        <ol class="flex items-center gap-1">
          <li><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>
          <li>/</li>
          <li><span class="text-gray-700">Admin</span></li>
          <li>/</li>
          <li><span class="text-gray-900 font-medium">Rekap INSVIDAY</span></li>
        </ol>
      </nav>
      <h1 class="mt-2 text-2xl font-semibold text-gray-900">Rekap INSVIDAY</h1>
      <p class="mt-1 text-sm text-gray-600">Daftar pendaftar, filter, dan aksi verifikasi.</p>
    </div>

    <div class="flex items-center gap-2">
      {{-- Export CSV mempertahankan filter aktif --}}
      <a href="{{ route('admin.insviday.export', request()->only(['status','visit_date'])) }}"
         class="rounded-xl bg-gray-900 px-3 py-2 text-sm font-semibold text-white hover:bg-black">
        Export CSV
      </a>
    </div>
  </div>

  {{-- Filter Bar --}}
  <div class="mb-6">
    <x-glass-card title="Filter" subtitle="Saring data pendaftar">
      <form method="GET" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-5">
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-700">Cari</label>
          <input type="text" name="q" value="{{ $filters['q'] ?? '' }}"
                placeholder="Nama, sekolah, WA, link drive..."
                class="w-full rounded-xl border border-white/30 bg-white/60 px-3 py-2">
        </div>
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-700">Tanggal Kunjungan</label>
          <input type="date" name="visit_date" value="{{ $filters['visit_date'] ?? '' }}"
                class="w-full rounded-xl border border-white/30 bg-white/60 px-3 py-2">
        </div>
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-700">Dari</label>
          <input type="date" name="from" value="{{ $filters['from'] ?? '' }}"
                class="w-full rounded-xl border border-white/30 bg-white/60 px-3 py-2">
        </div>
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-700">Sampai</label>
          <div class="flex gap-2">
            <input type="date" name="to" value="{{ $filters['to'] ?? '' }}"
                  class="w-full rounded-xl border border-white/30 bg-white/60 px-3 py-2">
            <button class="shrink-0 rounded-xl bg-gray-900 px-3 py-2 text-sm font-semibold text-white hover:bg-black">Terapkan</button>
          </div>
        </div>
        <div class="lg:col-span-5">
          <label class="mb-1 block text-xs font-medium text-gray-700">Urutkan</label>
          <select name="sort" class="w-full rounded-xl border border-white/30 bg-white/60 px-3 py-2">
            <option value="created_desc" @selected(($filters['sort'] ?? '')==='created_desc')>Terbaru dibuat</option>
            <option value="created_asc"  @selected(($filters['sort'] ?? '')==='created_asc')>Terlama dibuat</option>
            <option value="visit_asc"    @selected(($filters['sort'] ?? '')==='visit_asc')>Tanggal kunjungan ↑</option>
            <option value="visit_desc"   @selected(($filters['sort'] ?? '')==='visit_desc')>Tanggal kunjungan ↓</option>
            <option value="name_asc"     @selected(($filters['sort'] ?? '')==='name_asc')>Nama A–Z</option>
            <option value="name_desc"    @selected(($filters['sort'] ?? '')==='name_desc')>Nama Z–A</option>
          </select>
        </div>
      </form>
    </x-glass-card>
  </div>

  {{-- Tabel --}}
  <x-glass-card title="Pendaftar" subtitle="Total: {{ $regs->total() }}">
    @if($regs->count() === 0)
      <div class="rounded-xl border border-dashed border-gray-300 bg-white/60 p-8 text-center text-sm text-gray-600">
        Belum ada data sesuai filter.
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
          <thead class="border-b border-gray-200 text-xs uppercase text-gray-500">
            <tr>
              <th class="px-3 py-2">#</th>
              <th class="px-3 py-2">Nama & Sekolah</th>
              <th class="px-3 py-2">Kontak</th>
              <th class="px-3 py-2">Kunjungan</th>
              <th class="px-3 py-2">Pembayaran</th>
              <th class="px-3 py-2">Berkas</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @foreach ($regs as $i => $r)
              <tr class="align-top">
                <td class="px-3 py-3 text-gray-500">{{ ($regs->currentPage()-1)*$regs->perPage() + $i + 1 }}</td>

                <td class="px-3 py-3">
                  <div class="font-medium text-gray-900">{{ $r->full_name }}</div>
                  <div class="text-xs text-gray-600">{{ $r->school }}</div>
                  <div class="mt-1 text-[11px] text-gray-500">Daftar: {{ $r->created_at?->format('d M Y H:i') }}</div>
                </td>

                <td class="px-3 py-3">
                  <div class="text-sm">
                    <a class="underline" target="_blank" href="https://wa.me/{{ $r->whatsapp }}">{{ $r->whatsapp }}</a>
                  </div>
                </td>

                <td class="px-3 py-3">
                  <div class="text-sm text-gray-900">{{ $r->visit_date }}</div>
                </td>

                <td class="px-3 py-3">
                  <div class="text-sm text-gray-900">{{ $r->payment_method }}</div>
                  @if($r->payment_proof_path)
                    <a class="text-xs underline" target="_blank" href="{{ asset(str_replace('public/','storage/',$r->payment_proof_path)) }}">Lihat bukti</a>
                  @endif
                </td>

                <td class="px-3 py-3">
                  <a class="text-sm underline" target="_blank" href="{{ $r->gdrive_link }}">Folder GDrive</a>
                </td>

                <td class="px-3 py-3">
                  <div class="flex flex-wrap gap-2">
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      {{-- Pagination --}}
      <div class="mt-4">
        {{ $regs->links() }}
      </div>
    @endif
  </x-glass-card>
@endsection
