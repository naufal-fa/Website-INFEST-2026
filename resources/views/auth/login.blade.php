@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
  <div class="mb-6 text-center">
    <h1 class="text-2xl font-semibold text-gray-800">Welcome back</h1>
    <p class="mt-1 text-sm text-gray-500">Sign in to continue</p>
  </div>

  @if (session('status'))
    <div class="mb-4 rounded-lg border border-cyan-200 bg-cyan-50 px-4 py-3 text-sm text-cyan-800">
      {{ session('status') }}
    </div>
  @endif

  <form method="POST" action="{{ route('login') }}" class="space-y-5">
    @csrf

    {{-- Email --}}
    <div>
      <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
             class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 text-gray-900 shadow-sm outline-none ring-1 ring-transparent focus:border-cyan-300 focus:ring-cyan-200"
             placeholder="you@example.com">
      @error('email')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    </div>

    {{-- Password --}}
    <div>
      <div class="mb-1 flex items-center justify-between">
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="text-xs font-medium text-cyan-700 hover:text-cyan-800">Forgot password?</a>
        @endif
      </div>
      <input id="password" type="password" name="password" required
             class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 text-gray-900 shadow-sm outline-none ring-1 ring-transparent focus:border-cyan-300 focus:ring-cyan-200"
             placeholder="••••••••">
      @error('password')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    </div>

    {{-- Remember --}}
    <div class="flex items-center justify-between">
      <label class="inline-flex items-center gap-2 text-sm text-gray-600">
        <input type="checkbox" name="remember" class="rounded border-gray-300 text-cyan-600 focus:ring-cyan-500">
        Remember me
      </label>
    </div>

    {{-- Submit --}}
    <button type="submit" id="login-submit"
            class="group inline-flex w-full items-center justify-center gap-2 rounded-xl bg-cyan-600 px-4 py-2.5 font-semibold text-white shadow-md shadow-cyan-200 transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-300">
      Sign In <span class="transition-transform group-hover:translate-x-0.5">→</span>
    </button>

    {{-- To Register --}}
    <p class="text-center text-sm text-gray-600">
      Don’t have an account?
      <a href="{{ route('register') }}" class="font-medium text-cyan-700 hover:text-cyan-800">Create one</a>
    </p>
  </form>
@endsection