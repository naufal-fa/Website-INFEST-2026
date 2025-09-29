@extends('layouts.app')

@section('title','Admin • Rekap INCOME')

@section('content')
  <div class="mb-6 flex items-center justify-between gap-3">
    <div>
      <nav class="text-xs text-gray-500">
        <ol class="flex items-center gap-1">
          <li><a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a></li>
          <li>/</li>
          <li><span class="text-gray-700">Admin</span></li>
          <li>/</li>
          <li><span class="text-gray-900 font-medium">Rekap INCOME</span></li>
        </ol>
      </nav>
      <h1 class="mt-2 text-2xl font-semibold text-gray-900">Rekap INCOME</h1>
      <p class="mt-1 text-sm text-gray-600">Tim + submission abstrak dalam satu tabel.</p>
    </div>

    <div class="flex items-center gap-2">
      <a href="{{ route('admin.income.export', request()->only(['q','status','subtheme','has_submission'])) }}"
         class="rounded-xl bg-gray-900 px-3 py-2 text-sm font-semibold text-white hover:bg-black">
        Export CSV
      </a>
    </div>
  </div>

  <div class="mb-6">
    <x-glass-card title="Filter" subtitle="">
      <form method="GET" class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-6">
        <div class="lg:col-span-2">
          <label class="mb-1 block text-xs font-medium text-gray-700">Cari</label>
          <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Tim, ketua, email, sekolah"
                class="w-full rounded-xl border border-white/30 bg-white/60 px-3 py-2">
        </div>
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-700">Subtema</label>
          <select name="subtheme" class="w-full rounded-xl border border-white/30 bg-white/60 px-3 py-2">
            <option value="">Semua</option>
            @foreach($subthemes as $st)
              <option value="{{ $st }}" @selected(($filters['subtheme'] ?? '')===$st)>{{ $st }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="mb-1 block text-xs font-medium text-gray-700">Submission</label>
          <select name="has_submission" class="w-full rounded-xl border border-white/30 bg-white/60 px-3 py-2">
            <option value="">Semua</option>
            <option value="yes" @selected(($filters['hasSub'] ?? '')==='yes')>Ada</option>
            <option value="no"  @selected(($filters['hasSub'] ?? '')==='no')>Belum ada</option>
          </select>
        </div>
        <div class="flex items-end">
          <button class="w-full rounded-xl bg-gray-900 px-3 py-2 text-sm font-semibold text-white hover:bg-black">Terapkan</button>
        </div>
      </form>
    </x-glass-card>
  </div>

  <x-glass-card title="Data Tim" subtitle="Total: {{ $regs->total() }}">
    @if($regs->count()===0)
      <div class="rounded-xl border border-dashed border-gray-300 bg-white/60 p-8 text-center text-sm text-gray-600">
        Belum ada data sesuai filter.
      </div>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full text-left text-sm">
          <thead class="border-b border-gray-200 text-xs uppercase text-gray-500">
            <tr>
              <th class="px-3 py-2">#</th>
              <th class="px-3 py-2">Tim & Ketua</th>
              <th class="px-3 py-2">Sekolah & Kontak</th>
              <th class="px-3 py-2">Submission</th>
              <th class="px-3 py-2">Berkas</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            @foreach($regs as $i => $r)
              @php $s = $r->submission; @endphp
              <tr class="align-top">
                <td class="px-3 py-3 text-gray-500">{{ ($regs->currentPage()-1)*$regs->perPage() + $i + 1 }}</td>

                <td class="px-3 py-3">
                  <div class="font-medium text-gray-900">{{ $r->team_name }}</div>
                  <div class="text-sm text-gray-700">Ketua: {{ $r->leader_name }}</div>
                  <div class="text-xs text-gray-500">Daftar: {{ $r->created_at?->format('d M Y H:i') }}</div>
                </td>

                <td class="px-3 py-3">
                  <div class="text-sm text-gray-900">{{ $r->school }}</div>
                  <div class="text-xs text-gray-700">{{ $r->leader_email }}</div>
                  @if($r->leader_whatsapp)
                    <a class="text-xs underline" target="_blank" href="https://wa.me/{{ $r->leader_whatsapp }}">WA: {{ $r->leader_whatsapp }}</a>
                  @endif
                  @if($r->requirements_link)
                    <div class="mt-1 text-xs"><a class="underline" target="_blank" href="{{ $r->requirements_link }}">Link persyaratan</a></div>
                  @endif
                </td>

                <td class="px-3 py-3">
                  @if($s)
                    <div class="text-sm">
                      <div><span class="font-medium">Subtema:</span> {{ $s->subtheme }}</div>
                      <div class="mt-1"><span class="font-medium">Judul:</span> {{ $s->title }}</div>
                      <div class="mt-1 text-xs text-gray-500">Submit: {{ $s->submitted_at?->format('d M Y H:i') }}</div>
                    </div>
                  @else
                    <span class="rounded-full bg-yellow-500/10 px-2.5 py-0.5 text-xs font-semibold text-yellow-700 ring-1 ring-yellow-200">
                      Belum submit abstrak
                    </span>
                  @endif
                </td>

                <td class="px-3 py-3">
                  @if($s?->abstract_path)
                    <div><a class="text-xs underline" target="_blank" href="{{ asset(str_replace('public/','storage/',$s->abstract_path)) }}">Abstrak</a></div>
                  @endif
                  @if($s?->commitment_path)
                    <div class="mt-1"><a class="text-xs underline" target="_blank" href="{{ asset(str_replace('public/','storage/',$s->commitment_path)) }}">Surat Komitmen</a></div>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="mt-4">
        {{ $regs->links() }}
      </div>
    @endif
  </x-glass-card>
@endsection