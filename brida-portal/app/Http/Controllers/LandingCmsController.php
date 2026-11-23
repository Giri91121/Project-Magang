<?php

namespace App\Http\Controllers;

use App\Models\NavbarMenu;
use App\Models\HeroSlide;
use App\Models\LandingService;
use App\Models\Setting;
use App\Models\Berita;
use App\Models\ActivityLog;
use App\Services\InstagramFeedService;
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
        $beritaPublikasi = Berita::where('status', 'Publikasi')->latest()->get();

        return view('dashboard.landing-cms.index', compact('settings', 'menus', 'slides', 'services', 'beritaPublikasi'));
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
            'hero_slide_interval',
            'logo_footer_white',
            'layanan_section_badge',
            'layanan_section_title',
            'layanan_section_desc',
            // Topbar
            'topbar_enabled',
            'topbar_text',
            'topbar_bg_color',
            'topbar_text_color',
            // Halaman Pemerintahan
            'pemerintahan_header_title',
            'pemerintahan_header_subtitle',
            // Footer Global
            'site_name',
            'tagline',
            'footer_copyright',
            'gov_office_caption',
            'gov_profile_title',
            'gov_profile_p1',
            'gov_profile_p2',
            'gov_visi',
            'gov_misi_1',
            'gov_misi_2',
            'gov_misi_3',
            'gov_misi_4',
            // Tautan Pintasan & Google Maps
            'quicklink_1_label',
            'quicklink_1_url',
            'quicklink_2_label',
            'quicklink_2_url',
            'quicklink_3_label',
            'quicklink_3_url',
            'google_maps_embed',
            // Koneksi Otomatis Instagram @bridakotamakassar
            'ig_username',
            'ig_profile_url',
            'ig_access_token',
            'ig_behold_url',
            // 4 Pimpinan Daerah & BRIDA Makassar
            'leader_section_badge',
            'leader_section_title',
            'leader_1_name',
            'leader_1_title',
            'leader_2_name',
            'leader_2_title',
            'leader_3_name',
            'leader_3_title',
            'leader_4_name',
            'leader_4_title',
        ];

        foreach ($textKeys as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key), 'cms');
            }
        }

        // Upload Foto 4 Pimpinan (Wali Kota, Wakil Wali Kota, Kaban, Sekban) jika ada
        for ($i = 1; $i <= 4; $i++) {
            $field = "leader_{$i}_photo_file";
            if ($request->hasFile($field)) {
                $request->validate([$field => 'image|mimes:png,jpg,jpeg,webp|max:8192']);
                $path = $request->file($field)->store('leaders', 'public');
                Setting::set("leader_{$i}_photo", asset('storage/' . $path), 'leaders');
            }
        }

        // Bersihkan cache Instagram jika pengaturan IG diperbarui
        if ($request->has('ig_access_token') || $request->has('ig_behold_url')) {
            app(InstagramFeedService::class)->clearCache();
        }

        // Upload Foto Gedung Kantor di Halaman Pemerintahan jika ada
        if ($request->hasFile('gov_office_photo_file')) {
            $request->validate(['gov_office_photo_file' => 'image|mimes:png,jpg,jpeg,webp|max:8192']);
            $path = $request->file('gov_office_photo_file')->store('office', 'public');
            Setting::set('gov_office_photo', asset('storage/' . $path), 'pemerintahan');
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

        $maxOrder = NavbarMenu::where('parent_id', $validated['parent_id'] ?? null)->max('sort_order') ?? 0;

        $menu = NavbarMenu::create([
            'parent_id' => $validated['parent_id'] ?? null,
            'label' => $validated['label'],
            'url' => $validated['url'],
            'icon' => $validated['icon'] ?? null,
            'sort_order' => $validated['sort_order'] ?? ($maxOrder + 1),
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
            'icon' => $request->has('icon') ? $validated['icon'] : $menu->icon,
            'sort_order' => $validated['sort_order'] ?? $menu->sort_order,
            'target_blank' => $request->has('target_blank'),
            'is_active' => $request->has('is_active') ? (bool)$request->is_active : $menu->is_active,
        ]);

        return back()->with('success', "Menu '{$menu->label}' berhasil diperbarui!");
    }

    /**
     * Geser Urutan Menu / Submenu Naik atau Turun
     */
    public function moveMenu(Request $request, $id)
    {
        $menu = NavbarMenu::findOrFail($id);
        $direction = $request->input('direction'); // 'up' or 'down'

        $siblings = NavbarMenu::where('parent_id', $menu->parent_id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->values();

        foreach ($siblings as $idx => $item) {
            if ($item->sort_order !== $idx + 1) {
                $item->update(['sort_order' => $idx + 1]);
            }
        }

        $currentIndex = $siblings->search(fn($item) => $item->id === $menu->id);
        if ($currentIndex === false) {
            return back();
        }

        $targetIndex = $direction === 'up' ? $currentIndex - 1 : $currentIndex + 1;
        if ($targetIndex >= 0 && $targetIndex < $siblings->count()) {
            $target = $siblings[$targetIndex];
            $tempOrder = $menu->sort_order;
            $menu->update(['sort_order' => $target->sort_order]);
            $target->update(['sort_order' => $tempOrder]);
        }

        return back()->with('success', "Urutan menu '{$menu->label}' berhasil diperbarui!");
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
     * Tambah Layanan Baru (Sinkron untuk Beranda & Halaman /layanan)
     */
    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'kategori_badge' => 'nullable|string|max:100',
            'deskripsi' => 'required|string|max:1000',
            'detail_title' => 'nullable|string|max:150',
            'detail_items' => 'nullable|string',
            'estimasi_info' => 'nullable|string|max:100',
            'biaya_info' => 'nullable|string|max:100',
            'icon' => 'required|string|max:100',
            'link_text' => 'required|string|max:100',
            'link_url' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        LandingService::create([
            'judul' => $validated['judul'],
            'kategori_badge' => $validated['kategori_badge'] ?? 'Layanan Publik',
            'deskripsi' => $validated['deskripsi'],
            'detail_title' => $validated['detail_title'] ?? 'Persyaratan & Cakupan:',
            'detail_items' => $validated['detail_items'] ?? null,
            'estimasi_info' => $validated['estimasi_info'] ?? 'Estimasi: 1 - 3 Hari Kerja',
            'biaya_info' => $validated['biaya_info'] ?? 'Biaya: Rp 0 (Gratis)',
            'icon' => $validated['icon'],
            'link_text' => $validated['link_text'],
            'link_url' => $validated['link_url'],
            'sort_order' => $validated['sort_order'] ?? (LandingService::max('sort_order') + 1),
            'is_active' => true,
        ]);

        return back()->with('success', "Layanan '{$validated['judul']}' berhasil ditambahkan ke Beranda & Halaman Layanan!");
    }

    /**
     * Update Layanan (Sinkron untuk Beranda & Halaman /layanan)
     */
    public function updateService(Request $request, $id)
    {
        $srv = LandingService::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'kategori_badge' => 'nullable|string|max:100',
            'deskripsi' => 'required|string|max:1000',
            'detail_title' => 'nullable|string|max:150',
            'detail_items' => 'nullable|string',
            'estimasi_info' => 'nullable|string|max:100',
            'biaya_info' => 'nullable|string|max:100',
            'icon' => 'required|string|max:100',
            'link_text' => 'required|string|max:100',
            'link_url' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $srv->update($validated);

        return back()->with('success', "Layanan '{$srv->judul}' berhasil diperbarui di Beranda & Halaman Layanan!");
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

    /**
     * Update Pengaturan Halaman Berita & Publikasi (/berita & /berita/{slug})
     */
    public function updateBeritaPageSettings(Request $request)
    {
        $request->validate([
            'berita_header_title' => 'required|string|max:200',
            'berita_header_subtitle' => 'required|string|max:500',
            'berita_sorotan_mode' => 'required|in:otomatis,manual',
            'berita_sorotan_id' => 'nullable|integer',
            'berita_per_page' => 'required|integer|min:3|max:24',
            'berita_kategori_list' => 'required|string|max:500',
        ]);

        $settingsToSave = [
            'berita_header_title' => $request->berita_header_title,
            'berita_header_subtitle' => $request->berita_header_subtitle,
            'berita_sorotan_aktif' => $request->has('berita_sorotan_aktif') ? '1' : '0',
            'berita_sorotan_mode' => $request->berita_sorotan_mode,
            'berita_sorotan_id' => $request->berita_sorotan_id ?? '',
            'berita_per_page' => $request->berita_per_page,
            'berita_kategori_list' => $request->berita_kategori_list,
            'berita_komentar_aktif' => $request->has('berita_komentar_aktif') ? '1' : '0',
        ];

        foreach ($settingsToSave as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Editor Halaman Berita',
            'description' => 'Memperbarui tampilan banner, sorotan, kategori, paginasi, dan komentar halaman Berita.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Pengaturan Halaman Berita & Publikasi berhasil disimpan!');
    }

    /**
     * Update Pengaturan Halaman Kontak (/kontak)
     */
    public function updateKontakPageSettings(Request $request)
    {
        $request->validate([
            'kontak_header_title' => 'required|string|max:200',
            'kontak_header_subtitle' => 'required|string|max:500',
            'office_address' => 'required|string|max:500',
            'kontak_maps_url' => 'nullable|url|max:500',
            'work_hours' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:100',
            'contact_email' => 'required|email|max:150',
            'contact_whatsapp' => 'required|string|max:50',
            'social_instagram' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
        ]);

        $keys = [
            'kontak_header_title',
            'kontak_header_subtitle',
            'office_address',
            'kontak_maps_url',
            'work_hours',
            'contact_phone',
            'contact_email',
            'contact_whatsapp',
            'social_instagram',
            'social_youtube',
        ];

        foreach ($keys as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key, '') ?? '']);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Editor Halaman Kontak',
            'description' => 'Memperbarui banner, alamat sekretariat, jam kerja, kontak, dan tautan media sosial pada halaman Kontak.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Pengaturan Halaman Kontak berhasil disimpan!');
    }

    /**
     * Update Pengaturan Banner Header & Judul Section Halaman Layanan (/layanan)
     */
    public function updateLayananHeaderSettings(Request $request)
    {
        $request->validate([
            'layanan_header_title' => 'required|string|max:200',
            'layanan_header_subtitle' => 'required|string|max:500',
            'layanan_section_badge' => 'required|string|max:100',
            'layanan_section_title' => 'required|string|max:200',
        ]);

        foreach (['layanan_header_title', 'layanan_header_subtitle', 'layanan_section_badge', 'layanan_section_title'] as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key, '') ?? '']);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Editor Halaman Layanan',
            'description' => 'Memperbarui banner header dan judul section pada halaman Layanan.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Pengaturan Banner & Judul Halaman Layanan berhasil disimpan!');
    }

    /**
     * Update Pengaturan Halaman Informasi Publik (/informasi-publik)
     */
    public function updateInformasiPublikSettings(Request $request)
    {
        $request->validate([
            'info_header_title' => 'required|string|max:200',
            'info_header_subtitle' => 'required|string|max:500',
            'info_stat_1_value' => 'required|string|max:50',
            'info_stat_1_title' => 'required|string|max:100',
            'info_stat_1_desc' => 'required|string|max:255',
            'info_stat_2_value' => 'required|string|max:50',
            'info_stat_2_title' => 'required|string|max:100',
            'info_stat_2_desc' => 'required|string|max:255',
            'info_stat_3_value' => 'required|string|max:50',
            'info_stat_3_title' => 'required|string|max:100',
            'info_stat_3_desc' => 'required|string|max:255',
            'info_per_page' => 'required|integer|min:4|max:24',
        ]);

        $keys = [
            'info_header_title', 'info_header_subtitle',
            'info_stat_1_value', 'info_stat_1_title', 'info_stat_1_desc',
            'info_stat_2_value', 'info_stat_2_title', 'info_stat_2_desc',
            'info_stat_3_value', 'info_stat_3_title', 'info_stat_3_desc',
            'info_per_page',
        ];

        foreach ($keys as $key) {
            Setting::updateOrCreate(['key' => $key], ['value' => $request->input($key, '') ?? '']);
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'Update Editor Informasi Publik',
            'description' => 'Memperbarui banner header, 3 kartu capaian, dan paginasi pada halaman Informasi Publik.',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Pengaturan Halaman Informasi Publik berhasil disimpan!');
    }

    /**
     * Geser Urutan Slide Hero Naik atau Turun
     */
    public function moveSlide(Request $request, $id)
    {
        $this->moveItemOrder(HeroSlide::class, $id, $request->input('direction'));
        return back()->with('success', 'Urutan slide hero berhasil diperbarui!');
    }

    /**
     * Geser Urutan Kartu Layanan Naik atau Turun
     */
    public function moveService(Request $request, $id)
    {
        $this->moveItemOrder(LandingService::class, $id, $request->input('direction'));
        return back()->with('success', 'Urutan kartu layanan berhasil diperbarui!');
    }

    /**
     * Helper untuk menukar sort_order item dengan tetangga atas/bawahnya
     */
    private function moveItemOrder(string $modelClass, $id, ?string $direction): void
    {
        $items = $modelClass::orderBy('sort_order')->orderBy('id')->get()->values();
        foreach ($items as $idx => $item) {
            if ($item->sort_order !== $idx + 1) {
                $item->update(['sort_order' => $idx + 1]);
            }
        }

        $currentIndex = $items->search(fn($item) => $item->id == $id);
        if ($currentIndex === false) {
            return;
        }

        $targetIndex = $direction === 'up' ? $currentIndex - 1 : $currentIndex + 1;
        if ($targetIndex >= 0 && $targetIndex < $items->count()) {
            $current = $items[$currentIndex];
            $target = $items[$targetIndex];
            $tempOrder = $current->sort_order;
            $current->update(['sort_order' => $target->sort_order]);
            $target->update(['sort_order' => $tempOrder]);
        }
    }
}
