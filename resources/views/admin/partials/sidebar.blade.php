<aside class="dashboard-sidebar">
  <div class="sidebar-brand">
    <div class="brand-badge lifemedia-logo-badge">
      <img src="{{ asset('images/lifemedia-logo.png') }}" alt="Logo Lifemedia">
    </div>
    <div>
      <h4>LifeCare</h4>
      <p>Admin Lifemedia</p>
    </div>
  </div>

  <div class="sidebar-section">
    <div class="sidebar-section-title">Menu Utama</div>
    <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
      <i class="fa-solid fa-grid-2"></i><span>Dashboard</span>
    </a>
    <a class="sidebar-link {{ request()->routeIs('admin.pengaduan.*') ? 'active' : '' }}" href="{{ route('admin.pengaduan.index') }}">
      <i class="fa-solid fa-wifi"></i><span>Pengaduan</span>
    </a>
    <a class="sidebar-link {{ request()->routeIs('admin.pengaduan.unassigned') ? 'active' : '' }}" href="{{ route('admin.pengaduan.unassigned') }}">
      <i class="fa-solid fa-inbox"></i><span>Belum Ditugaskan</span>
      @if ($unassignedTicketsCount > 0)
        <span class="sidebar-count">{{ $unassignedTicketsCount }}</span>
      @endif
    </a>
    <a class="sidebar-link {{ request()->routeIs('admin.analitik') ? 'active' : '' }}" href="{{ route('admin.analitik') }}">
      <i class="fa-solid fa-chart-column"></i><span>Analitik</span>
    </a>
    <a class="sidebar-link {{ request()->routeIs('admin.laporan.index') ? 'active' : '' }}" href="{{ route('admin.laporan.index') }}">
      <i class="fa-solid fa-file-lines"></i><span>Laporan</span>
    </a>
  </div>

  <div class="sidebar-section">
    <div class="sidebar-section-title">Pengaturan</div>
    <a class="sidebar-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}" href="{{ route('admin.kategori.index') }}">
      <i class="fa-solid fa-list"></i><span>Jenis Gangguan</span>
    </a>
    <a class="sidebar-link {{ request()->routeIs('admin.teknisi.*') ? 'active' : '' }}" href="{{ route('admin.teknisi.index') }}">
      <i class="fa-solid fa-screwdriver-wrench"></i><span>Teknisi</span>
    </a>
  </div>

  <div class="sidebar-card">
    <p class="eyebrow">LifeCare</p>
    <h6>Dukungan Internet Lifemedia</h6>
    <p class="small mb-0">Kelola laporan pelanggan dan pantau tindak lanjut gangguan.</p>
  </div>
</aside>
