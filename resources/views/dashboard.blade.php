@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
  <div class="mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
  </div>

  <x-glass-card title="Welcome {{ Auth::user()->name }}!" subtitle="Data ini hanya contoh — sesuaikan field sesuai kebutuhan.">
  </x-glass-card>
@endsection
