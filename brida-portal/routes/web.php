<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermohonanRisetController;
use App\Http\Controllers\InovasiDaerahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

// Rute Publik (Landing Page BRIDA Kota Makassar)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pemerintahan', [HomeController::class, 'pemerintahan'])->name('pemerintahan');
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan');
Route::get('/informasi-publik', [HomeController::class, 'informasiPublik'])->name('informasi-publik');
Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [HomeController::class, 'beritaDetail'])->name('berita.detail');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');

// Rute Dashboard Internal (Terproteksi Autentikasi Breeze & RBAC Spatie)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Modul CRUD Layanan Izin Riset
    Route::prefix('dashboard/riset')->name('dashboard.riset.')->group(function () {
        Route::get('/', [PermohonanRisetController::class, 'index'])->name('index');
        Route::get('/create', [PermohonanRisetController::class, 'create'])->name('create');
        Route::post('/', [PermohonanRisetController::class, 'store'])->name('store');
        Route::get('/{id}', [PermohonanRisetController::class, 'show'])->name('show');
        Route::patch('/{id}/status', [PermohonanRisetController::class, 'updateStatus'])->name('update-status');
    });

    // Modul Database Inovasi Daerah & IGA
    Route::prefix('dashboard/inovasi')->name('dashboard.inovasi.')->group(function () {
        Route::get('/', [InovasiDaerahController::class, 'index'])->name('index');
        Route::get('/create', [InovasiDaerahController::class, 'create'])->name('create');
        Route::post('/', [InovasiDaerahController::class, 'store'])->name('store');
        Route::get('/{id}', [InovasiDaerahController::class, 'show'])->name('show');
    });

    // Modul CMS Berita & Publikasi (Khusus Admin / Humas)
    Route::prefix('dashboard/berita')->name('dashboard.berita.')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('index');
        Route::get('/create', [BeritaController::class, 'create'])->name('create');
        Route::post('/', [BeritaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BeritaController::class, 'update'])->name('update');
        Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('destroy');
    });

    // Modul Notifikasi & Log Aktivitas
    Route::prefix('dashboard/notifications')->name('dashboard.notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::patch('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    });

    // Modul Ekspor Laporan & Cetak Surat Rekomendasi
    Route::prefix('dashboard/export')->name('dashboard.export.')->group(function () {
        Route::get('/riset/surat/{id}', [ExportController::class, 'printSuratRekomendasi'])->name('riset.surat');
        Route::get('/riset/csv', [ExportController::class, 'exportRisetCsv'])->name('riset.csv');
        Route::get('/inovasi/csv', [ExportController::class, 'exportInovasiCsv'])->name('inovasi.csv');
    });

    // Modul Manajemen Pengguna & Hak Akses (Khusus Admin)
    Route::prefix('dashboard/users')->name('dashboard.users.')->middleware('role:Admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::patch('/{id}/role', [UserController::class, 'updateRole'])->name('update-role');
    });

    // Modul Pengaturan Profil & Kontak Instansi (Khusus Admin)
    Route::prefix('dashboard/settings')->name('dashboard.settings.')->middleware('role:Admin')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('/', [SettingController::class, 'update'])->name('update');
    });
});

require __DIR__.'/auth.php';
