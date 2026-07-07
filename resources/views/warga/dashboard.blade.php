@extends('layouts.app')

@section('title', 'Dashboard Warga — SIGAP Desa')

@section('body_class', 'dashboard-body')

@section('content')
<div class="dashboard-shell">
  <aside class="dashboard-sidebar">
    <div class="sidebar-brand">
      <div class="brand-badge">SD</div>
      <div>
        <h4>SIGAP Desa</h4>
        <p>Portal Warga</p>
      </div>
    </div>

    <div>
      <div class="sidebar-section-title">Menu Cepat</div>
      <a class="sidebar-link active" href="#overview"><i class="fas fa-chart-line"></i> Ringkasan</a>
      <a class="sidebar-link" href="#activity"><i class="fas fa-clock"></i> Aktivitas Terbaru</a>
      <a class="sidebar-link" href="#progress"><i class="fas fa-tasks"></i> Progress Pengaduan</a>
      <a class="sidebar-link" href="#laporan"><i class="fas fa-file-pdf"></i> Laporan PDF</a>
    </div>

    <div class="sidebar-card">
      <div class="eyebrow">Status Akun</div>
      <div class="progress-pill">Aktif sebagai Warga</div>
      <p class="mb-0">Akses cepat ke riwayat laporan, pengaduan, dan dokumen resmi desa.</p>
    </div>
  </aside>

  <section class="dashboard-main">
    <div class="dashboard-topbar">
      <div class="topbar-left">
        <h1 class="section-title mb-1">Halo, {{ auth()->user()->name }}</h1>
        <p class="text-muted mb-0">Lihat ringkasan pengaduan terkini dan pantau statusnya dari satu tampilan.</p>
      </div>

      <div class="topbar-actions">
        <div class="topbar-search">
          <i class="fas fa-search"></i>
          <input type="search" placeholder="Cari pengaduan, kategori, atau lokasi..." aria-label="Cari pengaduan" />
        </div>
        <button class="icon-btn" type="button" title="Filter"><i class="fas fa-filter"></i></button>
        <button class="icon-btn" type="button" title="Notifikasi"><i class="fas fa-bell"></i></button>
      </div>
    </div>

    <div class="hero-panel">
      <div>
        <span class="eyebrow">Dashboard Warga</span>
        <h2>Monitor pengaduan Anda dengan cepat dan jelas.</h2>
        <p>Semua informasi penting dari desa ditata rapi untuk membantu Anda menyelesaikan pengaduan.</p>
        <div class="hero-actions">
          <a href="{{ route('warga.pengaduan.create') }}" class="btn btn-primary">Buat Pengaduan Baru</a>
          <a href="{{ route('warga.laporan.pdf') }}" class="btn btn-outline-light">Unduh Laporan PDF</a>
        </div>
      </div>
      <div class="hero-widget">
        <div class="date-pill"><i class="fas fa-calendar-day"></i> {{ now()->translatedFormat('l, d F Y') }}</div>
        <div class="weather-pill"><i class="fas fa-cloud-sun"></i> Status Desa: Aktif</div>
      </div>
    </div>

    <div class="stats-grid">
      <div class="stat-card accent-blue">
        <div class="stat-icon"><i class="fas fa-envelope-open-text"></i></div>
        <div>
          <p>Total Pengaduan</p>
          <h3>{{ $complaints->count() }}</h3>
        </div>
      </div>
      <div class="stat-card accent-gold">
        <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
        <div>
          <p>Dalam Proses</p>
          <h3>{{ $complaints->where('status', 'Diproses')->count() }}</h3>
        </div>
      </div>
      <div class="stat-card accent-green">
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
        <div>
          <p>Selesai</p>
          <h3>{{ $complaints->where('status', 'Selesai')->count() }}</h3>
        </div>
      </div>
      <div class="stat-card accent-navy">
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
        <div>
          <p>Pengaduan Terakhir</p>
          <h3>{{ $complaints->first()?->created_at->format('d M Y H:i') ?? 'Belum ada' }}</h3>
        </div>
      </div>
    </div>

    <div class="content-grid">
      <div>
        <div class="panel-card" id="overview">
          <div class="panel-head">
            <div>
              <h5>Ringkasan Pengaduan</h5>
              <p class="text-muted mb-0">Lihat status dan detail terakhir dari laporan Anda.</p>
            </div>
            <span class="panel-badge">{{ $complaints->count() }} laporan</span>
          </div>

          <div class="panel-filters">
            <button class="chip-filter active" type="button">Semua</button>
            <button class="chip-filter" type="button">Diajukan</button>
            <button class="chip-filter" type="button">Diproses</button>
            <button class="chip-filter" type="button">Selesai</button>
          </div>

          <div class="table-wrapper">
            <table class="modern-table w-100">
              <thead>
                <tr>
                  <th>Waktu</th>
                  <th>Kategori</th>
                  <th>Lokasi</th>
                  <th>Status</th>
                  <th>Tindakan</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($complaints as $complaint)
                <tr>
                  <td>{{ $complaint->created_at->translatedFormat('d M Y H:i') }}</td>
                  <td>{{ $complaint->category }}</td>
                  <td>{{ $complaint->location }}</td>
                  <td><span class="badge-status badge-{{ strtolower($complaint->status) }}">{{ $complaint->status }}</span></td>
                  <td><a href="{{ route('warga.pengaduan.show', $complaint) }}" class="action-btn" title="Lihat detail"><i class="fas fa-eye"></i></a></td>
                </tr>
                @empty
                <tr>
                  <td colspan="5">
                    <div class="empty-state">
                      <div class="empty-icon"><i class="fas fa-inbox"></i></div>
                      <h5>Belum ada pengaduan</h5>
                      <p class="text-muted">Mulai buat pengaduan pertama Anda agar desa dapat menindaklanjuti lebih cepat.</p>
                      <a href="{{ route('warga.pengaduan.create') }}" class="btn btn-primary mt-3">Buat Pengaduan</a>
                    </div>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>

        <div class="bottom-grid">
          <div class="panel-card" id="activity">
            <div class="panel-head">
              <h5>Aktivitas Terbaru</h5>
              <span class="panel-badge">{{ $complaints->count() }} item</span>
            </div>
            <ul class="activity-list">
              @forelse ($complaints->take(4) as $complaint)
              <li>
                <div class="dot {{ $complaint->status == 'Selesai' ? 'green' : ($complaint->status == 'Diproses' ? 'gold' : 'navy') }}"></div>
                <div>
                  <strong>{{ $complaint->category }}</strong>
                  <p>{{ \Illuminate\Support\Str::limit($complaint->description, 70) }}</p>
                </div>
              </li>
              @empty
              <li class="empty-state">
                <div class="empty-icon"><i class="fas fa-question-circle"></i></div>
                <p class="text-muted">Tidak ada aktivitas untuk ditampilkan. Buat pengaduan agar riwayat Anda tercatat.</p>
              </li>
              @endforelse
            </ul>
          </div>

          <div class="panel-card" id="progress">
            <div class="panel-head">
              <h5>Ringkasan Progress</h5>
              <span class="panel-badge">Status update</span>
            </div>
            <div class="timeline-list">
              <li class="active">
                <span>1</span>
                <div>
                  <strong>Ajukan Pengaduan</strong>
                  <p>Pengaduan baru masuk dan sedang menunggu verifikasi.</p>
                </div>
              </li>
              <li>
                <span>2</span>
                <div>
                  <strong>Dalam Proses</strong>
                  <p>Petugas desa sedang meninjau dan menindaklanjuti laporan Anda.</p>
                </div>
              </li>
              <li>
                <span>3</span>
                <div>
                  <strong>Selesai</strong>
                  <p>Pengaduan ditutup ketika solusi telah diterapkan.</p>
                </div>
              </li>
            </div>
          </div>
        </div>
      </div>

      <aside class="side-stack">
        <div class="panel-card">
          <div class="panel-head">
            <h5>Ringkasan Cepat</h5>
            <span class="panel-badge">Waktu nyata</span>
          </div>
          <div class="quick-stats">
            <div>
              <strong>{{ $complaints->where('status', 'Diajukan')->count() }}</strong>
              <span>Menunggu tindak lanjut</span>
            </div>
            <div>
              <strong>{{ $complaints->where('status', 'Diproses')->count() }}</strong>
              <span>Diproses</span>
            </div>
            <div>
              <strong>{{ $complaints->where('status', 'Selesai')->count() }}</strong>
              <span>Telah selesai</span>
            </div>
          </div>
        </div>

        <div class="panel-card" id="laporan">
          <div class="panel-head">
            <h5>Laporan PDF</h5>
            <span class="panel-badge">Ekspor ringkas</span>
          </div>
          <div class="report-highlight">
            <div class="report-highlight-top">
              <strong>Unduh ringkasan pengaduan</strong>
              <span class="report-badge">PDF siap</span>
            </div>
            <p class="report-note">Simpan arsip pengaduan dan status terakhir untuk dokumen pribadi atau bukti penyelesaian.</p>
            <div class="report-mini-grid">
              <div class="report-mini-item">
                <strong>{{ $complaints->where('status', 'Diajukan')->count() }}</strong>
                <span>Diajukan</span>
              </div>
              <div class="report-mini-item">
                <strong>{{ $complaints->where('status', 'Diproses')->count() }}</strong>
                <span>Diproses</span>
              </div>
              <div class="report-mini-item">
                <strong>{{ $complaints->where('status', 'Selesai')->count() }}</strong>
                <span>Selesai</span>
              </div>
            </div>
            <a href="{{ route('warga.laporan.pdf') }}" class="report-link">Minta laporan</a>
          </div>
        </div>

        <div class="panel-card">
          <div class="panel-head">
            <h5>Pengingat</h5>
          </div>
          <div class="notify-list">
            <div class="notify-item">
              <div>
                <strong>Perbarui status</strong>
                <p>Pastikan laporan Anda dilengkapi dengan informasi lokasi yang jelas.</p>
              </div>
            </div>
            <div class="notify-item">
              <div>
                <strong>Gunakan fitur laporan</strong>
                <p>Cetak PDF sebagai arsip bukti pengaduan desa.</p>
              </div>
            </div>
          </div>
        </div>
      </aside>
    </div>
  </section>
</div>
@endsection
