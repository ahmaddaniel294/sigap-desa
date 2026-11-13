<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TechnicianController extends Controller
{
    public function index()
    {
        return view('admin.technicians.index', [
            'technicians' => User::where('role', 'teknisi')
                ->withCount('assignedComplaints')
                ->orderBy('name')
                ->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.technicians.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'teknisi',
        ]);

        return redirect()
            ->route('admin.teknisi.index')
            ->with('success', 'Akun teknisi berhasil dibuat dan dapat digunakan untuk masuk.');
    }
}
