@extends('layouts.app')

@section('title', 'Dashboard Teknisi — LifeCare')
@section('body_class', 'dashboard-body')

@section('dashboard_shell')
<div class="dashboard-shell admin-dashboard">
  @include('technician.partials.sidebar')
  <main class="dashboard-main">
    <header class="dashboard-topbar">
      <div>
        <strong>Dashboard Teknisi</strong>
        <span class="text-muted"> · Tiket yang ditugaskan kepada Anda</span>
      </div>
      <div class="topbar-actions">
        <div class="user-chip">
          <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
          <div><strong>{{ auth()->user()->name }}</strong><p>Teknisi Lifemedia</p></div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-logout" type="submit">Keluar</button>
        </form>
      </div>
    </header>

    <div class="dashboard-content">
      @include('admin.partials.feedback')

      <section class="hero-panel">
        <div>
          <p class="eyebrow">LifeCare E-Tiket</p>
          <h1 class="h2">Halo, {{ auth()->user()->name }}</h1>
          <p>Kelola tiket gangguan internet dan catat setiap progres penanganan.</p>
        </div>
        <div class="hero-widget">
          <div class="date-pill"><i class="fa-solid fa-calendar-day"></i>{{ now()->translatedFormat('l, d F Y') }}</div>
          <div class="weather-pill"><i class="fa-solid fa-wifi"></i><span>Tim Teknis Lifemedia</span></div>
        </div>
      </section>

      <section class="stats-grid">
        <article class="stat-card accent-blue"><div class="stat-icon"><i class="fa-solid fa-ticket"></i></div><div><p>Total Tiket</p><h3>{{ $stats['total'] }}</h3></div></article>
        <article class="stat-card accent-gold"><div class="stat-icon"><i class="fa-solid fa-inbox"></i></div><div><p>Perlu Ditangani</p><h3>{{ $stats['baru'] }}</h3></div></article>
        <article class="stat-card accent-navy"><div class="stat-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div><div><p>Sedang Diproses</p><h3>{{ $stats['diproses'] }}</h3></div></article>
        <article class="stat-card accent-green"><div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div><div><p>Selesai</p><h3>{{ $stats['selesai'] }}</h3></div></article>
      </section>

      <section class="panel-card table-panel">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Penugasan Anda</p>
            <h2 class="h5 mb-1">Tiket Gangguan</h2>
            <p class="text-muted mb-0">Buka tiket untuk melihat detail pelanggan dan memperbarui progres.</p>
          </div>
        </div>
        @if ($complaints->isEmpty())
          <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-ticket"></i></div>
            <h3 class="h6">Belum ada tiket yang ditugaskan</h3>
            <p>Tiket baru akan muncul setelah admin menugaskannya kepada Anda.</p>
          </div>
        @else
          <div class="table-wrapper">
            <table class="table modern-table">
              <thead><tr><th>Nomor Tiket</th><th>Pelanggan</th><th>Gangguan</th><th>Lokasi</th><th>Status</th><th>Aksi</th></tr></thead>
              <tbody>
                @foreach ($complaints as $ticket)
                  <tr>
                    <td><strong>TKT-{{ str_pad((string) $ticket->id, 6, '0', STR_PAD_LEFT) }}</strong><div class="small text-muted">{{ $ticket->created_at->format('d M Y') }}</div></td>
                    <td>{{ $ticket->user->name }}</td>
                    <td>{{ $ticket->category }}</td>
                    <td>{{ $ticket->location }}</td>
                    <td><span class="badge-status badge-{{ strtolower($ticket->status) }}">{{ $ticket->status }}</span></td>
                    <td><a href="{{ route('teknisi.tiket.show', $ticket) }}" class="action-btn" aria-label="Buka tiket TKT-{{ $ticket->id }}"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="mt-3">{{ $complaints->links() }}</div>
        @endif
      </section>
    </div>
  </main>
</div>
@endsection
