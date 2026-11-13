@extends('layouts.app')

@section('title', 'Tiket TKT-' . str_pad((string) $c->id, 6, '0', STR_PAD_LEFT) . ' — LifeCare')
@section('body_class', 'dashboard-body')

@section('dashboard_shell')
<div class="dashboard-shell admin-dashboard">
  @include('admin.partials.sidebar')

  <main class="dashboard-main">
    @include('admin.partials.topbar')

    <div class="dashboard-content">
      @include('admin.partials.feedback')

      <section class="panel-card admin-ticket-detail">
        <div class="panel-head">
          <div>
            <a href="{{ route('admin.pengaduan.index') }}" class="management-link small mb-2">
              <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pengaduan
            </a>
            <p class="eyebrow mb-1">Detail E-Tiket</p>
            <div class="text-muted small">TKT-{{ str_pad((string) $c->id, 6, '0', STR_PAD_LEFT) }} · pelanggan {{ $c->user->name }}</div>
            <h1 class="section-title h4 mb-0">{{ $c->category }}</h1>
          </div>
          <span class="badge-status badge-{{ strtolower($c->status) }} align-self-start">{{ $c->status }}</span>
        </div>

        @php $currentStep = $c->statusStepIndex(); @endphp
        <ol class="tracker admin-ticket-tracker mb-4">
          @foreach (\App\Models\Complaint::STATUS_FLOW as $i => $step)
            <li class="{{ $i < $currentStep ? 'done' : ($i === $currentStep ? 'active' : '') }}">
              <div class="dot">{{ $i + 1 }}</div>{{ $step }}
            </li>
          @endforeach
        </ol>

        <dl class="row">
          <dt class="col-sm-3 text-muted fw-normal">Alamat pemasangan Wi-Fi</dt>
          <dd class="col-sm-9">{{ $c->location }}</dd>

          <dt class="col-sm-3 text-muted fw-normal">Detail gangguan</dt>
          <dd class="col-sm-9">{{ $c->description }}</dd>

          @if ($c->photo)
          <dt class="col-sm-3 text-muted fw-normal">Lampiran</dt>
          <dd class="col-sm-9">
            @if (in_array(strtolower(pathinfo($c->photo, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp'], true))
              <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($c->photo) }}" target="_blank" rel="noopener">
                <img class="complaint-attachment-preview" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($c->photo) }}" alt="Foto lampiran pengaduan">
              </a>
            @else
              <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($c->photo) }}" target="_blank" rel="noopener"><i class="fa-solid fa-file-pdf me-1"></i>Lihat dokumen PDF</a>
            @endif
          </dd>
          @endif

          <dt class="col-sm-3 text-muted fw-normal">Dikirim</dt>
          <dd class="col-sm-9">{{ $c->created_at->format('Y-m-d H:i') }}</dd>

          <dt class="col-sm-3 text-muted fw-normal">Teknisi</dt>
          <dd class="col-sm-9">{{ $c->technician?->name ?? 'Belum ditugaskan' }}</dd>
          @if ($c->technician_note)
            <dt class="col-sm-3 text-muted fw-normal">Catatan teknisi</dt>
            <dd class="col-sm-9">{{ $c->technician_note }}</dd>
          @endif
        </dl>

        <hr>

        <form method="POST" action="{{ route('admin.pengaduan.update', $c) }}">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label" for="complaint-status">Perbarui Status</label>
            <select id="complaint-status" name="status" class="form-select">
              @foreach (\App\Models\Complaint::STATUS_FLOW as $s)
                <option value="{{ $s }}" {{ $s === $c->status ? 'selected' : '' }}>{{ $s }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label" for="admin-note">Tanggapan / Catatan untuk Pelanggan</label>
            <textarea id="admin-note" name="admin_note" class="form-control" rows="3" placeholder="Masukkan hasil pemeriksaan atau tindak lanjut untuk pelanggan.">{{ $c->admin_note }}</textarea>
          </div>
          <div class="mb-3">
            <label class="form-label" for="technician_id">Tugaskan Teknisi</label>
            <select id="technician_id" name="technician_id" class="form-select">
              <option value="">Belum ditugaskan</option>
              @foreach ($technicians as $technician)
                <option value="{{ $technician->id }}" {{ (string) old('technician_id', $c->technician_id) === (string) $technician->id ? 'selected' : '' }}>{{ $technician->name }} ({{ $technician->email }})</option>
              @endforeach
            </select>
            @error('technician_id')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            @if ($technicians->isEmpty())
              <div class="form-text">Belum ada akun teknisi. Buat akun melalui menu Teknisi terlebih dahulu.</div>
            @endif
          </div>
          <button type="submit" class="btn btn-primary">Simpan &amp; Kirim Notifikasi</button>
        </form>
      </section>
    </div>
  </main>
</div>
@endsection
