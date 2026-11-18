<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $beritaTerbaru = Berita::where('status', 'Publikasi')->latest()->take(3)->get();
        return view('landing.index', compact('beritaTerbaru'));
    }

    public function pemerintahan()
    {
        return view('landing.pemerintahan');
    }

    public function layanan()
    {
        return view('landing.layanan');
    }

    public function informasiPublik()
    {
        return view('landing.informasi-publik');
    }

    public function berita(Request $request)
    {
        $query = Berita::where('status', 'Publikasi')->latest();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $beritaList = $query->paginate(6)->withQueryString();
        $sorotan = Berita::where('status', 'Publikasi')->latest()->first();

        return view('landing.berita', compact('beritaList', 'sorotan'));
    }

    public function beritaDetail($slug)
    {
        $berita = Berita::where('slug', $slug)->where('status', 'Publikasi')->firstOrFail();
        
        // Tambah jumlah view pembaca
        $berita->increment('views');

        $beritaTerkait = Berita::where('status', 'Publikasi')
            ->where('id', '!=', $berita->id)
            ->where('kategori', $berita->kategori)
            ->latest()
            ->take(3)
            ->get();

        return view('landing.berita-detail', compact('berita', 'beritaTerkait'));
    }

    public function kontak()
    {
        return view('landing.kontak');
    }
}

