@php
  $menus = [
    [
      'label' => 'Dashboard',
      'icon'  => 'M3 12h18M12 3v18', // plus icon simple (contoh)
      'href'  => route('dashboard'),
      'active'=> request()->routeIs('dashboard'),
    ],
    // Contoh group "Events"
    [
      'label' => 'Daftar Event',
      'icon'  => 'M4 6h16M4 12h16M4 18h16', // menu icon
      'children' => [
        ['label' => 'INSHOW',   'href' => url('/events/inshow'),   'active'=> request()->is('events/inshow')],
        ['label' => 'INCOME',   'href' => url('/events/income'),   'active'=> request()->is('events/income')],
        ['label' => 'INVISDAY', 'href' => url('/events/invisday'), 'active'=> request()->is('events/invisday')],
        ['label' => 'INSTRY',   'href' => url('/events/instry'),   'active'=> request()->is('events/instry')],
      ],
    ],
  ];
@endphp

<aside class="w-64 shrink-0">
  <div class="sticky top-20">
    <nav class="rounded-2xl border border-gray-100 bg-white/70 backdrop-blur shadow-sm
                max-h-[calc(100vh-6rem)] overflow-y-auto">
      <ul class="p-2">
        @foreach ($menus as $item)
          @if (isset($item['children']))
            {{-- Item dengan submenu --}}
            @php
              $anyActive = collect($item['children'])->contains(fn($c) => $c['active'] ?? false);
              $groupId = \Illuminate\Support\Str::slug($item['label']).'-submenu';
            @endphp
            <li class="mb-1">
              <button type="button"
                class="w-full flex items-center justify-between rounded-xl px-3 py-2 text-sm
                       {{ $anyActive ? 'bg-cyan-50 text-cyan-700 ring-1 ring-cyan-200' : 'text-gray-700 hover:bg-gray-50' }}"
                data-toggle="{{ $groupId }}"
                aria-expanded="{{ $anyActive ? 'true' : 'false' }}"
                aria-controls="{{ $groupId }}">
                <span class="inline-flex items-center gap-2">
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] ?? '' }}" />
                  </svg>
                  <span class="font-medium">{{ $item['label'] }}</span>
                </span>
                <svg class="h-4 w-4 transition-transform {{ $anyActive ? 'rotate-180' : '' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6"/>
                </svg>
              </button>

              <ul id="{{ $groupId }}" class="mt-1 pl-2 space-y-1 {{ $anyActive ? '' : 'hidden' }}">
                @foreach ($item['children'] as $child)
                  <li>
                    <a href="{{ $child['href'] }}"
                       class="block rounded-lg px-3 py-2 text-sm
                              {{ ($child['active'] ?? false)
                                  ? 'bg-cyan-100 text-cyan-800 ring-1 ring-cyan-200'
                                  : 'text-gray-600 hover:bg-gray-50' }}">
                      {{ $child['label'] }}
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
            {{-- Item biasa --}}
            <li class="mb-1">
              <a href="{{ $item['href'] }}"
                 class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm
                        {{ ($item['active'] ?? false)
                            ? 'bg-cyan-50 text-cyan-700 ring-1 ring-cyan-200'
                            : 'text-gray-700 hover:bg-gray-50' }}">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] ?? '' }}" />
                </svg>
                <span class="font-medium">{{ $item['label'] }}</span>
              </a>
            </li>
          @endif
        @endforeach
      </ul>
    </nav>
  </div>
</aside>
