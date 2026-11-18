<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\KomentarBerita;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarBeritaController extends Controller
{
    /**
     * Tampilkan daftar komentar berita yang pernah dibuat oleh User (atau semua komentar jika Admin/verif_berita)
     */
    public function myComments()
    {
        $user = Auth::user();
        $canManageAll = $user->hasRole(['Admin', 'verif_berita']);

        $query = KomentarBerita::with(['berita', 'user'])->latest();
        if (!$canManageAll) {
            $query->where('user_id', $user->id);
        }

        $komentars = $query->paginate(10);

        return view('dashboard.komentar.index', compact('komentars', 'canManageAll'));
    }

    /**
     * Simpan komentar baru pada artikel berita (Wajib Login)
     */
    public function store(Request $request, $slug)
    {
        $berita = Berita::where('slug', $slug)->where('status', 'Publikasi')->firstOrFail();

        $validated = $request->validate([
            'komentar' => 'required|string|min:3|max:1000',
        ]);

        $komentar = KomentarBerita::create([
            'berita_id' => $berita->id,
            'user_id' => Auth::id(),
            'komentar' => $validated['komentar'],
            'is_approved' => true,
        ]);

        ActivityLog::log(
            'create_komentar',
            "Pengguna " . Auth::user()->name . " memberikan komentar pada berita '{$berita->judul}'",
            $berita
        );

        return redirect()->to(route('berita.detail', $berita->slug) . '#kolom-komentar')
            ->with('success_komentar', 'Terima kasih, tanggapan dan komentar Anda telah berhasil diterbitkan.');
    }

    /**
     * Hapus komentar (Hanya oleh Pemilik Komentar atau Admin)
     */
    public function destroy($id)
    {
        $komentar = KomentarBerita::with('berita')->findOrFail($id);
        $user = Auth::user();

        if ($komentar->user_id !== $user->id && !$user->hasRole('Admin')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus komentar ini.');
        }

        $slug = $komentar->berita->slug ?? '';
        $komentar->delete();

        ActivityLog::log('delete_komentar', "Komentar pada berita dihapus oleh " . $user->name);

        if ($slug) {
            return redirect()->to(route('berita.detail', $slug) . '#kolom-komentar')
                ->with('success_komentar', 'Komentar berhasil dihapus.');
        }

        return back()->with('success_komentar', 'Komentar berhasil dihapus.');
    }
}
