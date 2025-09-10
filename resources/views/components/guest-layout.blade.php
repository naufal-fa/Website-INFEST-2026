@props(['title' => null])

@extends('layouts.auth')

@section('content')
  {{ $slot }}
@endsection