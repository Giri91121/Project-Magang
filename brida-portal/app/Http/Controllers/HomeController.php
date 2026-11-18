<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Regulasi;
use App\Models\HeroSlide;
use App\Models\LandingService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $beritaTerbaru = Berita::where('status', 'Publikasi')->latest()->take(3)->get();
        $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order')->get();
        $landingServices = LandingService::where('is_active', true)->orderBy('sort_order')->get();

        return view('landing.index', compact('beritaTerbaru', 'heroSlides', 'landingServices'));
    }

    public function pemerintahan()
    {
        return view('landing.pemerintahan');
    }

    public function layanan()
    {
        return view('landing.layanan');
    }

    public function informasiPublik(Request $request)
    {
        $query = Regulasi::where('status', 'Aktif')->latest();

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

        $regulasiList = $query->paginate(8)->withQueryString();

        return view('landing.informasi-publik', compact('regulasiList'));
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
        $berita = Berita::with(['komentars' => function($q) {
            $q->where('is_approved', true)->with('user.roles')->latest();
        }])->where('slug', $slug)->where('status', 'Publikasi')->firstOrFail();
        
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

