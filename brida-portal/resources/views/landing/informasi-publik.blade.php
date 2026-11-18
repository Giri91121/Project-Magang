@extends('layouts.landing')

@section('title', 'Informasi Publik & Regulasi Riset - BRIDA Kota Makassar')
@section('meta_description', 'Keterbukaan informasi publik, dokumen regulasi inovasi daerah, laporan kinerja, dan repositori produk hukum BRIDA Pemerintah Kota Makassar.')

@section('content')
<main>
    <!-- Header Banner Halaman -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">Informasi Publik & Regulasi</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                Keterbukaan Informasi Publik & Regulasi Riset
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                Dokumentasi regulasi inovasi daerah, laporan kinerja, statistik ekosistem riset, dan layanan Pejabat Pengelola Informasi dan Dokumentasi (PPID) BRIDA Kota Makassar.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full space-y-16">

        <!-- 3 Kartu Capaian & Keterbukaan Informasi -->
        <section class="grid sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-bone-300 shadow-sm text-center">
                <div class="text-3xl font-black text-maroon-700">120+</div>
                <div class="text-xs font-bold text-slate-800 uppercase mt-1">Inovasi Terdaftar</div>
                <p class="text-[11px] text-slate-500 mt-1">Basis data inovasi perangkat daerah dalam database IGA Kemendagri.</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-bone-300 shadow-sm text-center">
                <div class="text-3xl font-black text-emerald-600">Sangat Inovatif</div>
                <div class="text-xs font-bold text-slate-800 uppercase mt-1">Predikat IID Nasional</div>
                <p class="text-[11px] text-slate-500 mt-1">Penilaian Indeks Inovasi Daerah Kementerian Dalam Negeri RI.</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-bone-300 shadow-sm text-center">
                <div class="text-3xl font-black text-indigo-700">100%</div>
                <div class="text-xs font-bold text-slate-800 uppercase mt-1">Keterbukaan Informasi</div>
                <p class="text-[11px] text-slate-500 mt-1">Akses publik terhadap dokumen kebijakan dan telaahan staf terbuka.</p>
            </div>
        </section>

        <!-- Daftar Regulasi & Repositori PDF Dinamis -->
        <section id="regulasi" class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-bone-300 pb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Payung Hukum</span>
                    <h2 class="text-2xl font-black text-slate-900 mt-0.5">Regulasi Riset & Inovasi Daerah</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1">Dasar hukum penyelenggaraan riset, pembinaan inovasi daerah, serta keterbukaan informasi publik.</p>
                </div>

                <!-- Filter Kategori Dinamis -->
                <div class="flex flex-wrap gap-2 text-xs">
                    <a href="{{ route('informasi-publik') }}#regulasi" class="{{ !request('kategori') ? 'bg-maroon-700 text-white font-bold' : 'bg-white border border-bone-300 text-slate-700 hover:border-maroon-700' }} px-3 py-1.5 rounded-xl transition">Semua</a>
                    <a href="{{ route('informasi-publik', ['kategori' => 'Peraturan Walikota']) }}#regulasi" class="{{ request('kategori') === 'Peraturan Walikota' ? 'bg-maroon-700 text-white font-bold' : 'bg-white border border-bone-300 text-slate-700 hover:border-maroon-700' }} px-3 py-1.5 rounded-xl transition">Peraturan Walikota</a>
                    <a href="{{ route('informasi-publik', ['kategori' => 'Peraturan Daerah']) }}#regulasi" class="{{ request('kategori') === 'Peraturan Daerah' ? 'bg-maroon-700 text-white font-bold' : 'bg-white border border-bone-300 text-slate-700 hover:border-maroon-700' }} px-3 py-1.5 rounded-xl transition">Peraturan Daerah</a>
                    <a href="{{ route('informasi-publik', ['kategori' => 'Pedoman Teknis']) }}#regulasi" class="{{ request('kategori') === 'Pedoman Teknis' ? 'bg-maroon-700 text-white font-bold' : 'bg-white border border-bone-300 text-slate-700 hover:border-maroon-700' }} px-3 py-1.5 rounded-xl transition">Pedoman & SOP</a>
                </div>
            </div>

            <!-- Grid Kartu Regulasi yang Dapat Diunduh -->
            <div class="grid sm:grid-cols-2 gap-6">
                @forelse($regulasiList as $item)
                <div class="bg-white rounded-3xl p-6 border border-bone-300 shadow-sm hover:shadow-md transition flex flex-col justify-between space-y-4 group">
                    <div class="space-y-2.5">
                        <div class="flex items-center justify-between">
                            <span class="text-[11px] font-bold text-maroon-700 bg-rose-50 border border-rose-200 px-3 py-0.5 rounded-full uppercase tracking-wide">
                                {{ $item->kategori }} ({{ $item->tahun }})
                            </span>
                            <span class="text-[11px] text-slate-400">
                                <i class="fa-solid fa-download mr-1"></i> {{ $item->download_count }} x diunduh
                            </span>
                        </div>
                        <h4 class="font-bold text-slate-900 text-base leading-snug group-hover:text-maroon-700 transition">
                            {{ $item->judul_regulasi }}
                        </h4>
                        <p class="font-mono text-xs font-semibold text-slate-500">
                            {{ $item->nomor_peraturan }}
                        </p>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            {{ $item->tentang }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-bone-200 flex items-center justify-between text-xs">
                        <span class="text-slate-400 text-[11px] flex items-center gap-1.5">
                            <i class="fa-regular fa-file-pdf text-rose-600 text-sm"></i>
                            <span>PDF • {{ $item->ukuran_file ?? '1.5 MB' }}</span>
                        </span>
                        <a href="{{ route('regulasi.download', $item->id) }}" class="inline-flex items-center gap-1.5 bg-maroon-700 hover:bg-maroon-800 text-white font-bold px-4 py-2 rounded-xl transition shadow-sm">
                            <i class="fa-solid fa-download text-xs"></i>
                            <span>Unduh Dokumen</span>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-2 py-12 text-center text-slate-400 text-xs">
                    Belum ada dokumen regulasi yang diunggah untuk kategori ini.
                </div>
                @endforelse
            </div>

            <!-- Paginasi -->
            <div class="pt-6">
                {{ $regulasiList->links() }}
            </div>
        </section>

    </div>
</main>
@endsection
