@extends('layouts.app')

@section('title', 'Detail Pengaduan #' . $c->id . ' — SIGAP Desa')

@section('content')
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <a href="{{ route('warga.dashboard') }}" class="text-decoration-none small">&larr; Kembali ke Pengaduan Saya</a>

      <div class="card-flat p-4 mt-3">
        <div class="d-flex justify-content-between flex-wrap gap-2 mb-4">
          <div>
            <div class="text-muted small">Pengaduan #{{ $c->id }}</div>
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

        <dl class="row mb-0">
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

          <dt class="col-sm-3 text-muted fw-normal">Diperbarui</dt>
          <dd class="col-sm-9">{{ $c->updated_at->format('Y-m-d H:i') }}</dd>

          @if ($c->admin_note)
          <dt class="col-sm-3 text-muted fw-normal">Tanggapan Admin</dt>
          <dd class="col-sm-9">
            <div class="p-3 rounded-3" style="background:#F5F7FA;">{{ $c->admin_note }}</div>
          </dd>
          @endif
        </dl>
      </div>
    </div>
  </div>
</div>
@endsection
