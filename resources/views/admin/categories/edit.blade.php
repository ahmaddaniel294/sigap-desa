@extends('layouts.app')

  @section('title', 'Edit Layanan — LifeCare')
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
              <h1 class="h4 mb-1">Edit Jenis Gangguan</h1>
              <p class="text-muted mb-0">Perbarui nama kategori pengaduan internet atau Wi-Fi.</p>
            </div>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-primary">Kembali</a>
          </div>

          <form method="POST" action="{{ route('admin.kategori.update', $category) }}" class="category-form">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label" for="category-name">Jenis Gangguan</label>
              <input id="category-name" type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </form>
        </section>
      </div>
    </main>
  </div>
</div>
@endsection
