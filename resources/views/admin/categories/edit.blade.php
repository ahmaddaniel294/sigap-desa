@extends('layouts.app')

@section('title', 'Edit Kategori — SIGAP Desa')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <a href="{{ route('admin.kategori.index') }}" class="text-decoration-none small">&larr; Kembali ke daftar kategori</a>

      <div class="card-flat p-4 mt-3">
        <h4 class="section-title mb-3">Edit Kategori</h4>

        <form method="POST" action="{{ route('admin.kategori.update', $category) }}">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <button type="submit" class="btn btn-primary">Perbarui</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
