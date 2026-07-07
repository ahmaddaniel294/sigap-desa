@extends('layouts.app')

@section('title', 'Kelola Pengaduan #' . $c->id . ' — SIGAP Desa')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <a href="{{ route('admin.dashboard') }}" class="text-decoration-none small">&larr; Kembali ke Dashboard</a>

      <div class="card-flat p-4 mt-3">
        <div class="d-flex justify-content-between flex-wrap gap-2 mb-4">
          <div>
            <div class="text-muted small">Pengaduan #{{ $c->id }} &middot; oleh {{ $c->user->name }}{{ $c->user->dusun ? ' ('.$c->user->dusun.')' : '' }}</div>
            <h4 class="section-title mb-0">{{ $c->category }}</h4>
          </div>
          <span class="badge-status badge-{{ strtolower($c->status) }} align-self-start">{{ $c->status }}</span>
        </div>

        @php $currentStep = $c->statusStepIndex(); @endphp
        <ol class="tracker mb-4">
          @foreach (\App\Models\Complaint::STATUS_FLOW as $i => $step)
            <li class="{{ $i < $currentStep ? 'done' : ($i === $currentStep ? 'active' : '') }}">
              <div class="dot">{{ $i + 1 }}</div>{{ $step }}
            </li>
          @endforeach
        </ol>

        <dl class="row">
          <dt class="col-sm-3 text-muted fw-normal">Lokasi</dt>
          <dd class="col-sm-9">{{ $c->location }}</dd>

          <dt class="col-sm-3 text-muted fw-normal">Deskripsi</dt>
          <dd class="col-sm-9">{{ $c->description }}</dd>

          @if ($c->photo)
          <dt class="col-sm-3 text-muted fw-normal">Bukti</dt>
          <dd class="col-sm-9">
            <a href="{{ \Illuminate\Support\Facades\Storage::url($c->photo) }}" target="_blank">Lihat lampiran</a>
          </dd>
          @endif

          <dt class="col-sm-3 text-muted fw-normal">Dilaporkan</dt>
          <dd class="col-sm-9">{{ $c->created_at->format('Y-m-d H:i') }}</dd>
        </dl>

        <hr>

        <form method="POST" action="{{ route('admin.pengaduan.update', $c) }}">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label">Perbarui Status</label>
            <select name="status" class="form-select">
              @foreach (\App\Models\Complaint::STATUS_FLOW as $s)
                <option value="{{ $s }}" {{ $s === $c->status ? 'selected' : '' }}>{{ $s }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Tanggapan / Catatan untuk Warga</label>
            <textarea name="admin_note" class="form-control" rows="3" placeholder="Contoh: Sudah dijadwalkan perbaikan minggu depan.">{{ $c->admin_note }}</textarea>
          </div>
          <button type="submit" class="btn btn-primary">Simpan &amp; Kirim Notifikasi</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
