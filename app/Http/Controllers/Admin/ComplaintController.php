<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        return $this->listing($request, false);
    }

    public function unassigned(Request $request)
    {
        return $this->listing($request, true);
    }

    private function listing(Request $request, bool $unassignedOnly)
    {
        $query = Complaint::with(['user', 'technician'])->latest();
        $status = $request->query('status');
        $search = trim((string) $request->query('search', ''));

        if ($unassignedOnly) {
            $query->whereNull('technician_id');
        }

        if (in_array($status, Complaint::STATUS_FLOW, true)) {
            $query->where('status', $status);
        }

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('category', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        return view('admin.complaints.index', [
            'complaints' => $query->paginate(15)->withQueryString(),
            'status' => $status,
            'search' => $search,
            'unassignedOnly' => $unassignedOnly,
        ]);
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['user', 'technician']);

        return view('admin.show', [
            'c' => $complaint,
            'technicians' => User::where('role', 'teknisi')->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Complaint $complaint)
    {
        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', Complaint::STATUS_FLOW)],
            'admin_note' => ['nullable', 'string'],
            'technician_id' => [
                'nullable',
                Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'teknisi')),
            ],
        ]);

        $complaint->update($data);

        session()->flash('success', 'Pengaduan berhasil diperbarui.');

        return redirect()->route('admin.pengaduan.show', $complaint);
    }
}
