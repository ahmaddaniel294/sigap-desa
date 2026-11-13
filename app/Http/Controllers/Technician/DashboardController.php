<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $technician = $request->user();
        $complaints = $technician->assignedComplaints()
            ->with('user')
            ->latest()
            ->paginate(12);

        return view('technician.dashboard', [
            'complaints' => $complaints,
            'stats' => [
                'total' => $technician->assignedComplaints()->count(),
                'baru' => $technician->assignedComplaints()->where('status', Complaint::STATUS_DIAJUKAN)->count(),
                'diproses' => $technician->assignedComplaints()->where('status', Complaint::STATUS_DIPROSES)->count(),
                'selesai' => $technician->assignedComplaints()->where('status', Complaint::STATUS_SELESAI)->count(),
            ],
        ]);
    }

    public function show(Request $request, int $complaint)
    {
        $ticket = $request->user()->assignedComplaints()
            ->with(['user', 'technician'])
            ->findOrFail($complaint);

        return view('technician.tickets.show', ['ticket' => $ticket]);
    }

    public function update(Request $request, int $complaint)
    {
        $ticket = $request->user()->assignedComplaints()->findOrFail($complaint);
        $data = $request->validate([
            'status' => ['required', 'in:' . Complaint::STATUS_DIPROSES . ',' . Complaint::STATUS_SELESAI],
            'technician_note' => ['required', 'string', 'max:5000'],
        ]);

        $ticket->update($data);

        return redirect()
            ->route('teknisi.tiket.show', $ticket)
            ->with('success', 'Progres dan catatan tiket berhasil diperbarui.');
    }
}
