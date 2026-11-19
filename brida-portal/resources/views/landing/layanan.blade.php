@extends('layouts.landing')

@section('title', 'Layanan Riset & Inovasi Daerah - BRIDA Kota Makassar')

@section('content')
<!-- Header Banner Halaman (Breadcrumb & Title) -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <!-- Breadcrumbs -->
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">Layanan Riset & Inovasi</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                Katalog Layanan Terpadu BRIDA
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                Fasilitasi riset kebijakan berbasis bukti ilmiah, rekomendasi izin penelitian, pendampingan inovasi perangkat daerah, serta kemitraan riset perguruan tinggi dan BRIN.
            </p>
        </div>
    </section>

    <!-- Main Content Layanan -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full space-y-16">
        
        <!-- Klaster Layanan Utama Detail (Dinamis dari Database LandingService) -->
        <section class="space-y-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">{{ $portalSettings['layanan_section_badge'] ?? 'Pelayanan Prima' }}</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $portalSettings['layanan_section_title'] ?? 'Layanan Terpadu BRIDA Kota Makassar' }}</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">{{ $portalSettings['layanan_section_desc'] ?? 'Disediakan secara transparan, akuntabel, dan bebas biaya retribusi (gratis) bagi seluruh pemangku kepentingan.' }}</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                @foreach($landingServices as $index => $srv)
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-bone-300 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl mb-4">
                            <i class="{{ $srv->icon }}"></i>
                        </div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-maroon-700 bg-rose-50 px-2.5 py-1 rounded-full">
                            {{ $srv->kategori_badge ?? 'Layanan Publik' }}
                        </span>
                        <h3 class="text-xl font-bold text-slate-900 mt-3 mb-2">{{ $index + 1 }}. {{ $srv->judul }}</h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                            {{ $srv->deskripsi }}
                        </p>
                    </div>

                    <div class="bg-bone-100 rounded-xl p-4 border border-bone-300 space-y-2 text-xs">
                        <h4 class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i> {{ $srv->detail_title ?? 'Persyaratan & Cakupan:' }}
                        </h4>
                        @if(count($srv->detail_items_array) > 0)
                        <ul class="list-disc list-inside text-slate-600 space-y-1 pl-1">
                            @foreach($srv->detail_items_array as $poin)
                                <li>{{ $poin }}</li>
                            @endforeach
                        </ul>
                        @endif
                        <div class="pt-2 border-t border-bone-300/80 flex items-center justify-between text-[11px] text-slate-500">
                            <span><i class="fa-regular fa-clock mr-1"></i> {{ $srv->estimasi_info ?? 'Estimasi: 1 - 3 Hari Kerja' }}</span>
                            <span class="font-bold text-emerald-600">{{ $srv->biaya_info ?? 'Biaya: Rp 0 (Gratis)' }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Alur Standar Pelayanan (SOP) -->
        <section class="bg-white rounded-2xl p-8 border border-bone-300 shadow-sm">
            <div class="border-b border-bone-300 pb-4 mb-6">
                <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Standar Operasional Prosedur</span>
                <h3 class="text-2xl font-black text-slate-900 mt-1">Alur Pengajuan Permohonan Layanan Riset</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Tahapan resmi pemohon riset untuk mendapatkan rekomendasi dari BRIDA Kota Makassar.</p>
            </div>

            <div class="grid sm:grid-cols-4 gap-6 relative">
                <!-- Langkah 1 -->
                <div class="bg-bone-100 p-5 rounded-xl border border-bone-300 text-center relative">
                    <div class="w-10 h-10 rounded-full bg-maroon-700 text-white font-bold flex items-center justify-center mx-auto mb-3 shadow">
                        1
                    </div>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">Siapkan Berkas</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Lengkapi surat pengantar instansi/kampus dan proposal riset dalam format PDF.</p>
                </div>

                <!-- Langkah 2 -->
                <div class="bg-bone-100 p-5 rounded-xl border border-bone-300 text-center relative">
                    <div class="w-10 h-10 rounded-full bg-maroon-700 text-white font-bold flex items-center justify-center mx-auto mb-3 shadow">
                        2
                    </div>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">Registrasi Portal</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Masuk menggunakan akun Google Anda dan ajukan permohonan melalui Dashboard.</p>
                </div>

                <!-- Langkah 3 -->
                <div class="bg-bone-100 p-5 rounded-xl border border-bone-300 text-center relative">
                    <div class="w-10 h-10 rounded-full bg-maroon-700 text-white font-bold flex items-center justify-center mx-auto mb-3 shadow">
                        3
                    </div>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">Verifikasi & Telaah</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Tim Verifikator Riset BRIDA memeriksa kesesuaian lokasi dan substansi kajian.</p>
                </div>

                <!-- Langkah 4 -->
                <div class="bg-bone-100 p-5 rounded-xl border border-bone-300 text-center relative">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white font-bold flex items-center justify-center mx-auto mb-3 shadow">
                        4
                    </div>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">Terbit Rekomendasi</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">Surat Rekomendasi Penelitian resmi ber-QR Code dapat langsung diunduh & dicetak.</p>
                </div>
            </div>
        </section>

    </main>
@endsection
