@extends('layouts.auth')

@section('content')
  <div class="mb-6 text-center">
    <h1 class="text-2xl font-semibold text-gray-800">Forgot your password?</h1>
    <p class="mt-1 text-sm text-gray-500">We’ll email you a reset link</p>
  </div>

  @if (session('status'))
    <div class="mb-4 rounded-lg border border-cyan-200 bg-cyan-50 px-4 py-3 text-sm text-cyan-800">
      {{ session('status') }}
    </div>
  @endif

  <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
    @csrf

    <div>
      <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
      <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
             class="w-full rounded-xl border-gray-200 bg-white px-4 py-2.5 text-gray-900 shadow-sm outline-none ring-1 ring-transparent focus:border-cyan-300 focus:ring-cyan-200"
             placeholder="you@example.com">
      @error('email')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <button type="submit"
            class="inline-flex w-full items-center justify-center rounded-xl bg-cyan-600 px-4 py-2.5 font-semibold text-white shadow-md shadow-cyan-200 transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-300">
      Send Reset Link
    </button>

    <p class="text-center text-sm text-gray-600">
      <a href="{{ route('login') }}" class="font-medium text-cyan-700 hover:text-cyan-800">Back to sign in</a>
    </p>
  </form>
@endsection
