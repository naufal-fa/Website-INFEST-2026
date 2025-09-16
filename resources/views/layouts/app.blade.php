<!DOCTYPE html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title', config('app.name', 'Laravel'))</title>

  {{-- Tailwind via CDN (tanpa npm) --}}
  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="icon" href="{{ asset('images/logo.png') }}?v=1">


  {{-- Inter font (opsional) --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    html,body{font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,sans-serif;}
  </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-cyan-50 via-white to-white">
  {{-- Intro Animation --}}
  <x-intro-animation />
  {{-- Background bubbles --}}
  <div class="pointer-events-none fixed inset-0 -z-10 overflow-hidden">
    <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-cyan-100 blur-3xl opacity-60"></div>
    <div class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-cyan-200 blur-3xl opacity-40"></div>
  </div>

  {{-- NAVBAR --}}
  <header class="sticky top-0 z-30 backdrop-blur bg-white/70 border-b border-cyan-100">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <div class="flex items-center gap-3">
        {{-- Toggle sidebar (mobile) --}}
        <button id="openSidebar" class="md:hidden inline-flex h-9 w-9 items-center justify-center rounded-xl border border-cyan-100 bg-white hover:bg-cyan-50">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>

        <a href="{{ url('/') }}" class="flex items-center gap-2">
          <div class="relative h-9 w-9 overflow-hidden rounded-xl bg-white">
            <img
              src="{{ asset('images/logo.png') }}"
              srcset="{{ asset('images/logo.png') }} 1x, {{ asset('images/logo.png') }} 2x"
              alt="{{ config('app.name', 'App') }} logo"
              class="absolute inset-0 h-full w-full object-contain"
              loading="lazy"
              draggable="false"
            >
          </div>
          <span class="text-lg font-semibold text-cyan-700">INFEST 2026</span>
        </a>
      </div>

      {{-- Right area --}}
      <div class="relative">
        <button id="userMenuBtn" class="inline-flex items-center gap-2 rounded-xl border border-cyan-100 bg-white px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-cyan-50">
          <span class="hidden sm:inline">{{ Auth::user()->name ?? 'User' }}</span>
          <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
          </svg>
        </button>
        <div id="userMenu" class="hidden absolute right-0 mt-2 w-44 rounded-xl border border-gray-100 bg-white shadow-lg">
          {{-- <a href="{{ route('profile.edit') }}" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a> --}}
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">Log out</button>
          </form>
        </div>
      </div>
    </div>
  </header>

  {{-- FLASH --}}
  @if (session('status'))
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 mt-4">
      <div class="rounded-lg border border-cyan-200 bg-cyan-50 px-4 py-3 text-sm text-cyan-800">
        {{ session('status') }}
      </div>
    </div>
  @endif

  {{-- CONTENT + SIDEBAR (desktop) --}}
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
    <div class="md:grid md:grid-cols-[16rem_1fr] md:gap-6">
      <div class="hidden md:block">
        @include('partials.sidebar')
      </div>
      <main class="min-w-0">
        @yield('content')
      </main>
    </div>
  </div>

  {{-- SIDEBAR DRAWER (mobile) --}}
  <div id="drawerBackdrop" class="fixed inset-0 z-40 bg-black/30 hidden md:hidden"></div>
  <div id="drawerPanel" class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full transition-transform md:hidden">
    <div class="h-full border-r border-cyan-100 bg-white/80 backdrop-blur p-3">
      <div class="flex items-center justify-between mb-2">
        <a href="{{ url('/') }}" class="flex items-center gap-2">
          <div class="relative h-9 w-9 overflow-hidden rounded-xl bg-white">
            <img
              src="{{ asset('images/logo.png') }}"
              srcset="{{ asset('images/logo.png') }} 1x, {{ asset('images/logo.png') }} 2x"
              alt="{{ config('app.name', 'App') }} logo"
              class="absolute inset-0 h-full w-full object-contain"
              loading="lazy"
              draggable="false"
            >
          </div>
          <span class="text-lg font-semibold text-cyan-700">INFEST 2026</span>
        </a>
        <button id="closeSidebar" class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-cyan-100 bg-white hover:bg-cyan-50">
          <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>
      @include('partials.sidebar')
    </div>
  </div>

  <footer class="mt-8 border-t border-cyan-100 bg-white/60">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 text-xs text-gray-500 text-center">
      © {{ date('Y') }} INFEST — All rights reserved.
    </div>
  </footer>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    // Dropdown user
    const btn = document.getElementById('userMenuBtn');
    const menu = document.getElementById('userMenu');
    if (btn && menu) {
      btn.addEventListener('click', () => menu.classList.toggle('hidden'));
      document.addEventListener('click', (e) => {
        if (!btn.contains(e.target) && !menu.contains(e.target)) menu.classList.add('hidden');
      });
    }

    // Sidebar drawer (mobile)
    const openBtn = document.getElementById('openSidebar');
    const closeBtn = document.getElementById('closeSidebar');
    const backdrop = document.getElementById('drawerBackdrop');
    const panel = document.getElementById('drawerPanel');

    function openDrawer() {
      panel.classList.remove('-translate-x-full');
      backdrop.classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }
    function closeDrawer() {
      panel.classList.add('-translate-x-full');
      backdrop.classList.add('hidden');
      document.body.style.overflow = '';
    }

    openBtn?.addEventListener('click', openDrawer);
    closeBtn?.addEventListener('click', closeDrawer);
    backdrop?.addEventListener('click', closeDrawer);

    // Toggle submenu
    document.querySelectorAll('[data-toggle]').forEach((btn) => {
      btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-toggle');
        const el = document.getElementById(id);
        if (!el) return;
        el.classList.toggle('hidden');
        // putar caret
        const caret = btn.querySelector('svg:last-child');
        caret?.classList.toggle('rotate-180');
        // ARIA
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        btn.setAttribute('aria-expanded', (!expanded).toString());
      });
    });
  </script>

  {{-- Alpine helper --}}
<script>
  function incomeUploader(){
    return {
      subs: ['Renewable energy','Kesehatan','Sistem Otomasi','Pertanian','Lingkungan'],
      form: { subtheme: '', title: '' },
      files: { abstract: null, commitment: null },
      done: { abstract: false, commitment: false },
      errors: {},
      uploading: false,
      progress: 0,
      get ready(){ return !!(this.form.subtheme && this.form.title && this.files.abstract && this.files.commitment); },
      pick(e, key){
        const file = e.target.files[0];
        this.files[key] = file || null;
        this.done[key] = false;
      },
      upload(){
        this.errors = {};
        const fd = new FormData();
        fd.append('_token', document.querySelector('input[name=_token]').value);
        fd.append('subtheme', this.form.subtheme);
        fd.append('title', this.form.title);
        fd.append('abstract_file', this.files.abstract);
        fd.append('commitment_file', this.files.commitment);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route('events.income.abstract') }}', true);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.upload.onprogress = (e) => {
          if (e.lengthComputable) {
            this.uploading = true;
            this.progress = Math.round((e.loaded / e.total) * 100);
          }
        };
        xhr.onload = () => {
          this.uploading = false;
          if (xhr.status >= 200 && xhr.status < 300) {
            this.progress = 100;
            this.done.abstract = true;
            this.done.commitment = true;
            // Pindah ke step 3
            window.dispatchEvent(new CustomEvent('goto-step', { detail: 3 }));
            // Refresh supaya link file tampil (opsional):
            setTimeout(()=>location.reload(), 300);
          } else {
            try {
              const res = JSON.parse(xhr.responseText);
              this.errors = res.errors || {'title':'Gagal mengunggah. Periksa kembali berkas & ukuran.'};
            } catch (_) {
              this.errors = {'title':'Gagal mengunggah. Coba lagi.'};
            }
          }
        };
        xhr.onerror = () => {
          this.uploading = false;
          this.errors = {'title':'Jaringan bermasalah. Coba lagi.'};
        };
        xhr.send(fd);
      }
    }
  }
</script>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
  function carousel({ images = [], interval = 0 } = {}) {
    return {
      images,
      index: 0,
      timer: null,
      startX: null,
      next(){ this.index = (this.index + 1) % this.images.length; },
      prev(){ this.index = (this.index - 1 + this.images.length) % this.images.length; },
      go(i){ this.index = i; this.autoplay(); },
      autoplay(){
        if (!interval) return;
        this.stop();
        this.timer = setInterval(() => this.next(), interval);
      },
      stop(){ if (this.timer) { clearInterval(this.timer); this.timer = null; } },
      onTouchStart(e){ this.startX = e.touches[0].clientX; },
      onTouchEnd(e){
        if (this.startX === null) return;
        const dx = e.changedTouches[0].clientX - this.startX;
        if (Math.abs(dx) > 40) { dx < 0 ? this.next() : this.prev(); }
        this.startX = null;
        this.autoplay();
      },
      init(){ this.autoplay(); }
    }
  }
</script>
<style>
/* Animation Keyframes */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

@keyframes floatIn {
  from { opacity: 0; transform: translateY(30px) scale(0.95); }
  to { opacity: 1; transform: translateY(0) scale(1); }
}

@keyframes slideInFromLeft {
  from { opacity: 0; transform: translateX(-20px); }
  to { opacity: 1; transform: translateX(0); }
}

@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.8; transform: scale(1.1); }
}


/* Base Animation Classes */
.animate-fade-in {
  animation: fadeIn 0.8s ease-out forwards;
  opacity: 0;
}

.animate-slide-up {
  animation: slideUp 0.8s ease-out forwards;
  opacity: 0;
}

.animate-float-in {
  animation: floatIn 1s ease-out forwards;
  opacity: 0;
}

/* Delay Classes */
.delay-300 { animation-delay: 0.3s; }
.delay-500 { animation-delay: 0.5s; }
.delay-700 { animation-delay: 0.7s; }
.delay-900 { animation-delay: 0.9s; }
.delay-1100 { animation-delay: 1.1s; }
.delay-1300 { animation-delay: 1.3s; }

/* Letter Animation for Title */
.letter-animation .letter {
  display: inline-block;
  animation: slideUp 0.8s ease-out forwards;
  animation-delay: var(--delay);
  opacity: 0;
}


/* Enhanced Hover Effects */
.hover-lift {
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.hover-lift:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}

.nav-btn-hover {
  transition: all 0.3s ease;
}

.nav-btn-hover:hover {
  transform: scale(1.1);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.btn-hover-effect {
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.btn-hover-effect:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.btn-hover-effect::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s;
}

.btn-hover-effect:hover::before {
  left: 100%;
}

/* Timeline Animations */
.timeline-item {
  animation: slideInFromLeft 0.8s ease-out forwards;
  animation-delay: var(--delay);
  opacity: 0;
}

.timeline-dot {
  transition: all 0.3s ease;
}

.timeline-dot:hover {
  transform: scale(1.2);
}

/* Carousel Enhancements */
.dot-indicator {
  transition: all 0.3s ease;
}

.dot-indicator:hover {
  transform: scale(1.2);
}


/* Responsive */
@media (max-width: 768px) {
  .letter-animation .letter {
    animation-duration: 0.6s;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {

  // Enhanced input focus effects
  const inputs = document.querySelectorAll('input, textarea, select');
  inputs.forEach(input => {
    input.addEventListener('focus', function() {
      this.style.transform = 'translateY(-1px)';
      this.style.boxShadow = '0 4px 15px rgba(6, 182, 212, 0.1)';
    });

    input.addEventListener('blur', function() {
      this.style.transform = '';
      this.style.boxShadow = '';
    });
  });

  // Timeline stagger animation
  const timelineItems = document.querySelectorAll('.timeline-item');
  timelineItems.forEach((item, index) => {
    item.style.setProperty('--delay', (index * 0.1) + 's');
  });

});
</script>

{{-- Start Sidebar --}}
<style>
  details > summary { list-style: none; }
  details > summary::-webkit-details-marker { display: none; }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('button[data-toggle]').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-toggle');
      const panel = document.getElementById(id);
      if (!panel) return;

      // toggle visibility
      panel.classList.toggle('hidden');

      // update aria-expanded
      const expanded = btn.getAttribute('aria-expanded') === 'true';
      btn.setAttribute('aria-expanded', (!expanded).toString());

      // rotate chevron (optional)
      const chev = btn.querySelector('[data-chevron]');
      if (chev) chev.classList.toggle('rotate-180');
    });
  });
});
</script>
{{-- End of Sidebar --}}

</body>
</html>
