<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna, Role Utama (Admin/User), dan Sub-Role (verif_berita, verif_riset)
     */
    public function index(Request $request)
    {
        $query = User::with('roles')->latest();

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10)->withQueryString();

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Perbarui Role Utama (Admin/User) serta Sub-Role (verif_berita, verif_riset) oleh Admin
     */
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'main_role' => 'required|in:Admin,User',
            'sub_roles' => 'nullable|array',
            'sub_roles.*' => 'in:verif_berita',
        ]);

        $rolesToSync = [$request->main_role];

        // Sub-role hanya berlaku untuk pengguna dengan Role Utama 'User'
        if ($request->main_role === 'User' && $request->filled('sub_roles')) {
            $rolesToSync = array_merge($rolesToSync, $request->sub_roles);
        }

        // Pastikan role sudah ada di database Spatie
        foreach ($rolesToSync as $rName) {
            Role::firstOrCreate(['name' => $rName]);
        }

        $user->syncRoles($rolesToSync);

        $labelRoles = implode(', ', $rolesToSync);

        ActivityLog::log(
            'change_role',
            "Otoritas akun {$user->name} diperbarui menjadi [{$labelRoles}] oleh " . auth()->user()->name,
            $user
        );

        return back()->with('success', "Hak akses akun {$user->name} berhasil diperbarui menjadi: {$labelRoles}.");
    }
}
