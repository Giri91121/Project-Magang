<?php

namespace App\Http\Controllers;

use App\Models\PermohonanRiset;
use App\Models\ActivityLog;
use App\Notifications\PermohonanRisetStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermohonanRisetController extends Controller
{
    /**
     * Tampilkan daftar usulan riset dengan filter & pagination
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        // Jika user BUKAN Admin dan BUKAN verif_riset, maka ia hanya bisa melihat permohonannya sendiri
        $isPemohonOnly = !$user->hasRole(['Admin', 'verif_riset']);

        $query = PermohonanRiset::with('user')->latest();

        // Jika hanya pemohon biasa, hanya tampilkan permohonannya sendiri
        if ($isPemohonOnly) {
            $query->where('user_id', $user->id);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pencarian judul / nama / institusi / nomor registrasi
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_penelitian', 'like', "%{$search}%")
                  ->orWhere('nama_pemohon', 'like', "%{$search}%")
                  ->orWhere('institusi', 'like', "%{$search}%")
                  ->orWhere('nomor_registrasi', 'like', "%{$search}%");
            });
        }

        $permohonan = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => $isPemohonOnly ? PermohonanRiset::where('user_id', $user->id)->count() : PermohonanRiset::count(),
            'pending' => $isPemohonOnly ? PermohonanRiset::where('user_id', $user->id)->where('status', 'Menunggu Review')->count() : PermohonanRiset::where('status', 'Menunggu Review')->count(),
            'review' => $isPemohonOnly ? PermohonanRiset::where('user_id', $user->id)->where('status', 'Sedang Ditelaah')->count() : PermohonanRiset::where('status', 'Sedang Ditelaah')->count(),
            'approved' => $isPemohonOnly ? PermohonanRiset::where('user_id', $user->id)->where('status', 'Disetujui')->count() : PermohonanRiset::where('status', 'Disetujui')->count(),
        ];

        return view('dashboard.riset.index', compact('permohonan', 'stats', 'isPemohonOnly'));
    }

    /**
     * Tampilkan formulir pengajuan izin riset baru
     */
    public function create()
    {
        return view('dashboard.riset.create');
    }

    /**
     * Simpan permohonan riset baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'institusi' => 'required|string|max:255',
            'jurusan_fakultas' => 'nullable|string|max:255',
            'kontak_wa' => 'required|string|max:25',
            'judul_penelitian' => 'required|string|max:500',
            'bidang_fokus' => 'required|string|max:100',
            'lokasi_penelitian' => 'required|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'file_proposal' => 'nullable|file|mimes:pdf|max:10240', // max 10MB
            'file_surat_pengantar' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        // Generate Nomor Registrasi Otomatis (RST-2026-XXXX)
        $latestId = PermohonanRiset::max('id') ?? 0;
        $nomorRegistrasi = 'RST-' . date('Y') . '-' . str_pad($latestId + 1, 3, '0', STR_PAD_LEFT);

        $data = $validated;
        $data['user_id'] = Auth::id();
        $data['nomor_registrasi'] = $nomorRegistrasi;
        $data['status'] = 'Menunggu Review';

        if ($request->hasFile('file_proposal')) {
            $data['file_proposal'] = $request->file('file_proposal')->store('proposals', 'public');
        }

        if ($request->hasFile('file_surat_pengantar')) {
            $data['file_surat_pengantar'] = $request->file('file_surat_pengantar')->store('surat_pengantar', 'public');
        }

        $permohonan = PermohonanRiset::create($data);

        // Catat ke Log Aktivitas
        ActivityLog::log('create_riset', "Permohonan riset baru {$nomorRegistrasi} diajukan oleh " . Auth::user()->name, $permohonan);

        return redirect()->route('dashboard.riset.show', $permohonan->id)
            ->with('success', "Permohonan riset berhasil diajukan dengan Nomor Registrasi: {$nomorRegistrasi}");
    }

    /**
     * Tampilkan detail permohonan riset & timeline status
     */
    public function show($id)
    {
        $permohonan = PermohonanRiset::with('user')->findOrFail($id);
        $user = Auth::user();

        // Validasi akses: jika bukan Admin dan bukan verif_riset, hanya boleh melihat permohonannya sendiri
        if (!$user->hasRole(['Admin', 'verif_riset']) && $permohonan->user_id !== $user->id) {
            abort(403, 'Anda tidak berhak melihat berkas ini.');
        }

        return view('dashboard.riset.show', compact('permohonan'));
    }

    /**
     * Perbarui status atau telaah oleh Admin / Peneliti
     */
    public function updateStatus(Request $request, $id)
    {
        if (!Auth::user()->hasRole(['Admin', 'verif_riset'])) {
            abort(403, 'Hanya Admin atau Verifikator Riset yang dapat memperbarui status berkas.');
        }

        $permohonan = PermohonanRiset::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:Menunggu Review,Sedang Ditelaah,Disetujui,Ditolak',
            'catatan_reviewer' => 'nullable|string',
        ]);

        $permohonan->update([
            'status' => $request->status,
            'catatan_reviewer' => $request->catatan_reviewer,
        ]);

        // Catat ke Log Aktivitas
        ActivityLog::log('update_status', "Status permohonan {$permohonan->nomor_registrasi} diubah menjadi '{$request->status}' oleh " . Auth::user()->name, $permohonan);

        // Kirim Notifikasi ke Pemohon jika ada akunnya
        if ($permohonan->user) {
            $permohonan->user->notify(new PermohonanRisetStatusNotification($permohonan, $request->catatan_reviewer ?? ''));
        }

        return back()->with('success', 'Status permohonan riset berhasil diperbarui.');
    }
}
