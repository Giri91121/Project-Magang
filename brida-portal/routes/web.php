<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Rute Publik (Landing Page BRIDA Kota Makassar)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pemerintahan', [HomeController::class, 'pemerintahan'])->name('pemerintahan');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan');
Route::get('/informasi-publik', [HomeController::class, 'informasiPublik'])->name('informasi-publik');
Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// Rute Dashboard Internal (Terproteksi Autentikasi Breeze & RBAC Spatie)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
