@extends('layouts.app')

@section('title', 'Teknisi — LifeCare')
@section('body_class', 'dashboard-body')

@section('dashboard_shell')
<div class="dashboard-shell admin-dashboard">
  @include('admin.partials.sidebar')

  <main class="dashboard-main">
    @include('admin.partials.topbar')
    <div class="dashboard-content">
      @include('admin.partials.feedback')

      <section class="panel-card table-panel">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Manajemen Tim</p>
            <h1 class="section-title mb-1">Teknisi Lifemedia</h1>
            <p class="text-muted mb-0">Kelola akun teknisi yang dapat menerima penugasan tiket.</p>
          </div>
          <a class="btn btn-primary" href="{{ route('admin.teknisi.create') }}"><i class="fa-solid fa-plus me-1"></i> Tambah Teknisi</a>
        </div>

        @if ($technicians->isEmpty())
          <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
            <h2 class="h6">Belum ada teknisi</h2>
            <p>Buat akun teknisi agar admin dapat menugaskan tiket gangguan.</p>
          </div>
        @else
          <div class="table-wrapper">
            <table class="table modern-table">
              <thead>
                <tr><th>Nama</th><th>Email Login</th><th>Tiket Ditugaskan</th><th>Bergabung</th></tr>
              </thead>
              <tbody>
                @foreach ($technicians as $technician)
                  <tr>
                    <td><strong>{{ $technician->name }}</strong></td>
                    <td>{{ $technician->email }}</td>
                    <td><span class="panel-badge">{{ $technician->assigned_complaints_count }} tiket</span></td>
                    <td>{{ $technician->created_at->format('d M Y') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="mt-3">{{ $technicians->links() }}</div>
        @endif
      </section>
    </div>
  </main>
</div>
@endsection
