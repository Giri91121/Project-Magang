@extends('layouts.landing')

@section('title', $berita->judul . ' - BRIDA Kota Makassar')
@section('meta_description', $berita->ringkasan)

@section('content')
<main>
    <!-- Header Banner & Breadcrumb -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-10 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-4xl mx-auto">
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <a href="{{ route('berita') }}" class="hover:text-white transition">Berita</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium truncate max-w-xs">{{ $berita->judul }}</span>
            </nav>
            <div class="space-y-3">
                <span class="inline-block bg-rose-500/20 text-rose-300 border border-rose-400/30 text-xs font-bold px-3 py-1 rounded-full uppercase">
                    {{ $berita->kategori }}
                </span>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-white leading-tight">
                    {{ $berita->judul }}
                </h1>
                <div class="flex items-center gap-4 text-xs text-rose-200/80 pt-2 border-t border-rose-400/20">
                    <span><i class="fa-regular fa-calendar mr-1.5"></i> {{ $berita->published_at ? $berita->published_at->format('d F Y') : date('d F Y') }}</span>
                    <span>&bull;</span>
                    <span><i class="fa-regular fa-user mr-1.5"></i> {{ $berita->user->name ?? 'Humas BRIDA Makassar' }}</span>
                    <span>&bull;</span>
                    <span><i class="fa-regular fa-eye mr-1.5"></i> {{ $berita->views }} kali dibaca</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Isi Artikel & Rekomendasi Terkait -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">

        <!-- Foto Sampul Resolusi Penuh -->
        <div class="rounded-3xl overflow-hidden border border-bone-300 shadow-md bg-slate-900">
            <img src="{{ $berita->gambar_url }}" alt="{{ $berita->judul }}" class="w-full max-h-[460px] object-cover">
        </div>

        <!-- Paragraf Ringkasan Highlight -->
        <div class="p-6 rounded-2xl bg-bone-100 border-l-4 border-maroon-700 text-slate-800 text-sm sm:text-base font-semibold leading-relaxed italic">
            "{{ $berita->ringkasan }}"
        </div>

        <!-- Narasi Berita Lengkap -->
        <article class="prose max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
            {!! nl2br($berita->konten) !!}
        </article>

        <!-- Bagian Bagikan Berita -->
        <div class="pt-6 border-t border-bone-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-xs">
            <span class="font-bold text-slate-700">Bagikan Informasi Ini:</span>
            <div class="flex items-center gap-2">
                <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' ' . url()->current()) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>WhatsApp</span>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-3 py-1.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-brands fa-facebook-f text-sm"></i>
                    <span>Facebook</span>
                </a>
                <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berita berhasil disalin ke clipboard!');" class="bg-slate-700 hover:bg-slate-800 text-white font-bold px-3 py-1.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-link text-xs"></i>
                    <span>Salin Tautan</span>
                </button>
            </div>
        </div>

        <!-- Berita Terkait Lainnya -->
        @if($beritaTerkait->count() > 0)
        <div class="pt-10 border-t border-bone-300 space-y-6">
            <h3 class="text-xl font-black text-slate-900">Rilis Terkait Lainnya</h3>
            <div class="grid sm:grid-cols-3 gap-5">
                @foreach($beritaTerkait as $rel)
                <a href="{{ route('berita.detail', $rel->slug) }}" class="bg-white rounded-2xl border border-bone-300 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col group">
                    <div class="h-32 bg-slate-200 overflow-hidden">
                        <img src="{{ $rel->gambar_url }}" alt="{{ $rel->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    </div>
                    <div class="p-4 space-y-1">
                        <span class="text-[10px] text-maroon-700 font-bold uppercase">{{ $rel->kategori }}</span>
                        <h4 class="font-bold text-xs text-slate-900 line-clamp-2 group-hover:text-maroon-700 transition">
                            {{ $rel->judul }}
                        </h4>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</main>
@endsection
