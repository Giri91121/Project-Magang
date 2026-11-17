@extends('layouts.landing')

@section('title', 'Kabar & Kegiatan - BRIDA Kota Makassar')

@section('content')
<!-- Header Banner Halaman -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">Berita & Publikasi</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                Kabar & Publikasi Kegiatan BRIDA
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                Informasi terkini mengenai agenda riset terapan daerah, capaian inovasi SKPD, seminar desiminasi ilmiah, dan kemitraan strategis Pemerintah Kota Makassar.
            </p>
        </div>
    </section>

    <!-- Main Content Berita -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full space-y-12">

        <!-- Sorotan Berita Utama (Featured News) -->
        <section class="bg-white rounded-2xl border border-bone-300 overflow-hidden shadow-sm grid lg:grid-cols-12 gap-0">
            <div class="lg:col-span-7 relative h-72 sm:h-96 bg-slate-900 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1200&q=80" alt="Rapat Koordinasi Riset Daerah" class="w-full h-full object-cover opacity-90 hover:scale-105 transition duration-500">
                <span class="absolute top-4 left-4 bg-maroon-700 text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow">
                    Sorotan Utama
                </span>
            </div>
            <div class="lg:col-span-5 p-6 sm:p-8 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                        <span><i class="fa-regular fa-calendar mr-1"></i> 14 November 2026</span>
                        <span>&bull;</span>
                        <span class="text-maroon-700 font-bold uppercase"><i class="fa-solid fa-tag mr-1"></i> Kebijakan Riset</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-snug hover:text-maroon-700 transition">
                        BRIDA Kota Makassar Matangkan Rencana Induk Riset Daerah Menuju Makassar Rendah Karbon 2027
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Pemerintah Kota Makassar melalui Badan Riset dan Inovasi Daerah (BRIDA) menggelar lokakarya strategis bersama pakar lingkungan, perwakilan perguruan tinggi, dan BRIN guna merumuskan Peta Jalan Riset Rendah Karbon (Low Carbon City) yang berbasis bukti ilmiah dan indikator terukur.
                    </p>
                </div>
                <div class="pt-4 border-t border-bone-300 flex items-center justify-between text-xs text-slate-500">
                    <span>Oleh: <strong>Humas BRIDA Makassar</strong></span>
                    <span class="text-maroon-700 font-bold cursor-pointer hover:underline">Baca Selengkapnya &rarr;</span>
                </div>
            </div>
        </section>

        <!-- Grid Berita & Artikel Terbaru -->
        <section class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-bone-300 pb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Daftar Rilis</span>
                    <h3 class="text-2xl font-black text-slate-900 mt-0.5">Semua Artikel & Kabar Kegiatan</h3>
                </div>
                <!-- Filter Kategori Sederhana -->
                <div class="flex flex-wrap gap-2 text-xs">
                    <button class="bg-maroon-700 text-white font-bold px-3 py-1.5 rounded-lg">Semua</button>
                    <button class="bg-white border border-bone-300 text-slate-700 hover:border-maroon-700 px-3 py-1.5 rounded-lg transition">Riset Daerah</button>
                    <button class="bg-white border border-bone-300 text-slate-700 hover:border-maroon-700 px-3 py-1.5 rounded-lg transition">Inovasi Perangkat Daerah</button>
                    <button class="bg-white border border-bone-300 text-slate-700 hover:border-maroon-700 px-3 py-1.5 rounded-lg transition">Kemitraan Kampus</button>
                </div>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <!-- Artikel 1 -->
                <div class="bg-white rounded-2xl border border-bone-300 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="h-44 bg-slate-200 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=600&q=80" alt="Pendampingan Inovasi" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-5 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-slate-400">
                                <span class="text-maroon-700 font-bold uppercase">Inovasi Daerah</span>
                                <span>&bull;</span>
                                <span>28 Oktober 2026</span>
                            </div>
                            <h4 class="font-bold text-sm text-slate-900 leading-snug hover:text-maroon-700 transition cursor-pointer">
                                Pendampingan Penginputan Data Inovasi OPD untuk Penilaian IGA Kemendagri
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                BRIDA Makassar menggelar desk konsultasi teknis bagi seluruh operator SKPD guna memastikan seluruh kelengkapan eviden indikator kematangan inovasi terunggah sesuai standar Kemendagri.
                            </p>
                        </div>
                    </div>
                    <div class="px-5 pb-5 pt-2 border-t border-bone-300/80 flex items-center justify-between text-xs text-maroon-700 font-bold">
                        <span>Rilis Resmi</span>
                        <span class="hover:underline cursor-pointer">Selengkapnya &rarr;</span>
                    </div>
                </div>

                <!-- Artikel 2 -->
                <div class="bg-white rounded-2xl border border-bone-300 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="h-44 bg-slate-200 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=80" alt="Kerja Sama Universitas" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-5 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-slate-400">
                                <span class="text-maroon-700 font-bold uppercase">Kemitraan Riset</span>
                                <span>&bull;</span>
                                <span>15 Oktober 2026</span>
                            </div>
                            <h4 class="font-bold text-sm text-slate-900 leading-snug hover:text-maroon-700 transition cursor-pointer">
                                Sinergi BRIDA dan Universitas Hasanuddin Perkuat Hilirisasi Riset Maritim Perkotaan
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                Kesepakatan bersama pemanfaatan laboratorium dan hilirisasi produk riset nelayan pesisir Makassar guna memperkuat daya saing ekonomi berbasis potensi kelautan lokal.
                            </p>
                        </div>
                    </div>
                    <div class="px-5 pb-5 pt-2 border-t border-bone-300/80 flex items-center justify-between text-xs text-maroon-700 font-bold">
                        <span>Rilis Resmi</span>
                        <span class="hover:underline cursor-pointer">Selengkapnya &rarr;</span>
                    </div>
                </div>

                <!-- Artikel 3 -->
                <div class="bg-white rounded-2xl border border-bone-300 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="h-44 bg-slate-200 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=600&q=80" alt="Sosialisasi HAKI" class="w-full h-full object-cover hover:scale-105 transition duration-500">
                        </div>
                        <div class="p-5 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-slate-400">
                                <span class="text-maroon-700 font-bold uppercase">Kekayaan Intelektual</span>
                                <span>&bull;</span>
                                <span>02 Oktober 2026</span>
                            </div>
                            <h4 class="font-bold text-sm text-slate-900 leading-snug hover:text-maroon-700 transition cursor-pointer">
                                Fasilitasi Perlindungan Hak Cipta dan Paten bagi Inovator Perangkat Daerah Kota Makassar
                            </h4>
                            <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">
                                Sosialisasi tata cara pendaftaran Hak Kekayaan Intelektual (HAKI) agar karya cipta dan aplikasi pelayanan publik terlindungi secara legal formal.
                            </p>
                        </div>
                    </div>
                    <div class="px-5 pb-5 pt-2 border-t border-bone-300/80 flex items-center justify-between text-xs text-maroon-700 font-bold">
                        <span>Rilis Resmi</span>
                        <span class="hover:underline cursor-pointer">Selengkapnya &rarr;</span>
                    </div>
                </div>

            </div>
        </section>

    </main>
@endsection
