<aside class="dashboard-sidebar">
  <div class="sidebar-brand">
    <div class="brand-badge lifemedia-logo-badge">
      <img src="{{ asset('images/lifemedia-logo.png') }}" alt="Logo Lifemedia">
    </div>
    <div>
      <h4>LifeCare</h4>
      <p>Portal Pelanggan</p>
    </div>
  </div>

  <div>
    <div class="sidebar-section-title">Menu Pelanggan</div>
    <a class="sidebar-link {{ request()->routeIs('warga.dashboard') ? 'active' : '' }}" href="{{ route('warga.dashboard') }}">
      <i class="fas fa-chart-line"></i><span>Ringkasan</span>
    </a>
    <a class="sidebar-link {{ request()->routeIs('warga.pengaduan.create') ? 'active' : '' }}" href="{{ route('warga.pengaduan.create') }}">
      <i class="fas fa-plus-circle"></i><span>Buat Pengaduan</span>
    </a>
    <a class="sidebar-link {{ request()->routeIs('warga.aktivitas', 'warga.pengaduan.show') ? 'active' : '' }}" href="{{ route('warga.aktivitas') }}">
      <i class="fas fa-clock"></i><span>Aktivitas</span>
    </a>
    <a class="sidebar-link {{ request()->routeIs('warga.progress') ? 'active' : '' }}" href="{{ route('warga.progress') }}">
      <i class="fas fa-tasks"></i><span>Progres Tiket</span>
    </a>
    <a class="sidebar-link {{ request()->routeIs('warga.laporan.index') ? 'active' : '' }}" href="{{ route('warga.laporan.index') }}">
      <i class="fas fa-file-pdf"></i><span>Laporan</span>
    </a>
  </div>

  <div class="sidebar-card">
    <div class="eyebrow">Status Akun</div>
    <div class="progress-pill">Pelanggan Lifemedia</div>
    <p class="mb-0">Kelola tiket dan pantau tindak lanjut gangguan internet.</p>
  </div>
</aside>
