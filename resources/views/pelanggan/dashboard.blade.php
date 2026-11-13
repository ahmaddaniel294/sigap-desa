@extends('layouts.app')

@section('title', 'Dashboard Pelanggan — LifeCare')
@section('body_class', 'dashboard-body')

@section('content')
<div class="dashboard-shell admin-dashboard">
  @include('pelanggan.partials.dashboard-sidebar')

  <main class="dashboard-main">
    <div class="dashboard-topbar">
      <div>
        <h1 class="section-title mb-1">Halo, {{ auth()->user()->name }}</h1>
        <p class="text-muted mb-0">Ringkasan tiket gangguan internet dan Wi-Fi Anda.</p>
      </div>
    </div>

    <div class="dashboard-content">
      <section class="hero-panel">
        <div>
          <p class="eyebrow">Layanan Pelanggan Lifemedia</p>
          <h2>Pantau pengaduan internet Anda dengan mudah.</h2>
          <p>Gunakan menu di samping untuk melihat aktivitas, progres tiket, dan laporan secara terpisah.</p>
          <div class="hero-actions">
            <a href="{{ route('warga.pengaduan.create') }}" class="btn btn-primary">Buat Pengaduan Baru</a>
            <a href="{{ route('warga.progress') }}" class="btn btn-outline-light">Lihat Progres Tiket</a>
          </div>
        </div>
        <div class="hero-widget">
          <div class="date-pill"><i class="fas fa-calendar-day"></i> {{ now()->translatedFormat('l, d F Y') }}</div>
          <div class="weather-pill"><i class="fas fa-wifi"></i> Layanan Lifemedia</div>
        </div>
      </section>

      <section class="stats-grid">
        <article class="stat-card accent-blue">
          <div class="stat-icon"><i class="fas fa-envelope-open-text"></i></div>
          <div><p>Total Pengaduan</p><h3>{{ $complaints->count() }}</h3></div>
        </article>
        <article class="stat-card accent-gold">
          <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
          <div><p>Dalam Proses</p><h3>{{ $complaints->where('status', 'Diproses')->count() }}</h3></div>
        </article>
        <article class="stat-card accent-green">
          <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
          <div><p>Selesai</p><h3>{{ $complaints->where('status', 'Selesai')->count() }}</h3></div>
        </article>
        <article class="stat-card accent-navy">
          <div class="stat-icon"><i class="fas fa-clock"></i></div>
          <div><p>Pengaduan Terakhir</p><h3>{{ $complaints->first()?->created_at->format('d M Y H:i') ?? 'Belum ada' }}</h3></div>
        </article>
      </section>

      <div class="customer-route-cards">
        <a class="customer-route-card" href="{{ route('warga.aktivitas') }}">
          <span class="customer-route-icon"><i class="fas fa-clock"></i></span>
          <span><strong>Aktivitas Pengaduan</strong><small>Lihat seluruh tiket dan riwayat terbaru.</small></span>
          <i class="fas fa-arrow-right"></i>
        </a>
        <a class="customer-route-card" href="{{ route('warga.progress') }}">
          <span class="customer-route-icon"><i class="fas fa-list-check"></i></span>
          <span><strong>Progres Tiket</strong><small>Pantau tiket menunggu, diproses, dan selesai.</small></span>
          <i class="fas fa-arrow-right"></i>
        </a>
        <a class="customer-route-card" href="{{ route('warga.laporan.index') }}">
          <span class="customer-route-icon"><i class="fas fa-file-lines"></i></span>
          <span><strong>Laporan</strong><small>Lihat ringkasan dan unduh laporan PDF.</small></span>
          <i class="fas fa-arrow-right"></i>
        </a>
      </div>
    </div>
  </main>
</div>
@endsection
