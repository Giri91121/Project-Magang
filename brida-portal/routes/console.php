<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Spatie\Permission\Models\Role;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('user:make-admin {email?}', function ($email = null) {
    Role::firstOrCreate(['name' => 'Admin']);

    if ($email) {
        $user = User::where('email', $email)->first();
    } else {
        // Jika email tidak disebutkan, ambil user yang terakhir kali mendaftar (akun Google terbaru)
        $user = User::whereNotNull('google_id')->latest()->first() ?? User::latest()->first();
    }

    if (!$user) {
        $this->error('Pengguna tidak ditemukan.');
        return;
    }

    $user->syncRoles(['Admin']);
    $this->info("BERHASIL! Akun {$user->name} ({$user->email}) sekarang telah menjadi ADMIN.");
})->purpose('Angkat akun pengguna menjadi Administrator Utama BRIDA');
