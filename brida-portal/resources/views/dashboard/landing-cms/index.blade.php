<x-app-layout>
    <div class="space-y-6" x-data="{ activeTab: localStorage.getItem('landingCmsActiveTab') || 'beranda' }" x-init="$watch('activeTab', val => localStorage.setItem('landingCmsActiveTab', val))">

        <!-- Top Header & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <span class="text-slate-800 font-bold">Editor Landing Page</span>
                </nav>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    Kustomisasi Landing Page & Navbar
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Ubah menu navbar, unggah gambar background slideshow, ganti logo, dan edit kartu layanan langsung dari sini.
                </p>
            </div>

            <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 bg-white border border-bone-300 hover:border-maroon-700 text-slate-700 font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-sm">
                <i class="fa-solid fa-eye text-maroon-700"></i>
                <span>Lihat Hasil di Landing Page</span>
            </a>
        </div>

        <!-- Navigasi Tab Editor (Berbasis Menu Landing Page) -->
        <div class="flex flex-wrap gap-2 bg-white p-2 rounded-2xl border border-bone-300 shadow-sm">
            <button type="button" @click="activeTab = 'global'" :class="activeTab === 'global' ? 'bg-maroon-700 text-white shadow' : 'text-slate-600 hover:bg-bone-100'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition">
                <i class="fa-solid fa-bars"></i>
                <span>1. Navbar & Global</span>
            </button>
            <button type="button" @click="activeTab = 'beranda'" :class="activeTab === 'beranda' ? 'bg-maroon-700 text-white shadow' : 'text-slate-600 hover:bg-bone-100'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition">
                <i class="fa-solid fa-house"></i>
                <span>2. Beranda</span>
            </button>
            <button type="button" @click="activeTab = 'pemerintahan'" :class="activeTab === 'pemerintahan' ? 'bg-maroon-700 text-white shadow' : 'text-slate-600 hover:bg-bone-100'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition">
                <i class="fa-solid fa-landmark"></i>
                <span>3. Pemerintahan</span>
            </button>
            <button type="button" @click="activeTab = 'layanan'" :class="activeTab === 'layanan' ? 'bg-maroon-700 text-white shadow' : 'text-slate-600 hover:bg-bone-100'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition">
                <i class="fa-solid fa-table-cells-large"></i>
                <span>4. Layanan</span>
            </button>
            <button type="button" @click="activeTab = 'berita'" :class="activeTab === 'berita' ? 'bg-maroon-700 text-white shadow' : 'text-slate-600 hover:bg-bone-100'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition">
                <i class="fa-regular fa-newspaper"></i>
                <span>5. Berita</span>
            </button>
            <button type="button" @click="activeTab = 'kontak'" :class="activeTab === 'kontak' ? 'bg-maroon-700 text-white shadow' : 'text-slate-600 hover:bg-bone-100'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition">
                <i class="fa-solid fa-address-book"></i>
                <span>6. Kontak</span>
            </button>
            <button type="button" @click="activeTab = 'informasi-publik'" :class="activeTab === 'informasi-publik' ? 'bg-maroon-700 text-white shadow' : 'text-slate-600 hover:bg-bone-100'" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold transition">
                <i class="fa-solid fa-book-open"></i>
                <span>7. Informasi Publik</span>
            </button>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 1: HERO BANNER, GAMBAR SLIDESHOW, & LOGO                   -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'beranda'" class="space-y-8">

            <!-- A. Gambar Background Slideshow Beranda -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-bone-200 pb-4">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Visual Latar Belakang</span>
                        <h3 class="text-lg font-black text-slate-900">Gambar Background Slideshow Beranda</h3>
                        <p class="text-xs text-slate-500">Unggah foto baru atau ganti gambar background utama di halaman depan.</p>
                    </div>
                </div>

                <!-- Daftar Gambar Slide Aktif -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($slides as $slide)
                    <div class="rounded-2xl border border-bone-300 overflow-hidden bg-bone-50 flex flex-col justify-between shadow-sm">
                        <div class="relative h-44 bg-slate-900">
                            <img src="{{ $slide->gambar_url }}" alt="{{ $slide->judul_alt }}" class="w-full h-full object-cover">
                            <span class="absolute top-3 left-3 bg-maroon-700 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow">
                                Slide #{{ $slide->sort_order }}
                            </span>
                        </div>
                        <div class="p-4 space-y-3">
                            <form method="POST" action="{{ route('dashboard.landing-cms.slides.update', $slide->id) }}" enctype="multipart/form-data" class="space-y-2.5">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase">Keterangan Gambar</label>
                                    <input type="text" name="judul_alt" value="{{ $slide->judul_alt }}" class="w-full text-xs rounded-xl border border-bone-300 py-1.5 px-2.5 bg-white mt-0.5">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase">Ganti File FotoIni</label>
                                    <input type="file" name="gambar_slide" accept="image/*" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-slate-700 file:text-white mt-0.5">
                                </div>
                                <div class="flex items-center justify-between pt-1">
                                    <button type="submit" class="bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-[11px] px-3.5 py-1.5 rounded-xl transition">
                                        Simpan Perubahan Slide
                                    </button>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('dashboard.landing-cms.slides.destroy', $slide->id) }}" data-confirm="Hapus gambar slide ini dari beranda?" data-confirm-title="Hapus Gambar Slide" data-confirm-btn="Ya, Hapus" class="border-t border-bone-200 pt-2 text-right">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-[11px] font-bold text-rose-600 hover:underline">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Hapus Slide Ini
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach

                    <!-- Kartu Tambah Gambar Slide Baru -->
                    <form method="POST" action="{{ route('dashboard.landing-cms.slides.store') }}" enctype="multipart/form-data" class="rounded-2xl border-2 border-dashed border-bone-300 bg-bone-50/50 p-6 flex flex-col justify-center space-y-4">
                        @csrf
                        <div class="text-center space-y-1">
                            <div class="w-10 h-10 rounded-xl bg-rose-100 text-maroon-700 flex items-center justify-center mx-auto text-base">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <h4 class="font-bold text-xs text-slate-900">Tambah Slide Gambar Baru</h4>
                            <p class="text-[11px] text-slate-400">Format JPG/PNG/WEBP (Maks 10MB)</p>
                        </div>
                        <div class="space-y-2">
                            <input type="text" name="judul_alt" placeholder="Nama/Keterangan Foto..." class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 bg-white">
                            <input type="file" name="gambar_slide" required accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-maroon-700 file:text-white">
                        </div>
                        <button type="submit" class="w-full bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs py-2.5 rounded-xl transition shadow">
                            + Unggah Gambar Slide
                        </button>
                    </form>
                </div>
            </div>

            <!-- B. Form Edit Logo, Teks Headline Hero, & Tombol Beranda -->
            <form method="POST" action="{{ route('dashboard.landing-cms.update-hero') }}" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-8">
                @csrf

                <!-- Bagian Ganti Logo Header & Footer -->
                <div class="space-y-4">
                    <div class="border-b border-bone-200 pb-2">
                        <h3 class="text-base font-black text-slate-900">Logo Website (Header & Footer)</h3>
                        <p class="text-xs text-slate-500">Pilih file gambar baru dari komputer Anda jika ingin mengganti logo.</p>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div class="p-4 rounded-2xl bg-bone-50 border border-bone-300 space-y-3">
                            <span class="text-xs font-bold text-slate-800 block">Logo Header Utama (Atas)</span>
                            <div class="h-16 bg-white rounded-xl border border-bone-200 flex items-center justify-center p-2">
                                <img src="{{ asset($settings['logo_header'] ?? 'images/LOGO-FIX-BRIDA.png') }}" alt="Logo Header" class="max-h-12 w-auto object-contain">
                            </div>
                            <input type="file" name="logo_header_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-maroon-700 file:text-white">
                        </div>

                        <div class="p-4 rounded-2xl bg-bone-50 border border-bone-300 space-y-3">
                            <span class="text-xs font-bold text-slate-800 block">Logo Footer (Bawah - Versi Putih)</span>
                            <div class="h-16 bg-maroon-950 rounded-xl border border-maroon-800 flex items-center justify-center p-2">
                                <img src="{{ asset($settings['logo_footer'] ?? 'images/logo-brida-white.png') }}" alt="Logo Footer" class="max-h-12 w-auto object-contain">
                            </div>
                            <input type="file" name="logo_footer_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-maroon-700 file:text-white">
                        </div>
                    </div>
                </div>

                <!-- Bagian Teks Headline & Tombol Hero (Dilengkapi Color Picker Visual) -->
                <div class="space-y-4">
                    <div class="border-b border-bone-200 pb-2">
                        <h3 class="text-base font-black text-slate-900">Teks Judul Besar, Warna Teks & Tombol Hero Beranda</h3>
                        <p class="text-xs text-slate-500">Klik kotak warna di samping teks untuk memilih warna sesuka Anda secara visual tanpa kode.</p>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-4">
                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-slate-700">Judul Baris Awal</label>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] text-slate-400">Warna:</span>
                                    <input type="color" name="hero_title_1_color" value="{{ $settings['hero_title_1_color'] ?? '#FDFDFB' }}" class="w-6 h-6 rounded cursor-pointer border border-bone-300 p-0.5 bg-white" title="Pilih Warna Teks Baris Awal">
                                </div>
                            </div>
                            <input type="text" name="hero_title_1" value="{{ $settings['hero_title_1'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3">
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-rose-600">Teks Sorotan (Highlight)</label>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] text-slate-400">Warna:</span>
                                    <input type="color" name="hero_title_highlight_color" value="{{ $settings['hero_title_highlight_color'] ?? '#FB7185' }}" class="w-6 h-6 rounded cursor-pointer border border-rose-300 p-0.5 bg-white" title="Pilih Warna Teks Sorotan">
                                </div>
                            </div>
                            <input type="text" name="hero_title_highlight" value="{{ $settings['hero_title_highlight'] ?? '' }}" class="w-full text-xs rounded-xl border border-rose-300 py-2.5 px-3 font-bold">
                        </div>

                        <div class="space-y-1.5">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-slate-700">Judul Baris Akhir</label>
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] text-slate-400">Warna:</span>
                                    <input type="color" name="hero_title_2_color" value="{{ $settings['hero_title_2_color'] ?? '#FDFDFB' }}" class="w-6 h-6 rounded cursor-pointer border border-bone-300 p-0.5 bg-white" title="Pilih Warna Teks Baris Akhir">
                                </div>
                            </div>
                            <input type="text" name="hero_title_2" value="{{ $settings['hero_title_2'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex items-center justify-between">
                            <label class="block text-xs font-bold text-slate-700">Paragraf Sambutan Hero</label>
                            <div class="flex items-center gap-1.5">
                                <span class="text-[10px] text-slate-400">Warna Teks Paragraf:</span>
                                <input type="color" name="hero_subtitle_color" value="{{ $settings['hero_subtitle_color'] ?? '#FAF9F5' }}" class="w-6 h-6 rounded cursor-pointer border border-bone-300 p-0.5 bg-white" title="Pilih Warna Paragraf Sambutan">
                            </div>
                        </div>
                        <textarea name="hero_subtitle" rows="3" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4 pt-2">
                        <div class="p-4 rounded-2xl bg-bone-50 border border-bone-300 space-y-2.5">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-extrabold text-maroon-700 block">Tombol Utama Kiri</span>
                                <div class="flex items-center gap-2">
                                    <label class="text-[10px] text-slate-500 flex items-center gap-1">
                                        <span>Warna Tombol:</span>
                                        <input type="color" name="hero_btn1_bg_color" value="{{ $settings['hero_btn1_bg_color'] ?? '#BE123C' }}" class="w-5 h-5 rounded cursor-pointer border border-bone-300 p-0 bg-white">
                                    </label>
                                    <label class="text-[10px] text-slate-500 flex items-center gap-1">
                                        <span>Teks:</span>
                                        <input type="color" name="hero_btn1_text_color" value="{{ $settings['hero_btn1_text_color'] ?? '#FFFFFF' }}" class="w-5 h-5 rounded cursor-pointer border border-bone-300 p-0 bg-white">
                                    </label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Teks Tombol 1</label>
                                <input type="text" name="hero_btn1_text" value="{{ $settings['hero_btn1_text'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 bg-white mt-0.5">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Link Tujuan Tombol 1</label>
                                <input type="text" name="hero_btn1_url" value="{{ $settings['hero_btn1_url'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 bg-white mt-0.5">
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-bone-50 border border-bone-300 space-y-2.5">
                            <span class="text-xs font-extrabold text-slate-700 block">Tombol Kedua Kanan (Transparan)</span>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Teks Tombol 2</label>
                                <input type="text" name="hero_btn2_text" value="{{ $settings['hero_btn2_text'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 bg-white mt-0.5">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Link Tujuan Tombol 2</label>
                                <input type="text" name="hero_btn2_url" value="{{ $settings['hero_btn2_url'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 bg-white mt-0.5">
                            </div>
                        </div>
                    </div>

                    <!-- Durasi Perpindahan Gambar Slideshow -->
                    <div class="p-4 rounded-2xl bg-bone-50 border border-bone-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-800">Durasi Perpindahan Gambar Slideshow</label>
                            <p class="text-[11px] text-slate-500">Atur berapa detik sekali gambar background hero berganti otomatis.</p>
                        </div>
                        <select name="hero_slide_interval" class="rounded-xl border border-bone-300 text-xs font-bold px-3 py-2 bg-white focus:ring-maroon-700 focus:border-maroon-700">
                            @foreach([2, 3, 4, 5, 7, 10, 15] as $sec)
                                <option value="{{ $sec }}" {{ (int)($settings['hero_slide_interval'] ?? 5) === $sec ? 'selected' : '' }}>{{ $sec }} Detik</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-bone-200 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Teks Hero & Logo</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 2: MANAJEMEN MENU NAVBAR & SUBMENU DROPDOWN                -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'global'" class="grid lg:grid-cols-12 gap-6 items-start">

            <!-- Kolom Kiri: Form Tambah Menu / Submenu Baru -->
            <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-bone-300 shadow-sm space-y-5">
                <div class="border-b border-bone-200 pb-3">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Tambah Navigasi</span>
                    <h3 class="text-base font-black text-slate-900 mt-0.5">Buat Menu Navbar / Submenu Baru</h3>
                </div>

                <form method="POST" action="{{ route('dashboard.landing-cms.menus.store') }}" class="space-y-4">
                    @csrf
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Posisi Menu</label>
                        <select name="parent_id" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3 bg-white">
                            <option value="">-- Menu Utama (Tampil di Baris Atas) --</option>
                            @foreach($menus as $m)
                                <option value="{{ $m->id }}">Submenu Dropdown di bawah: {{ $m->label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Nama / Label Menu <span class="text-rose-500">*</span></label>
                        <input type="text" name="label" required placeholder="Contoh: Jurnal Ilmiah / Struktur Organisasi" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3">
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Alamat Link Tujuan (URL) <span class="text-rose-500">*</span></label>
                        <input type="text" name="url" required placeholder="Contoh: /layanan atau https://..." class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3">
                    </div>

                    <div class="space-y-1.5" x-data="{ iconVal: '' }">
                        <label class="block text-xs font-bold text-slate-700">Ikon Menu / Submenu (Opsional)</label>
                        <div class="flex items-center gap-2">
                            <div class="w-9 h-9 rounded-xl bg-bone-100 border border-bone-300 flex items-center justify-center text-maroon-700 shrink-0">
                                <i :class="iconVal || 'fa-solid fa-circle-dot'" class="text-sm"></i>
                            </div>
                            <input type="text" name="icon" x-model="iconVal" placeholder="fa-solid fa-sitemap" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3">
                        </div>
                        <div class="flex flex-wrap gap-1.5 pt-1">
                            @foreach(['fa-solid fa-sitemap', 'fa-solid fa-landmark', 'fa-solid fa-flask', 'fa-solid fa-file-lines', 'fa-solid fa-users', 'fa-solid fa-bullhorn', 'fa-solid fa-envelope', 'fa-solid fa-book-open'] as $ic)
                                <button type="button" @click="iconVal = '{{ $ic }}'" class="w-7 h-7 rounded-lg border border-bone-300 bg-white hover:border-maroon-700 hover:text-maroon-700 text-slate-600 flex items-center justify-center text-xs transition" title="{{ $ic }}">
                                    <i class="{{ $ic }}"></i>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <label class="flex items-center gap-2 cursor-pointer pt-1">
                        <input type="checkbox" name="target_blank" value="1" class="rounded text-maroon-700 focus:ring-maroon-700 border-slate-300">
                        <span class="text-xs text-slate-600 font-medium">Buka link di tab browser baru</span>
                    </label>

                    <button type="submit" class="w-full bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs py-3 rounded-xl transition shadow">
                        + Tambahkan ke Navbar
                    </button>
                </form>
            </div>

            <!-- Kolom Kanan: Daftar Menu & Submenu Saat Ini -->
            <div class="lg:col-span-8 bg-white rounded-3xl p-6 border border-bone-300 shadow-sm space-y-4">
                <div class="border-b border-bone-200 pb-3 flex items-center justify-between">
                    <div>
                        <h3 class="text-base font-black text-slate-900">Susunan Menu Navbar Saat Ini</h3>
                        <p class="text-xs text-slate-500">Anda dapat langsung mengubah nama menu, link URL, urutan, atau menghapusnya.</p>
                    </div>
                </div>

                <div class="space-y-4">
                    @foreach($menus as $menu)
                    <div class="p-4 rounded-2xl border border-bone-300 bg-bone-50/60 space-y-3">
                        <!-- Baris Edit Menu Utama -->
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <!-- Tombol Naik / Turun Menu Utama -->
                            <div class="flex items-center gap-1 shrink-0">
                                <form method="POST" action="{{ route('dashboard.landing-cms.menus.move', $menu->id) }}">
                                    @csrf
                                    <input type="hidden" name="direction" value="up">
                                    <button type="submit" {{ $loop->first ? 'disabled' : '' }} class="w-7 h-7 rounded-lg border border-bone-300 bg-white text-slate-600 hover:border-maroon-700 hover:text-maroon-700 disabled:opacity-30 disabled:cursor-not-allowed flex items-center justify-center text-[10px] transition" title="Naikkan Urutan">
                                        <i class="fa-solid fa-chevron-up"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('dashboard.landing-cms.menus.move', $menu->id) }}">
                                    @csrf
                                    <input type="hidden" name="direction" value="down">
                                    <button type="submit" {{ $loop->last ? 'disabled' : '' }} class="w-7 h-7 rounded-lg border border-bone-300 bg-white text-slate-600 hover:border-maroon-700 hover:text-maroon-700 disabled:opacity-30 disabled:cursor-not-allowed flex items-center justify-center text-[10px] transition" title="Turunkan Urutan">
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                </form>
                            </div>

                            <form method="POST" action="{{ route('dashboard.landing-cms.menus.update', $menu->id) }}" class="flex-1 grid sm:grid-cols-12 gap-2 items-center" x-data="{ iconVal: '{{ $menu->icon }}' }">
                                @csrf
                                @method('PATCH')
                                <div class="sm:col-span-3 flex items-center gap-1.5">
                                    <div class="w-7 h-7 rounded-lg bg-white border border-bone-300 flex items-center justify-center text-maroon-700 shrink-0 text-xs">
                                        <i :class="iconVal || 'fa-solid fa-circle-dot'"></i>
                                    </div>
                                    <input type="text" name="icon" x-model="iconVal" placeholder="fa-solid fa-..." title="Class Ikon FontAwesome" class="w-full text-[11px] rounded-xl border border-bone-300 py-1.5 px-2 bg-white">
                                </div>
                                <div class="sm:col-span-3">
                                    <input type="text" name="label" value="{{ $menu->label }}" required class="w-full text-xs font-extrabold text-slate-900 rounded-xl border border-bone-300 py-1.5 px-3 bg-white">
                                </div>
                                <div class="sm:col-span-3">
                                    <input type="text" name="url" value="{{ $menu->url }}" required class="w-full text-xs text-slate-600 rounded-xl border border-bone-300 py-1.5 px-3 bg-white">
                                </div>
                                <div class="sm:col-span-1 flex items-center justify-center">
                                    <input type="hidden" name="is_active" value="0">
                                    <input type="checkbox" name="is_active" value="1" {{ $menu->is_active ? 'checked' : '' }} title="Aktif / Tampilkan di Navbar" class="rounded text-maroon-700 focus:ring-maroon-700 border-slate-300">
                                </div>
                                <div class="sm:col-span-2 flex justify-end">
                                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold text-[11px] px-3 py-1.5 rounded-xl transition">
                                        Simpan
                                    </button>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('dashboard.landing-cms.menus.destroy', $menu->id) }}" data-confirm="Hapus menu '{{ $menu->label }}' beserta submenunya?" data-confirm-title="Hapus Menu Navbar" data-confirm-btn="Ya, Hapus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg transition" title="Hapus Menu">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                        </div>

                        <!-- Daftar Submenu Dropdown jika ada -->
                        @if($menu->children->count() > 0)
                        <div class="pl-6 border-l-2 border-rose-300 space-y-2 pt-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider text-maroon-700 block">Submenu Dropdown ({{ $menu->label }}):</span>
                            @foreach($menu->children->sortBy('sort_order') as $child)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-white p-2.5 rounded-xl border border-bone-200">
                                <!-- Tombol Naik / Turun Submenu -->
                                <div class="flex items-center gap-1 shrink-0">
                                    <form method="POST" action="{{ route('dashboard.landing-cms.menus.move', $child->id) }}">
                                        @csrf
                                        <input type="hidden" name="direction" value="up">
                                        <button type="submit" {{ $loop->first ? 'disabled' : '' }} class="w-6 h-6 rounded-md border border-bone-300 bg-bone-50 text-slate-600 hover:border-maroon-700 hover:text-maroon-700 disabled:opacity-30 disabled:cursor-not-allowed flex items-center justify-center text-[9px] transition" title="Naikkan Submenu">
                                            <i class="fa-solid fa-chevron-up"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.landing-cms.menus.move', $child->id) }}">
                                        @csrf
                                        <input type="hidden" name="direction" value="down">
                                        <button type="submit" {{ $loop->last ? 'disabled' : '' }} class="w-6 h-6 rounded-md border border-bone-300 bg-bone-50 text-slate-600 hover:border-maroon-700 hover:text-maroon-700 disabled:opacity-30 disabled:cursor-not-allowed flex items-center justify-center text-[9px] transition" title="Turunkan Submenu">
                                            <i class="fa-solid fa-chevron-down"></i>
                                        </button>
                                    </form>
                                </div>

                                <form method="POST" action="{{ route('dashboard.landing-cms.menus.update', $child->id) }}" class="flex-1 grid sm:grid-cols-12 gap-2 items-center" x-data="{ iconVal: '{{ $child->icon }}' }">
                                    @csrf
                                    @method('PATCH')
                                    <div class="sm:col-span-3 flex items-center gap-1.5">
                                        <div class="w-6 h-6 rounded-md bg-bone-50 border border-bone-300 flex items-center justify-center text-maroon-700 shrink-0 text-[11px]">
                                            <i :class="iconVal || 'fa-solid fa-circle-dot'"></i>
                                        </div>
                                        <input type="text" name="icon" x-model="iconVal" placeholder="fa-solid fa-..." title="Class Ikon FontAwesome" class="w-full text-[11px] rounded-lg border border-bone-300 py-1 px-2">
                                    </div>
                                    <div class="sm:col-span-3">
                                        <input type="text" name="label" value="{{ $child->label }}" required class="w-full text-[11px] font-bold text-slate-800 rounded-lg border border-bone-300 py-1 px-2.5">
                                    </div>
                                    <div class="sm:col-span-3">
                                        <input type="text" name="url" value="{{ $child->url }}" required class="w-full text-[11px] text-slate-500 rounded-lg border border-bone-300 py-1 px-2.5">
                                    </div>
                                    <div class="sm:col-span-1 flex items-center justify-center">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" value="1" {{ $child->is_active ? 'checked' : '' }} title="Aktif / Tampilkan" class="rounded text-maroon-700 focus:ring-maroon-700 border-slate-300">
                                    </div>
                                    <div class="sm:col-span-2 flex justify-end">
                                        <button type="submit" class="bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-[10px] px-2.5 py-1 rounded-lg transition">
                                            Update
                                        </button>
                                    </div>
                                </form>
                                <form method="POST" action="{{ route('dashboard.landing-cms.menus.destroy', $child->id) }}" data-confirm="Hapus submenu '{{ $child->label }}'?" data-confirm-title="Hapus Submenu" data-confirm-btn="Ya, Hapus">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-slate-400 hover:text-rose-600">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Pengaturan Teks Footer Global -->
            <form method="POST" action="{{ route('dashboard.landing-cms.update-hero') }}" class="lg:col-span-12 bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-5">
                @csrf
                <div class="border-b border-bone-200 pb-3">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Tampilan Global</span>
                    <h3 class="text-base font-black text-slate-900">Teks Deskripsi & Hak Cipta Footer</h3>
                    <p class="text-xs text-slate-500">Ubah teks deskripsi singkat instansi dan tulisan hak cipta (copyright) di bagian bawah seluruh halaman.</p>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Deskripsi Singkat Instansi di Footer</label>
                        <textarea name="tagline" rows="2" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">{{ $settings['tagline'] ?? 'Portal resmi layanan riset, kajian kebijakan strategis, serta fasilitasi ekosistem inovasi daerah Pemerintah Kota Makassar.' }}</textarea>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Teks Hak Cipta (Copyright)</label>
                        <input type="text" name="footer_copyright" value="{{ $settings['footer_copyright'] ?? ('© ' . date('Y') . ' Badan Riset dan Inovasi Daerah Kota Makassar. Seluruh hak cipta dilindungi.') }}" required class="w-full rounded-xl border border-bone-300 text-xs font-semibold px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-sm">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Teks Footer</span>
                    </button>
                </div>
            </form>

        </div>

        <!-- ============================================================== -->
        <!-- TAB 3: KARTU LAYANAN UTAMA DI BERANDA                          -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'layanan'" class="space-y-6">

            <!-- Banner Header & Judul Section Halaman Layanan -->
            <form method="POST" action="{{ route('dashboard.landing-cms.layanan-header') }}" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-5">
                @csrf
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-bone-200 pb-3">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Kustomisasi Halaman /layanan</span>
                        <h3 class="text-base font-black text-slate-900">Banner Header & Judul Section Layanan</h3>
                    </div>
                    <a href="{{ route('layanan') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-maroon-700 hover:underline">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>Buka Halaman Layanan</span>
                    </a>
                </div>
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Judul Utama Banner (/layanan)</label>
                        <input type="text" name="layanan_header_title" value="{{ $settings['layanan_header_title'] ?? 'Katalog Layanan Terpadu BRIDA' }}" required class="w-full rounded-xl border border-bone-300 text-xs font-semibold px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Deskripsi Pengantar Banner (/layanan)</label>
                        <textarea name="layanan_header_subtitle" rows="2" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">{{ $settings['layanan_header_subtitle'] ?? 'Fasilitasi riset kebijakan berbasis bukti ilmiah, rekomendasi izin penelitian, pendampingan inovasi perangkat daerah, serta kemitraan riset perguruan tinggi dan BRIN.' }}</textarea>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Badge Section Layanan</label>
                        <input type="text" name="layanan_section_badge" value="{{ $settings['layanan_section_badge'] ?? 'Pelayanan Prima' }}" required class="w-full rounded-xl border border-bone-300 text-xs font-semibold px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Judul Section Layanan</label>
                        <input type="text" name="layanan_section_title" value="{{ $settings['layanan_section_title'] ?? 'Layanan Riset & Inovasi' }}" required class="w-full rounded-xl border border-bone-300 text-xs font-semibold px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-sm">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Header Halaman Layanan</span>
                    </button>
                </div>
            </form>

            <!-- Daftar Kartu Layanan yang Dapat Diedit -->
            <div class="grid md:grid-cols-2 gap-6">
                @foreach($services as $srv)
                <div class="bg-white rounded-3xl p-6 border border-bone-300 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-bone-200 pb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-maroon-700 text-white flex items-center justify-center text-base">
                                <i class="{{ $srv->icon }}"></i>
                            </div>
                            <h4 class="font-black text-sm text-slate-900">{{ $srv->judul }}</h4>
                        </div>
                        <form method="POST" action="{{ route('dashboard.landing-cms.services.destroy', $srv->id) }}" data-confirm="Hapus kartu layanan '{{ $srv->judul }}' dari beranda?" data-confirm-title="Hapus Kartu Layanan" data-confirm-btn="Ya, Hapus">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-rose-600 hover:underline">
                                <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                            </button>
                        </form>
                    </div>

                    <form method="POST" action="{{ route('dashboard.landing-cms.services.update', $srv->id) }}" class="space-y-3">
                        @csrf
                        @method('PATCH')
                        <div class="grid sm:grid-cols-3 gap-3">
                            <div class="sm:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-600">Judul Layanan</label>
                                <input type="text" name="judul" value="{{ $srv->judul }}" required class="w-full text-xs font-bold rounded-xl border border-bone-300 py-2 px-3 mt-0.5">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Kode Ikon</label>
                                <input type="text" name="icon" value="{{ $srv->icon }}" required class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-0.5">
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Badge Kategori (Halaman Layanan)</label>
                                <input type="text" name="kategori_badge" value="{{ $srv->kategori_badge ?? 'Layanan Publik' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-0.5">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Judul Daftar Poin</label>
                                <input type="text" name="detail_title" value="{{ $srv->detail_title ?? 'Persyaratan & Cakupan:' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-0.5">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-600">Deskripsi Layanan</label>
                            <textarea name="deskripsi" rows="2" required class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-0.5">{{ $srv->deskripsi }}</textarea>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-600">Daftar Poin Persyaratan / Cakupan (1 Poin per Baris - Tampil di /layanan)</label>
                            <textarea name="detail_items" rows="3" placeholder="Ketik 1 poin per baris..." class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-0.5 bg-bone-50/50">{{ $srv->detail_items }}</textarea>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Estimasi Waktu / Jadwal</label>
                                <input type="text" name="estimasi_info" value="{{ $srv->estimasi_info ?? 'Estimasi: 1 - 3 Hari Kerja' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-0.5">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Info Biaya / Status</label>
                                <input type="text" name="biaya_info" value="{{ $srv->biaya_info ?? 'Biaya: Rp 0 (Gratis)' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-0.5">
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Teks Link Beranda</label>
                                <input type="text" name="link_text" value="{{ $srv->link_text }}" required class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-0.5">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">URL Link Tujuan</label>
                                <input type="text" name="link_url" value="{{ $srv->link_url }}" required class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-0.5">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Urutan</label>
                                <input type="number" name="sort_order" value="{{ $srv->sort_order }}" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-0.5">
                            </div>
                        </div>

                        <div class="pt-2 text-right">
                            <button type="submit" class="bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow-sm">
                                Simpan Perubahan Layanan
                            </button>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>

            <!-- Form Tambah Kartu Layanan Baru -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-4">
                <h3 class="text-base font-black text-slate-900 border-b border-bone-200 pb-2">+ Tambah Kartu Layanan Baru di Beranda</h3>
                <form method="POST" action="{{ route('dashboard.landing-cms.services.store') }}" class="grid sm:grid-cols-12 gap-4">
                    @csrf
                    <div class="sm:col-span-5">
                        <label class="block text-xs font-bold text-slate-700">Judul Layanan <span class="text-rose-500">*</span></label>
                        <input type="text" name="judul" required placeholder="Contoh: Klinik HKI & Paten" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-1">
                    </div>
                    <div class="sm:col-span-3">
                        <label class="block text-xs font-bold text-slate-700">Ikon FontAwesome</label>
                        <input type="text" name="icon" value="fa-solid fa-certificate" required class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-1">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700">Teks Link</label>
                        <input type="text" name="link_text" value="Lihat Layanan" required class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-1">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700">URL Tujuan</label>
                        <input type="text" name="link_url" value="/layanan" required class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 mt-1">
                    </div>
                    <div class="sm:col-span-10">
                        <input type="text" name="deskripsi" required placeholder="Tuliskan penjelasan singkat layanan ini..." class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3">
                    </div>
                    <div class="sm:col-span-2">
                        <button type="submit" class="w-full bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs py-2.5 rounded-xl transition shadow">
                            + Tambah Kartu
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <!-- ============================================================== -->
        <!-- TAB 4: EDITOR HALAMAN PEMERINTAHAN (PROFIL, FOTO, VISI MISI)   -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'pemerintahan'" class="space-y-6">
            <form method="POST" action="{{ route('dashboard.landing-cms.update-hero') }}" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-8">
                @csrf

                <!-- Banner Header Halaman Pemerintahan -->
                <div class="space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-bone-200 pb-2">
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Banner Atas /pemerintahan</span>
                            <h3 class="text-base font-black text-slate-900">Banner Header Halaman Pemerintahan</h3>
                        </div>
                        <a href="{{ route('pemerintahan') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-maroon-700 hover:underline">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            <span>Buka Halaman Pemerintahan</span>
                        </a>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Judul Utama Banner</label>
                            <input type="text" name="pemerintahan_header_title" value="{{ $settings['pemerintahan_header_title'] ?? 'Profil & Tata Kelola Kelembagaan' }}" class="w-full rounded-xl border border-bone-300 text-xs font-semibold px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Deskripsi Pengantar Banner</label>
                            <textarea name="pemerintahan_header_subtitle" rows="2" class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">{{ $settings['pemerintahan_header_subtitle'] ?? 'Mengenal lebih dekat Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar, fungsi penunjang urusan pemerintahan daerah di bidang penelitian, pengembangan, pengkajian, dan inovasi.' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Foto Gedung & Profil Lembaga -->
                <div class="space-y-4">
                    <div class="border-b border-bone-200 pb-2">
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Halaman /pemerintahan</span>
                        <h3 class="text-base font-black text-slate-900">Foto Kantor Sekretariat & Profil Lembaga</h3>
                    </div>

                    <div class="grid md:grid-cols-12 gap-6 items-start">
                        <div class="md:col-span-5 p-4 rounded-2xl bg-bone-50 border border-bone-300 space-y-3">
                            <span class="text-xs font-bold text-slate-800 block">Foto Gedung Kantor / Sekretariat</span>
                            <div class="h-44 rounded-xl overflow-hidden bg-slate-900 border border-bone-300">
                                <img src="{{ $settings['gov_office_photo'] ?? 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80' }}" alt="Gedung Kantor" class="w-full h-full object-cover">
                            </div>
                            <input type="file" name="gov_office_photo_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-maroon-700 file:text-white">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-600">Keterangan Bawah Foto</label>
                                <input type="text" name="gov_office_caption" value="{{ $settings['gov_office_caption'] ?? 'Sekretariat BRIDA Kota Makassar' }}" class="w-full text-xs rounded-xl border border-bone-300 py-1.5 px-2.5 bg-white mt-0.5">
                            </div>
                        </div>

                        <div class="md:col-span-7 space-y-4">
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Judul Profil Lembaga</label>
                                <input type="text" name="gov_profile_title" value="{{ $settings['gov_profile_title'] ?? 'Badan Riset dan Inovasi Daerah (BRIDA)' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3">
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Paragraf Profil 1</label>
                                <textarea name="gov_profile_p1" rows="4" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3">{{ $settings['gov_profile_p1'] ?? '' }}</textarea>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-700">Paragraf Profil 2</label>
                                <textarea name="gov_profile_p2" rows="4" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3">{{ $settings['gov_profile_p2'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Visi & 4 Poin Misi -->
                <div class="space-y-4">
                    <div class="border-b border-bone-200 pb-2">
                        <h3 class="text-base font-black text-slate-900">Visi & Misi Inovasi Daerah</h3>
                    </div>

                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-maroon-700">Kalimat Visi Utama</label>
                        <textarea name="gov_visi" rows="2" class="w-full text-xs font-bold rounded-xl border border-rose-300 py-2 px-3">{{ $settings['gov_visi'] ?? '' }}</textarea>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Misi Poin 1</label>
                            <textarea name="gov_misi_1" rows="2" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3">{{ $settings['gov_misi_1'] ?? '' }}</textarea>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Misi Poin 2</label>
                            <textarea name="gov_misi_2" rows="2" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3">{{ $settings['gov_misi_2'] ?? '' }}</textarea>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Misi Poin 3</label>
                            <textarea name="gov_misi_3" rows="2" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3">{{ $settings['gov_misi_3'] ?? '' }}</textarea>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Misi Poin 4</label>
                            <textarea name="gov_misi_4" rows="2" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3">{{ $settings['gov_misi_4'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-bone-200 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Halaman Pemerintahan</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 5: BAR PENGUMUMAN ATAS, PINTASAN LINK, & GOOGLE MAPS       -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'beranda'" class="space-y-6">
            <form method="POST" action="{{ route('dashboard.landing-cms.update-hero') }}" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-8">
                @csrf

                <!-- 1. Bar Pengumuman Paling Atas (Top Bar) -->
                <div class="space-y-4">
                    <div class="border-b border-bone-200 pb-2">
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Header Atas</span>
                        <h3 class="text-base font-black text-slate-900">Bar Pengumuman Paling Atas (Top Announcement Bar)</h3>
                    </div>

                    <div class="grid sm:grid-cols-12 gap-4 items-center">
                        <div class="sm:col-span-3">
                            <label class="block text-xs font-bold text-slate-700">Status Tampil</label>
                            <select name="topbar_enabled" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3 mt-1 font-bold">
                                <option value="1" {{ ($settings['topbar_enabled'] ?? '1') == '1' ? 'selected' : '' }}>Tampilkan Bar Atas</option>
                                <option value="0" {{ ($settings['topbar_enabled'] ?? '1') == '0' ? 'selected' : '' }}>Sembunyikan Bar Atas</option>
                            </select>
                        </div>
                        <div class="sm:col-span-5">
                            <label class="block text-xs font-bold text-slate-700">Teks Pengumuman Atas</label>
                            <input type="text" name="topbar_text" value="{{ $settings['topbar_text'] ?? 'Portal Resmi Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3 mt-1">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Warna Latar</label>
                            <input type="color" name="topbar_bg_color" value="{{ $settings['topbar_bg_color'] ?? '#3D000E' }}" class="w-full h-10 rounded-xl cursor-pointer border border-bone-300 p-1 bg-white mt-1">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Warna Teks</label>
                            <input type="color" name="topbar_text_color" value="{{ $settings['topbar_text_color'] ?? '#F5F4EE' }}" class="w-full h-10 rounded-xl cursor-pointer border border-bone-300 p-1 bg-white mt-1">
                        </div>
                    </div>
                </div>

                <!-- 2. Tautan Pintasan Resmi di Bawah Beranda -->
                <div class="space-y-4">
                    <div class="border-b border-bone-200 pb-2">
                        <h3 class="text-base font-black text-slate-900">Daftar Tautan Pintasan Resmi (Bagian Bawah Beranda)</h3>
                    </div>

                    <div class="grid sm:grid-cols-3 gap-4">
                        <div class="p-4 rounded-2xl bg-bone-50 border border-bone-300 space-y-2">
                            <span class="text-xs font-bold text-maroon-700 block">Pintasan Link #1</span>
                            <input type="text" name="quicklink_1_label" value="{{ $settings['quicklink_1_label'] ?? '' }}" placeholder="Nama Link 1" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 bg-white">
                            <input type="text" name="quicklink_1_url" value="{{ $settings['quicklink_1_url'] ?? '' }}" placeholder="URL Link 1" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 bg-white">
                        </div>
                        <div class="p-4 rounded-2xl bg-bone-50 border border-bone-300 space-y-2">
                            <span class="text-xs font-bold text-maroon-700 block">Pintasan Link #2</span>
                            <input type="text" name="quicklink_2_label" value="{{ $settings['quicklink_2_label'] ?? '' }}" placeholder="Nama Link 2" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 bg-white">
                            <input type="text" name="quicklink_2_url" value="{{ $settings['quicklink_2_url'] ?? '' }}" placeholder="URL Link 2" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 bg-white">
                        </div>
                        <div class="p-4 rounded-2xl bg-bone-50 border border-bone-300 space-y-2">
                            <span class="text-xs font-bold text-maroon-700 block">Pintasan Link #3</span>
                            <input type="text" name="quicklink_3_label" value="{{ $settings['quicklink_3_label'] ?? '' }}" placeholder="Nama Link 3" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 bg-white">
                            <input type="text" name="quicklink_3_url" value="{{ $settings['quicklink_3_url'] ?? '' }}" placeholder="URL Link 3" class="w-full text-xs rounded-xl border border-bone-300 py-2 px-3 bg-white">
                        </div>
                    </div>
                </div>

                <!-- 3. Embed Peta Google Maps Halaman Kontak -->
                <div class="space-y-2">
                    <div class="border-b border-bone-200 pb-2">
                        <h3 class="text-base font-black text-slate-900">URL Embed Peta Google Maps (Halaman Kontak)</h3>
                        <p class="text-xs text-slate-500">Salin URL dari menu "Bagikan -> Sematkan Peta (src)" di Google Maps jika ingin mengubah titik lokasi peta kantor.</p>
                    </div>
                    <input type="text" name="google_maps_embed" value="{{ $settings['google_maps_embed'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3 font-mono text-slate-600">
                </div>

                <div class="pt-4 border-t border-bone-200 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Pengumuman, Pintasan & Maps</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 6: KONEKSI OTOMATIS INSTAGRAM @bridakotamakassar           -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'beranda'" class="space-y-6">
            <form method="POST" action="{{ route('dashboard.landing-cms.update-hero') }}" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-6">
                @csrf

                <div class="border-b border-bone-200 pb-3">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-rose-600">Auto-Sync Feed Instagram</span>
                    <h3 class="text-base font-black text-slate-900">Koneksi Otomatis 3 Postingan Terbaru Instagram @bridakotamakassar</h3>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Cukup hubungkan <strong>1 kali saja</strong> menggunakan Behold.so JSON Feed URL (paling mudah) atau Instagram Graph API Token. Selanjutnya 3 postingan terbaru akan otomatis terupdate setiap jam tanpa perlu diedit manual lagi!
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Username Instagram Resmi</label>
                        <input type="text" name="ig_username" value="{{ $settings['ig_username'] ?? '@bridakotamakassar' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">URL Profil Instagram</label>
                        <input type="url" name="ig_profile_url" value="{{ $settings['ig_profile_url'] ?? 'https://www.instagram.com/bridakotamakassar/' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3">
                    </div>
                </div>

                <!-- Pilihan Jalur 1 (Paling Praktis): Behold.so JSON Feed URL -->
                <div class="p-5 rounded-2xl bg-bone-50 border border-bone-300 space-y-2.5">
                    <div class="flex items-center justify-between">
                        <label class="block text-xs font-extrabold text-maroon-700">
                            <i class="fa-solid fa-bolt mr-1"></i> Opsi 1 (Paling Mudah - 1 Menit): Behold.so JSON Feed URL
                        </label>
                        <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded-full">Direkomendasikan</span>
                    </div>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Daftar gratis di <a href="https://behold.so" target="_blank" class="text-maroon-700 font-bold underline">behold.so</a>, hubungkan akun <strong>@bridakotamakassar</strong>, buat Feed bertipe <strong>JSON</strong>, lalu tempelkan URL-nya di bawah ini:
                    </p>
                    <input type="url" name="ig_behold_url" value="{{ $settings['ig_behold_url'] ?? '' }}" placeholder="https://feeds.behold.so/xxxxxxxxxxxx" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3 bg-white font-mono">
                </div>

                <!-- Pilihan Jalur 2 (Resmi Meta Developer): Instagram Graph API Access Token -->
                <div class="p-5 rounded-2xl bg-bone-50 border border-bone-300 space-y-2.5">
                    <label class="block text-xs font-extrabold text-slate-800">
                        <i class="fa-brands fa-meta mr-1 text-blue-600"></i> Opsi 2 (Resmi Meta): Instagram Graph API Access Token
                    </label>
                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Jika tim IT memiliki Long-Lived Access Token resmi dari Meta for Developers untuk akun <strong>@bridakotamakassar</strong>, tempelkan tokennya di bawah ini:
                    </p>
                    <input type="text" name="ig_access_token" value="{{ $settings['ig_access_token'] ?? '' }}" placeholder="IGQWRP..." class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3 bg-white font-mono">
                </div>

                <div class="pt-4 border-t border-bone-200 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-arrows-rotate"></i>
                        <span>Simpan & Sinkronkan Feed Instagram Sekarang</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 7: FOTO & NAMA 4 PIMPINAN (WALI KOTA, WAWALI, KABAN, SEKBAN)-->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'beranda'" class="space-y-6">
            <form method="POST" action="{{ route('dashboard.landing-cms.update-hero') }}" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-8">
                @csrf

                <div class="border-b border-bone-200 pb-3">
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Section Pimpinan Beranda</span>
                    <h3 class="text-base font-black text-slate-900">Foto & Nama Pimpinan Daerah serta Pimpinan BRIDA</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Tampil tepat di antara Hero Banner dan Section Layanan. Unggah foto potret (JPG/PNG) untuk Wali Kota, Wakil Wali Kota, Kepala Badan, dan Sekretaris Badan.</p>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Label Kecil Atas Section</label>
                        <input type="text" name="leader_section_badge" value="{{ $settings['leader_section_badge'] ?? 'Pimpinan Daerah & Lembaga' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Judul Utama Section Pimpinan</label>
                        <input type="text" name="leader_section_title" value="{{ $settings['leader_section_title'] ?? 'Pimpinan Pemerintah Kota & BRIDA Makassar' }}" class="w-full text-xs rounded-xl border border-bone-300 py-2.5 px-3">
                    </div>
                </div>

                @php
                    $leaderLabels = [
                        1 => '1. Wali Kota Makassar',
                        2 => '2. Wakil Wali Kota Makassar',
                        3 => '3. Kepala Badan (Kaban) BRIDA',
                        4 => '4. Sekretaris Badan (Sekban) BRIDA',
                    ];
                @endphp

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @for($i = 1; $i <= 4; $i++)
                    @php
                        $photoVal = $settings["leader_{$i}_photo"] ?? '';
                    @endphp
                    <div class="p-4 rounded-2xl bg-bone-50 border border-bone-300 space-y-3 flex flex-col justify-between">
                        <div class="space-y-3">
                            <span class="text-xs font-extrabold text-maroon-700 block">{{ $leaderLabels[$i] }}</span>

                            <div class="aspect-[3/4] rounded-xl overflow-hidden bg-bone-200 border border-bone-300 flex items-center justify-center">
                                @if(!empty($photoVal))
                                    <img src="{{ $photoVal }}" alt="Pimpinan {{ $i }}" class="w-full h-full object-cover object-top">
                                @else
                                    <div class="text-center text-slate-400 p-3">
                                        <i class="fa-solid fa-user-tie text-3xl mb-1 block"></i>
                                        <span class="text-[10px]">Belum ada foto</span>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Unggah Foto (JPG/PNG)</label>
                                <input type="file" name="leader_{{ $i }}_photo_file" accept="image/*" class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-maroon-700 file:text-white mt-0.5">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Jabatan Resmi</label>
                                <input type="text" name="leader_{{ $i }}_title" value="{{ $settings["leader_{$i}_title"] ?? '' }}" class="w-full text-xs font-bold rounded-xl border border-bone-300 py-1.5 px-2.5 bg-white mt-0.5">
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 uppercase">Nama Lengkap & Gelar</label>
                                <input type="text" name="leader_{{ $i }}_name" value="{{ $settings["leader_{$i}_name"] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 py-1.5 px-2.5 bg-white mt-0.5">
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>

                <div class="pt-4 border-t border-bone-200 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Foto & Nama Pimpinan</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 8: EDITOR HALAMAN BERITA & PUBLIKASI                       -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'berita'" class="space-y-6" x-data="{ sorotanMode: '{{ $settings['berita_sorotan_mode'] ?? 'otomatis' }}' }">
            <form method="POST" action="{{ route('dashboard.landing-cms.berita') }}" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-6">
                @csrf
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-bone-200 pb-4">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Kustomisasi Portal Berita</span>
                        <h3 class="text-lg font-black text-slate-900">Editor Halaman Berita & Publikasi</h3>
                        <p class="text-xs text-slate-500">Atur banner header, berita sorotan utama (featured), filter kategori, jumlah per halaman, dan kolom komentar.</p>
                    </div>
                    <a href="{{ route('berita') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-maroon-700 hover:underline">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>Buka Halaman Berita</span>
                    </a>
                </div>

                <!-- 1. Banner Header -->
                <div class="space-y-4">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 border-b border-bone-200 pb-2">1. Banner Header Halaman Berita</h4>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Judul Utama Banner</label>
                            <input type="text" name="berita_header_title" value="{{ $settings['berita_header_title'] ?? 'Kabar & Publikasi Resmi BRIDA' }}" required class="w-full rounded-xl border border-bone-300 text-xs font-semibold px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Deskripsi Pengantar Banner</label>
                            <textarea name="berita_header_subtitle" rows="2" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">{{ $settings['berita_header_subtitle'] ?? 'Informasi terkini mengenai agenda riset terapan daerah, capaian inovasi SKPD, seminar diseminasi ilmiah, dan kemitraan strategis Pemerintah Kota Makassar.' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Sorotan Berita Utama -->
                <div class="space-y-4 pt-2">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 border-b border-bone-200 pb-2">2. Pengaturan Sorotan Berita Utama (Featured)</h4>
                    <div class="flex items-center gap-3 bg-bone-50 p-3.5 rounded-2xl border border-bone-200">
                        <input type="checkbox" id="berita_sorotan_aktif" name="berita_sorotan_aktif" value="1" {{ ($settings['berita_sorotan_aktif'] ?? '1') === '1' ? 'checked' : '' }} class="rounded text-maroon-700 focus:ring-maroon-700">
                        <label for="berita_sorotan_aktif" class="text-xs font-bold text-slate-800 cursor-pointer">Tampilkan Bagian Sorotan Utama di Atas Daftar Berita</label>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Mode Pemilihan Sorotan</label>
                            <select name="berita_sorotan_mode" x-model="sorotanMode" class="w-full rounded-xl border border-bone-300 text-xs font-semibold px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                                <option value="otomatis">Otomatis (Selalu Berita Terbaru)</option>
                                <option value="manual">Manual (Pilih 1 Berita Tertentu)</option>
                            </select>
                        </div>
                        <div x-show="sorotanMode === 'manual'">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Pilih Berita Sorotan</label>
                            <select name="berita_sorotan_id" class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                                <option value="">-- Pilih Berita --</option>
                                @foreach($beritaPublikasi as $bp)
                                    <option value="{{ $bp->id }}" {{ ($settings['berita_sorotan_id'] ?? '') == $bp->id ? 'selected' : '' }}>
                                        {{ Str::limit($bp->judul, 65) }} ({{ $bp->published_at ? $bp->published_at->format('d/m/Y') : '' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- 3. Filter Kategori, Paginasi & Komentar -->
                <div class="space-y-4 pt-2">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 border-b border-bone-200 pb-2">3. Kategori Filter, Paginasi & Komentar</h4>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jumlah Berita Per Halaman</label>
                            <select name="berita_per_page" class="w-full rounded-xl border border-bone-300 text-xs font-semibold px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                                @foreach([3, 6, 9, 12, 15] as $qty)
                                    <option value="{{ $qty }}" {{ (int)($settings['berita_per_page'] ?? 6) === $qty ? 'selected' : '' }}>{{ $qty }} Berita / Halaman</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Daftar Tombol Filter Kategori (Pisahkan dengan koma)</label>
                            <input type="text" name="berita_kategori_list" value="{{ $settings['berita_kategori_list'] ?? 'Kebijakan Riset, Inovasi Daerah, Kemitraan Kampus, Agenda BRIDA' }}" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                    </div>

                    <div class="flex items-center gap-3 bg-bone-50 p-3.5 rounded-2xl border border-bone-200">
                        <input type="checkbox" id="berita_komentar_aktif" name="berita_komentar_aktif" value="1" {{ ($settings['berita_komentar_aktif'] ?? '1') === '1' ? 'checked' : '' }} class="rounded text-maroon-700 focus:ring-maroon-700">
                        <label for="berita_komentar_aktif" class="text-xs font-bold text-slate-800 cursor-pointer">Aktifkan Kolom Komentar Publik di Halaman Detail Berita</label>
                    </div>
                </div>

                <div class="pt-4 border-t border-bone-200 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Pengaturan Halaman Berita</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 6: EDITOR HALAMAN KONTAK                                   -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'kontak'" class="space-y-6">
            <form method="POST" action="{{ route('dashboard.landing-cms.kontak') }}" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-6">
                @csrf
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-bone-200 pb-4">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Kustomisasi Halaman Kontak</span>
                        <h3 class="text-lg font-black text-slate-900">Editor Halaman Kontak & Saluran Resmi</h3>
                        <p class="text-xs text-slate-500">Atur banner header, alamat sekretariat, jam kerja, call center, email, WhatsApp, dan media sosial.</p>
                    </div>
                    <a href="{{ route('kontak') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-maroon-700 hover:underline">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>Buka Halaman Kontak</span>
                    </a>
                </div>

                <!-- 1. Banner Header -->
                <div class="space-y-4">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 border-b border-bone-200 pb-2">1. Banner Header Halaman Kontak</h4>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Judul Utama Banner</label>
                            <input type="text" name="kontak_header_title" value="{{ $settings['kontak_header_title'] ?? 'Kontak & Saluran Komunikasi Resmi' }}" required class="w-full rounded-xl border border-bone-300 text-xs font-semibold px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Deskripsi Pengantar Banner</label>
                            <textarea name="kontak_header_subtitle" rows="2" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">{{ $settings['kontak_header_subtitle'] ?? 'Kami siap melayani kebutuhan konsultasi riset, fasilitasi inovasi daerah, serta koordinasi kelembagaan. Silakan hubungi kami melalui saluran komunikasi tertera di bawah.' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. Alamat, Jam Operasional & Saluran Komunikasi -->
                <div class="space-y-4 pt-2">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 border-b border-bone-200 pb-2">2. Alamat Sekretariat, Jam Kerja & Kontak</h4>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Alamat Lengkap Sekretariat</label>
                            <textarea name="office_address" rows="2" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">{{ $settings['office_address'] ?? 'Gedung Balai Kota Makassar Lantai 2, Jl. Ahmad Yani No. 2, Baru, Kec. Ujung Pandang, Kota Makassar, Sulawesi Selatan 90111' }}</textarea>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Tautan Google Maps (Tombol Buka di Google Maps)</label>
                            <input type="url" name="kontak_maps_url" value="{{ $settings['kontak_maps_url'] ?? 'https://maps.google.com/?q=Balai+Kota+Makassar' }}" placeholder="https://maps.google.com/..." class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jam Operasional</label>
                            <input type="text" name="work_hours" value="{{ $settings['work_hours'] ?? 'Senin - Kamis (08.00 - 16.00 WITA), Jumat (08.00 - 16.30 WITA)' }}" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Telepon / Call Center</label>
                            <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '112 (Bebas Pulsa)' }}" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Email Sekretariat</label>
                            <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'brida@makassarkota.go.id' }}" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Nomor WhatsApp Layanan</label>
                            <input type="text" name="contact_whatsapp" value="{{ $settings['contact_whatsapp'] ?? '081144002233' }}" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">URL Instagram Resmi (Opsional)</label>
                            <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="https://instagram.com/bridakotamakassar" class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">URL YouTube Resmi (Opsional)</label>
                            <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}" placeholder="https://youtube.com/@..." class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-bone-200 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Pengaturan Halaman Kontak</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- ============================================================== -->
        <!-- TAB 7: EDITOR HALAMAN INFORMASI PUBLIK                         -->
        <!-- ============================================================== -->
        <div x-show="activeTab === 'informasi-publik'" class="space-y-6">
            <form method="POST" action="{{ route('dashboard.landing-cms.informasi-publik') }}" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-6">
                @csrf
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-bone-200 pb-4">
                    <div>
                        <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Kustomisasi Informasi Publik</span>
                        <h3 class="text-lg font-black text-slate-900">Editor Halaman Informasi Publik & Regulasi</h3>
                        <p class="text-xs text-slate-500">Atur banner header, 3 kartu capaian keterbukaan informasi, dan jumlah dokumen regulasi per halaman.</p>
                    </div>
                    <a href="{{ route('informasi-publik') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-maroon-700 hover:underline">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        <span>Buka Halaman Informasi Publik</span>
                    </a>
                </div>

                <!-- 1. Banner Header -->
                <div class="space-y-4">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 border-b border-bone-200 pb-2">1. Banner Header Halaman Informasi Publik</h4>
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Judul Utama Banner</label>
                            <input type="text" name="info_header_title" value="{{ $settings['info_header_title'] ?? 'Keterbukaan Informasi Publik & Regulasi Riset' }}" required class="w-full rounded-xl border border-bone-300 text-xs font-semibold px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Deskripsi Pengantar Banner</label>
                            <textarea name="info_header_subtitle" rows="2" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">{{ $settings['info_header_subtitle'] ?? 'Dokumentasi regulasi inovasi daerah, laporan kinerja, statistik ekosistem riset, dan layanan Pejabat Pengelola Informasi dan Dokumentasi (PPID) BRIDA Kota Makassar.' }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. 3 Kartu Capaian & Keterbukaan Informasi -->
                <div class="space-y-4 pt-2">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 border-b border-bone-200 pb-2">2. 3 Kartu Capaian & Keterbukaan Informasi</h4>
                    <div class="grid md:grid-cols-3 gap-4">
                        <!-- Kartu 1 -->
                        <div class="p-4 rounded-2xl bg-bone-50 border border-bone-200 space-y-3">
                            <span class="text-[11px] font-extrabold text-maroon-700 uppercase block">Kartu 1</span>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Angka / Nilai</label>
                                <input type="text" name="info_stat_1_value" value="{{ $settings['info_stat_1_value'] ?? '120+' }}" required class="w-full rounded-xl border border-bone-300 text-xs font-bold px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Judul Kartu</label>
                                <input type="text" name="info_stat_1_title" value="{{ $settings['info_stat_1_title'] ?? 'Inovasi Terdaftar' }}" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Deskripsi Singkat</label>
                                <textarea name="info_stat_1_desc" rows="2" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2">{{ $settings['info_stat_1_desc'] ?? 'Basis data inovasi perangkat daerah dalam database IGA Kemendagri.' }}</textarea>
                            </div>
                        </div>

                        <!-- Kartu 2 -->
                        <div class="p-4 rounded-2xl bg-bone-50 border border-bone-200 space-y-3">
                            <span class="text-[11px] font-extrabold text-emerald-700 uppercase block">Kartu 2</span>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Angka / Predikat</label>
                                <input type="text" name="info_stat_2_value" value="{{ $settings['info_stat_2_value'] ?? 'Sangat Inovatif' }}" required class="w-full rounded-xl border border-bone-300 text-xs font-bold px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Judul Kartu</label>
                                <input type="text" name="info_stat_2_title" value="{{ $settings['info_stat_2_title'] ?? 'Predikat IID Nasional' }}" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Deskripsi Singkat</label>
                                <textarea name="info_stat_2_desc" rows="2" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2">{{ $settings['info_stat_2_desc'] ?? 'Penilaian Indeks Inovasi Daerah Kementerian Dalam Negeri RI.' }}</textarea>
                            </div>
                        </div>

                        <!-- Kartu 3 -->
                        <div class="p-4 rounded-2xl bg-bone-50 border border-bone-200 space-y-3">
                            <span class="text-[11px] font-extrabold text-indigo-700 uppercase block">Kartu 3</span>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Angka / Nilai</label>
                                <input type="text" name="info_stat_3_value" value="{{ $settings['info_stat_3_value'] ?? '100%' }}" required class="w-full rounded-xl border border-bone-300 text-xs font-bold px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Judul Kartu</label>
                                <input type="text" name="info_stat_3_title" value="{{ $settings['info_stat_3_title'] ?? 'Keterbukaan Informasi' }}" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-600 uppercase mb-1">Deskripsi Singkat</label>
                                <textarea name="info_stat_3_desc" rows="2" required class="w-full rounded-xl border border-bone-300 text-xs px-3 py-2">{{ $settings['info_stat_3_desc'] ?? 'Akses publik terhadap dokumen kebijakan dan telaahan staf terbuka.' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Paginasi Dokumen Regulasi -->
                <div class="space-y-4 pt-2">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 border-b border-bone-200 pb-2">3. Pengaturan Daftar Regulasi</h4>
                    <div class="max-w-xs">
                        <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Jumlah Dokumen Per Halaman</label>
                        <select name="info_per_page" class="w-full rounded-xl border border-bone-300 text-xs font-semibold px-3 py-2.5 focus:ring-maroon-700 focus:border-maroon-700">
                            @foreach([6, 8, 12, 16] as $qty)
                                <option value="{{ $qty }}" {{ (int)($settings['info_per_page'] ?? 8) === $qty ? 'selected' : '' }}>{{ $qty }} Dokumen / Halaman</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="pt-4 border-t border-bone-200 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Pengaturan Informasi Publik</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>
