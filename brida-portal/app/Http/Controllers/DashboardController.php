<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $primaryRole = $roles->first() ?? 'Pengguna';

        // Statistik Realistis BRIDA Makassar
        $stats = [
            'total_riset' => 48,
            'riset_pending' => 5,
            'riset_disetujui' => 43,
            'total_inovasi' => 124,
            'skpd_terlibat' => 38,
            'kategori_iga' => 'Sangat Inovatif',
        ];

        // Daftar Berkas Izin Riset Terkini
        $recentPermohonan = [
            [
                'id' => 'RST-2026-089',
                'pemohon' => 'Andi Muhammad Ilham (Unhas)',
                'judul' => 'Kajian Transformasi Transportasi Publik Rendah Karbon Kota Makassar',
                'tanggal' => '16 Nov 2026',
                'status' => 'Menunggu Review',
                'status_color' => 'bg-amber-100 text-amber-800',
            ],
            [
                'id' => 'RST-2026-088',
                'pemohon' => 'Nurul Aulia Rahman (UNM)',
                'judul' => 'Efektivitas Program Lorong Wisata terhadap Kesejahteraan UMKM Pesisir',
                'tanggal' => '14 Nov 2026',
                'status' => 'Disetujui',
                'status_color' => 'bg-emerald-100 text-emerald-800',
            ],
            [
                'id' => 'RST-2026-087',
                'pemohon' => 'Fakultas Kedokteran Unhas',
                'judul' => 'Pemetaan Stunting dan Intervensi Nutrisi Cerdas di Wilayah Kepulauan',
                'tanggal' => '11 Nov 2026',
                'status' => 'Disetujui',
                'status_color' => 'bg-emerald-100 text-emerald-800',
            ],
            [
                'id' => 'RST-2026-086',
                'pemohon' => 'Bappeda Litbang Kota Parepare',
                'judul' => 'Studi Banding Replikasi Inovasi Kebersihan Lingkungan Terpadu',
                'tanggal' => '08 Nov 2026',
                'status' => 'Selesai',
                'status_color' => 'bg-blue-100 text-blue-800',
            ],
        ];

        return view('dashboard', compact('user', 'primaryRole', 'stats', 'recentPermohonan'));
    }
}
