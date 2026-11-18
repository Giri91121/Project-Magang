<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Tampilkan daftar seluruh pengguna dan peran mereka
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
        $roles = Role::all();

        return view('dashboard.users.index', compact('users', 'roles'));
    }

    /**
     * Perbarui hak akses role pengguna (Khusus Admin)
     */
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Sinkronisasi role Spatie
        $user->syncRoles([$request->role]);

        return back()->with('success', "Hak akses role akun {$user->name} berhasil diperbarui menjadi {$request->role}.");
    }
}
