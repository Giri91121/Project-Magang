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

                <!-- Tata Letak Media Pemda: 1 Berita Sorotan Besar + 3 Berita Daftar (Dinamis dari Database) -->
                @php
                    $beritaUtama = $beritaTerbaru->first();
                    $beritaSamping = $beritaTerbaru->skip(1);
                @endphp
                <div class="grid lg:grid-cols-12 gap-6">
                    
                    @if($beritaUtama)
                    <!-- Berita Sorotan Utama (Kiri - 7 Kolom) -->
                    <a href="{{ route('berita.detail', $beritaUtama->slug) }}" class="lg:col-span-7 bg-white rounded-3xl overflow-hidden border border-bone-300 shadow-sm flex flex-col justify-between hover:shadow-md transition group block">
                        <div class="relative h-64 sm:h-72 bg-slate-900 overflow-hidden">
                            <img src="{{ $beritaUtama->gambar_url }}" alt="{{ $beritaUtama->judul }}" class="w-full h-full object-cover opacity-85 group-hover:scale-105 transition duration-500">
                            <span class="absolute top-4 left-4 bg-maroon-700 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow">
                                Sorotan Utama
                            </span>
                        </div>
                        <div class="p-6 space-y-3">
                            <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                                <span><i class="fa-regular fa-calendar mr-1"></i> {{ $beritaUtama->published_at ? $beritaUtama->published_at->format('d F Y') : date('d F Y') }}</span>
                                <span>&bull;</span>
                                <span class="text-maroon-700 font-bold"><i class="fa-solid fa-tag mr-1"></i> {{ $beritaUtama->kategori }}</span>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 leading-snug group-hover:text-maroon-700 transition">
                                {{ $beritaUtama->judul }}
                            </h3>
                            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-3">
                                {{ $beritaUtama->ringkasan }}
                            </p>
                        </div>
                    </a>
                    @endif

                    <!-- Daftar Berita Terkait (Kanan - 5 Kolom) -->
                    <div class="lg:col-span-5 space-y-4">
                        @forelse($beritaSamping as $item)
                        <a href="{{ route('berita.detail', $item->slug) }}" class="bg-white p-4 rounded-2xl border border-bone-300 hover:border-maroon-700 transition flex gap-4 block group shadow-sm hover:shadow-md">
                            <div class="w-20 h-20 rounded-xl bg-slate-200 overflow-hidden shrink-0">
                                <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </div>
                            <div class="space-y-1 min-w-0">
                                <span class="text-[10px] font-bold text-maroon-700 uppercase">{{ $item->kategori }}</span>
                                <h4 class="text-xs font-bold text-slate-900 leading-snug line-clamp-2 group-hover:text-maroon-700 transition">
                                    {{ $item->judul }}
                                </h4>
                                <span class="text-[10px] text-slate-400 block">{{ $item->published_at ? $item->published_at->format('d M Y') : date('d M Y') }}</span>
                            </div>
                        </a>
                        @empty
                        <div class="p-6 bg-white rounded-2xl border border-bone-300 text-center text-xs text-slate-400">
                            Belum ada rilis berita tambahan.
                        </div>
                        @endforelse
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
