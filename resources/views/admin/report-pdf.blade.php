<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan SIGAP Desa</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #17212d; font-size: 12px; }
        h1, h2 { margin-bottom: 6px; }
        .header { border-bottom: 2px solid #0B2545; padding-bottom: 10px; margin-bottom: 14px; }
        .stats { display: flex; gap: 10px; margin-bottom: 14px; }
        .stat-card { flex: 1; border: 1px solid #dce5ef; border-radius: 8px; padding: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #dce5ef; padding: 6px; text-align: left; }
        th { background: #0B2545; color: #fff; }
        .muted { color: #697587; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIGAP Desa</h1>
        <div class="muted">Laporan pengaduan masyarakat desa</div>
        <div class="muted">Dicetak pada {{ $generatedAt }}</div>
    </div>

    <div class="stats">
        <div class="stat-card"><strong>{{ $stats['masuk'] }}</strong><br>Pengaduan Masuk</div>
        <div class="stat-card"><strong>{{ $stats['diproses'] }}</strong><br>Sedang Diproses</div>
        <div class="stat-card"><strong>{{ $stats['selesai'] }}</strong><br>Selesai</div>
        <div class="stat-card"><strong>{{ $stats['total'] }}</strong><br>Total Pengaduan</div>
    </div>

    <h2>Daftar Pengaduan Terbaru</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelapor</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($complaints as $item)
                <tr>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->location }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
