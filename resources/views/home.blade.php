@extends('layouts.app')

@section('title', 'LifeCare — Layanan Pengaduan Wi-Fi Lifemedia')
@section('body_class', 'lifecare-home')

@section('content')

<section class="hero">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-7">
        <div class="eyebrow">Layanan Pelanggan Lifemedia</div>
        <h1 class="mb-3">Laporkan gangguan internet dan Wi-Fi Lifemedia dengan mudah.</h1>
        <p class="lead mb-4">LifeCare membantu pelanggan menyampaikan kendala koneksi, memantau proses penanganan, dan melihat riwayat pengaduan secara online.</p>
        <div class="d-flex flex-wrap gap-2">
          @auth
            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('warga.pengaduan.create') }}" class="btn lifecare-btn-gold btn-lg px-4">
              {{ auth()->user()->isAdmin() ? 'Buka Dashboard' : 'Buat Pengaduan' }}
            </a>
          @else
            <a href="{{ route('register') }}" class="btn lifecare-btn-gold btn-lg px-4">Daftar sebagai Pelanggan</a>
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">Masuk</a>
          @endauth
        </div>
        <div class="mt-4">
          @foreach (['Gangguan Koneksi Internet','Wi-Fi Lambat','Wi-Fi Tidak Terhubung','Internet Terputus','Masalah Router / Modem'] as $cat)
            <span class="chip home-chip">{{ $cat }}</span>
          @endforeach
        </div>
      </div>
      <div class="col-lg-5">
        <div class="home-stats-panel">
          <div class="home-stats-heading">
            <span>Ringkasan layanan</span>
            <span class="home-live-indicator"><i class="fa-solid fa-circle"></i> Terkini</span>
          </div>
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
  </div>
</section>

<section class="py-5">
  <div class="container">
    <h2 class="section-title text-center mb-1">Bagaimana alurnya?</h2>
    <p class="text-center text-muted mb-5">Pantau proses pengaduan dari laporan masuk hingga selesai ditangani.</p>
    <ul class="tracker mb-0" style="max-width:900px; margin:0 auto; list-style: none; padding-left: 0;">
      <li class="done"><div class="dot">1</div>Pengaduan Dikirim</li>
      <li class="done"><div class="dot">2</div>Ditinjau Tim</li>
      <li class="active"><div class="dot">3</div>Dalam Penanganan</li>
      <li><div class="dot">4</div>Pembaruan Status</li>
      <li><div class="dot">5</div>Selesai</li>
    </ul>
  </div>
</section>

<section class="py-5 home-features">
  <div class="container">
    <div class="home-section-heading text-center">
      <span class="home-section-kicker">Dukungan LifeCare</span>
      <h2 class="section-title mb-2">Layanan yang jelas dan mudah diikuti</h2>
      <p class="text-muted mb-0">Semua kebutuhan pengaduan pelanggan dan tindak lanjut tim dalam satu tempat.</p>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card-flat p-4 h-100">
          <h5 class="section-title">Untuk Pelanggan</h5>
          <ul class="text-muted mb-0 ps-3">
            <li>Registrasi &amp; login mandiri</li>
            <li>Laporkan kendala koneksi dan lampirkan bukti</li>
            <li>Pantau status pengaduan</li>
            <li>Riwayat pengaduan tersimpan</li>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-flat p-4 h-100">
          <h5 class="section-title">Untuk Tim Lifemedia</h5>
          <ul class="text-muted mb-0 ps-3">
            <li>Dashboard ringkasan gangguan pelanggan</li>
            <li>Tinjau dan perbarui status pengaduan</li>
            <li>Berikan tanggapan dan tindak lanjut</li>
            <li>Pantau jenis kendala internet dan Wi-Fi</li>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card-flat p-4 h-100">
          <h5 class="section-title">Transparan &amp; Akuntabel</h5>
          <ul class="text-muted mb-0 ps-3">
            <li>Setiap pengaduan tercatat digital</li>
            <li>Riwayat perubahan status tersimpan</li>
            <li>Informasi pelanggan ditampilkan sesuai hak akses</li>
            <li>Mendukung pemantauan kualitas layanan Lifemedia</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection
