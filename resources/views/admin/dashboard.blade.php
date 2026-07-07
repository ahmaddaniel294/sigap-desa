@extends('layouts.app')

@section('title', 'Dashboard Admin — SIGAP Desa')
@section('body_class', 'dashboard-body')

@section('dashboard_shell')
<div class="dashboard-shell" id="dashboard">
  <aside class="dashboard-sidebar">
    <div class="sidebar-brand">
      <div class="brand-badge">S</div>
      <div>
        <h4>SIGAP Desa</h4>
        <p>Admin Center</p>
      </div>
    </div>

    <div class="sidebar-section">
      <div class="sidebar-section-title">Utama</div>
      <a class="sidebar-link active" href="#dashboard"><i class="fa-solid fa-grid-2"></i><span>Dashboard</span></a>
      <a class="sidebar-link" href="#complaints-table"><i class="fa-solid fa-message"></i><span>Pengaduan</span></a>
      <a class="sidebar-link" href="#analytics"><i class="fa-solid fa-chart-column"></i><span>Analitik</span></a>
      <a class="sidebar-link" href="#reports"><i class="fa-solid fa-file-lines"></i><span>Laporan</span></a>
    </div>

    <div class="sidebar-card">
      <p class="eyebrow">Hari ini</p>
      <h6>Waktu aktif layanan</h6>
      <div class="progress-pill">99.8%</div>
      <p class="small">Semua layanan desa berjalan dengan baik.</p>
    </div>
  </aside>

  <div class="dashboard-main">
    <header class="dashboard-topbar">
      <div class="topbar-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari pengaduan atau kategori" data-table-search>
      </div>

      <div class="topbar-actions">
        <button class="icon-btn" id="themeToggle" type="button" aria-label="Toggle dark mode">
          <i class="fa-solid fa-moon"></i>
        </button>
        <button class="icon-btn" id="notificationButton" type="button" aria-label="Notifications">
          <i class="fa-solid fa-bell"></i>
        </button>
        <button class="icon-btn" id="quickActionsButton" type="button" aria-label="Quick actions">
          <i class="fa-solid fa-plus"></i>
        </button>
        <div class="user-chip">
          <div class="avatar">A</div>
          <div>
            <strong>{{ auth()->user()->name }}</strong>
            <p>Admin Desa</p>
          </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn btn-logout" type="submit">Keluar</button>
        </form>
      </div>
    </header>

    <div class="dashboard-content">
      <section class="hero-panel" id="dashboard-hero">
        <div>
          <p class="eyebrow">SIGAP Desa • Pelayanan Digital</p>
          <h2>Dashboard operasional yang rapi, cepat, dan dapat dipercaya.</h2>
          <p>Kelola pengaduan, pantau perkembangan, dan respons cepat untuk kebutuhan warga desa dengan pengalaman yang modern.</p>
          <div class="hero-actions">
            <a class="btn btn-primary" href="#complaints-table">Lihat pengaduan</a>
            <a class="btn btn-outline-light" href="{{ route('admin.laporan.pdf') }}">Unduh laporan PDF</a>
          </div>
        </div>
        <div class="hero-widget">
          <div class="date-pill" id="liveDate">—</div>
          <div class="weather-pill">
            <i class="fa-solid fa-cloud-sun"></i>
            <span>24°C • Cerah</span>
          </div>
        </div>
      </section>

      <section class="stats-grid">
        <article class="stat-card accent-blue">
          <div class="stat-icon"><i class="fa-solid fa-inbox"></i></div>
          <div>
            <p>Pengaduan Masuk</p>
            <h3 data-counter="{{ $stats['masuk'] }}">{{ $stats['masuk'] }}</h3>
          </div>
        </article>
        <article class="stat-card accent-gold">
          <div class="stat-icon"><i class="fa-solid fa-spinner"></i></div>
          <div>
            <p>Sedang Diproses</p>
            <h3 data-counter="{{ $stats['diproses'] }}">{{ $stats['diproses'] }}</h3>
          </div>
        </article>
        <article class="stat-card accent-green">
          <div class="stat-icon"><i class="fa-solid fa-circle-check"></i></div>
          <div>
            <p>Selesai</p>
            <h3 data-counter="{{ $stats['selesai'] }}">{{ $stats['selesai'] }}</h3>
          </div>
        </article>
        <article class="stat-card accent-navy">
          <div class="stat-icon"><i class="fa-solid fa-chart-pie"></i></div>
          <div>
            <p>Total Pengaduan</p>
            <h3 data-counter="{{ $stats['total'] }}">{{ $stats['total'] }}</h3>
          </div>
        </article>
      </section>

      <section class="panel-card" id="analytics">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Analitik</p>
            <h5>Ringkasan Data</h5>
          </div>
          <a class="management-link" href="#complaints-table">Lihat detail pengaduan</a>
        </div>
        <div class="bottom-grid">
          <article class="panel-card">
            <div class="panel-head">
              <h5>Konversi Status</h5>
            </div>
            <div class="report-mini-grid">
              <div class="report-mini-item">
                <strong>{{ $stats['masuk'] }}</strong>
                <span>Masuk</span>
              </div>
              <div class="report-mini-item">
                <strong>{{ $stats['diproses'] }}</strong>
                <span>Diproses</span>
              </div>
              <div class="report-mini-item">
                <strong>{{ $stats['selesai'] }}</strong>
                <span>Selesai</span>
              </div>
            </div>
          </article>
          <article class="panel-card">
            <div class="panel-head">
              <h5>Ringkasan Kategori</h5>
            </div>
            <div class="feature-list">
              <li><i class="fa-solid fa-circle-dot"></i> Jalan Rusak: {{ $categoryCounts['Jalan Rusak'] ?? 0 }}</li>
              <li><i class="fa-solid fa-circle-dot"></i> Sampah & Kebersihan: {{ $categoryCounts['Sampah & Kebersihan'] ?? 0 }}</li>
              <li><i class="fa-solid fa-circle-dot"></i> Lainnya: {{ $categoryCounts['Lainnya'] ?? 0 }}</li>
            </div>
          </article>
        </div>
      </section>

      <section class="panel-card" id="reports">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Laporan</p>
            <h5>Unduh ringkasan pengaduan</h5>
          </div>
          <a class="management-link" href="{{ route('admin.laporan.pdf') }}">Unduh PDF</a>
        </div>
        <p class="mt-2 text-muted">Cetak laporan kerja desa secara cepat untuk administrasi, rapat, atau arsip operasional.</p>
      </section>

      <div class="panel-card table-panel" id="complaints-table">
          <div class="panel-head">
            <div>
              <p class="eyebrow">Operasional</p>
              <h5>Daftar Pengaduan</h5>
            </div>
            <div class="panel-filters">
              <button class="chip-filter active" data-status="all" type="button">Semua</button>
              <button class="chip-filter" data-status="Diajukan" type="button">Baru</button>
              <button class="chip-filter" data-status="Diproses" type="button">Diproses</button>
              <button class="chip-filter" data-status="Selesai" type="button">Selesai</button>
            </div>
          </div>

          @if ($complaints->isEmpty())
            <div class="empty-state">
              <div class="empty-icon"><i class="fa-solid fa-file-circle-plus"></i></div>
              <h6>Tidak ada pengaduan</h6>
              <p>Belum ada data dalam tampilan ini. Pengaduan baru dari warga akan muncul di sini secara otomatis.</p>
            </div>
          @else
            <div class="table-wrapper">
              <table class="table modern-table">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Pelapor</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($complaints as $c)
                    <tr data-status="{{ $c->status }}" data-search="{{ strtolower($c->user->name . ' ' . $c->category . ' ' . $c->location) }}">
                      <td>{{ $c->created_at->format('d M Y') }}</td>
                      <td><strong>{{ $c->user->name }}</strong></td>
                      <td>{{ $c->category }}</td>
                      <td>{{ $c->location }}</td>
                      <td><span class="badge-status badge-{{ strtolower($c->status) }}">{{ $c->status }}</span></td>
                      <td><a href="{{ route('admin.pengaduan.show', $c) }}" class="action-btn"><i class="fa-solid fa-arrow-up-right-from-square"></i></a></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <div class="table-footer">
              <span id="tableCount">{{ $complaints->count() }} records</span>
              <div class="pagination-mini">
                <button class="page-btn" type="button" data-page="prev"><i class="fa-solid fa-angle-left"></i></button>
                <button class="page-btn active" type="button" data-page="1">1</button>
                <button class="page-btn" type="button" data-page="2">2</button>
                <button class="page-btn" type="button" data-page="next"><i class="fa-solid fa-angle-right"></i></button>
              </div>
            </div>
          @endif
        </div>
    </div>
  </div>
</div>

<div class="toast-stack" id="toastStack"></div>
<div class="skeleton-screen" id="pageSkeleton">
  <div class="skeleton-block large"></div>
  <div class="skeleton-block"></div>
  <div class="skeleton-block"></div>
</div>
@endsection

@section('scripts')
<script>
  const skeleton = document.getElementById('pageSkeleton');
  window.addEventListener('load', () => {
    setTimeout(() => {
      skeleton.classList.add('hidden');
      showToast('Dashboard berhasil dimuat', 'success');
    }, 650);
  });

  const themeToggle = document.getElementById('themeToggle');
  const savedTheme = localStorage.getItem('sigap-theme') || 'light';
  document.body.setAttribute('data-theme', savedTheme);
  themeToggle?.addEventListener('click', () => {
    const next = document.body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
    document.body.setAttribute('data-theme', next);
    localStorage.setItem('sigap-theme', next);
    themeToggle.innerHTML = next === 'dark' ? '<i class="fa-solid fa-sun"></i>' : '<i class="fa-solid fa-moon"></i>';
    showToast(next === 'dark' ? 'Mode gelap diaktifkan' : 'Mode terang diaktifkan', 'info');
  });

  const liveDate = document.getElementById('liveDate');
  if (liveDate) {
    const formatter = new Intl.DateTimeFormat('id-ID', { dateStyle: 'full' });
    liveDate.textContent = formatter.format(new Date());
  }

  const showToast = (message, type = 'info') => {
    const stack = document.getElementById('toastStack');
    const toast = document.createElement('div');
    toast.className = `toast-notice ${type}`;
    toast.innerHTML = `<span>${message}</span>`;
    stack.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 20);
    setTimeout(() => {
      toast.classList.remove('show');
      setTimeout(() => toast.remove(), 250);
    }, 2600);
  };

  const notificationBtn = document.getElementById('notificationButton');
  const quickActionsBtn = document.getElementById('quickActionsButton');
  const notificationsSection = document.getElementById('notifications');
  const managementSection = document.getElementById('management');

  notificationBtn?.addEventListener('click', () => {
    if (notificationsSection) {
      notificationsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
      showToast('Membuka pusat notifikasi', 'info');
    } else {
      showToast('Tidak ada notifikasi saat ini', 'info');
    }
  });

  quickActionsBtn?.addEventListener('click', () => {
    if (managementSection) {
      managementSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
      showToast('Menu manajemen cepat dibuka', 'success');
    }
  });

  document.querySelectorAll('[data-counter]').forEach((node) => {
    const target = Number(node.getAttribute('data-counter') || 0);
    let current = 0;
    const step = Math.max(1, Math.round(target / 18));
    const timer = setInterval(() => {
      current += step;
      if (current >= target) {
        node.textContent = target;
        clearInterval(timer);
      } else {
        node.textContent = current;
      }
    }, 50);
  });

  const rows = Array.from(document.querySelectorAll('.modern-table tbody tr'));
  const searchInput = document.querySelector('[data-table-search]');
  const filterButtons = document.querySelectorAll('.chip-filter');

  const applyTableFilters = () => {
    const query = (searchInput?.value || '').toLowerCase();
    const activeStatus = document.querySelector('.chip-filter.active')?.getAttribute('data-status') || 'all';

    rows.forEach((row) => {
      const matchesQuery = row.getAttribute('data-search')?.includes(query);
      const matchesStatus = activeStatus === 'all' || row.getAttribute('data-status') === activeStatus;
      row.style.display = matchesQuery && matchesStatus ? '' : 'none';
    });

    const visibleCount = rows.filter((row) => row.style.display !== 'none').length;
    const count = document.getElementById('tableCount');
    if (count) count.textContent = `${visibleCount} data`;
  };

  searchInput?.addEventListener('input', applyTableFilters);
  searchInput?.addEventListener('keyup', applyTableFilters);
  searchInput?.addEventListener('search', applyTableFilters);
  filterButtons.forEach((btn) => btn.addEventListener('click', () => {
    filterButtons.forEach((item) => item.classList.remove('active'));
    btn.classList.add('active');
    applyTableFilters();
  }));

  applyTableFilters();
</script>
@endsection
