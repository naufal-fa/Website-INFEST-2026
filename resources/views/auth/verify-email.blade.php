@extends('layouts.auth')

@section('content')
  <div class="mb-6 text-center">
    <h1 class="text-2xl font-semibold text-gray-800">Verify your email</h1>
    <p class="mt-1 text-sm text-gray-600">
      We have sent a verification link to your email address.
      If you didn’t receive it, you can request another below.
    </p>
  </div>

  @if (session('status') == 'verification-link-sent')
    <div class="mb-4 rounded-lg border border-cyan-200 bg-cyan-50 px-4 py-3 text-sm text-cyan-800">
      A new verification link has been sent to your email.
    </div>
  @endif

  <form method="POST" action="{{ route('verification.send') }}" class="space-y-3">
    @csrf
    <button type="submit"
      class="inline-flex w-full items-center justify-center rounded-xl bg-cyan-600 px-4 py-2.5 font-semibold text-white shadow-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-300">
      Resend Verification Email
    </button>
  </form>

  <form method="POST" action="{{ route('logout') }}" class="mt-3">
    @csrf
    <button type="submit"
      class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">
      Log out
    </button>
  </form>
@endsection
