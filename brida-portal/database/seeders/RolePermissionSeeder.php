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

        // 1. Buat Daftar Permissions
        $permissions = [
            'manage users',
            'manage roles',
            'view dashboard',
            'view riset',
            'create riset',
            'approve riset',
            'view inovasi',
            'manage inovasi',
            'publish berita',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Buat Daftar Roles
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $penelitiRole = Role::firstOrCreate(['name' => 'Peneliti']);
        $fasilitatorRole = Role::firstOrCreate(['name' => 'Fasilitator Inovasi']);
        $pemohonRole = Role::firstOrCreate(['name' => 'Pemohon']);

        // 3. Assign Permissions ke Roles
        $adminRole->givePermissionTo(Permission::all());

        $penelitiRole->givePermissionTo([
            'view dashboard',
            'view riset',
            'approve riset',
            'publish berita',
        ]);

        $fasilitatorRole->givePermissionTo([
            'view dashboard',
            'view inovasi',
            'manage inovasi',
            'publish berita',
        ]);

        $pemohonRole->givePermissionTo([
            'view dashboard',
            'view riset',
            'create riset',
        ]);

        // 4. Buat Akun Demo Resmi untuk Masing-masing Role
        $users = [
            [
                'name' => 'Administrator Utama BRIDA',
                'email' => 'admin@brida.makassarkota.go.id',
                'password' => Hash::make('password123'),
                'role' => 'Admin',
            ],
            [
                'name' => 'Dr. H. Ahmad Fauzi (Tim Periset)',
                'email' => 'peneliti@brida.makassarkota.go.id',
                'password' => Hash::make('password123'),
                'role' => 'Peneliti',
            ],
            [
                'name' => 'Siti Nurhaliza, S.STP (Fasilitator OPD)',
                'email' => 'fasilitator@brida.makassarkota.go.id',
                'password' => Hash::make('password123'),
                'role' => 'Fasilitator Inovasi',
            ],
            [
                'name' => 'Muhammad Giri (Pemohon Riset Mahasiswa)',
                'email' => 'pemohon@brida.makassarkota.go.id',
                'password' => Hash::make('password123'),
                'role' => 'Pemohon',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => $userData['password'],
                    'email_verified_at' => now(),
                ]
            );

            $user->syncRoles([$userData['role']]);
        }
    }
}
