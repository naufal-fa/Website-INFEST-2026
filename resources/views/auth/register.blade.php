@extends('layouts.auth')

@section('title', 'Register')

@section('content')
  <div class="mb-6 text-center">
    <h1 class="text-2xl font-semibold text-gray-800">Create your account</h1>
    <p class="mt-1 text-sm text-gray-500">Join us and get started</p>
  </div>

  <form method="POST" action="{{ route('register') }}" class="space-y-5">
    @csrf

    {{-- Name --}}
    <div>
      <label for="name" class="mb-1 block text-sm font-medium text-gray-700">Name</label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
             class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 text-gray-900 shadow-sm outline-none ring-1 ring-transparent focus:border-cyan-300 focus:ring-cyan-200"
             placeholder="Your name">
      @error('name')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    </div>

    {{-- Email --}}
    <div>
      <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required
             class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 text-gray-900 shadow-sm outline-none ring-1 ring-transparent focus:border-cyan-300 focus:ring-cyan-200"
             placeholder="you@example.com">
      @error('email')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    </div>

    {{-- Password --}}
    <div>
      <label for="password" class="mb-1 block text-sm font-medium text-gray-700">Password</label>
      <input id="password" type="password" name="password" required
             class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 text-gray-900 shadow-sm outline-none ring-1 ring-transparent focus:border-cyan-300 focus:ring-cyan-200"
             placeholder="Min. 8 characters">
      @error('password')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    </div>

    {{-- Confirm --}}
    <div>
      <label for="password_confirmation" class="mb-1 block text-sm font-medium text-gray-700">Confirm Password</label>
      <input id="password_confirmation" type="password" name="password_confirmation" required
             class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 text-gray-900 shadow-sm outline-none ring-1 ring-transparent focus:border-cyan-300 focus:ring-cyan-200"
             placeholder="Repeat password">
    </div>

    <button type="submit"
            class="group inline-flex w-full items-center justify-center gap-2 rounded-xl bg-cyan-600 px-4 py-2.5 font-semibold text-white shadow-md shadow-cyan-200 transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-300">
      Create Account <span class="transition-transform group-hover:translate-x-0.5">→</span>
    </button>

    <p class="text-center text-sm text-gray-600">
      Already have an account?
      <a href="{{ route('login') }}" class="font-medium text-cyan-700 hover:text-cyan-800">Sign in</a>
    </p>
  </form>
@endsection
