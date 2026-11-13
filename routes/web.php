<?php

use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\TechnicianController as AdminTechnicianController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Technician\DashboardController as TechnicianDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'customer'])->group(function () {
    Route::get('/dashboard', [ComplaintController::class, 'dashboard'])->name('warga.dashboard');
    Route::get('/dashboard/aktivitas', [ComplaintController::class, 'activities'])->name('warga.aktivitas');
    Route::get('/dashboard/progres', [ComplaintController::class, 'progress'])->name('warga.progress');
    Route::get('/dashboard/laporan', [ComplaintController::class, 'report'])->name('warga.laporan.index');
    Route::get('/pengaduan/baru', [ComplaintController::class, 'create'])->name('warga.pengaduan.create');
    Route::post('/pengaduan', [ComplaintController::class, 'store'])->name('warga.pengaduan.store');
    Route::get('/pengaduan/{complaint}', [ComplaintController::class, 'show'])->name('warga.pengaduan.show');
    Route::get('/laporan/pdf', [ComplaintController::class, 'downloadPdf'])->name('warga.laporan.pdf');
});

Route::middleware(['auth', 'technician'])->prefix('teknisi')->name('teknisi.')->group(function () {
    Route::get('/', [TechnicianDashboardController::class, 'index'])->name('dashboard');
    Route::get('/tiket/{complaint}', [TechnicianDashboardController::class, 'show'])->name('tiket.show');
    Route::put('/tiket/{complaint}', [TechnicianDashboardController::class, 'update'])->name('tiket.update');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengaduan', [AdminComplaintController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/belum-ditugaskan', [AdminComplaintController::class, 'unassigned'])->name('pengaduan.unassigned');
    Route::get('/analitik', [AdminDashboardController::class, 'analytics'])->name('analitik');
    Route::get('/laporan', [ReportController::class, 'index'])->name('laporan.index');
    Route::get('/pengaduan/{complaint}', [AdminComplaintController::class, 'show'])->name('pengaduan.show');
    Route::put('/pengaduan/{complaint}', [AdminComplaintController::class, 'update'])->name('pengaduan.update');
    Route::get('/laporan/pdf', [ReportController::class, 'downloadPdf'])->name('laporan.pdf');
    Route::get('/teknisi', [AdminTechnicianController::class, 'index'])->name('teknisi.index');
    Route::get('/teknisi/create', [AdminTechnicianController::class, 'create'])->name('teknisi.create');
    Route::post('/teknisi', [AdminTechnicianController::class, 'store'])->name('teknisi.store');

    Route::get('/kategori', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('kategori.destroy');
});
