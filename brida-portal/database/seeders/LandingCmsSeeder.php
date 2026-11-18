<?php

namespace Database\Seeders;

use App\Models\NavbarMenu;
use App\Models\HeroSlide;
use App\Models\LandingService;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class LandingCmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Default Settings untuk Hero & Logo
        $heroSettings = [
            ['key' => 'logo_header', 'value' => 'images/LOGO-FIX-BRIDA.png', 'group' => 'appearance'],
            ['key' => 'logo_footer', 'value' => 'images/logo-brida-white.png', 'group' => 'appearance'],
            ['key' => 'hero_title_1', 'value' => 'Mendorong Inovasi Berbasis Riset, Mewujudkan', 'group' => 'hero'],
            ['key' => 'hero_title_highlight', 'value' => 'Makassar Kota Dunia', 'group' => 'hero'],
            ['key' => 'hero_title_2', 'value' => 'yang Berdaya Saing.', 'group' => 'hero'],
            ['key' => 'hero_subtitle', 'value' => 'Selamat datang di Portal Resmi Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar. Kami mengoordinasikan ekosistem riset terapan, pendampingan inovasi perangkat daerah, serta perumusan rekomendasi kebijakan pembangunan daerah berbasis data dan bukti ilmiah.', 'group' => 'hero'],
            ['key' => 'hero_btn1_text', 'value' => 'Layanan & Fasilitasi Riset', 'group' => 'hero'],
            ['key' => 'hero_btn1_url', 'value' => '/layanan', 'group' => 'hero'],
            ['key' => 'hero_btn2_text', 'value' => 'Ekosistem Inovasi Daerah', 'group' => 'hero'],
            ['key' => 'hero_btn2_url', 'value' => '/informasi-publik', 'group' => 'hero'],
            ['key' => 'layanan_section_badge', 'value' => 'Layanan Publik & Kedinasan', 'group' => 'hero'],
            ['key' => 'layanan_section_title', 'value' => 'Layanan Terpadu BRIDA Kota Makassar', 'group' => 'hero'],
            ['key' => 'layanan_section_desc', 'value' => 'Akses layanan pengusulan riset kebijakan, fasilitasi inovasi daerah, serta kemitraan ilmiah.', 'group' => 'hero'],
        ];

        foreach ($heroSettings as $set) {
            Setting::updateOrCreate(['key' => $set['key']], $set);
        }

        // 2. Seed Default Hero Slideshow Images
        if (HeroSlide::count() === 0) {
            HeroSlide::create([
                'judul_alt' => 'Dokumentasi Kegiatan BRIDA Makassar 1',
                'gambar_path' => 'images/slide1.jpg',
                'sort_order' => 1,
                'is_active' => true,
            ]);
            HeroSlide::create([
                'judul_alt' => 'Dokumentasi Kegiatan BRIDA Makassar 2',
                'gambar_path' => 'images/slide2.jpg',
                'sort_order' => 2,
                'is_active' => true,
            ]);
        }

        // 3. Seed Default Navbar Menus & Dropdown Submenus
        if (NavbarMenu::count() === 0) {
            NavbarMenu::create(['label' => 'Beranda', 'url' => '/', 'sort_order' => 1, 'is_active' => true]);

            $pemerintahan = NavbarMenu::create(['label' => 'Pemerintahan', 'url' => '/pemerintahan', 'sort_order' => 2, 'is_active' => true]);
            NavbarMenu::create(['parent_id' => $pemerintahan->id, 'label' => 'Profil BRIDA Makassar', 'url' => '/pemerintahan#profil', 'icon' => 'fa-solid fa-landmark', 'sort_order' => 1, 'is_active' => true]);
            NavbarMenu::create(['parent_id' => $pemerintahan->id, 'label' => 'Visi & Misi Inovasi', 'url' => '/pemerintahan#visi-misi', 'icon' => 'fa-solid fa-bullseye', 'sort_order' => 2, 'is_active' => true]);
            NavbarMenu::create(['parent_id' => $pemerintahan->id, 'label' => 'Tugas Pokok & Fungsi', 'url' => '/pemerintahan#tupoksi', 'icon' => 'fa-solid fa-list-check', 'sort_order' => 3, 'is_active' => true]);

            NavbarMenu::create(['label' => 'Layanan', 'url' => '/layanan', 'sort_order' => 3, 'is_active' => true]);
            NavbarMenu::create(['label' => 'Informasi Publik', 'url' => '/informasi-publik', 'sort_order' => 4, 'is_active' => true]);
            NavbarMenu::create(['label' => 'Berita', 'url' => '/berita', 'sort_order' => 5, 'is_active' => true]);
            NavbarMenu::create(['label' => 'Kontak', 'url' => '/kontak', 'sort_order' => 6, 'is_active' => true]);

            $ppid = NavbarMenu::create(['label' => 'PPID', 'url' => '#', 'sort_order' => 7, 'is_active' => true]);
            NavbarMenu::create(['parent_id' => $ppid->id, 'label' => 'PPID Makassar', 'url' => 'https://ppid.makassarkota.go.id/', 'target_blank' => true, 'sort_order' => 1, 'is_active' => true]);
            NavbarMenu::create(['parent_id' => $ppid->id, 'label' => 'Informasi Publik', 'url' => 'https://ppid.makassarkota.go.id/daftar-informasi-publik', 'target_blank' => true, 'sort_order' => 2, 'is_active' => true]);
            NavbarMenu::create(['parent_id' => $ppid->id, 'label' => 'Permohonan Informasi Publik', 'url' => 'https://ppid.makassarkota.go.id/permohonan-informasi', 'target_blank' => true, 'sort_order' => 3, 'is_active' => true]);
            NavbarMenu::create(['parent_id' => $ppid->id, 'label' => 'Permohonan Keberatan', 'url' => 'https://ppid.makassarkota.go.id/pengajuan-keberatan', 'target_blank' => true, 'sort_order' => 4, 'is_active' => true]);
        }

        // 4. Seed Default 4 Kartu Layanan di Beranda
        if (LandingService::count() === 0) {
            $services = [
                [
                    'judul' => 'Riset & Pengkajian Kebijakan',
                    'deskripsi' => 'Pelaksanaan riset ilmiah terapan dan penyusunan rekomendasi kebijakan pembangunan daerah berbasis bukti (evidence-based policy).',
                    'icon' => 'fa-solid fa-microscope',
                    'link_text' => 'Informasi Riset',
                    'link_url' => '/layanan',
                    'sort_order' => 1,
                ],
                [
                    'judul' => 'Fasilitasi Inovasi Daerah',
                    'deskripsi' => 'Pendampingan dan pemetaan inovasi perangkat daerah (OPD) untuk pengukuran Indeks Inovasi Daerah (IID) tahunan Kemendagri.',
                    'icon' => 'fa-solid fa-lightbulb',
                    'link_text' => 'Katalog Inovasi',
                    'link_url' => '/layanan',
                    'sort_order' => 2,
                ],
                [
                    'judul' => 'Peta Jalan Riset Daerah',
                    'deskripsi' => 'Penyusunan Rencana Induk Riset Daerah (RIRD) sebagai pedoman arah pembangunan sains dan teknologi jangka panjang kota.',
                    'icon' => 'fa-solid fa-book-atlas',
                    'link_text' => 'Dokumen RIRD',
                    'link_url' => '/layanan',
                    'sort_order' => 3,
                ],
                [
                    'judul' => 'Kemitraan Akademisi & BRIN',
                    'deskripsi' => 'Sinergi riset bersama Badan Riset dan Inovasi Nasional (BRIN), perguruan tinggi, dan peneliti untuk akselerasi solusi daerah.',
                    'icon' => 'fa-solid fa-handshake-angle',
                    'link_text' => 'Kerja Sama Riset',
                    'link_url' => '/layanan',
                    'sort_order' => 4,
                ],
            ];

            foreach ($services as $srv) {
                LandingService::create($srv);
            }
        }
    }
}
