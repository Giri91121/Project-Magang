<?php

namespace App\Http\Controllers;

use App\Models\InovasiDaerah;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InovasiDaerahController extends Controller
{
    /**
     * Tampilkan katalog & tabel pemantauan inovasi daerah
     */
    public function index(Request $request)
    {
        $query = InovasiDaerah::with('user')->latest();

        if ($request->filled('tahapan')) {
            $query->where('tahapan_inovasi', $request->tahapan);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_inovasi', 'like', "%{$search}%")
                  ->orWhere('perangkat_daerah', 'like', "%{$search}%")
                  ->orWhere('kode_inovasi', 'like', "%{$search}%");
            });
        }

        $inovasiList = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => InovasiDaerah::count(),
            'penerapan' => InovasiDaerah::where('tahapan_inovasi', 'Penerapan')->count(),
            'uji_coba' => InovasiDaerah::where('tahapan_inovasi', 'Uji Coba')->count(),
            'rata_skor' => round(InovasiDaerah::avg('skor_kematangan') ?? 0, 1),
        ];

        return view('dashboard.inovasi.index', compact('inovasiList', 'stats'));
    }

    /**
     * Tampilkan formulir tambah inovasi baru
     */
    public function create()
    {
        return view('dashboard.inovasi.create');
    }

    /**
     * Simpan inovasi daerah baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_inovasi' => 'required|string|max:255',
            'perangkat_daerah' => 'required|string|max:255',
            'tahapan_inovasi' => 'required|in:Inisiatif,Uji Coba,Penerapan',
            'inisiator' => 'required|string|max:100',
            'jenis_inovasi' => 'required|in:Digital,Non-Digital',
            'urusan_pemerintahan' => 'required|string|max:255',
            'ringkasan' => 'required|string',
            'kebaruan' => 'nullable|string',
            'skor_kematangan' => 'nullable|integer|min:0|max:130',
            'tahun_penerapan' => 'required|integer|min:2020|max:2030',
        ]);

        $latestId = InovasiDaerah::max('id') ?? 0;
        $kodeInovasi = 'INOV-MKS-' . str_pad($latestId + 1, 3, '0', STR_PAD_LEFT);

        $data = $validated;
        $data['user_id'] = Auth::id();
        $data['kode_inovasi'] = $kodeInovasi;
        $data['status_verifikasi'] = 'Terverifikasi';
        $data['skor_kematangan'] = $request->skor_kematangan ?? 80;

        $inovasi = InovasiDaerah::create($data);

        // Catat ke Log Aktivitas
        ActivityLog::log('create_inovasi', "Inovasi daerah baru '{$validated['nama_inovasi']}' ({$kodeInovasi}) ditambahkan oleh " . Auth::user()->name, $inovasi);

        return redirect()->route('dashboard.inovasi.index')
            ->with('success', "Inovasi {$validated['nama_inovasi']} ({$kodeInovasi}) berhasil ditambahkan ke katalog IGA.");
    }

    /**
     * Tampilkan rincian inovasi & indikator kematangan
     */
    public function show($id)
    {
        $inovasi = InovasiDaerah::findOrFail($id);
        return view('dashboard.inovasi.show', compact('inovasi'));
    }
}
