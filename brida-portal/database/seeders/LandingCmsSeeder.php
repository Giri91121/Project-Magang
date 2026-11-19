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

            // Top Announcement Bar
            ['key' => 'topbar_enabled', 'value' => '1', 'group' => 'topbar'],
            ['key' => 'topbar_text', 'value' => 'Portal Resmi Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar', 'group' => 'topbar'],
            ['key' => 'topbar_bg_color', 'value' => '#3D000E', 'group' => 'topbar'],
            ['key' => 'topbar_text_color', 'value' => '#F5F4EE', 'group' => 'topbar'],

            // Halaman Pemerintahan (Profil, Foto Kantor, Visi, & Misi)
            ['key' => 'gov_office_photo', 'value' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80', 'group' => 'pemerintahan'],
            ['key' => 'gov_office_caption', 'value' => 'Sekretariat BRIDA Kota Makassar', 'group' => 'pemerintahan'],
            ['key' => 'gov_profile_title', 'value' => 'Badan Riset dan Inovasi Daerah (BRIDA)', 'group' => 'pemerintahan'],
            ['key' => 'gov_profile_p1', 'value' => 'Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar merupakan unsur penunjang urusan pemerintahan di bidang penelitian dan pengembangan yang menjadi kewenangan daerah. BRIDA dibentuk untuk mengintegrasikan seluruh ekosistem riset terapan dan inovasi demi memperkuat pengambilan kebijakan berbasis data dan bukti ilmiah (evidence-based policy).', 'group' => 'pemerintahan'],
            ['key' => 'gov_profile_p2', 'value' => 'Sesuai dengan amanat peraturan perundang-undangan dan koordinasi bersama Badan Riset dan Inovasi Nasional (BRIN), BRIDA Kota Makassar berfungsi sebagai jembatan strategis antara akademisi, industri, masyarakat, dan pemerintah (Pentahelix) guna mempercepat terwujudnya Makassar sebagai Kota Dunia yang Maju, Tangguh, dan Rendah Karbon.', 'group' => 'pemerintahan'],
            ['key' => 'gov_visi', 'value' => '"Menjadi Pusat Rujukan Riset dan Inovasi yang Adaptif Menuju Makassar Kota Dunia yang Berdaya Saing."', 'group' => 'pemerintahan'],
            ['key' => 'gov_misi_1', 'value' => 'Meningkatkan Kualitas Riset Kebijakan: Menyusun kajian ilmiah tematik strategis untuk mendukung respon kebijakan Wali Kota terhadap tantangan perkotaan terkini.', 'group' => 'pemerintahan'],
            ['key' => 'gov_misi_2', 'value' => 'Mengakselerasi Ekosistem Inovasi SKPD: Mendorong dan mendampingi karya inovasi pelayanan publik dan tata kelola di lingkungan perangkat daerah Kota Makassar.', 'group' => 'pemerintahan'],
            ['key' => 'gov_misi_3', 'value' => 'Memperkuat Kemitraan Pentahelix: Membangun kolaborasi riset terapan bersama perguruan tinggi (Unhas, UNM, dll.), industri, dan lembaga riset nasional (BRIN).', 'group' => 'pemerintahan'],
            ['key' => 'gov_misi_4', 'value' => 'Mendorong Difusi & Hilirisasi Inovasi: Memastikan hasil riset terapan dapat diaplikasikan langsung untuk meningkatkan mutu taraf hidup warga kota.', 'group' => 'pemerintahan'],

            // Tautan Pintasan Beranda & Peta Google Maps
            ['key' => 'quicklink_1_label', 'value' => 'Portal Resmi Pemerintah Kota Makassar', 'group' => 'links'],
            ['key' => 'quicklink_1_url', 'value' => 'https://makassarkota.go.id', 'group' => 'links'],
            ['key' => 'quicklink_2_label', 'value' => 'Badan Riset dan Inovasi Nasional (BRIN)', 'group' => 'links'],
            ['key' => 'quicklink_2_url', 'value' => 'https://brin.go.id', 'group' => 'links'],
            ['key' => 'quicklink_3_label', 'value' => 'Pedoman Pengusulan Inovasi Daerah', 'group' => 'links'],
            ['key' => 'quicklink_3_url', 'value' => '/informasi-publik#regulasi', 'group' => 'links'],
            ['key' => 'google_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.8118318855523!2d119.4069811756598!3d-5.133932794843075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbf02939e60be1b%3A0xe54e5658fe969418!2sKantor%20Walikota%20Makassar!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid', 'group' => 'links'],

            // 3 Postingan Terbaru Instagram BRIDA Kota Makassar
            ['key' => 'ig_username', 'value' => '@brida.makassarkota', 'group' => 'instagram'],
            ['key' => 'ig_profile_url', 'value' => 'https://www.instagram.com/brida.makassarkota/', 'group' => 'instagram'],
            ['key' => 'ig_post_1_image', 'value' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=600&q=80', 'group' => 'instagram'],
            ['key' => 'ig_post_1_caption', 'value' => 'Rapat Koordinasi Penyusunan Peta Jalan Riset & Inovasi Daerah Kota Makassar bersama BRIN RI dan Perguruan Tinggi. #BRIDAMakassar #MakassarKotaDunia', 'group' => 'instagram'],
            ['key' => 'ig_post_1_url', 'value' => 'https://www.instagram.com/brida.makassarkota/', 'group' => 'instagram'],
            ['key' => 'ig_post_1_date', 'value' => '2 hari yang lalu', 'group' => 'instagram'],

            ['key' => 'ig_post_2_image', 'value' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=600&q=80', 'group' => 'instagram'],
            ['key' => 'ig_post_2_caption', 'value' => 'Bimbingan Teknis Penginputan Indeks Inovasi Daerah (IID) bagi seluruh Operator SKPD lingkup Pemerintah Kota Makassar menuju IGA 2026.', 'group' => 'instagram'],
            ['key' => 'ig_post_2_url', 'value' => 'https://www.instagram.com/brida.makassarkota/', 'group' => 'instagram'],
            ['key' => 'ig_post_2_date', 'value' => '5 hari yang lalu', 'group' => 'instagram'],

            ['key' => 'ig_post_3_image', 'value' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=600&q=80', 'group' => 'instagram'],
            ['key' => 'ig_post_3_caption', 'value' => 'Klinik Fasilitasi HKI & Paten Sederhana bagi Inovator Muda, UMKM, dan ASN Kota Makassar. Daftarkan karya inovasi Anda secara gratis!', 'group' => 'instagram'],
            ['key' => 'ig_post_3_url', 'value' => 'https://www.instagram.com/brida.makassarkota/', 'group' => 'instagram'],
            ['key' => 'ig_post_3_date', 'value' => '1 minggu yang lalu', 'group' => 'instagram'],
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
