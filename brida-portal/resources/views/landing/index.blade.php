@extends('layouts.landing')

@section('title', 'BRIDA Kota Makassar - Badan Riset dan Inovasi Daerah')

@section('content')
<main>
        <!-- Hero Banner Portal Pemda (Slideshow Berwibawa & Visual Nyata - Full Viewport) -->
        <section id="beranda" class="relative overflow-hidden bg-slate-900 text-white min-h-[calc(100vh-7.5rem)] flex items-center justify-center">
            <!-- Background Slideshow Auto-Crop & Full-Cover -->
            <div id="hero-slideshow" class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                <!-- Slide 1 (Aktif Awal) -->
                <img
                    src="{{ asset('images') }}/slide1.jpg"
                    alt="Dokumentasi Kegiatan BRIDA Makassar 1"
                    class="hero-slide active"
                >
                <!-- Slide 2 -->
                <img
                    src="{{ asset('images') }}/slide2.jpg"
                    alt="Dokumentasi Kegiatan BRIDA Makassar 2"
                    class="hero-slide"
                >
                <!-- Lapisan Gradasi Warna Elegan Transparan (Foto Jauh Lebih Terang & Jelas) -->
                <div class="absolute inset-0 bg-gradient-to-r from-maroon-950/50 via-slate-950/30 to-black/20 z-10"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10 w-full">
                <div class="grid lg:grid-cols-12 gap-10 items-center">
                    
                    <!-- Sisi Kiri: Headline Resmi Pemerintahan -->
                    <div class="lg:col-span-12 max-w-4xl space-y-6">
                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight text-bone-50 drop-shadow-md">
                            Mendorong Inovasi Berbasis Riset, Mewujudkan <span class="text-rose-400">Makassar Kota Dunia</span> yang Berdaya Saing.
                        </h1>

                        <p class="text-base sm:text-lg text-bone-100 max-w-2xl leading-relaxed font-normal drop-shadow-sm">
                            Selamat datang di Portal Resmi Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar. Kami mengoordinasikan ekosistem riset terapan, pendampingan inovasi perangkat daerah, serta perumusan rekomendasi kebijakan pembangunan daerah berbasis data dan bukti ilmiah.
                        </p>

                        <!-- Tombol Aksi Cepat Portal -->
                        <div class="flex flex-wrap gap-4 pt-2">
                            <a href="{{ route('layanan') }}" class="inline-flex items-center gap-2.5 bg-rose-700 hover:bg-rose-800 text-white font-bold px-6 py-3.5 rounded-xl transition shadow-lg shadow-rose-950/40 text-sm">
                                <span>Layanan & Fasilitasi Riset</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <a href="{{ route('informasi-publik') }}" class="inline-flex items-center gap-2.5 bg-white/10 hover:bg-white/20 text-bone-100 font-bold px-6 py-3.5 rounded-xl border border-white/20 transition text-sm">
                                <i class="fa-solid fa-lightbulb text-rose-400"></i>
                                <span>Ekosistem Inovasi Daerah</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Layanan Utama BRIDA Kota Makassar (Format Grid Formal Pemerintahan) -->
        <section id="layanan" class="py-16 bg-white border-b border-bone-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                    <div>
                        <span class="text-xs font-bold tracking-widest uppercase text-maroon-700">Layanan Publik & Kedinasan</span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">Layanan Terpadu BRIDA Kota Makassar</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-xl">Akses layanan pengusulan riset kebijakan, fasilitasi inovasi daerah, serta kemitraan ilmiah.</p>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 bg-bone-100 px-3 py-1.5 rounded-lg border border-bone-300 w-fit">
                        Sistem Terintegrasi Pemkot Makassar
                    </span>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Layanan 1 -->
                    <a href="{{ route('layanan') }}" class="bg-bone-100/70 border border-bone-300 rounded-xl p-6 hover:border-maroon-700 transition group flex flex-col justify-between block">
                        <div class="space-y-3">
                            <div class="w-11 h-11 rounded-lg bg-maroon-700 text-white flex items-center justify-center text-lg">
                                <i class="fa-solid fa-microscope"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base group-hover:text-maroon-700 transition">Riset & Pengkajian Kebijakan</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Pelaksanaan riset ilmiah terapan dan penyusunan rekomendasi kebijakan pembangunan daerah berbasis bukti (*evidence-based policy*).
                            </p>
                        </div>
                        <div class="pt-4 border-t border-bone-300/80 mt-4">
                            <span class="text-xs font-bold text-maroon-700 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                                <span>Informasi Riset</span>
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </span>
                        </div>
                    </a>

                    <!-- Layanan 2 -->
                    <a href="{{ route('layanan') }}" class="bg-bone-100/70 border border-bone-300 rounded-xl p-6 hover:border-maroon-700 transition group flex flex-col justify-between block">
                        <div class="space-y-3">
                            <div class="w-11 h-11 rounded-lg bg-maroon-700 text-white flex items-center justify-center text-lg">
                                <i class="fa-solid fa-lightbulb"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base group-hover:text-maroon-700 transition">Fasilitasi Inovasi Daerah</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Pendampingan dan pemetaan inovasi perangkat daerah (OPD) untuk pengukuran Indeks Inovasi Daerah (IID) tahunan Kemendagri.
                            </p>
                        </div>
                        <div class="pt-4 border-t border-bone-300/80 mt-4">
                            <span class="text-xs font-bold text-maroon-700 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                                <span>Katalog Inovasi</span>
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </span>
                        </div>
                    </a>

                    <!-- Layanan 3 -->
                    <a href="{{ route('layanan') }}" class="bg-bone-100/70 border border-bone-300 rounded-xl p-6 hover:border-maroon-700 transition group flex flex-col justify-between block">
                        <div class="space-y-3">
                            <div class="w-11 h-11 rounded-lg bg-maroon-700 text-white flex items-center justify-center text-lg">
                                <i class="fa-solid fa-book-atlas"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base group-hover:text-maroon-700 transition">Peta Jalan Riset Daerah</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Penyusunan Rencana Induk Riset Daerah (RIRD) sebagai pedoman arah pembangunan sains dan teknologi jangka panjang kota.
                            </p>
                        </div>
                        <div class="pt-4 border-t border-bone-300/80 mt-4">
                            <span class="text-xs font-bold text-maroon-700 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                                <span>Dokumen RIRD</span>
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </span>
                        </div>
                    </a>

                    <!-- Layanan 4 -->
                    <a href="{{ route('layanan') }}" class="bg-bone-100/70 border border-bone-300 rounded-xl p-6 hover:border-maroon-700 transition group flex flex-col justify-between block">
                        <div class="space-y-3">
                            <div class="w-11 h-11 rounded-lg bg-maroon-700 text-white flex items-center justify-center text-lg">
                                <i class="fa-solid fa-handshake-angle"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base group-hover:text-maroon-700 transition">Kemitraan Akademisi & BRIN</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                Sinergi riset bersama Badan Riset dan Inovasi Nasional (BRIN), perguruan tinggi, dan peneliti untuk akselerasi solusi daerah.
                            </p>
                        </div>
                        <div class="pt-4 border-t border-bone-300/80 mt-4">
                            <span class="text-xs font-bold text-maroon-700 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                                <span>Kerja Sama Riset</span>
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </span>
                        </div>
                    </a>
                </div>

            </div>
        </section>

        <!-- Profil Instansi & Komitmen Pembangunan -->
        <section id="tentang" class="py-16 bg-bone-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-10 items-center">
                    
                    <!-- Sisi Gambar Nyata / Dokumentasi Kantor -->
                    <div class="lg:col-span-5">
                        <div class="relative rounded-2xl overflow-hidden border-2 border-bone-300 shadow-xl bg-slate-900">
                            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80" alt="Ruang Rapat Koordinasi Riset BRIDA" class="w-full h-80 object-cover opacity-90">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-5 left-5 right-5 text-white">
                                <span class="text-[10px] uppercase font-bold tracking-wider text-rose-300">Badan Riset & Inovasi Daerah</span>
                                <h4 class="font-bold text-sm sm:text-base">Mewujudkan Tata Kelola Berbasis Sains & Data</h4>
                                <p class="text-xs text-bone-300 mt-1">Balai Kota Makassar, Sulawesi Selatan</p>
                            </div>
                        </div>
                    </div>

                    <!-- Narasi Instansi -->
                    <div class="lg:col-span-7 space-y-5">
                        <div>
                            <span class="text-xs font-bold tracking-widest uppercase text-maroon-700">Tentang Lembaga</span>
                            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">
                                Badan Riset dan Inovasi Daerah Kota Makassar
                            </h2>
                        </div>

                        <p class="text-sm text-slate-600 leading-relaxed">
                            BRIDA Kota Makassar dibentuk sebagai perangkat daerah penunjang urusan pemerintahan di bidang penelitian, pengembangan, pengkajian, dan penerapan inovasi guna menghasilkan kebijakan yang solutif, terukur, dan berdampak luas bagi kemajuan Kota Makassar.
                        </p>

                        <div class="grid sm:grid-cols-2 gap-4 pt-2">
                            <div class="bg-white p-4 rounded-xl border border-bone-300">
                                <h4 class="font-bold text-sm text-slate-900 flex items-center gap-2 mb-1">
                                    <i class="fa-solid fa-bullseye text-maroon-700"></i> Visi Utama
                                </h4>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Menjadi pusat rujukan riset dan inovasi yang adaptif guna mendukung percepatan pembangunan Kota Makassar Menuju Kota Dunia.
                                </p>
                            </div>

                            <div class="bg-white p-4 rounded-xl border border-bone-300">
                                <h4 class="font-bold text-sm text-slate-900 flex items-center gap-2 mb-1">
                                    <i class="fa-solid fa-list-check text-maroon-700"></i> Fokus Kerja
                                </h4>
                                <p class="text-xs text-slate-600 leading-relaxed">
                                    Penyusunan naskah kebijakan tematik, peningkatan indeks inovasi daerah, serta pembinaan ekosistem periset muda.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Ekosistem & Peta Inovasi Daerah Kota Makassar -->
        <section id="inovasi-daerah" class="py-16 bg-white border-y border-bone-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="max-w-3xl mb-12">
                    <span class="text-xs font-bold tracking-widest uppercase text-maroon-700">Inovasi Perangkat Daerah</span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">
                        Ekosistem Inovasi Kota Makassar
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 leading-relaxed">
                        Pengembangan dan pembinaan karya inovasi daerah sesuai amanat PP No. 38 Tahun 2017 untuk meningkatkan efisiensi birokrasi, daya saing ekonomi, dan mutu layanan kepada masyarakat.
                    </p>
                </div>

                <div class="bg-bone-100 rounded-2xl p-6 sm:p-8 border border-bone-300">
                    <h3 class="font-bold text-slate-900 text-sm sm:text-base mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-shapes text-maroon-700"></i>
                        <span>3 Klaster Utama Inovasi Daerah</span>
                    </h3>

                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-white p-5 rounded-xl border border-bone-300">
                            <div class="w-10 h-10 rounded-lg bg-rose-50 text-maroon-700 flex items-center justify-center text-lg mb-3">
                                <i class="fa-solid fa-building-user"></i>
                            </div>
                            <h4 class="font-bold text-sm text-slate-900">Inovasi Tata Kelola Pemerintahan</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Transformasi manajemen birokrasi, digitalisasi alur kerja kedinasan, dan efisiensi penganggaran di lingkungan Pemkot Makassar.
                            </p>
                        </div>

                        <div class="bg-white p-5 rounded-xl border border-bone-300">
                            <div class="w-10 h-10 rounded-lg bg-rose-50 text-maroon-700 flex items-center justify-center text-lg mb-3">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <h4 class="font-bold text-sm text-slate-900">Inovasi Pelayanan Publik</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Peningkatan kecepatan, kemudahan akses, dan keterbukaan layanan publik di bidang kesehatan, pendidikan, dan perizinan.
                            </p>
                        </div>

                        <div class="bg-white p-5 rounded-xl border border-bone-300">
                            <div class="w-10 h-10 rounded-lg bg-rose-50 text-maroon-700 flex items-center justify-center text-lg mb-3">
                                <i class="fa-solid fa-city"></i>
                            </div>
                            <h4 class="font-bold text-sm text-slate-900">Inovasi Kewilayahan & Lingkungan</h4>
                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                Penerapan teknologi ramah lingkungan, lorong wisata cerdas, serta pengelolaan limbah terpadu perkotaan.
                            </p>
                        </div>
                    </div>

                    <!-- Dokumen Panduan & Unduhan Resmi -->
                    <div class="mt-8 pt-6 border-t border-bone-300 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-file-pdf text-2xl text-maroon-700"></i>
                            <div>
                                <span class="font-bold text-xs sm:text-sm text-slate-900 block">Buku Panduan Layanan & Informasi BRIDA</span>
                                <span class="text-[11px] text-slate-500">Pedoman pengusulan riset, konsultasi inovasi, dan permohonan data ilmiah daerah.</span>
                            </div>
                        </div>
                        <a href="{{ asset('docs') }}/Panduan_Pengguna_BRIDA_Makassar.txt" download class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow">
                            <i class="fa-solid fa-download"></i>
                            <span>Unduh Panduan Layanan (TXT)</span>
                        </a>
                    </div>
                </div>

            </div>
        </section>

        <!-- Berita & Informasi BRIDA (Format Portal Berita Nyata Pemda) -->
        <section id="berita" class="py-16 bg-bone-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex items-center justify-between mb-8 pb-3 border-b border-bone-300">
                    <div>
                        <span class="text-xs font-bold tracking-widest uppercase text-maroon-700">Publikasi Resmi</span>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight mt-0.5">Kabar & Kegiatan BRIDA Makassar</h2>
                    </div>
                    <a href="{{ route('berita') }}" class="text-xs font-bold text-maroon-700 hover:text-maroon-800 flex items-center gap-1 hover:underline">
                        <span>Semua Rilis</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <!-- Tata Letak Media Pemda: 1 Berita Sorotan Besar + 3 Berita Daftar -->
                <div class="grid lg:grid-cols-12 gap-6">
                    
                    <!-- Berita Sorotan Utama (Kiri - 7 Kolom) -->
                    <a href="{{ route('berita') }}" class="lg:col-span-7 bg-white rounded-2xl overflow-hidden border border-bone-300 shadow-sm flex flex-col justify-between hover:shadow-md transition group block">
                        <div class="relative h-64 bg-slate-900 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1000&q=80" alt="Rapat Koordinasi Riset Daerah" class="w-full h-full object-cover opacity-85 group-hover:scale-105 transition duration-500">
                            <span class="absolute top-4 left-4 bg-maroon-700 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                Sorotan Utama
                            </span>
                        </div>
                        <div class="p-6 space-y-3">
                            <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                                <span><i class="fa-regular fa-calendar mr-1"></i> November 2026</span>
                                <span>&bull;</span>
                                <span><i class="fa-solid fa-tag mr-1"></i> Kebijakan Riset</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 leading-snug group-hover:text-maroon-700 transition">
                                BRIDA Kota Makassar Matangkan Rencana Induk Riset Daerah Menuju Makassar Rendah Karbon
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">
                                Upaya akselerasi pembangunan perkotaan berbasis sains dan data ilmiah diwujudkan melalui perumusan peta jalan riset komprehensif bersama para akademisi dan pemangku kepentingan daerah.
                            </p>
                        </div>
                    </a>

                    <!-- Daftar Berita Terkait (Kanan - 5 Kolom) -->
                    <div class="lg:col-span-5 space-y-4">
                        
                        <!-- Item 1 -->
                        <a href="{{ route('berita') }}" class="bg-white p-4 rounded-xl border border-bone-300 hover:border-maroon-700 transition flex gap-4 block group">
                            <div class="w-20 h-20 rounded-lg bg-slate-200 overflow-hidden shrink-0">
                                <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=300&q=80" alt="Penyusunan Riset Kebijakan" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="space-y-1">
                                <span class="text-[10px] font-bold text-maroon-700 uppercase">Riset Daerah</span>
                                <h4 class="text-xs font-bold text-slate-900 leading-snug line-clamp-2 group-hover:text-maroon-700 transition">
                                    Penyusunan Peta Jalan Riset Daerah Menuju Makassar Low Carbon City 2027
                                </h4>
                                <span class="text-[10px] text-slate-400 block">28 Oktober 2026</span>
                            </div>
                        </a>

                        <!-- Item 2 -->
                        <a href="{{ route('berita') }}" class="bg-white p-4 rounded-xl border border-bone-300 hover:border-maroon-700 transition flex gap-4 block group">
                            <div class="w-20 h-20 rounded-lg bg-slate-200 overflow-hidden shrink-0">
                                <img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?auto=format&fit=crop&w=300&q=80" alt="Pengukuran Indeks Inovasi" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="space-y-1">
                                <span class="text-[10px] font-bold text-maroon-700 uppercase">Indeks Inovasi</span>
                                <h4 class="text-xs font-bold text-slate-900 leading-snug line-clamp-2 group-hover:text-maroon-700 transition">
                                    Pendampingan Penginputan Data Inovasi OPD untuk Penilaian Innovative Government Award
                                </h4>
                                <span class="text-[10px] text-slate-400 block">20 Oktober 2026</span>
                            </div>
                        </a>

                        <!-- Item 3 -->
                        <a href="{{ route('berita') }}" class="bg-white p-4 rounded-xl border border-bone-300 hover:border-maroon-700 transition flex gap-4 block group">
                            <div class="w-20 h-20 rounded-lg bg-slate-200 overflow-hidden shrink-0">
                                <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=300&q=80" alt="Kerja Sama Universitas" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="space-y-1">
                                <span class="text-[10px] font-bold text-maroon-700 uppercase">Kerja Sama</span>
                                <h4 class="text-xs font-bold text-slate-900 leading-snug line-clamp-2 group-hover:text-maroon-700 transition">
                                    Kolaborasi Pengkajian Sosial Kemasyarakatan Bersama Lembaga Riset Perguruan Tinggi
                                </h4>
                                <span class="text-[10px] text-slate-400 block">12 Oktober 2026</span>
                            </div>
                        </a>

                    </div>

                </div>

            </div>
        </section>

        <!-- Informasi Kontak & Lokasi Kantor Resmi -->
        <section id="kontak" class="py-16 bg-white border-t border-bone-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-12 gap-8 items-center">
                    
                    <div class="lg:col-span-7 space-y-4">
                        <span class="text-xs font-bold tracking-widest uppercase text-maroon-700">Sekretariat Instansi</span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            Badan Riset dan Inovasi Daerah (BRIDA)
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-xl">
                            Silakan menghubungi kami melalui saluran resmi atau berkunjung langsung ke kantor sekretariat BRIDA di Balai Kota Makassar untuk koordinasi program penelitian dan pengusulan inovasi daerah.
                        </p>

                        <div class="grid sm:grid-cols-2 gap-4 pt-2 text-xs">
                            <div class="flex items-start gap-3 p-3.5 rounded-xl bg-bone-100 border border-bone-300">
                                <i class="fa-solid fa-location-dot text-maroon-700 text-base mt-0.5"></i>
                                <div>
                                    <strong class="text-slate-900 block">Alamat Sekretariat</strong>
                                    Balai Kota Makassar, Jl. Ahmad Yani No. 2, Kota Makassar
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3.5 rounded-xl bg-bone-100 border border-bone-300">
                                <i class="fa-solid fa-envelope text-maroon-700 text-base mt-0.5"></i>
                                <div>
                                    <strong class="text-slate-900 block">Surat Elektronik</strong>
                                    brida@makassarkota.go.id
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-5 bg-bone-100 p-6 rounded-2xl border border-bone-300 space-y-4">
                        <h4 class="font-bold text-sm text-slate-900">Tautan Pintasan Resmi</h4>
                        <ul class="text-xs space-y-2 text-slate-600">
                            <li><a href="https://makassarkota.go.id" target="_blank" class="hover:text-maroon-700 flex items-center justify-between py-1 border-b border-bone-300"><span>Portal Resmi Pemerintah Kota Makassar</span><i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i></a></li>
                            <li><a href="https://brin.go.id" target="_blank" class="hover:text-maroon-700 flex items-center justify-between py-1 border-b border-bone-300"><span>Badan Riset dan Inovasi Nasional (BRIN)</span><i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i></a></li>
                            <li><a href="informasi-publik.html#regulasi" class="hover:text-maroon-700 flex items-center justify-between py-1 border-b border-bone-300"><span>Pedoman Pengusulan Inovasi Daerah</span><i class="fa-solid fa-arrow-right text-[10px]"></i></a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
