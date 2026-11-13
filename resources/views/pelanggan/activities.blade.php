@extends('layouts.app')

@section('title', 'Aktivitas Pengaduan — LifeCare')
@section('body_class', 'dashboard-body')

@section('content')
<div class="dashboard-shell admin-dashboard">
  @include('pelanggan.partials.dashboard-sidebar')
  <main class="dashboard-main">
    @include('pelanggan.partials.dashboard-topbar', [
      'pageTitle' => 'Aktivitas Pengaduan',
      'pageDescription' => 'Seluruh tiket pengaduan internet dan Wi-Fi yang pernah Anda kirim.',
    ])
    <div class="dashboard-content">
      <section class="panel-card table-panel">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Riwayat Tiket</p>
            <h2 class="h5 mb-1">Aktivitas Terbaru</h2>
            <p class="text-muted mb-0">{{ $complaints->total() }} tiket tercatat pada akun Anda.</p>
          </div>
        </div>
        @if ($complaints->isEmpty())
          <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-clock"></i></div>
            <h3 class="h6">Belum ada aktivitas</h3>
            <p>Pengaduan yang Anda kirim akan tercatat di halaman ini.</p>
            <a href="{{ route('warga.pengaduan.create') }}" class="btn btn-primary mt-2">Buat Pengaduan</a>
          </div>
        @else
          <div class="table-wrapper">
            <table class="table modern-table">
              <thead><tr><th>Tanggal</th><th>Nomor Tiket</th><th>Jenis Gangguan</th><th>Lokasi</th><th>Status</th><th>Aksi</th></tr></thead>
              <tbody>
                @foreach ($complaints as $complaint)
                  <tr>
                    <td>{{ $complaint->created_at->translatedFormat('d M Y, H:i') }}</td>
                    <td><strong>TKT-{{ str_pad((string) $complaint->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                    <td>{{ $complaint->category }}</td>
                    <td>{{ $complaint->location }}</td>
                    <td><span class="badge-status badge-{{ strtolower($complaint->status) }}">{{ $complaint->status }}</span></td>
                    <td><a href="{{ route('warga.pengaduan.show', $complaint) }}" class="action-btn" aria-label="Lihat tiket {{ $complaint->id }}"><i class="fas fa-eye"></i></a></td>
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
