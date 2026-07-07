@extends('layouts.app')

@section('title', 'Buat Pengaduan — SIGAP Desa')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <h3 class="section-title mb-1">Buat Pengaduan</h3>
      <p class="text-muted mb-4">Isi formulir berikut selengkap mungkin agar admin desa dapat menindaklanjuti dengan cepat.</p>

      <div class="card-flat p-4">
        <form method="POST" action="{{ route('warga.pengaduan.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
              <option value="" selected disabled>Pilih kategori pengaduan</option>
              @foreach ($categories as $cat)
                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
              @endforeach
            </select>
            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" placeholder="Contoh: Dusun Melati, RT 03/RW 02" value="{{ old('location') }}" required>
            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Jelaskan kondisi/keluhan secara rinci" required>{{ old('description') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-4">
            <label class="form-label">Unggah Bukti (opsional)</label>
            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp,.pdf">
            <div class="form-text">Format JPG, PNG, WEBP, atau PDF. Maks. 5MB.</div>
            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <button type="submit" class="btn btn-primary w-100">Kirim Pengaduan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
