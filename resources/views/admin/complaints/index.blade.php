@extends('layouts.app')

@section('title', 'Pengaduan Pelanggan — LifeCare')
@section('body_class', 'dashboard-body')

@section('dashboard_shell')
<div class="dashboard-shell admin-dashboard">
  @include('admin.partials.sidebar')

  <main class="dashboard-main">
    @include('admin.partials.topbar', ['search' => true])

    <div class="dashboard-content">
      <section class="panel-card table-panel">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Layanan Lifemedia</p>
            <h1 class="section-title mb-1">{{ $unassignedOnly ? 'Tiket Belum Ditugaskan' : 'Pengaduan Pelanggan' }}</h1>
            <p class="text-muted mb-0">{{ $unassignedOnly ? 'Tiket yang belum memiliki teknisi untuk ditangani.' : 'Tinjau dan tindak lanjuti gangguan internet dan Wi-Fi.' }}</p>
          </div>
          @if ($unassignedOnly)
            <a class="btn btn-outline-primary" href="{{ route('admin.pengaduan.index') }}">Semua pengaduan</a>
          @else
            <a class="btn btn-outline-primary" href="{{ route('admin.laporan.index') }}">Lihat laporan</a>
          @endif
        </div>

        <form class="panel-filters" method="GET" action="{{ route('admin.pengaduan.index') }}">
          <input class="form-control" type="search" name="search" value="{{ $search }}" placeholder="Cari nama, lokasi, atau gangguan">
          <select class="form-select" name="status" aria-label="Filter status">
            <option value="">Semua status</option>
            @foreach (\App\Models\Complaint::STATUS_FLOW as $statusOption)
              <option value="{{ $statusOption }}" {{ $status === $statusOption ? 'selected' : '' }}>{{ $statusOption }}</option>
            @endforeach
          </select>
          <button class="btn btn-primary" type="submit">Terapkan</button>
          @if ($search !== '' || $status)
            <a class="btn btn-outline-secondary" href="{{ route('admin.pengaduan.index') }}">Reset</a>
          @endif
        </form>

        @if ($complaints->isEmpty())
          <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-wifi"></i></div>
            <h2 class="h6">Pengaduan tidak ditemukan</h2>
            <p>Pengaduan yang sesuai dengan pencarian atau filter akan muncul di sini.</p>
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
                  <th>Teknisi</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($complaints as $complaint)
                  <tr>
                    <td>{{ $complaint->created_at->format('d M Y') }}</td>
                    <td><strong>{{ $complaint->user->name }}</strong></td>
                    <td>{{ $complaint->category }}</td>
                    <td>{{ $complaint->location }}</td>
                    <td>{{ $complaint->technician?->name ?? 'Belum ditugaskan' }}</td>
                    <td><span class="badge-status badge-{{ strtolower($complaint->status) }}">{{ $complaint->status }}</span></td>
                    <td><a href="{{ route('admin.pengaduan.show', $complaint) }}" class="action-btn" aria-label="Lihat pengaduan {{ $complaint->id }}"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></td>
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
