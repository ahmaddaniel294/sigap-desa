@extends('layouts.app')

@section('title', 'Masuk — SIGAP Desa')

@section('content')
<div class="container">
  <div class="auth-shell card-flat p-4 p-md-5">
    <h3 class="section-title mb-1">Masuk</h3>
    <p class="text-muted mb-4">Masuk untuk membuat atau memantau pengaduan Anda.</p>
    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Kata Sandi</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-primary w-100" type="submit">Masuk</button>
    </form>
    <p class="text-muted small mt-4 mb-0">
      Belum punya akun? <a href="{{ route('register') }}">Daftar sebagai warga</a>
    </p>
    <hr>
    <p class="text-muted small mb-0">
      Demo admin: <code>admin@desa.id</code> / <code>admin123</code><br>
      Demo warga: <code>warga@desa.id</code> / <code>warga123</code>
    </p>
  </div>
</div>
@endsection
