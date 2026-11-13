@extends('layouts.app')

@section('title', 'Tiket TKT-' . str_pad((string) $ticket->id, 6, '0', STR_PAD_LEFT) . ' — LifeCare')
@section('body_class', 'dashboard-body')

@section('dashboard_shell')
<div class="dashboard-shell admin-dashboard">
  @include('technician.partials.sidebar')
  <main class="dashboard-main">
    <header class="dashboard-topbar">
      <div><a class="text-decoration-none" href="{{ route('teknisi.dashboard') }}">&larr; Kembali ke daftar tiket</a></div>
      <div class="topbar-actions">
        <div class="user-chip"><div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div><div><strong>{{ auth()->user()->name }}</strong><p>Teknisi Lifemedia</p></div></div>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-logout" type="submit">Keluar</button></form>
      </div>
    </header>

    <div class="dashboard-content">
      @include('admin.partials.feedback')
      <section class="panel-card">
        <div class="panel-head">
          <div>
            <p class="eyebrow">Detail E-Tiket</p>
            <h1 class="section-title mb-1">TKT-{{ str_pad((string) $ticket->id, 6, '0', STR_PAD_LEFT) }}</h1>
            <p class="text-muted mb-0">{{ $ticket->category }} · dibuat {{ $ticket->created_at->format('d M Y, H:i') }}</p>
          </div>
          <span class="badge-status badge-{{ strtolower($ticket->status) }}">{{ $ticket->status }}</span>
        </div>

        <div class="row g-4">
          <div class="col-lg-7">
            <dl class="row mb-0">
              <dt class="col-sm-4 text-muted fw-normal">Pelanggan</dt><dd class="col-sm-8">{{ $ticket->user->name }}</dd>
              <dt class="col-sm-4 text-muted fw-normal">Lokasi layanan</dt><dd class="col-sm-8">{{ $ticket->location }}</dd>
              <dt class="col-sm-4 text-muted fw-normal">Detail gangguan</dt><dd class="col-sm-8">{{ $ticket->description }}</dd>
              @if ($ticket->photo)
                <dt class="col-sm-4 text-muted fw-normal">Lampiran</dt>
                <dd class="col-sm-8">
                  @if (in_array(strtolower(pathinfo($ticket->photo, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp'], true))
                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($ticket->photo) }}" target="_blank" rel="noopener">
                      <img class="complaint-attachment-preview" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($ticket->photo) }}" alt="Foto lampiran pelanggan">
                    </a>
                  @else
                    <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($ticket->photo) }}" target="_blank" rel="noopener"><i class="fa-solid fa-file-pdf me-1"></i>Lihat dokumen PDF pelanggan</a>
                  @endif
                </dd>
              @endif
            </dl>
            @if ($ticket->admin_note)
              <div class="alert alert-info mt-3 mb-0"><strong>Catatan admin:</strong> {{ $ticket->admin_note }}</div>
            @endif
          </div>

          <div class="col-lg-5">
            <div class="p-3 rounded-3 bg-light h-100">
              <h2 class="h6">Pembaruan terakhir</h2>
              @if ($ticket->technician_note)
                <p class="mb-0">{{ $ticket->technician_note }}</p>
              @else
                <p class="text-muted mb-0">Belum ada catatan penanganan.</p>
              @endif
            </div>
          </div>
        </div>

        <hr class="my-4">
        <form method="POST" action="{{ route('teknisi.tiket.update', $ticket) }}">
          @csrf
          @method('PUT')
          <div class="row g-3">
            <div class="col-md-4">
              <label for="ticket-status" class="form-label">Status Penanganan</label>
              @php
                $selectedStatus = old(
                    'status',
                    $ticket->status === \App\Models\Complaint::STATUS_SELESAI
                        ? \App\Models\Complaint::STATUS_SELESAI
                        : \App\Models\Complaint::STATUS_DIPROSES
                );
              @endphp
              <select id="ticket-status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                <option value="{{ \App\Models\Complaint::STATUS_DIPROSES }}" {{ $selectedStatus === \App\Models\Complaint::STATUS_DIPROSES ? 'selected' : '' }}>Diproses</option>
                <option value="{{ \App\Models\Complaint::STATUS_SELESAI }}" {{ $selectedStatus === \App\Models\Complaint::STATUS_SELESAI ? 'selected' : '' }}>Selesai</option>
              </select>
              @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <label for="technician-note" class="form-label">Catatan pemeriksaan / tindak lanjut</label>
              <textarea id="technician-note" name="technician_note" rows="4" maxlength="5000" class="form-control @error('technician_note') is-invalid @enderror" placeholder="Jelaskan hasil pengecekan, tindakan yang dilakukan, atau hasil perbaikan.">{{ old('technician_note', $ticket->technician_note) }}</textarea>
              @error('technician_note')<div class="invalid-feedback">{{ $message }}</div>@enderror
              <div class="form-text">Catatan ini dapat dilihat pelanggan pada detail tiketnya.</div>
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3"><i class="fa-solid fa-floppy-disk me-1"></i> Simpan Pembaruan</button>
        </form>
      </section>
    </div>
  </main>
</div>
@endsection
