<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Hapus role lama yang sudah tidak digunakan jika ada
        Role::whereIn('name', ['Peneliti', 'Fasilitator Inovasi', 'Pemohon'])->delete();

        // 1. Buat Role Utama (Admin & User) dan Sub-Role (verif_berita, verif_riset)
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $userRole = Role::firstOrCreate(['name' => 'User']);
        $verifBeritaRole = Role::firstOrCreate(['name' => 'verif_berita']);
        $verifRisetRole = Role::firstOrCreate(['name' => 'verif_riset']);

        // 2. Pastikan seluruh user yang sudah ada di database memiliki minimal role User jika belum Admin
        foreach (User::all() as $existingUser) {
            if ($existingUser->email === 'admin@brida.makassarkota.go.id' || $existingUser->email === 'admin@makassarkota.go.id') {
                $existingUser->syncRoles(['Admin']);
            } elseif (!$existingUser->hasRole('Admin') && !$existingUser->hasRole('User')) {
                $existingUser->assignRole('User');
            }
        }

        // 3. Buat / Update Akun Demo Resmi Sesuai Struktur Baru
        $demoUsers = [
            [
                'name' => 'Administrator Utama BRIDA',
                'email' => 'admin@makassarkota.go.id',
                'password' => Hash::make('password'),
                'roles' => ['Admin'],
            ],
            [
                'name' => 'Andi Pratama (User Pemohon)',
                'email' => 'user@makassarkota.go.id',
                'password' => Hash::make('password'),
                'roles' => ['User'],
            ],
            [
                'name' => 'Dr. Ahmad Fauzi (User + Verifikator Riset)',
                'email' => 'verif.riset@makassarkota.go.id',
                'password' => Hash::make('password'),
                'roles' => ['User', 'verif_riset'],
            ],
            [
                'name' => 'Siti Nurhaliza (User + Verifikator Berita)',
                'email' => 'verif.berita@makassarkota.go.id',
                'password' => Hash::make('password'),
                'roles' => ['User', 'verif_berita'],
            ],
        ];

        foreach ($demoUsers as $data) {
            $u = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => $data['password'],
                    'email_verified_at' => now(),
                ]
            );
            $u->syncRoles($data['roles']);
        }
    }
}
