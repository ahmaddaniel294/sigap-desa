@extends('layouts.app')

@section('title', 'Laporan Pengaduan — LifeCare')
@section('body_class', 'dashboard-body')

@section('dashboard_shell')
<div class="dashboard-shell admin-dashboard">
  @include('admin.partials.sidebar')

  <main class="dashboard-main">
    @include('admin.partials.topbar')

    <div class="dashboard-content">
      <section class="hero-panel">
        <div>
          <p class="eyebrow">Dokumen Operasional</p>
          <h1 class="h2">Laporan Pengaduan</h1>
          <p>Unduh rekap gangguan internet dan Wi-Fi Lifemedia untuk arsip atau evaluasi.</p>
        </div>
        <a class="btn btn-outline-light" href="{{ route('admin.laporan.pdf') }}"><i class="fa-solid fa-file-pdf me-2"></i>Unduh PDF</a>
      </section>

      <section class="stats-grid">
        <article class="stat-card accent-navy"><div class="stat-icon"><i class="fa-solid fa-chart-pie"></i></div><div><p>Total Pengaduan</p><h3>{{ $stats['total'] }}</h3></div></article>
        <article class="stat-card accent-blue"><div class="stat-icon"><i class="fa-solid fa-inbox"></i></div><div><p>Baru Masuk</p><h3>{{ $stats['masuk'] }}</h3></div></article>
        <article class="stat-card accent-gold"><div class="stat-icon"><i class="fa-solid fa-wifi"></i></div><div><p>Sedang Ditangani</p><h3>{{ $stats['diproses'] }}</h3></div></article>
        <article class="stat-card accent-green"><div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div><div><p>Selesai</p><h3>{{ $stats['selesai'] }}</h3></div></article>
      </section>

      <section class="panel-card">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Ekspor</p>
            <h2 class="h5">Rekap Pengaduan Lifemedia</h2>
          </div>
          <a class="btn btn-primary" href="{{ route('admin.laporan.pdf') }}">Unduh Laporan PDF</a>
        </div>
        <p class="text-muted mb-0">
          @if ($latestComplaint)
            Pengaduan terbaru diterima {{ $latestComplaint->created_at->format('d M Y, H:i') }} dari {{ $latestComplaint->user->name }}.
          @else
            Belum ada pengaduan yang dapat dimasukkan ke laporan.
          @endif
        </p>
      </section>
    </div>
  </main>
</div>
@endsection
