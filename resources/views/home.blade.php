@extends('layouts.app')

@section('title', 'SIGAP Desa — Sistem Pengaduan Masyarakat Desa')

@section('content')

<section class="hero">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-7">
        <div class="eyebrow">Layanan Pengaduan Digital Desa</div>
        <h1 class="mb-3">Lapor jalan rusak, sampah, atau keluhan warga &mdash; tanpa harus ke kantor desa.</h1>
        <p class="lead mb-4">SIGAP Desa mencatat setiap laporan warga secara digital, memantau progres penanganannya, dan membuat penanganan admin desa jadi terukur dan transparan.</p>
        <div class="d-flex flex-wrap gap-2">
          @auth
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('warga.pengaduan.create') }}" class="btn sigap-btn-gold btn-lg px-4">
              {{ auth()->user()->isAdmin() ? 'Buka Dashboard' : 'Buat Pengaduan' }}
            </a>
          @else
            <a href="{{ route('register') }}" class="btn sigap-btn-gold btn-lg px-4">Daftar sebagai Warga</a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">Masuk</a>
          @endauth
        </div>
        <div class="mt-4">
          @foreach (['Jalan Rusak','Penerangan Jalan','Sampah & Kebersihan','Fasilitas Umum','Keamanan'] as $cat)
            <span class="chip" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.18); color:#fff;">{{ $cat }}</span>
          @endforeach
        </div>
      </div>
      <div class="col-lg-5">
        <div class="row g-3">
          <div class="col-6">
            <div class="stat-pill">
              <div class="num">{{ $stats['total'] }}</div>
              <div class="label">Total Pengaduan</div>
            </div>
          </div>
          <div class="col-6">
            <div class="stat-pill">
              <div class="num">{{ $stats['masuk'] }}</div>
              <div class="label">Baru Masuk</div>
            </div>
          </div>
          <div class="col-6">
            <div class="stat-pill">
              <div class="num">{{ $stats['diproses'] }}</div>
              <div class="label">Sedang Diproses</div>
            </div>
          </div>
          <div class="col-6">
            <div class="stat-pill">
              <div class="num">{{ $stats['selesai'] }}</div>
              <div class="label">Selesai Ditangani</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <h2 class="section-title text-center mb-1">Bagaimana alurnya?</h2>
    <p class="text-center text-muted mb-5">Lima langkah dari laporan dibuat sampai ditindaklanjuti tuntas.</p>
    <ol class="tracker mb-0" style="max-width:900px; margin:0 auto;">
      <li class="done"><div class="dot">1</div>Pengaduan Dibuat</li>
      <li class="done"><div class="dot">2</div>Validasi Sistem</li>
      <li class="active"><div class="dot">3</div>Diterima Admin</li>
      <li><div class="dot">4</div>Diproses</li>
      <li><div class="dot">5</div>Selesai</li>
    </ol>
  </div>
</section>

<section class="py-5" style="background:#fff;">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card-flat p-4 h-100">
          <h5 class="section-title">Untuk Warga</h5>
          <ul class="text-muted mb-0 ps-3">
            <li>Registrasi &amp; login mandiri</li>
            <li>Buat pengaduan dengan foto bukti</li>
            <li>Pantau status secara real-time</li>
            <li>Riwayat semua laporan tersimpan</li>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-flat p-4 h-100">
          <h5 class="section-title">Untuk Admin Desa</h5>
          <ul class="text-muted mb-0 ps-3">
            <li>Dashboard rekap &amp; tren laporan</li>
            <li>Verifikasi &amp; ubah status laporan</li>
            <li>Beri tanggapan resmi ke warga</li>
            <li>Statistik kategori pengaduan</li>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-flat p-4 h-100">
          <h5 class="section-title">Transparan &amp; Akuntabel</h5>
          <ul class="text-muted mb-0 ps-3">
            <li>Setiap laporan tercatat digital</li>
            <li>Riwayat perubahan status terekam</li>
            <li>Data pribadi warga dijaga aksesnya</li>
            <li>Mendukung evaluasi kinerja desa</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
