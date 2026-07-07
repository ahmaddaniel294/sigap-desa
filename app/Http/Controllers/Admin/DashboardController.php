<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total' => Complaint::count(),
            'masuk' => Complaint::where('status', Complaint::STATUS_DIAJUKAN)->count(),
            'diproses' => Complaint::where('status', Complaint::STATUS_DIPROSES)->count(),
            'selesai' => Complaint::where('status', Complaint::STATUS_SELESAI)->count(),
        ];

        $trend = Complaint::selectRaw('DATE(created_at) as day, COUNT(*) as jumlah')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $categories = Complaint::selectRaw('category, COUNT(*) as jumlah')
            ->groupBy('category')
            ->orderByDesc('jumlah')
            ->get();

        $categoryCounts = $categories->pluck('jumlah', 'category')->toArray();
        $statusFilter = $request->query('status');

        $query = Complaint::with('user')->latest();
        if (in_array($statusFilter, Complaint::STATUS_FLOW, true)) {
            $query->where('status', $statusFilter);
        }
        $complaints = $query->get();

        return view('admin.dashboard', [
            'stats' => $stats,
            'complaints' => $complaints,
            'statusFilter' => $statusFilter,
            'trendLabels' => $trend->pluck('day')->values(),
            'trendValues' => $trend->pluck('jumlah')->values(),
            'categoryLabels' => $categories->pluck('category')->values(),
            'categoryValues' => $categories->pluck('jumlah')->values(),
            'categoryCounts' => $categoryCounts,
        ]);
    }
}
