@extends('layouts.app')

@section('title', 'Dashboard Admin — LifeCare')
@section('body_class', 'dashboard-body')

@section('dashboard_shell')
<div class="dashboard-shell admin-dashboard">
  @include('admin.partials.sidebar')

  <main class="dashboard-main">
    @include('admin.partials.topbar')

    <div class="dashboard-content">
      <section class="hero-panel">
        <div>
          <p class="eyebrow">LifeCare · Dukungan Internet Lifemedia</p>
          <h1 class="h2">Dashboard Pengaduan</h1>
          <p>Pantau gangguan internet pelanggan dan tindak lanjut tim Lifemedia.</p>
          <div class="hero-actions">
            <a class="btn btn-primary" href="{{ route('admin.pengaduan.index') }}">Buka Pengaduan</a>
            <a class="btn btn-outline-light" href="{{ route('admin.analitik') }}">Lihat Analitik</a>
          </div>
        </div>
        <div class="hero-widget">
          <div class="date-pill">{{ now()->translatedFormat('l, d F Y') }}</div>
          <div class="weather-pill"><i class="fa-solid fa-wifi"></i><span>Layanan Lifemedia</span></div>
        </div>
      </section>

      <section class="stats-grid">
        <article class="stat-card accent-blue"><div class="stat-icon"><i class="fa-solid fa-inbox"></i></div><div><p>Pengaduan Masuk</p><h3>{{ $stats['masuk'] }}</h3></div></article>
        <article class="stat-card accent-gold"><div class="stat-icon"><i class="fa-solid fa-wifi"></i></div><div><p>Sedang Ditangani</p><h3>{{ $stats['diproses'] }}</h3></div></article>
        <article class="stat-card accent-green"><div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div><div><p>Selesai</p><h3>{{ $stats['selesai'] }}</h3></div></article>
        <article class="stat-card accent-navy"><div class="stat-icon"><i class="fa-solid fa-chart-pie"></i></div><div><p>Total Pengaduan</p><h3>{{ $stats['total'] }}</h3></div></article>
      </section>

      <section class="panel-card table-panel">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Aktivitas terbaru</p>
            <h2 class="h5">Pengaduan Terbaru</h2>
          </div>
          <a class="management-link" href="{{ route('admin.pengaduan.index') }}">Lihat semua pengaduan</a>
        </div>

        @if ($recentComplaints->isEmpty())
          <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-wifi"></i></div>
            <h3 class="h6">Belum ada pengaduan</h3>
            <p>Pengaduan gangguan internet dari pelanggan akan muncul di sini.</p>
          </div>
        @else
          <div class="table-wrapper">
            <table class="table modern-table">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Pelanggan</th>
                  <th>Jenis Gangguan</th>
                  <th>Alamat Pemasangan</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($recentComplaints as $complaint)
                  <tr>
                    <td>{{ $complaint->created_at->format('d M Y') }}</td>
                    <td><strong>{{ $complaint->user->name }}</strong></td>
                    <td>{{ $complaint->category }}</td>
                    <td>{{ $complaint->location }}</td>
                    <td><span class="badge-status badge-{{ strtolower($complaint->status) }}">{{ $complaint->status }}</span></td>
                    <td><a href="{{ route('admin.pengaduan.show', $complaint) }}" class="action-btn" aria-label="Lihat pengaduan {{ $complaint->id }}"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </section>
    </div>
  </main>
</div>
@endsection
