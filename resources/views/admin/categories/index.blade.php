@extends('layouts.app')

@section('title', 'Kelola Layanan — LifeCare')
@section('body_class', 'dashboard-body')

@section('dashboard_shell')
<div class="dashboard-shell admin-dashboard">
  @include('admin.partials.sidebar')

  <main class="dashboard-main">
    @include('admin.partials.topbar')

    <div class="dashboard-content">
      @include('admin.partials.feedback')

      <section class="panel-card">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Pengaturan Lifemedia</p>
            <h1 class="h4 mb-1">Jenis Gangguan</h1>
            <p class="text-muted mb-0">Kelola jenis gangguan internet dan Wi-Fi yang dapat dipilih pelanggan.</p>
          </div>
          <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">Tambah Jenis Gangguan</a>
        </div>

        @if($categories->isEmpty())
          <div class="empty-state">
            <div class="empty-icon"><i class="fa-solid fa-list"></i></div>
            <h2 class="h6">Belum ada jenis gangguan</h2>
            <p>Tambahkan jenis gangguan agar pelanggan dapat membuat pengaduan.</p>
          </div>
        @else
          <div class="table-wrapper">
            <table class="table modern-table">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Jenis Gangguan</th>
                  <th class="text-end">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($categories as $category)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td class="text-end">
                  <a href="{{ route('admin.kategori.edit', $category) }}" class="btn btn-sm btn-outline-primary me-2">Edit</a>
                  <form action="{{ route('admin.kategori.destroy', $category) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                  </form>
                </td>
              </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </section>
    </div>
  </main>
</div>
@endsection
