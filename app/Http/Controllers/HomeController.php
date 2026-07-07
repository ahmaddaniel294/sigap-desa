<?php

namespace App\Http\Controllers;

use App\Models\Complaint;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'total' => Complaint::count(),
            'masuk' => Complaint::where('status', Complaint::STATUS_DIAJUKAN)->count(),
            'diproses' => Complaint::where('status', Complaint::STATUS_DIPROSES)->count(),
            'selesai' => Complaint::where('status', Complaint::STATUS_SELESAI)->count(),
        ];

        return view('home', compact('stats'));
    }
}
