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
            'komentar' => 'required|string|min:3|max:500',
        ], [
            'komentar.required' => 'Komentar tidak boleh kosong.',
            'komentar.min' => 'Komentar minimal 3 karakter.',
            'komentar.max' => 'Komentar maksimal 500 karakter.',
        ]);

        $text = trim($validated['komentar']);

        // 1. Deteksi Link / URL
        if (preg_match('/(https?:\/\/|www\.|[a-z0-9\-]+\.(com|id|net|org|xyz|info|biz|co|io|me|ly|gg|vip|site|online|top|link|click)\b)/i', $text)) {
            ActivityLog::log(
                'spam_komentar_link',
                Auth::user()->name . " mencoba mengirim komentar mengandung link pada berita: {$berita->judul}",
                $berita
            );
            return back()->withInput()->withErrors(['komentar' => 'Komentar tidak diperbolehkan mengandung tautan atau link URL.']);
        }

        // 2. Deteksi Kata Spam & Pengulangan Karakter Berlebihan
        $spamKeywords = ['slot', 'gacor', 'judi', 'maxwin', 'togel', 'pinjol', 'zeus', 'scatter', 'jp paus', 'situs terpercaya', 'poker', 'casino', 'rtp live', 'daftar sekarang', 'bonus new member'];
        $lowerText = mb_strtolower($text);
        $hasSpamKeyword = false;
        foreach ($spamKeywords as $kw) {
            if (str_contains($lowerText, $kw)) {
                $hasSpamKeyword = true;
                break;
            }
        }
        if ($hasSpamKeyword || preg_match('/(.)\1{7,}/u', $text)) {
            ActivityLog::log(
                'spam_komentar_kata',
                Auth::user()->name . " terdeteksi mengirim komentar spam pada berita: {$berita->judul}",
                $berita
            );
            return back()->withInput()->withErrors(['komentar' => 'Komentar terdeteksi mengandung unsur spam dan tidak dapat dipublikasikan.']);
        }

        // 3. Rate Limiting (Jeda 30 Detik antar komentar)
        $recentCooldown = KomentarBerita::where('user_id', Auth::id())
            ->where('created_at', '>=', now()->subSeconds(30))
            ->exists();
        if ($recentCooldown) {
            return back()->withInput()->withErrors(['komentar' => 'Mohon tunggu 30 detik sebelum mengirim komentar berikutnya.']);
        }

        // 4. Deteksi Komentar Duplikat
        $lastComment = KomentarBerita::where('berita_id', $berita->id)
            ->where('user_id', Auth::id())
            ->latest()
            ->first();
        if ($lastComment && mb_strtolower(trim($lastComment->komentar)) === $lowerText) {
            return back()->withInput()->withErrors(['komentar' => 'Komentar yang sama sudah pernah Anda kirimkan.']);
        }

        $komentar = KomentarBerita::create([
            'berita_id' => $berita->id,
            'user_id' => Auth::id(),
            'komentar' => $text,
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
