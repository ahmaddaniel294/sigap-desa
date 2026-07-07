<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'SIGAP Desa')</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="@yield('body_class', '')">

@if (view()->hasSection('dashboard_shell'))
  @yield('dashboard_shell')
@else
  <nav class="navbar navbar-expand-lg navbar-dark sigap-navbar sticky-top">
    <div class="container">
      <a class="navbar-brand" href="{{ route('home') }}">
        <span class="brand-mark">SIGAP</span><span class="brand-sub">Desa</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="nav">
        <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
          @auth
            @if (auth()->user()->isAdmin())
              <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
            @else
              <li class="nav-item"><a class="nav-link" href="{{ route('warga.dashboard') }}">Pengaduan Saya</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('warga.pengaduan.create') }}">Buat Pengaduan</a></li>
            @endif
            <li class="nav-item">
              <span class="nav-link disabled d-none d-lg-inline">|</span>
            </li>
            <li class="nav-item"><span class="nav-link text-warning-emphasis fw-semibold">{{ auth()->user()->name }}</span></li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light ms-lg-2">Keluar</button>
              </form>
            </li>
          @else
            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
            <li class="nav-item"><a class="btn btn-sm sigap-btn-gold ms-lg-2" href="{{ route('register') }}">Daftar Warga</a></li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-3">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if (session('info'))
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0 ps-3">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
  </div>

  <main>
    @yield('content')
  </main>

  <footer class="sigap-footer mt-5">
    <div class="container py-4 text-center">
      <div class="small text-white-50">SIGAP Desa &mdash; Sistem Pengaduan Masyarakat Desa Berbasis Web</div>
      <div class="small text-white-50">Prototipe Tugas Akhir &middot; Dibangun dengan Laravel, MySQL &amp; Bootstrap</div>
    </div>
  </footer>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
