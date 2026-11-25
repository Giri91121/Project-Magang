<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KomentarBerita;
use App\Models\Regulasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $primaryRole = $user->hasRole('Admin') ? 'Admin' : 'User';
        $subRoles = $roles->reject(fn($r) => in_array($r, ['Admin', 'User']))->values()->all();

        $stats = [
            'total_berita' => Berita::where('status', 'Publikasi')->count(),
            'total_komentar' => KomentarBerita::count(),
            'total_regulasi' => Regulasi::count(),
            'total_users' => User::count(),
        ];

        $recentBerita = Berita::latest()->take(5)->get();

        return view('dashboard', compact('user', 'primaryRole', 'subRoles', 'stats', 'recentBerita'));
    }
}
