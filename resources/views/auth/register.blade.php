@extends('layouts.app')

@section('title', 'Daftar Pelanggan — LifeCare')
@section('body_class', 'lifecare-auth')

@section('content')
<div class="container">
  <div class="auth-shell card-flat p-4 p-md-5">
    <h3 class="section-title mb-1">Daftar sebagai Pelanggan</h3>
    <p class="text-muted mb-4">Buat akun LifeCare untuk mengirim dan memantau pengaduan internet Lifemedia.</p>
    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat pemasangan Lifemedia</label>
        <input type="text" name="dusun" class="form-control" placeholder="Masukkan alamat pemasangan internet" value="{{ old('dusun') }}">
      </div>
      <div class="mb-3">
        <label class="form-label">Kata Sandi</label>
        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="6">
        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <button class="btn btn-primary w-100" type="submit">Daftar</button>
    </form>
    <p class="text-muted small mt-4 mb-0">
      Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
    </p>
  </div>
</div>
@endsection
