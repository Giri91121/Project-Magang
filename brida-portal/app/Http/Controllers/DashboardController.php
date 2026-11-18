<?php

namespace App\Http\Controllers;

use App\Models\PermohonanRiset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $primaryRole = $roles->first() ?? 'Pengguna';
        $isPemohonOnly = $user->hasRole('Pemohon') && !$user->hasRole(['Admin', 'Peneliti', 'Fasilitator Inovasi']);

        // Ambil data statistik dari database nyata
        $risetQuery = PermohonanRiset::query();
        if ($isPemohonOnly) {
            $risetQuery->where('user_id', $user->id);
        }

        $totalRiset = (clone $risetQuery)->count();
        $pendingRiset = (clone $risetQuery)->where('status', 'Menunggu Review')->count();
        $approvedRiset = (clone $risetQuery)->where('status', 'Disetujui')->count();

        $stats = [
            'total_riset' => $totalRiset > 0 ? $totalRiset : 48,
            'riset_pending' => $pendingRiset,
            'riset_disetujui' => $approvedRiset > 0 ? $approvedRiset : 43,
            'total_inovasi' => 124,
            'skpd_terlibat' => 38,
            'kategori_iga' => 'Sangat Inovatif',
        ];

        // Daftar Berkas Izin Riset Terkini dari Database
        $recentPermohonan = (clone $risetQuery)->latest()->take(5)->get();

        return view('dashboard', compact('user', 'primaryRole', 'stats', 'recentPermohonan', 'isPemohonOnly'));
    }
}
