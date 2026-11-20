@extends('layouts.landing')

@section('title', 'Kabar & Publikasi Kegiatan - BRIDA Kota Makassar')
@section('meta_description', 'Portal berita resmi Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar, menyajikan agenda riset, capaian inovasi SKPD, dan kemitraan ilmiah.')

@section('content')
<main>
    <!-- Header Banner Halaman -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">Berita & Publikasi</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                {{ $settings['berita_header_title'] ?? 'Kabar & Publikasi Resmi BRIDA' }}
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                {{ $settings['berita_header_subtitle'] ?? 'Informasi terkini mengenai agenda riset terapan daerah, capaian inovasi SKPD, seminar diseminasi ilmiah, dan kemitraan strategis Pemerintah Kota Makassar.' }}
            </p>
        </div>
    </section>

    <!-- Main Content Berita -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full space-y-12">

        <!-- Sorotan Berita Utama (Featured News) -->
        @if($sorotan)
        <section class="bg-white rounded-3xl border border-bone-300 overflow-hidden shadow-sm grid lg:grid-cols-12 gap-0 hover:shadow-md transition">
            <div class="lg:col-span-7 relative h-72 sm:h-96 bg-slate-900 overflow-hidden">
                <img src="{{ $sorotan->gambar_url }}" alt="{{ $sorotan->judul }}" class="w-full h-full object-cover opacity-90 hover:scale-105 transition duration-500">
                <span class="absolute top-4 left-4 bg-maroon-700 text-white text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow">
                    Sorotan Utama
                </span>
            </div>
            <div class="lg:col-span-5 p-6 sm:p-8 flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                        <span><i class="fa-regular fa-calendar mr-1"></i> {{ $sorotan->published_at ? $sorotan->published_at->format('d F Y') : date('d F Y') }}</span>
                        <span>&bull;</span>
                        <span class="text-maroon-700 font-bold uppercase"><i class="fa-solid fa-tag mr-1"></i> {{ $sorotan->kategori }}</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-snug hover:text-maroon-700 transition">
                        <a href="{{ route('berita.detail', $sorotan->slug) }}">{{ $sorotan->judul }}</a>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed line-clamp-4">
                        {{ $sorotan->ringkasan }}
                    </p>
                </div>
                <div class="pt-4 border-t border-bone-300 flex items-center justify-between text-xs text-slate-500">
                    <span>Oleh: <strong>Humas BRIDA Makassar</strong></span>
                    <a href="{{ route('berita.detail', $sorotan->slug) }}" class="text-maroon-700 font-bold hover:underline inline-flex items-center gap-1">
                        <span>Baca Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </section>
        @endif

        <!-- Grid Berita & Artikel Terbaru -->
        <section class="space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-bone-300 pb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Daftar Rilis</span>
                    <h3 class="text-2xl font-black text-slate-900 mt-0.5">Semua Artikel & Kabar Kegiatan</h3>
                </div>
                
                <!-- Filter Kategori Dinamis -->
                @php
                    $kategoriRaw = $settings['berita_kategori_list'] ?? 'Kebijakan Riset, Inovasi Daerah, Kemitraan Kampus, Agenda BRIDA';
                    $kategoriItems = array_filter(array_map('trim', explode(',', $kategoriRaw)));
                @endphp
                <div class="flex flex-wrap gap-2 text-xs">
                    <a href="{{ route('berita') }}" class="{{ !request('kategori') ? 'bg-maroon-700 text-white font-bold' : 'bg-white border border-bone-300 text-slate-700 hover:border-maroon-700' }} px-3 py-1.5 rounded-xl transition">Semua</a>
                    @foreach($kategoriItems as $kat)
                        <a href="{{ route('berita', ['kategori' => $kat]) }}" class="{{ request('kategori') === $kat ? 'bg-maroon-700 text-white font-bold' : 'bg-white border border-bone-300 text-slate-700 hover:border-maroon-700' }} px-3 py-1.5 rounded-xl transition">{{ $kat }}</a>
                    @endforeach
                </div>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($beritaList as $item)
                <div class="bg-white rounded-3xl border border-bone-300 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between group">
                    <div>
                        <div class="h-48 bg-slate-200 overflow-hidden relative">
                            <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm text-maroon-800 text-[10px] font-bold px-2.5 py-0.5 rounded-md">
                                {{ $item->kategori }}
                            </span>
                        </div>
                        <div class="p-6 space-y-2">
                            <div class="flex items-center gap-2 text-[11px] text-slate-400">
                                <span><i class="fa-regular fa-calendar mr-1"></i> {{ $item->published_at ? $item->published_at->format('d M Y') : date('d M Y') }}</span>
                                <span>&bull;</span>
                                <span><i class="fa-regular fa-eye mr-1"></i> {{ $item->views }} x dibaca</span>
                            </div>
                            <h4 class="font-bold text-slate-900 text-sm leading-snug group-hover:text-maroon-700 transition line-clamp-2">
                                <a href="{{ route('berita.detail', $item->slug) }}">{{ $item->judul }}</a>
                            </h4>
                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed">
                                {{ $item->ringkasan }}
                            </p>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="{{ route('berita.detail', $item->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-maroon-700 hover:underline">
                            <span>Baca Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 py-12 text-center text-slate-400 text-xs">
                    <i class="fa-regular fa-newspaper text-3xl text-slate-300 block mb-2"></i>
                    Belum ada artikel berita untuk kategori ini.
                </div>
                @endforelse
            </div>

            <!-- Paginasi Berita -->
            <div class="pt-6">
                {{ $beritaList->links() }}
            </div>
        </section>

    </div>
</main>
@endsection
