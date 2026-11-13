@extends('layouts.app')

@section('title', 'Tambah Teknisi — LifeCare')
@section('body_class', 'dashboard-body')

@section('dashboard_shell')
<div class="dashboard-shell admin-dashboard">
  @include('admin.partials.sidebar')

  <main class="dashboard-main">
    @include('admin.partials.topbar')
    <div class="dashboard-content">
      @include('admin.partials.feedback')

      <section class="panel-card">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Manajemen Tim</p>
            <h1 class="section-title mb-1">Buat Akun Teknisi</h1>
            <p class="text-muted mb-0">Akun teknisi dibuat oleh admin dan digunakan untuk masuk ke dashboard penugasan.</p>
          </div>
          <a href="{{ route('admin.teknisi.index') }}" class="btn btn-outline-primary">Kembali</a>
        </div>

        <form method="POST" action="{{ route('admin.teknisi.store') }}" class="category-form">
          @csrf
          <div class="mb-3">
            <label for="technician-name" class="form-label">Nama Teknisi</label>
            <input id="technician-name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label for="technician-email" class="form-label">Email Login</label>
            <input id="technician-email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label for="technician-password" class="form-label">Kata Sandi</label>
            <input id="technician-password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8" required>
            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label for="technician-password-confirmation" class="form-label">Konfirmasi Kata Sandi</label>
            <input id="technician-password-confirmation" type="password" name="password_confirmation" class="form-control" minlength="8" required>
          </div>
          <button type="submit" class="btn btn-primary">Buat Akun Teknisi</button>
        </form>
      </section>
    </div>
  </main>
</div>
@endsection
