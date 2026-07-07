@extends('layouts.app')

@section('title', 'Kelola Kategori — SIGAP Desa')

@section('content')
<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h3 class="section-title mb-1">Kelola Kategori</h3>
      <p class="text-muted">Tambahkan, perbarui, atau hapus kategori pengaduan untuk sistem SIGAP Desa.</p>
    </div>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="card-flat p-4">
    @if($categories->isEmpty())
      <div class="text-center py-5 text-muted">Belum ada kategori tersedia. Buat kategori baru untuk memulai.</div>
    @else
      <div class="table-responsive">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Nama Kategori</th>
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
  </div>
</div>
@endsection
