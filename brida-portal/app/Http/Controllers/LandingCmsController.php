<?php

namespace App\Http\Controllers;

use App\Models\NavbarMenu;
use App\Models\HeroSlide;
use App\Models\LandingService;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingCmsController extends Controller
{
    /**
     * Tampilkan halaman kontrol penuh tanpa coding (No-Code Visual CMS) untuk Landing Page & Navbar
     */
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $menus = NavbarMenu::with('children')->whereNull('parent_id')->orderBy('sort_order')->get();
        $slides = HeroSlide::orderBy('sort_order')->get();
        $services = LandingService::orderBy('sort_order')->get();

        return view('dashboard.landing-cms.index', compact('settings', 'menus', 'slides', 'services'));
    }

    /**
     * Update Teks Hero Beranda, Judul Section, dan Upload Logo Header / Footer
     */
    public function updateHeroAndAppearance(Request $request)
    {
        $textKeys = [
            'hero_title_1',
            'hero_title_1_color',
            'hero_title_highlight',
            'hero_title_highlight_color',
            'hero_title_2',
            'hero_title_2_color',
            'hero_subtitle',
            'hero_subtitle_color',
            'hero_btn1_text',
            'hero_btn1_url',
            'hero_btn1_bg_color',
            'hero_btn1_text_color',
            'hero_btn2_text',
            'hero_btn2_url',
            'layanan_section_badge',
            'layanan_section_title',
            'layanan_section_desc',
        ];

        foreach ($textKeys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key), 'hero');
            }
        }

        // Upload Logo Header Baru jika ada
        if ($request->hasFile('logo_header_file')) {
            $request->validate(['logo_header_file' => 'image|mimes:png,jpg,jpeg,webp,svg|max:5120']);
            $path = $request->file('logo_header_file')->store('logos', 'public');
            Setting::set('logo_header', 'storage/' . $path, 'appearance');
        }

        // Upload Logo Footer Baru jika ada
        if ($request->hasFile('logo_footer_file')) {
            $request->validate(['logo_footer_file' => 'image|mimes:png,jpg,jpeg,webp,svg|max:5120']);
            $path = $request->file('logo_footer_file')->store('logos', 'public');
            Setting::set('logo_footer', 'storage/' . $path, 'appearance');
        }

        ActivityLog::log('update_landing', "Konten Hero Beranda & Logo diperbarui oleh " . Auth::user()->name);

        return back()->with('success', 'Tampilan Hero Beranda dan Logo berhasil diperbarui!');
    }

    /**
     * Tambah Gambar Background Slideshow Baru di Beranda
     */
    public function storeSlide(Request $request)
    {
        $request->validate([
            'gambar_slide' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
            'judul_alt' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $path = $request->file('gambar_slide')->store('slides', 'public');

        $slide = HeroSlide::create([
            'judul_alt' => $request->judul_alt ?? 'Background Slide BRIDA',
            'gambar_path' => $path,
            'sort_order' => $request->sort_order ?? (HeroSlide::max('sort_order') + 1),
            'is_active' => true,
        ]);

        ActivityLog::log('create_slide', "Gambar slideshow beranda baru ditambahkan oleh " . Auth::user()->name, $slide);

        return back()->with('success', 'Gambar background slideshow baru berhasil diunggah dan ditampilkan di beranda!');
    }

    /**
     * Ganti Gambar pada Slide Tertentu
     */
    public function updateSlide(Request $request, $id)
    {
        $slide = HeroSlide::findOrFail($id);

        $request->validate([
            'gambar_slide' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'judul_alt' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        if ($request->hasFile('gambar_slide')) {
            $slide->gambar_path = $request->file('gambar_slide')->store('slides', 'public');
        }

        if ($request->filled('judul_alt')) {
            $slide->judul_alt = $request->judul_alt;
        }

        if ($request->filled('sort_order')) {
            $slide->sort_order = $request->sort_order;
        }

        $slide->save();

        return back()->with('success', 'Gambar slide beranda berhasil diperbarui!');
    }

    /**
     * Hapus Slide Background
     */
    public function destroySlide($id)
    {
        $slide = HeroSlide::findOrFail($id);
        $slide->delete();

        return back()->with('success', 'Gambar slide berhasil dihapus dari beranda.');
    }

    /**
     * Tambah Menu Navbar Utama atau Submenu Dropdown Baru
     */
    public function storeMenu(Request $request)
    {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:navbar_menus,id',
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
            'target_blank' => 'nullable|boolean',
        ]);

        $menu = NavbarMenu::create([
            'parent_id' => $validated['parent_id'] ?? null,
            'label' => $validated['label'],
            'url' => $validated['url'],
            'icon' => $validated['icon'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 10,
            'target_blank' => $request->has('target_blank'),
            'is_active' => true,
        ]);

        ActivityLog::log('create_menu', "Menu navbar '{$menu->label}' ditambahkan oleh " . Auth::user()->name, $menu);

        return back()->with('success', "Menu '{$menu->label}' berhasil ditambahkan ke Navbar!");
    }

    /**
     * Edit Menu Navbar / Submenu
     */
    public function updateMenu(Request $request, $id)
    {
        $menu = NavbarMenu::findOrFail($id);

        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'sort_order' => 'nullable|integer',
        ]);

        $menu->update([
            'label' => $validated['label'],
            'url' => $validated['url'],
            'icon' => $validated['icon'] ?? $menu->icon,
            'sort_order' => $validated['sort_order'] ?? $menu->sort_order,
            'target_blank' => $request->has('target_blank'),
        ]);

        return back()->with('success', "Menu '{$menu->label}' berhasil diperbarui!");
    }

    /**
     * Hapus Menu Navbar / Submenu
     */
    public function destroyMenu($id)
    {
        $menu = NavbarMenu::findOrFail($id);
        $label = $menu->label;
        $menu->delete();

        return back()->with('success', "Menu '{$label}' berhasil dihapus dari Navbar.");
    }

    /**
     * Tambah Kartu Layanan Baru di Beranda
     */
    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string|max:500',
            'icon' => 'required|string|max:100',
            'link_text' => 'required|string|max:100',
            'link_url' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        LandingService::create([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'icon' => $validated['icon'],
            'link_text' => $validated['link_text'],
            'link_url' => $validated['link_url'],
            'sort_order' => $validated['sort_order'] ?? (LandingService::max('sort_order') + 1),
            'is_active' => true,
        ]);

        return back()->with('success', "Kartu layanan '{$validated['judul']}' berhasil ditambahkan ke Beranda!");
    }

    /**
     * Update Kartu Layanan di Beranda
     */
    public function updateService(Request $request, $id)
    {
        $srv = LandingService::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'required|string|max:500',
            'icon' => 'required|string|max:100',
            'link_text' => 'required|string|max:100',
            'link_url' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $srv->update($validated);

        return back()->with('success', "Kartu layanan '{$srv->judul}' berhasil diperbarui!");
    }

    /**
     * Hapus Kartu Layanan dari Beranda
     */
    public function destroyService($id)
    {
        $srv = LandingService::findOrFail($id);
        $srv->delete();

        return back()->with('success', 'Kartu layanan berhasil dihapus dari Beranda.');
    }
}
