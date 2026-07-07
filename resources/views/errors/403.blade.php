@extends('layouts.app')

@section('title', '403 — SIGAP Desa')

@section('content')
<div class="container py-5 text-center">
  <div style="font-family:Poppins; font-weight:700; font-size:4rem; color:#0B2545;">403</div>
  <p class="text-muted mb-4">{{ $exception->getMessage() ?: 'Anda tidak memiliki akses ke halaman ini.' }}</p>
  <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
</div>
@endsection
