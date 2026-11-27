@extends('layouts.landing')

@section('title', 'Tentang BRIDA, SIGAP & Tim Pengembang - BRIDA Kota Makassar')
@section('meta_description', 'Mengenal Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar, perbedaannya dengan sistem SIGAP, serta profil tim pengembang portal.')

@section('content')
<main>
    <!-- Header Banner Halaman -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">Tentang</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                {{ $portalSettings['tentang_header_title'] ?? 'Tentang BRIDA, SIGAP & Pengembang' }}
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                {{ $portalSettings['tentang_header_subtitle'] ?? 'Mengenal lebih dekat Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar, perannya bersama platform SIGAP, serta tim pengembang di balik portal ini.' }}
            </p>
        </div>
    </section>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14 space-y-12">

        <!-- 1. Apa itu BRIDA? -->
        <section class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-2xl bg-rose-50 border border-rose-200 flex items-center justify-center text-maroon-700 text-lg shrink-0">
                    <i class="fa-solid fa-landmark"></i>
                </div>
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700 block">Profil Kelembagaan</span>
                    <h2 class="text-xl font-black text-slate-900">Apa itu BRIDA?</h2>
                </div>
            </div>
            <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                {{ $portalSettings['tentang_apa_itu_brida'] ?? "Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar adalah perangkat daerah yang menyelenggarakan fungsi penunjang urusan pemerintahan di bidang penelitian, pengembangan, pengkajian, penerapan, serta invensi dan inovasi di daerah.\n\nBRIDA berperan sebagai pusat perumusan kebijakan berbasis bukti ilmiah (evidence-based policy) guna mendorong daya saing dan kemajuan inovasi Pemerintah Kota Makassar." }}
            </p>
        </section>

        <!-- 2. Apa Beda BRIDA dengan SIGAP? -->
        <section class="space-y-5">
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700 block">Perbandingan Peran</span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">Apa Beda BRIDA dengan SIGAP?</h2>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-bone-300 shadow-sm space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 border border-rose-200 text-maroon-700 text-xs font-extrabold">
                        <i class="fa-solid fa-building-columns"></i>
                        <span>BRIDA (Lembaga / Instansi)</span>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $portalSettings['tentang_beda_brida'] ?? 'BRIDA adalah instansi resmi Pemerintah Kota Makassar yang bertugas mengoordinasikan kegiatan riset, kajian kebijakan strategis, dan pembinaan ekosistem inovasi daerah.' }}
                    </p>
                </div>

                <div class="bg-white rounded-3xl p-6 sm:p-7 border border-bone-300 shadow-sm space-y-3">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-extrabold">
                        <i class="fa-solid fa-laptop-code"></i>
                        <span>SIGAP (Sistem / Platform Digital)</span>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                        {{ $portalSettings['tentang_beda_sigap'] ?? 'SIGAP adalah sistem informasi atau platform digital yang digunakan untuk mendukung pelayanan publik, publikasi informasi, serta tata kelola data dan keterbukaan informasi secara cepat dan terintegrasi.' }}
                    </p>
                </div>
            </div>
        </section>

        <!-- 3. Profil Tim Developer -->
        <section class="space-y-5">
            <div>
                <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700 block">Tim Pengembang</span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">Profil Tim Developer Portal</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    {{ $portalSettings['tentang_dev_intro'] ?? 'Portal ini dirancang dan dibangun oleh tim mahasiswa magang sebagai kontribusi nyata dalam digitalisasi layanan informasi BRIDA Kota Makassar.' }}
                </p>
            </div>

            @php
                $developers = [
                    [
                        'nama' => 'Giri Kencana Jati',
                        'foto' => 'images/giri.png',
                    ],
                    [
                        'nama' => 'Muh. Ilham Yusal',
                        'foto' => 'images/ilham.jpg',
                    ],
                ];
            @endphp

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($developers as $dev)
                    <div class="bg-white rounded-3xl p-6 border border-bone-300 shadow-sm flex items-center gap-4
                    hover:shadow-md transition">
                        <img src="{{ asset($dev['foto']) }}" alt="{{ $dev['nama'] }}" class="w-12 h-12 rounded-2xl
                        object-cover shrink-0 shadow-sm border border-bone-200">
                        <div class="min-w-0">
                            <h3 class="text-sm font-black text-slate-900 truncate">{{ $dev['nama'] }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
</main>
@endsection
