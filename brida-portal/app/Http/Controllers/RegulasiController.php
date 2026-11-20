<?php

namespace App\Http\Controllers;

use App\Models\Regulasi;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegulasiController extends Controller
{
    /**
     * Tampilkan daftar seluruh regulasi & dokumen di dashboard
     */
    public function index(Request $request)
    {
        $query = Regulasi::with('user')->latest();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_regulasi', 'like', "%{$search}%")
                  ->orWhere('nomor_peraturan', 'like', "%{$search}%")
                  ->orWhere('tentang', 'like', "%{$search}%");
            });
        }

        $regulasis = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => Regulasi::count(),
            'perwali' => Regulasi::where('kategori', 'Peraturan Walikota')->count(),
            'sop' => Regulasi::where('kategori', 'Pedoman Teknis')->count(),
            'total_unduhan' => Regulasi::sum('download_count'),
        ];

        return view('dashboard.regulasi.index', compact('regulasis', 'stats'));
    }

    /**
     * Tampilkan form upload dokumen regulasi baru
     */
    public function create()
    {
        return view('dashboard.regulasi.create');
    }

    /**
     * Simpan dokumen regulasi baru ke database & storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_regulasi' => 'required|string|max:255',
            'nomor_peraturan' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tahun' => 'required|integer|min:2015|max:2030',
            'tentang' => 'required|string',
            'file_dokumen' => 'nullable|file|mimes:pdf|max:15360', // Maks. 15 MB
            'status' => 'required|in:Aktif,Draft',
        ]);

        $data = $validated;
        $data['user_id'] = Auth::id();

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $data['ukuran_file'] = round($file->getSize() / 1048576, 2) . ' MB';
            $data['file_dokumen'] = $file->store('regulasi', 'public');
        } else {
            $data['ukuran_file'] = '1.0 MB';
        }

        $regulasi = Regulasi::create($data);

        ActivityLog::log('create_regulasi', "Regulasi baru '{$regulasi->nomor_peraturan}' diunggah oleh " . Auth::user()->name, $regulasi);

        return redirect()->route('dashboard.regulasi.index')
            ->with('success', "Dokumen regulasi '{$regulasi->nomor_peraturan}' berhasil ditambahkan ke repositori.");
    }

    /**
     * Hapus dokumen regulasi
     */
    public function destroy($id)
    {
        $regulasi = Regulasi::findOrFail($id);
        $nomor = $regulasi->nomor_peraturan;
        $regulasi->delete();

        ActivityLog::log('delete_regulasi', "Regulasi '{$nomor}' dihapus oleh " . Auth::user()->name);

        return back()->with('success', "Dokumen regulasi '{$nomor}' berhasil dihapus.");
    }

    /**
     * Aksi Unduh Dokumen Publik & Counter Download
     */
    public function download($id)
    {
        $regulasi = Regulasi::findOrFail($id);
        $regulasi->increment('download_count');

        if ($regulasi->file_dokumen && file_exists(storage_path('app/public/' . $regulasi->file_dokumen))) {
            return response()->download(storage_path('app/public/' . $regulasi->file_dokumen));
        }

        // Default fallback panduan txt jika belum ada pdf
        return response()->download(public_path('docs/Panduan_Pengguna_BRIDA_Makassar.txt'));
    }
}
