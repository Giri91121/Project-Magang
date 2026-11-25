<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Regulasi;
use App\Models\HeroSlide;
use App\Models\LandingService;
use App\Models\Setting;
use App\Services\InstagramFeedService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(InstagramFeedService $instagramService)
    {
        $beritaTerbaru = Berita::where('status', 'Publikasi')->latest()->take(3)->get();
        $heroSlides = HeroSlide::where('is_active', true)->orderBy('sort_order')->get();
        $landingServices = LandingService::where('is_active', true)->orderBy('sort_order')->get();
        $instagramPosts = $instagramService->getLatestPosts(3);

        return view('landing.index', compact('beritaTerbaru', 'heroSlides', 'landingServices', 'instagramPosts'));
    }

    public function pemerintahan()
    {
        return view('landing.pemerintahan');
    }

    public function strukturOrganisasi()
    {
        return view('landing.struktur-organisasi');
    }

    public function layanan()
    {
        $landingServices = LandingService::where('is_active', true)->orderBy('sort_order')->get();
        return view('landing.layanan', compact('landingServices'));
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

        $infoPerPage = (int) (Setting::where('key', 'info_per_page')->value('value') ?? 8);
        if ($infoPerPage < 4) {
            $infoPerPage = 8;
        }
        $regulasiList = $query->paginate($infoPerPage)->withQueryString();

        return view('landing.informasi-publik', compact('regulasiList'));
    }

    public function berita(Request $request)
    {
        $settings = Setting::all()->pluck('value', 'key');
        $perPage = (int) ($settings['berita_per_page'] ?? 6);
        if ($perPage < 3) {
            $perPage = 6;
        }

        $query = Berita::where('status', 'Publikasi')->latest();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $beritaList = $query->paginate($perPage)->withQueryString();

        $sorotan = null;
        if (($settings['berita_sorotan_aktif'] ?? '1') === '1') {
            if (($settings['berita_sorotan_mode'] ?? 'otomatis') === 'manual' && !empty($settings['berita_sorotan_id'])) {
                $sorotan = Berita::where('status', 'Publikasi')->find($settings['berita_sorotan_id']);
            }
            if (!$sorotan) {
                $sorotan = Berita::where('status', 'Publikasi')->latest()->first();
            }
        }

        return view('landing.berita', compact('beritaList', 'sorotan', 'settings'));
    }

    public function beritaDetail($slug)
    {
        $settings = Setting::all()->pluck('value', 'key');

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

        return view('landing.berita-detail', compact('berita', 'beritaTerkait', 'settings'));
    }

    public function kontak()
    {
        return view('landing.kontak');
    }

    public function ppidPelaksana()
    {
        $regulasiList = Regulasi::latest()->get();
        return view('landing.ppid-pelaksana', compact('regulasiList'));
    }

    public function downloadPpidDoc($doc)
    {
        $key = match ($doc) {
            'renstra' => 'ppid_renstra_file',
            'renja' => 'ppid_renja_file',
            'lakip' => 'ppid_lakip_file',
            default => null,
        };

        if (!$key) {
            abort(404);
        }

        $relativePath = Setting::where('key', $key)->value('value');
        if (!$relativePath) {
            abort(404, 'Dokumen belum tersedia.');
        }

        $fullPath = storage_path('app/public/' . $relativePath);
        if (!file_exists($fullPath)) {
            abort(404, 'File dokumen tidak ditemukan di server.');
        }

        return response()->download($fullPath);
    }

    public function tentang()
    {
        return view('landing.tentang');
    }
}

