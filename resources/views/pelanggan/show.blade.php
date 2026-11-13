@extends('layouts.app')

@section('title', 'Detail Tiket TKT-' . str_pad((string) $c->id, 6, '0', STR_PAD_LEFT) . ' — LifeCare')
@section('body_class', 'dashboard-body')

@section('content')
<div class="dashboard-shell admin-dashboard">
  @include('pelanggan.partials.dashboard-sidebar')

  <main class="dashboard-main">
    @include('pelanggan.partials.dashboard-topbar', [
      'pageTitle' => 'Detail Tiket',
      'pageDescription' => 'Informasi dan perkembangan penanganan pengaduan Anda.',
    ])

    <div class="dashboard-content">
      <section class="panel-card customer-ticket-detail">
        <div class="panel-head">
          <div>
            <a href="{{ route('warga.dashboard') }}" class="management-link small mb-2">
              <i class="fa-solid fa-arrow-left"></i> Kembali ke Ringkasan
            </a>
            <p class="eyebrow mb-1">TKT-{{ str_pad((string) $c->id, 6, '0', STR_PAD_LEFT) }}</p>
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

        <dl class="row mb-0 customer-ticket-information">
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
              <a class="customer-ticket-link" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($c->photo) }}" target="_blank" rel="noopener"><i class="fa-solid fa-file-pdf"></i>Lihat dokumen PDF</a>
            @endif
          </dd>
          @endif

          <dt class="col-sm-3 text-muted fw-normal">Dikirim</dt>
          <dd class="col-sm-9">{{ $c->created_at->format('Y-m-d H:i') }}</dd>

          <dt class="col-sm-3 text-muted fw-normal">Diperbarui</dt>
          <dd class="col-sm-9">{{ $c->updated_at->format('Y-m-d H:i') }}</dd>

          @if ($c->admin_note)
          <dt class="col-sm-3 text-muted fw-normal">Tanggapan Tim Lifemedia</dt>
          <dd class="col-sm-9"><div class="customer-ticket-note">{{ $c->admin_note }}</div></dd>
          @endif

          @if ($c->technician)
          <dt class="col-sm-3 text-muted fw-normal">Teknisi</dt>
          <dd class="col-sm-9">{{ $c->technician->name }}</dd>
          @endif
          @if ($c->technician_note)
          <dt class="col-sm-3 text-muted fw-normal">Pembaruan teknisi</dt>
          <dd class="col-sm-9"><div class="customer-ticket-note">{{ $c->technician_note }}</div></dd>
          @endif
        </dl>
      </section>
    </div>
  </main>
</div>
@endsection
