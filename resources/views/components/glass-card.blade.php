@props([
  'title' => null,
  'subtitle' => null,
])

<div class="relative rounded-2xl p-[1px] bg-gradient-to-br from-cyan-400/40 via-cyan-200/30 to-cyan-500/30 shadow-[0_20px_60px_-20px_rgba(14,165,233,.35)]">
  <div class="relative rounded-2xl border border-white/20 bg-white/50 backdrop-blur-xl">
    {{-- dekorasi bubble halus --}}
    <div class="pointer-events-none absolute -top-8 -right-8 h-32 w-32 rounded-full bg-cyan-200/40 blur-2xl"></div>
    <div class="pointer-events-none absolute -bottom-10 -left-8 h-32 w-32 rounded-full bg-cyan-100/40 blur-2xl"></div>

    <div class="relative px-6 py-5 sm:px-7 sm:py-6">
      @if($title || $subtitle)
        <div class="mb-4">
          @if($title)
            <h2 class="text-lg font-semibold text-gray-800">{{ $title }}</h2>
          @endif
          @if($subtitle)
            <p class="mt-0.5 text-sm text-gray-600">{{ $subtitle }}</p>
          @endif
        </div>
      @endif

      {{ $slot }}
    </div>
  </div>
</div>
