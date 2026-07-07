<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function show(Complaint $complaint)
    {
        $complaint->load('user');

        return view('admin.show', ['c' => $complaint]);
    }

    public function update(Request $request, Complaint $complaint)
    {
        $data = $request->validate([
            'status' => ['required', 'in:' . implode(',', Complaint::STATUS_FLOW)],
            'admin_note' => ['nullable', 'string'],
        ]);

        $complaint->update($data);

        session()->flash('success', 'Status pengaduan berhasil diperbarui dan warga akan menerima notifikasi.');

        return redirect()->route('admin.pengaduan.show', $complaint);
    }
}
