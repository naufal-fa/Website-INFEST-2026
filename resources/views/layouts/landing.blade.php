<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name'))</title>

  {{-- Favicon (opsional) --}}
  <link rel="icon" href="{{ asset('images/logo.png') }}?v=1">

  {{-- Tailwind CDN --}}
  <script src="https://cdn.tailwindcss.com"></script>
  {{-- Alpine (untuk toggle mobile menu) --}}
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    @keyframes floatY {
      0%   { transform: translateY(0) rotate(0deg); }
      50%  { transform: translateY(-12px) rotate(0.2deg); }
      100% { transform: translateY(0) rotate(0deg); }
    }
    .floating-logo {
      animation: floatY 4.8s ease-in-out infinite;
      filter: drop-shadow(0 12px 24px rgba(0,0,0,.15));
      will-change: transform;
    }
  </style>

  @stack('head')
</head>
<body class="min-h-screen bg-gradient-to-b from-white to-cyan-50 antialiased">

  {{-- NAVBAR --}}
  <header x-data="{ open:false }" class="sticky top-0 z-50 border-b border-gray-100/70 bg-white/70 backdrop-blur">
    <div class="mx-auto max-w-6xl px-4">
      <div class="flex h-14 items-center justify-between gap-3">
        {{-- Brand --}}
        <a href="" class="flex items-center gap-3">
          <div class="relative h-10 w-10 overflow-hidden bg-white">
            <img src="{{ asset('images/logo.png') }}" alt="Logo INFEST"
                 class="absolute inset-0 h-full w-full object-contain" draggable="false">
          </div>
          <span class="text-base font-semibold text-gray-900">INFEST 2026</span>
        </a>

        {{-- Links (desktop) --}}
        {{-- <nav class="hidden md:flex items-center gap-1">
          <a href="{{ route('events.income') }}"
             class="rounded-xl px-3 py-2 text-sm {{ request()->routeIs('events.income') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            INCOME
          </a>
          <a href="{{ route('events.inshow') }}"
             class="rounded-xl px-3 py-2 text-sm {{ request()->routeIs('events.inshow') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            INSHOW
          </a>
          <a href="{{ route('events.invisday') }}"
             class="rounded-xl px-3 py-2 text-sm {{ request()->routeIs('events.invisday') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            INVISDAY
          </a>
          <a href="{{ route('events.instry') }}"
             class="rounded-xl px-3 py-2 text-sm {{ request()->routeIs('events.instry') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
            INSTRY
          </a>
        </nav> --}}

        {{-- Actions (desktop) --}}
        <div class="hidden md:flex items-center gap-2">
          @guest
            <a href="{{ route('login') }}"
               class="rounded-xl border border-gray-200 bg-white px-3 py-1.5 text-sm font-medium text-gray-900 hover:bg-gray-50">
              Sign in
            </a>
            <a href="{{ route('register') }}"
               class="rounded-xl bg-gray-900 px-3 py-1.5 text-sm font-semibold text-white hover:bg-black">
              Register
            </a>
          @endguest
          @auth
            <a href="{{ route('dashboard') }}"
               class="rounded-xl bg-gray-900 px-3 py-1.5 text-sm font-semibold text-white hover:bg-black">
              Dashboard
            </a>
          @endauth
        </div>

        {{-- Mobile toggle --}}
        <button @click="open = !open" class="md:hidden inline-flex h-9 w-9 items-center justify-center rounded-xl border border-gray-200 bg-white">
          <svg x-show="!open" class="h-5 w-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <svg x-show="open" class="h-5 w-5 text-gray-700" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      {{-- Mobile menu --}}
      <div x-show="open" x-collapse class="md:hidden pb-3">
        {{-- <nav class="mt-2 space-y-1">
          <a href="{{ route('events.income') }}" class="block rounded-xl px-3 py-2 text-sm {{ request()->routeIs('events.income') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' }}">INCOME</a>
          <a href="{{ route('events.inshow') }}" class="block rounded-xl px-3 py-2 text-sm {{ request()->routeIs('events.inshow') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' }}">INSHOW</a>
          <a href="{{ route('events.invisday') }}" class="block rounded-xl px-3 py-2 text-sm {{ request()->routeIs('events.invisday') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' }}">INVISDAY</a>
          <a href="{{ route('events.instry') }}" class="block rounded-xl px-3 py-2 text-sm {{ request()->routeIs('events.instry') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-100' }}">INSTRY</a>
        </nav> --}}
        <div class="mt-2 flex items-center gap-2">
          @guest
            <a href="{{ route('login') }}" class="flex-1 rounded-xl border border-gray-200 bg-white px-3 py-2 text-center text-sm font-medium text-gray-900">Sign in</a>
            <a href="{{ route('register') }}" class="flex-1 rounded-xl bg-gray-900 px-3 py-2 text-center text-sm font-semibold text-white">Register</a>
          @endguest
          @auth
            <a href="{{ route('dashboard') }}" class="w-full rounded-xl bg-gray-900 px-3 py-2 text-center text-sm font-semibold text-white">Dashboard</a>
          @endauth
        </div>
      </div>
    </div>
  </header>

  {{-- CONTENT --}}
  <main class="mx-auto max-w-4xl px-4 py-16 sm:py-20">
    @yield('content')
  </main>

  @stack('scripts')
</body>
</html>