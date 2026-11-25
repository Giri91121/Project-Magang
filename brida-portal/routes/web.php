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
use App\Http\Controllers\RegulasiController;
use App\Http\Controllers\KomentarBeritaController;
use App\Http\Controllers\LandingCmsController;
use Illuminate\Support\Facades\Route;

// Rute Publik (Landing Page BRIDA Kota Makassar)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pemerintahan', [HomeController::class, 'pemerintahan'])->name('pemerintahan');
Route::get('/struktur-organisasi', [HomeController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
Route::get('/pemerintahan/struktur-organisasi', [HomeController::class, 'strukturOrganisasi']);
Route::get('/layanan', [HomeController::class, 'layanan'])->name('layanan');
Route::get('/informasi-publik', [HomeController::class, 'informasiPublik'])->name('informasi-publik');
Route::get('/regulasi/download/{id}', [RegulasiController::class, 'download'])->name('regulasi.download');
Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [HomeController::class, 'beritaDetail'])->name('berita.detail');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('/ppid-pelaksana', [HomeController::class, 'ppidPelaksana'])->name('ppid-pelaksana');
Route::get('/ppid-pelaksana/download/{doc}', [HomeController::class, 'downloadPpidDoc'])->name('ppid-pelaksana.download');
Route::get('/tentang', [HomeController::class, 'tentang'])->name('tentang');

// Rute Dashboard Internal (Terproteksi Autentikasi Breeze & RBAC Spatie)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute Kirim, Hapus, & Lihat Komentar Saya (Wajib Login + Proteksi Honeypot Anti-Spam)
    Route::post('/berita/{slug}/komentar', [KomentarBeritaController::class, 'store'])
        ->middleware('honeypot')
        ->name('berita.komentar.store');
    Route::delete('/komentar/{id}', [KomentarBeritaController::class, 'destroy'])->name('berita.komentar.destroy');
    Route::get('/dashboard/komentar', [KomentarBeritaController::class, 'myComments'])->name('dashboard.komentar.index');

    // Modul CMS Berita & Publikasi (Khusus Admin atau Sub-Role verif_berita)
    Route::prefix('dashboard/berita')->name('dashboard.berita.')->middleware('role:Admin|verif_berita')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('index');
        Route::get('/create', [BeritaController::class, 'create'])->name('create');
        Route::post('/', [BeritaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BeritaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BeritaController::class, 'update'])->name('update');
        Route::delete('/{id}', [BeritaController::class, 'destroy'])->name('destroy');
    });

    // Modul Repositori Dokumen & Regulasi (Khusus Admin)
    Route::prefix('dashboard/regulasi')->name('dashboard.regulasi.')->middleware('role:Admin')->group(function () {
        Route::get('/', [RegulasiController::class, 'index'])->name('index');
        Route::get('/create', [RegulasiController::class, 'create'])->name('create');
        Route::post('/', [RegulasiController::class, 'store'])->name('store');
        Route::delete('/{id}', [RegulasiController::class, 'destroy'])->name('destroy');
    });

    // Modul Notifikasi & Log Aktivitas
    Route::prefix('dashboard/notifications')->name('dashboard.notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::patch('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    });

    // Modul Manajemen Pengguna & Hak Akses (Khusus Admin)
    Route::prefix('dashboard/users')->name('dashboard.users.')->middleware('role:Admin')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::patch('/{id}/role', [UserController::class, 'updateRole'])->name('update-role');
    });

    // Modul Editor Penuh Landing Page & Navbar Tanpa Coding (Khusus Admin)
    Route::prefix('dashboard/landing-cms')->name('dashboard.landing-cms.')->middleware('role:Admin')->group(function () {
        Route::get('/', [LandingCmsController::class, 'index'])->name('index');
        Route::post('/hero-appearance', [LandingCmsController::class, 'updateHeroAndAppearance'])->name('update-hero');
        Route::post('/berita-settings', [LandingCmsController::class, 'updateBeritaPageSettings'])->name('berita');
        Route::post('/kontak-settings', [LandingCmsController::class, 'updateKontakPageSettings'])->name('kontak');
        Route::post('/layanan-header', [LandingCmsController::class, 'updateLayananHeaderSettings'])->name('layanan-header');
        Route::post('/informasi-publik-settings', [LandingCmsController::class, 'updateInformasiPublikSettings'])->name('informasi-publik');
        Route::post('/ppid-settings', [LandingCmsController::class, 'updatePpidSettings'])->name('ppid');
        Route::post('/tentang-settings', [LandingCmsController::class, 'updateTentangSettings'])->name('tentang');
        
        // Slideshow Gambar Hero
        Route::post('/slides', [LandingCmsController::class, 'storeSlide'])->name('slides.store');
        Route::patch('/slides/{id}', [LandingCmsController::class, 'updateSlide'])->name('slides.update');
        Route::post('/slides/{id}/move', [LandingCmsController::class, 'moveSlide'])->name('slides.move');
        Route::delete('/slides/{id}', [LandingCmsController::class, 'destroySlide'])->name('slides.destroy');

        // Menu Navbar & Submenu Dropdown
        Route::post('/menus', [LandingCmsController::class, 'storeMenu'])->name('menus.store');
        Route::patch('/menus/{id}', [LandingCmsController::class, 'updateMenu'])->name('menus.update');
        Route::post('/menus/{id}/move', [LandingCmsController::class, 'moveMenu'])->name('menus.move');
        Route::delete('/menus/{id}', [LandingCmsController::class, 'destroyMenu'])->name('menus.destroy');

        // Kartu Layanan Beranda
        Route::post('/services', [LandingCmsController::class, 'storeService'])->name('services.store');
        Route::patch('/services/{id}', [LandingCmsController::class, 'updateService'])->name('services.update');
        Route::post('/services/{id}/move', [LandingCmsController::class, 'moveService'])->name('services.move');
        Route::delete('/services/{id}', [LandingCmsController::class, 'destroyService'])->name('services.destroy');
    });
});

require __DIR__.'/auth.php';

// Jebakan URL Honeypot (Menangkap Scanner Peretas yang Mencari Celah di Web .go.id)
Route::any('/{trap}', function (\Illuminate\Http\Request $request, $trap) {
    \App\Models\ActivityLog::log(
        'honeypot_trap',
        "PERINGATAN KEAMANAN: Percobaan akses jebakan Honeypot (/{$trap}) dari IP " . $request->ip()
    );
    abort(403, 'Akses ditolak dan dicatat oleh Sistem Keamanan BRIDA Kota Makassar.');
})->where('trap', 'wp-admin|wp-login\.php|phpmyadmin|administrator|admin-login|xmlrpc\.php');
