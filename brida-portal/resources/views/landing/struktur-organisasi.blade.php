@extends('layouts.landing')

@section('title', 'Struktur Organisasi - BRIDA Kota Makassar')
@section('meta_description', 'Struktur Organisasi Badan Riset dan Inovasi Daerah (BRIDA) Pemerintah Kota Makassar.')

@section('content')
<main>
    <!-- Header Banner Halaman -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <a href="{{ route('pemerintahan') }}" class="hover:text-white transition">Pemerintahan</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">Struktur Organisasi</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                Struktur Organisasi
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                Susunan organisasi dan tata kerja Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar.
            </p>
        </div>
    </section>

    <!-- Area Konten Kosong (Siap Diisi Detail Nanti) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 min-h-[50vh] flex items-center justify-center">
        <div class="text-center space-y-3 max-w-md">
            <div class="w-16 h-16 rounded-2xl bg-bone-200 border border-bone-300 text-maroon-700 flex items-center justify-center mx-auto text-2xl">
                <i class="fa-solid fa-sitemap"></i>
            </div>
            <h2 class="text-lg font-extrabold text-slate-800">Struktur Organisasi BRIDA Kota Makassar</h2>
            <p class="text-xs text-slate-500 leading-relaxed">
                Halaman ini sedang disiapkan dan akan segera dilengkapi dengan bagan serta detail struktur organisasi resmi.
            </p>
        </div>
    </div>
</main>
@endsection
