<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function downloadPdf(Request $request)
    {
        $stats = [
            'total' => Complaint::count(),
            'masuk' => Complaint::where('status', Complaint::STATUS_DIAJUKAN)->count(),
            'diproses' => Complaint::where('status', Complaint::STATUS_DIPROSES)->count(),
            'selesai' => Complaint::where('status', Complaint::STATUS_SELESAI)->count(),
        ];

        $complaints = Complaint::with('user')->latest()->take(20)->get();

        $pdf = Pdf::loadView('admin.report-pdf', [
            'stats' => $stats,
            'complaints' => $complaints,
            'generatedAt' => now()->locale('id')->translatedFormat('d F Y, H:i'),
        ]);

        return $pdf->download('laporan-pengaduan-sigap-desa.pdf');
    }
}
