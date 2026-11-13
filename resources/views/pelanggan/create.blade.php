@extends('layouts.app')

@section('title', 'Buat Pengaduan — LifeCare')
@section('body_class', 'dashboard-body')

@section('content')
<div class="dashboard-shell admin-dashboard">
  @include('pelanggan.partials.dashboard-sidebar')

  <main class="dashboard-main">
    @include('pelanggan.partials.dashboard-topbar', [
      'pageTitle' => 'Buat Pengaduan Internet',
      'pageDescription' => 'Jelaskan kendala internet atau Wi-Fi Lifemedia agar tim dukungan dapat menindaklanjutinya.',
    ])

    <div class="dashboard-content">
      @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <section class="panel-card complaint-form-panel">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Tiket Pelanggan</p>
            <h2 class="h5 mb-1">Informasi Gangguan</h2>
            <p class="text-muted mb-0">Lengkapi detail berikut supaya tim Lifemedia dapat memeriksa kendala Anda.</p>
          </div>
        </div>

        <form method="POST" action="{{ route('warga.pengaduan.store') }}" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label" for="complaint-category">Kategori Gangguan</label>
            <select id="complaint-category" name="category" class="form-select @error('category') is-invalid @enderror" required>
              <option value="" selected disabled>Pilih jenis gangguan</option>
              @foreach ($categories as $cat)
                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
              @endforeach
            </select>
            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="complaint-location">Alamat pemasangan Wi-Fi</label>
            <input id="complaint-location" type="text" name="location" class="form-control @error('location') is-invalid @enderror" placeholder="Alamat lengkap lokasi pemasangan Lifemedia" value="{{ old('location') }}" required>
            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label" for="complaint-description">Detail gangguan</label>
            <textarea id="complaint-description" name="description" class="form-control @error('description') is-invalid @enderror" rows="4" placeholder="Jelaskan kendala koneksi, kapan mulai terjadi, dan lampu indikator router jika diketahui" required>{{ old('description') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-4">
            <label class="form-label" for="complaint-photo">Lampiran foto perangkat atau bukti gangguan (opsional)</label>
            <input id="complaint-photo" type="file" name="photo" class="form-control @error('photo') is-invalid @enderror" accept="image/jpeg,image/png,image/webp,application/pdf">
            <div class="form-text">Pilih foto JPG, PNG, WEBP atau dokumen PDF. Maks. 5MB.</div>
            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Kirim Pengaduan</button>
        </form>
      </section>
    </div>
  </main>
</div>
@endsection
