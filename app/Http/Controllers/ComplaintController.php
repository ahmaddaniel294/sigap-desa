<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Complaint;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ComplaintController extends Controller
{
    public function dashboard()
    {
        $complaints = Auth::user()->complaints()->latest()->get();

        return view('warga.dashboard', compact('complaints'));
    }

    public function downloadPdf()
    {
        $user = Auth::user();
        $complaints = $user->complaints()->latest()->get();

        $stats = [
            'total' => $complaints->count(),
            'diajukan' => $complaints->where('status', Complaint::STATUS_DIAJUKAN)->count(),
            'diproses' => $complaints->where('status', Complaint::STATUS_DIPROSES)->count(),
            'selesai' => $complaints->where('status', Complaint::STATUS_SELESAI)->count(),
        ];

        $pdf = Pdf::loadView('warga.report-pdf', [
            'user' => $user,
            'stats' => $stats,
            'complaints' => $complaints,
            'generatedAt' => now()->locale('id')->translatedFormat('d F Y, H:i'),
        ]);

        return $pdf->download('laporan-pengaduan-warga-sigap-desa.pdf');
    }

    public function create()
    {
        $categories = Category::orderBy('name')->pluck('name')->toArray();

        if (empty($categories)) {
            $categories = Complaint::CATEGORIES;
        }

        return view('warga.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $categories = Category::orderBy('name')->pluck('name')->toArray();

        if (empty($categories)) {
            $categories = Complaint::CATEGORIES;
        }

        $data = $request->validate([
            'category' => ['required', 'string', Rule::in($categories)],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('uploads', 'public');
        }

        Auth::user()->complaints()->create([
            'category' => $data['category'],
            'location' => $data['location'],
            'description' => $data['description'],
            'photo' => $photoPath,
            'status' => Complaint::STATUS_DIAJUKAN,
        ]);

        session()->flash('success', 'Pengaduan berhasil dikirim dan akan segera diverifikasi admin desa.');

        return redirect()->route('warga.dashboard');
    }

    public function show(Complaint $complaint)
    {
        abort_unless(
            $complaint->user_id === Auth::id() || Auth::user()->isAdmin(),
            403
        );

        return view('warga.show', ['c' => $complaint]);
    }
}
