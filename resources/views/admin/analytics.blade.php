@extends('layouts.app')

@section('title', 'Analitik Pengaduan — LifeCare')
@section('body_class', 'dashboard-body')

@section('dashboard_shell')
<div class="dashboard-shell admin-dashboard">
  @include('admin.partials.sidebar')

  <main class="dashboard-main">
    @include('admin.partials.topbar')

    <div class="dashboard-content">
      <section class="hero-panel">
        <div>
          <p class="eyebrow">LifeCare · Lifemedia</p>
          <h1 class="h2">Analitik Pengaduan</h1>
          <p>Ringkasan status, jenis gangguan, dan jumlah pengaduan pelanggan.</p>
        </div>
        <a class="btn btn-outline-light" href="{{ route('admin.pengaduan.index') }}">Lihat semua pengaduan</a>
      </section>

      <section class="stats-grid">
        <article class="stat-card accent-blue"><div class="stat-icon"><i class="fa-solid fa-inbox"></i></div><div><p>Pengaduan Masuk</p><h3>{{ $stats['masuk'] }}</h3></div></article>
        <article class="stat-card accent-gold"><div class="stat-icon"><i class="fa-solid fa-wifi"></i></div><div><p>Sedang Ditangani</p><h3>{{ $stats['diproses'] }}</h3></div></article>
        <article class="stat-card accent-green"><div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div><div><p>Selesai</p><h3>{{ $stats['selesai'] }}</h3></div></article>
        <article class="stat-card accent-navy"><div class="stat-icon"><i class="fa-solid fa-chart-pie"></i></div><div><p>Total Pengaduan</p><h3>{{ $stats['total'] }}</h3></div></article>
      </section>

      <section class="bottom-grid">
        <article class="panel-card">
          <div class="panel-head"><div><p class="eyebrow">Tren</p><h2 class="h5">Pengaduan per Hari</h2></div></div>
          @if ($trend->isEmpty())
            <p class="text-muted mb-0">Belum ada data pengaduan untuk dianalisis.</p>
          @else
            <div class="table-wrapper">
              <table class="table modern-table">
                <thead><tr><th>Tanggal</th><th>Jumlah Pengaduan</th></tr></thead>
                <tbody>
                  @foreach ($trend as $day)
                    <tr><td>{{ \Illuminate\Support\Carbon::parse($day->day)->format('d M Y') }}</td><td>{{ $day->jumlah }}</td></tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </article>

        <article class="panel-card">
          <div class="panel-head"><div><p class="eyebrow">Kategori</p><h2 class="h5">Jenis Gangguan</h2></div></div>
          @if ($categories->isEmpty())
            <p class="text-muted mb-0">Belum ada kategori gangguan.</p>
          @else
            <div class="report-mini-grid">
              @foreach ($categories as $category)
                <div class="report-mini-item"><strong>{{ $category->jumlah }}</strong><span>{{ $category->category }}</span></div>
              @endforeach
            </div>
          @endif
        </article>
      </section>
    </div>
  </main>
</div>
@endsection
