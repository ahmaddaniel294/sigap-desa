<aside class="dashboard-sidebar">
  <div class="sidebar-brand">
    <div class="brand-badge lifemedia-logo-badge">
      <img src="{{ asset('images/lifemedia-logo.png') }}" alt="Logo Lifemedia">
    </div>
    <div>
      <h4>LifeCare</h4>
      <p>Teknisi Lifemedia</p>
    </div>
  </div>
  <div class="sidebar-section">
    <div class="sidebar-section-title">Menu Teknisi</div>
    <a class="sidebar-link {{ request()->routeIs('teknisi.dashboard') ? 'active' : '' }}" href="{{ route('teknisi.dashboard') }}">
      <i class="fa-solid fa-ticket"></i><span>Daftar Tiket</span>
    </a>
  </div>
  <div class="sidebar-card">
    <p class="eyebrow">LifeCare E-Tiket</p>
    <h6>Penanganan Gangguan</h6>
    <p class="small mb-0">Perbarui progres dan catatan agar pelanggan dapat memantau penanganan.</p>
  </div>
</aside>
