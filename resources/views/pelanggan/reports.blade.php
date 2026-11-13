@extends('layouts.app')

@section('title', 'Laporan Pengaduan — LifeCare')
@section('body_class', 'dashboard-body')

@section('content')
<div class="dashboard-shell admin-dashboard">
  @include('pelanggan.partials.dashboard-sidebar')
  <main class="dashboard-main">
    @include('pelanggan.partials.dashboard-topbar', [
      'pageTitle' => 'Laporan Pengaduan',
      'pageDescription' => 'Ringkasan tiket dan arsip penanganan pada akun Anda.',
    ])
    <div class="dashboard-content">
      <section class="stats-grid">
        <article class="stat-card accent-blue"><div class="stat-icon"><i class="fas fa-ticket"></i></div><div><p>Total Tiket</p><h3>{{ $stats['total'] }}</h3></div></article>
        <article class="stat-card accent-gold"><div class="stat-icon"><i class="fas fa-inbox"></i></div><div><p>Diajukan</p><h3>{{ $stats['diajukan'] }}</h3></div></article>
        <article class="stat-card accent-navy"><div class="stat-icon"><i class="fas fa-screwdriver-wrench"></i></div><div><p>Diproses</p><h3>{{ $stats['diproses'] }}</h3></div></article>
        <article class="stat-card accent-green"><div class="stat-icon"><i class="fas fa-circle-check"></i></div><div><p>Selesai</p><h3>{{ $stats['selesai'] }}</h3></div></article>
      </section>

      <section class="panel-card">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Arsip Pribadi</p>
            <h2 class="h5 mb-1">Unduh Laporan Pengaduan</h2>
            <p class="text-muted mb-0">Simpan ringkasan seluruh tiket dan status penanganan dalam format PDF.</p>
          </div>
        </div>
        <div class="report-highlight">
          <div class="report-highlight-top">
            <strong>LifeCare · Laporan Pelanggan</strong>
          </div>
          <p class="report-note">Laporan dibuat berdasarkan data pengaduan yang tercatat pada akun {{ auth()->user()->name }}.</p>
          <div class="report-mini-grid">
            <div class="report-mini-item"><strong>{{ $stats['diajukan'] }}</strong><span>Diajukan</span></div>
            <div class="report-mini-item"><strong>{{ $stats['diproses'] }}</strong><span>Diproses</span></div>
            <div class="report-mini-item"><strong>{{ $stats['selesai'] }}</strong><span>Selesai</span></div>
          </div>
          <a href="{{ route('warga.laporan.pdf') }}" class="btn btn-primary mt-3"><i class="fas fa-download me-1"></i> Unduh Laporan PDF</a>
        </div>
      </section>
    </div>
  </main>
</div>
@endsection
