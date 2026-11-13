<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => $this->stats(),
            'recentComplaints' => Complaint::with('user')->latest()->take(5)->get(),
        ]);
    }

    public function analytics()
    {
        $trend = Complaint::selectRaw('DATE(created_at) as day, COUNT(*) as jumlah')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $categories = Complaint::selectRaw('category, COUNT(*) as jumlah')
            ->groupBy('category')
            ->orderByDesc('jumlah')
            ->get();

        return view('admin.analytics', [
            'stats' => $this->stats(),
            'trend' => $trend,
            'categories' => $categories,
        ]);
    }

    private function stats(): array
    {
        return [
            'total' => Complaint::count(),
            'masuk' => Complaint::where('status', Complaint::STATUS_DIAJUKAN)->count(),
            'diproses' => Complaint::where('status', Complaint::STATUS_DIPROSES)->count(),
            'selesai' => Complaint::where('status', Complaint::STATUS_SELESAI)->count(),
        ];
    }
}
