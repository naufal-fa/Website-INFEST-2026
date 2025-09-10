<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ config('app.name', 'Laravel') }}</title>

  {{-- Tailwind via CDN (no build) --}}
  <script>
    // Optional: set Tailwind's container and font if you want
    window.tailwind = { config: { theme: { extend: {} } } }
  </script>
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- Inter font (opsional) --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    html,body{font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, sans-serif;}
  </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-cyan-50 via-white to-white">
  <div class="relative min-h-screen">
    {{-- Background accent bubbles --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
      <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-cyan-100 blur-3xl opacity-60"></div>
      <div class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-cyan-200 blur-3xl opacity-40"></div>
    </div>

    <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-10">
      <div class="w-full max-w-md">
        {{-- Brand / Logo --}}
        <div class="mb-8 flex items-center justify-center">
          <a href="{{ url('/') }}" class="group inline-flex items-center gap-2">
            <div class="grid h-10 w-10 place-items-center rounded-2xl bg-cyan-500 text-white shadow-lg ring-1 ring-cyan-400/50">
              <!-- Simple spark icon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transition-transform group-hover:rotate-12" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 3v4m0 10v4m7-7h-4M9 12H5m9.192-5.192l2.829 2.829M6.979 14.95l-2.829 2.828m0-10.606l2.829 2.829m10.606 0l2.829-2.829"/>
              </svg>
            </div>
            <span class="text-xl font-semibold text-cyan-700">{{ config('app.name','Laravel') }}</span>
          </a>
        </div>

        {{-- Card --}}
        <div class="rounded-2xl border border-cyan-100 bg-white/70 backdrop-blur-sm shadow-xl shadow-cyan-100/40">
          <div class="px-6 py-7 sm:px-8">
            @if (session('status'))
              <div class="mb-4 rounded-lg border border-cyan-200 bg-cyan-50 px-4 py-3 text-sm text-cyan-800">
                {{ session('status') }}
              </div>
            @endif

            {{-- Slot content: form --}}
            @yield('content')
          </div>
        </div>

        {{-- Footer small text --}}
        <p class="mt-6 text-center text-xs text-gray-500">
          © {{ date('Y') }} {{ config('app.name','Laravel') }} — All rights reserved.
        </p>
      </div>
    </div>
  </div>
</body>
</html>