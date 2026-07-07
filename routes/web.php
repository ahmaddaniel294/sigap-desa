<?php

use App\Http\Controllers\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [ComplaintController::class, 'dashboard'])->name('warga.dashboard');
    Route::get('/pengaduan/baru', [ComplaintController::class, 'create'])->name('warga.pengaduan.create');
    Route::post('/pengaduan', [ComplaintController::class, 'store'])->name('warga.pengaduan.store');
    Route::get('/pengaduan/{complaint}', [ComplaintController::class, 'show'])->name('warga.pengaduan.show');
    Route::get('/laporan/pdf', [ComplaintController::class, 'downloadPdf'])->name('warga.laporan.pdf');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengaduan/{complaint}', [AdminComplaintController::class, 'show'])->name('pengaduan.show');
    Route::put('/pengaduan/{complaint}', [AdminComplaintController::class, 'update'])->name('pengaduan.update');
    Route::get('/laporan/pdf', [ReportController::class, 'downloadPdf'])->name('laporan.pdf');

    Route::get('/kategori', [\App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [\App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{category}/edit', [\App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{category}', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy'])->name('kategori.destroy');
});
