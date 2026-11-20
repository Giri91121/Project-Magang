@extends('layouts.landing')

@section('title', 'BRIDA Kota Makassar - Badan Riset dan Inovasi Daerah')

@section('content')
<main>
        <!-- Hero Banner Portal Pemda (Slideshow & Teks Dinamis dari Dashboard) -->
        <section id="beranda" class="relative overflow-hidden bg-slate-900 text-white min-h-[calc(100vh-7.5rem)] flex items-center justify-center">
            <!-- Background Slideshow Auto-Crop & Full-Cover -->
            <div id="hero-slideshow" class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
                @forelse($heroSlides as $index => $slide)
                    <img
                        src="{{ $slide->gambar_url }}"
                        alt="{{ $slide->judul_alt }}"
                        class="hero-slide {{ $index === 0 ? 'active' : '' }}"
                    >
                @empty
                    <img
                        src="{{ asset('images/slide1.jpg') }}"
                        alt="Dokumentasi Kegiatan BRIDA Makassar"
                        class="hero-slide active"
                    >
                @endforelse
                <!-- Lapisan Gradasi Warna Elegan Transparan -->
                <div class="absolute inset-0 bg-gradient-to-r from-maroon-950/50 via-slate-950/30 to-black/20 z-10"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative z-10 w-full">
                <div class="grid lg:grid-cols-12 gap-10 items-center">
                    
                    <!-- Sisi Kiri: Headline Resmi Pemerintahan (Dinamis Teks & Warna dari Dashboard) -->
                    <div class="lg:col-span-12 max-w-4xl space-y-6">
                        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight drop-shadow-md">
                            <span style="color: {{ $portalSettings['hero_title_1_color'] ?? '#FDFDFB' }};">
                                {{ $portalSettings['hero_title_1'] ?? 'Mendorong Inovasi Berbasis Riset, Mewujudkan' }}
                            </span>
                            <span style="color: {{ $portalSettings['hero_title_highlight_color'] ?? '#FB7185' }};">
                                {{ $portalSettings['hero_title_highlight'] ?? 'Makassar Kota Dunia' }}
                            </span>
                            <span style="color: {{ $portalSettings['hero_title_2_color'] ?? '#FDFDFB' }};">
                                {{ $portalSettings['hero_title_2'] ?? 'yang Berdaya Saing.' }}
                            </span>
                        </h1>

                        <p class="text-base sm:text-lg max-w-2xl leading-relaxed font-normal drop-shadow-sm" style="color: {{ $portalSettings['hero_subtitle_color'] ?? '#FAF9F5' }};">
                            {{ $portalSettings['hero_subtitle'] ?? 'Selamat datang di Portal Resmi Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar. Kami mengoordinasikan ekosistem riset terapan, pendampingan inovasi perangkat daerah, serta perumusan rekomendasi kebijakan pembangunan daerah berbasis data dan bukti ilmiah.' }}
                        </p>

                        <!-- Tombol Aksi Cepat Portal -->
                        <div class="flex flex-wrap gap-4 pt-2">
                            <a href="{{ $portalSettings['hero_btn1_url'] ?? route('layanan') }}" 
                               style="background-color: {{ $portalSettings['hero_btn1_bg_color'] ?? '#BE123C' }}; color: {{ $portalSettings['hero_btn1_text_color'] ?? '#FFFFFF' }};"
                               class="inline-flex items-center gap-2.5 hover:opacity-90 font-bold px-6 py-3.5 rounded-xl transition shadow-lg shadow-rose-950/40 text-sm">
                                <span>{{ $portalSettings['hero_btn1_text'] ?? 'Layanan & Fasilitasi Riset' }}</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <a href="{{ $portalSettings['hero_btn2_url'] ?? route('informasi-publik') }}" class="inline-flex items-center gap-2.5 bg-white/10 hover:bg-white/20 text-bone-100 font-bold px-6 py-3.5 rounded-xl border border-white/20 transition text-sm">
                                <i class="fa-solid fa-lightbulb text-rose-400"></i>
                                <span>{{ $portalSettings['hero_btn2_text'] ?? 'Ekosistem Inovasi Daerah' }}</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Section Baru: Pimpinan Daerah & Pimpinan BRIDA Kota Makassar -->
        <section id="pimpinan" class="py-16 bg-bone-100 border-b border-bone-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="text-center max-w-2xl mx-auto mb-12 space-y-2">
                    <span class="text-xs font-bold tracking-widest uppercase text-maroon-700">
                        {{ $portalSettings['leader_section_badge'] ?? 'Pimpinan Daerah & Lembaga' }}
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                        {{ $portalSettings['leader_section_title'] ?? 'Pimpinan Pemerintah Kota & BRIDA Makassar' }}
                    </h2>
                    <div class="w-16 h-1 bg-maroon-700 mx-auto rounded-full mt-2"></div>
                </div>

                @php
                    $defaultLeaders = [
                        1 => ['name' => 'Munafri Arifuddin, S.H.', 'title' => 'Wali Kota Makassar'],
                        2 => ['name' => 'Aliyah Mustika Ilham, S.E.', 'title' => 'Wakil Wali Kota Makassar'],
                        3 => ['name' => 'Kepala Badan BRIDA Kota Makassar', 'title' => 'Kepala Badan BRIDA'],
                        4 => ['name' => 'Sekretaris Badan BRIDA Kota Makassar', 'title' => 'Sekretaris Badan BRIDA'],
                    ];
                @endphp

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-7">
                    @for($l = 1; $l <= 4; $l++)
                    @php
                        $lName = $portalSettings["leader_{$l}_name"] ?? $defaultLeaders[$l]['name'];
                        $lTitle = $portalSettings["leader_{$l}_title"] ?? $defaultLeaders[$l]['title'];
                        $lPhoto = $portalSettings["leader_{$l}_photo"] ?? '';
                    @endphp
                    <div class="bg-white rounded-2xl border border-bone-300 overflow-hidden shadow-sm hover:shadow-lg hover:border-maroon-700/50 transition group flex flex-col">
                        <!-- Bingkai Foto Formal Potret 3:4 -->
                        <div class="relative aspect-[3/4] bg-gradient-to-b from-bone-200 to-bone-100 overflow-hidden flex items-end justify-center">
                            @if(!empty($lPhoto))
                                <img src="{{ $lPhoto }}" alt="{{ $lName }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500">
                            @else
                                <!-- Placeholder Elegan Sebelum Foto Asli Diunggah di Dashboard -->
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                    <div class="w-20 h-20 rounded-full bg-bone-300/70 flex items-center justify-center text-3xl text-maroon-700/60 mb-2">
                                        <i class="fa-solid fa-user-tie"></i>
                                    </div>
                                    <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-400">Foto {{ $lTitle }}</span>
                                </div>
                            @endif
                            <div class="absolute inset-x-0 bottom-0 h-16 bg-gradient-to-t from-black/40 to-transparent pointer-events-none"></div>
                        </div>

                        <!-- Nama & Jabatan Resmi -->
                        <div class="p-4 sm:p-5 text-center flex-1 flex flex-col justify-center space-y-1.5 bg-white">
                            <span class="inline-block mx-auto bg-rose-50 text-maroon-700 border border-rose-200 text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full">
                                {{ $lTitle }}
                            </span>
                            <h3 class="font-extrabold text-slate-900 text-xs sm:text-sm leading-snug pt-0.5">
                                {{ $lName }}
                            </h3>
                        </div>
                    </div>
                    @endfor
                </div>

            </div>
        </section>

        <!-- Layanan Utama BRIDA Kota Makassar (Dinamis dari Database LandingService) -->
        <section id="layanan" class="py-16 bg-white border-b border-bone-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                    <div>
                        <span class="text-xs font-bold tracking-widest uppercase text-maroon-700">{{ $portalSettings['layanan_section_badge'] ?? 'Layanan Publik & Kedinasan' }}</span>
                        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">{{ $portalSettings['layanan_section_title'] ?? 'Layanan Terpadu BRIDA Kota Makassar' }}</h2>
                        <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-xl">{{ $portalSettings['layanan_section_desc'] ?? 'Akses layanan pengusulan riset kebijakan, fasilitasi inovasi daerah, serta kemitraan ilmiah.' }}</p>
                    </div>
                    <span class="text-xs font-semibold text-slate-400 bg-bone-100 px-3 py-1.5 rounded-lg border border-bone-300 w-fit">
                        Sistem Terintegrasi Pemkot Makassar
                    </span>
                </div>

                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($landingServices as $srv)
                    <a href="{{ $srv->link_url }}" class="bg-bone-100/70 border border-bone-300 rounded-xl p-6 hover:border-maroon-700 transition group flex flex-col justify-between block">
                        <div class="space-y-3">
                            <div class="w-11 h-11 rounded-lg bg-maroon-700 text-white flex items-center justify-center text-lg">
                                <i class="{{ $srv->icon }}"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-base group-hover:text-maroon-700 transition">{{ $srv->judul }}</h3>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                {{ $srv->deskripsi }}
                            </p>
                        </div>
                        <div class="pt-4 border-t border-bone-300/80 mt-4">
                            <span class="text-xs font-bold text-maroon-700 flex items-center gap-1.5 group-hover:translate-x-1 transition-transform">
                                <span>{{ $srv->link_text }}</span>
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </span>
                        </div>
                    </a>
                    @endforeach
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

                <!-- 3 Postingan Terbaru Instagram @bridakotamakassar (Otomatis dari InstagramFeedService) -->
                <div class="mt-14 pt-10 border-t border-bone-300">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-7">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 text-white flex items-center justify-center text-lg shadow-sm shrink-0">
                                <i class="fa-brands fa-instagram"></i>
                            </div>
                            <div>
                                <span class="text-[11px] font-bold tracking-widest uppercase text-maroon-700">Media Sosial Resmi</span>
                                <h3 class="text-xl font-black text-slate-900 tracking-tight">
                                    Postingan Terbaru Instagram {{ $portalSettings['ig_username'] ?? '@bridakotamakassar' }}
                                </h3>
                            </div>
                        </div>
                        <a href="{{ $portalSettings['ig_profile_url'] ?? 'https://www.instagram.com/bridakotamakassar/' }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 bg-white hover:bg-maroon-700 text-maroon-700 hover:text-white border border-maroon-700/30 font-bold text-xs px-4 py-2 rounded-xl transition shadow-sm w-fit">
                            <i class="fa-brands fa-instagram text-sm"></i>
                            <span>Ikuti @bridakotamakassar</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($instagramPosts as $post)
                        <a href="{{ $post['url'] }}" target="_blank" rel="noopener noreferrer" class="bg-white rounded-2xl border border-bone-300 overflow-hidden shadow-sm hover:shadow-md hover:border-maroon-700 transition group flex flex-col justify-between">
                            <div>
                                <!-- Header Mini Kartu Instagram -->
                                <div class="px-4 py-3 flex items-center justify-between border-b border-bone-200/80">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-7 h-7 rounded-full bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 p-[2px] shrink-0">
                                            <div class="w-full h-full rounded-full bg-white flex items-center justify-center text-[10px] font-black text-maroon-700">
                                                BR
                                            </div>
                                        </div>
                                        <span class="text-xs font-bold text-slate-800 truncate">{{ $portalSettings['ig_username'] ?? '@bridakotamakassar' }}</span>
                                    </div>
                                    <div class="flex items-center gap-1.5">
                                        @if(($post['media_type'] ?? '') === 'VIDEO')
                                            <span class="text-[9px] font-bold bg-rose-50 text-rose-600 px-1.5 py-0.5 rounded">REELS</span>
                                        @endif
                                        <i class="fa-brands fa-instagram text-rose-500 text-sm"></i>
                                    </div>
                                </div>

                                <!-- Foto Postingan Instagram -->
                                <div class="relative aspect-[4/3] bg-slate-900 overflow-hidden">
                                    <img src="{{ $post['image'] }}" alt="Postingan Instagram @bridakotamakassar" class="w-full h-full object-cover group-hover:scale-105 transition duration-500" loading="lazy">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition flex items-center justify-center">
                                        <span class="opacity-0 group-hover:opacity-100 transition bg-white/95 text-slate-900 text-[11px] font-bold px-3 py-1.5 rounded-full shadow flex items-center gap-1.5">
                                            <i class="fa-brands fa-instagram text-rose-600"></i> Lihat di Instagram
                                        </span>
                                    </div>
                                </div>

                                <!-- Caption Singkat -->
                                <div class="p-4">
                                    <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                                        <strong class="text-slate-900 mr-1">{{ ltrim($portalSettings['ig_username'] ?? 'bridakotamakassar', '@') }}</strong>
                                        {{ $post['caption'] }}
                                    </p>
                                </div>
                            </div>

                            <!-- Footer Waktu Postingan -->
                            <div class="px-4 py-2.5 border-t border-bone-200/70 bg-bone-50/50 flex items-center justify-between text-[10px] text-slate-400">
                                <span><i class="fa-regular fa-clock mr-1"></i> {{ $post['date'] }}</span>
                                <span class="font-bold text-maroon-700 group-hover:underline">Buka Postingan &rarr;</span>
                            </div>
                        </a>
                        @endforeach
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
                                    {{ $portalSettings['office_address'] ?? 'Balai Kota Makassar, Jl. Ahmad Yani No. 2, Kota Makassar' }}
                                </div>
                            </div>

                            <div class="flex items-start gap-3 p-3.5 rounded-xl bg-bone-100 border border-bone-300">
                                <i class="fa-solid fa-envelope text-maroon-700 text-base mt-0.5"></i>
                                <div>
                                    <strong class="text-slate-900 block">Surat Elektronik</strong>
                                    {{ $portalSettings['contact_email'] ?? 'brida@makassarkota.go.id' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-5 bg-bone-100 p-6 rounded-2xl border border-bone-300 space-y-4">
                        <h4 class="font-bold text-sm text-slate-900">Tautan Pintasan Resmi</h4>
                        <ul class="text-xs space-y-2 text-slate-600">
                            <li><a href="{{ $portalSettings['quicklink_1_url'] ?? 'https://makassarkota.go.id' }}" target="_blank" class="hover:text-maroon-700 flex items-center justify-between py-1 border-b border-bone-300"><span>{{ $portalSettings['quicklink_1_label'] ?? 'Portal Resmi Pemerintah Kota Makassar' }}</span><i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i></a></li>
                            <li><a href="{{ $portalSettings['quicklink_2_url'] ?? 'https://brin.go.id' }}" target="_blank" class="hover:text-maroon-700 flex items-center justify-between py-1 border-b border-bone-300"><span>{{ $portalSettings['quicklink_2_label'] ?? 'Badan Riset dan Inovasi Nasional (BRIN)' }}</span><i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i></a></li>
                            <li><a href="{{ $portalSettings['quicklink_3_url'] ?? '/informasi-publik#regulasi' }}" class="hover:text-maroon-700 flex items-center justify-between py-1 border-b border-bone-300"><span>{{ $portalSettings['quicklink_3_label'] ?? 'Pedoman Pengusulan Inovasi Daerah' }}</span><i class="fa-solid fa-arrow-right text-[10px]"></i></a></li>
                        </ul>
                    </div>

                </div>
            </div>
        </section>
    </main>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('#hero-slideshow .hero-slide');
    if (slides.length > 1) {
        let current = 0;
        const intervalMs = {{ max(2, (int)($portalSettings['hero_slide_interval'] ?? 5)) * 1000 }};
        setInterval(() => {
            slides[current].classList.remove('active');
            current = (current + 1) % slides.length;
            slides[current].classList.add('active');
        }, intervalMs);
    }
});
</script>
@endsection
