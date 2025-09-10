@extends('layouts.auth')

@section('content')
  <div class="mb-6 text-center">
    <h1 class="text-2xl font-semibold text-gray-800">Reset password</h1>
    <p class="mt-1 text-sm text-gray-500">Enter a new password</p>
  </div>

  <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <input type="hidden" name="email" value="{{ old('email', $request->email) }}">

    {{-- New password --}}
    <div>
      <label for="password" class="mb-1 block text-sm font-medium text-gray-700">New Password</label>
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
            class="inline-flex w-full items-center justify-center rounded-xl bg-cyan-600 px-4 py-2.5 font-semibold text-white shadow-md shadow-cyan-200 transition hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-300">
      Update Password
    </button>

    <p class="text-center text-sm text-gray-600">
      <a href="{{ route('login') }}" class="font-medium text-cyan-700 hover:text-cyan-800">Back to sign in</a>
    </p>
  </form>
@endsection
