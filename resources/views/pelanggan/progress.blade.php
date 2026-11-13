@extends('layouts.app')

@section('title', 'Progres Tiket — LifeCare')
@section('body_class', 'dashboard-body')

@section('content')
<div class="dashboard-shell admin-dashboard">
  @include('pelanggan.partials.dashboard-sidebar')
  <main class="dashboard-main">
    @include('pelanggan.partials.dashboard-topbar', [
      'pageTitle' => 'Progres Tiket',
      'pageDescription' => 'Pantau status dan tindak lanjut setiap gangguan yang Anda laporkan.',
    ])
    <div class="dashboard-content">
      <section class="stats-grid">
        <article class="stat-card accent-blue"><div class="stat-icon"><i class="fas fa-inbox"></i></div><div><p>Menunggu Tindak Lanjut</p><h3>{{ $stats['diajukan'] }}</h3></div></article>
        <article class="stat-card accent-gold"><div class="stat-icon"><i class="fas fa-screwdriver-wrench"></i></div><div><p>Sedang Diproses</p><h3>{{ $stats['diproses'] }}</h3></div></article>
        <article class="stat-card accent-green"><div class="stat-icon"><i class="fas fa-circle-check"></i></div><div><p>Selesai</p><h3>{{ $stats['selesai'] }}</h3></div></article>
      </section>

      <section class="panel-card table-panel">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Status Penanganan</p>
            <h2 class="h5 mb-1">Progres per Tiket</h2>
            <p class="text-muted mb-0">Buka detail tiket untuk membaca catatan admin dan pembaruan teknisi.</p>
          </div>
        </div>
        @if ($complaints->isEmpty())
          <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-list-check"></i></div>
            <h3 class="h6">Belum ada progres tiket</h3>
            <p>Status penanganan akan terlihat setelah Anda mengirim pengaduan.</p>
          </div>
        @else
          <div class="timeline-list">
            @foreach ($complaints as $complaint)
              <article class="customer-progress-item">
                <div class="customer-progress-marker"><i class="fas {{ $complaint->status === \App\Models\Complaint::STATUS_SELESAI ? 'fa-check' : ($complaint->status === \App\Models\Complaint::STATUS_DIPROSES ? 'fa-screwdriver-wrench' : 'fa-inbox') }}"></i></div>
                <div class="customer-progress-content">
                  <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                      <strong>TKT-{{ str_pad((string) $complaint->id, 6, '0', STR_PAD_LEFT) }} · {{ $complaint->category }}</strong>
                      <p class="mb-1">{{ $complaint->location }} · {{ $complaint->created_at->translatedFormat('d M Y, H:i') }}</p>
                    </div>
                    <span class="badge-status badge-{{ strtolower($complaint->status) }}">{{ $complaint->status }}</span>
                  </div>
                  @if ($complaint->technician)
                    <p class="small mb-1"><strong>Teknisi:</strong> {{ $complaint->technician->name }}</p>
                  @endif
                  @if ($complaint->admin_note)
                    <p class="small mb-1"><strong>Tanggapan tim:</strong> {{ $complaint->admin_note }}</p>
                  @endif
                  @if ($complaint->technician_note)
                    <p class="small mb-2"><strong>Pembaruan teknisi:</strong> {{ $complaint->technician_note }}</p>
                  @endif
                  <a class="customer-ticket-link small" href="{{ route('warga.pengaduan.show', $complaint) }}">Lihat detail tiket <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
              </article>
            @endforeach
          </div>
        @endif
      </section>
    </div>
  </main>
</div>
@endsection
