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
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" onclick="navigator.clipboard.writeText(window.location.href); window.showBridaAlert('success', 'Tautan Tersalin!', 'Tautan berita berhasil disalin ke clipboard Anda.');" class="bg-slate-700 hover:bg-slate-800 text-white font-bold px-3 py-1.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-solid fa-link text-xs"></i>
                    <span>Salin Link</span>
                </button>
                <a href="https://api.whatsapp.com/send?text={{ urlencode($berita->judul . ' ' . url()->current()) }}" target="_blank" rel="noopener noreferrer" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    <span>WA</span>
                </a>
                <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" onclick="navigator.clipboard.writeText(window.location.href); if(window.showBridaAlert) window.showBridaAlert('info', 'Tautan Tersalin!', 'Tautan disalin ke clipboard. Silakan tempel di Instagram Anda.');" class="bg-gradient-to-r from-rose-600 to-pink-600 hover:from-rose-700 hover:to-pink-700 text-white font-bold px-3 py-1.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-brands fa-instagram text-sm"></i>
                    <span>IG</span>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-3 py-1.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-brands fa-facebook-f text-sm"></i>
                    <span>FB</span>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($berita->judul) }}" target="_blank" rel="noopener noreferrer" class="bg-slate-900 hover:bg-black text-white font-bold px-3 py-1.5 rounded-xl transition flex items-center gap-1.5 shadow-sm">
                    <i class="fa-brands fa-x-twitter text-xs"></i>
                    <span>X</span>
                </a>
            </div>
        </div>

        <!-- Bagian Kolom Komentar & Tanggapan Publik (Wajib Login) -->
        @if(($settings['berita_komentar_aktif'] ?? '1') === '1')
        <section id="kolom-komentar" class="pt-10 border-t border-bone-300 space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-black text-slate-900 flex items-center gap-2">
                    <i class="fa-regular fa-comments text-maroon-700"></i>
                    <span>Komentar & Tanggapan ({{ $berita->komentars->count() }})</span>
                </h3>
            </div>

            @if(session('success_komentar'))
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i>
                    <span>{{ session('success_komentar') }}</span>
                </div>
            @endif

            @auth
                <!-- Formulir Tulis Komentar (Khusus Pengguna yang Sudah Login) -->
                <form method="POST" action="{{ route('berita.komentar.store', $berita->slug) }}" class="bg-white rounded-3xl p-6 border border-bone-300 shadow-sm space-y-4">
                    @csrf
                    <x-honeypot />
                    <div class="flex items-center gap-3 pb-2 border-b border-bone-200">
                        <div class="w-9 h-9 rounded-xl bg-maroon-700 text-white font-bold text-xs flex items-center justify-center shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div>
                            <span class="text-xs font-bold text-slate-900 block">{{ Auth::user()->name }}</span>
                            <span class="text-[10px] font-semibold text-maroon-700">{{ Auth::user()->getRoleNames()->first() ?? 'Pengguna Terverifikasi' }}</span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label for="komentar" class="sr-only">Tulis Komentar</label>
                        <textarea 
                            name="komentar" 
                            id="komentar" 
                            rows="3" 
                            required 
                            minlength="3"
                            maxlength="500"
                            oninput="document.getElementById('komentar-counter').textContent = this.value.length + ' / 500'"
                            placeholder="Tuliskan tanggapan, masukan, atau pertanyaan santun terkait berita ini..." 
                            class="w-full text-xs sm:text-sm rounded-2xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 p-3.5 bg-bone-50/50">{{ old('komentar') }}</textarea>
                        <div class="flex items-center justify-between text-[11px] text-slate-400 px-1">
                            <span>Dilarang menyertakan link/URL atau spam</span>
                            <span id="komentar-counter" class="font-bold text-slate-500">{{ mb_strlen(old('komentar', '')) }} / 500</span>
                        </div>
                        @error('komentar')
                            <p class="text-[11px] text-rose-600 font-semibold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <span class="text-[11px] text-slate-400">
                            <i class="fa-solid fa-shield-halved mr-1 text-emerald-600"></i> Berkomentar dengan etika & kesantunan publik
                        </span>
                        <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-md">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Kirim Komentar</span>
                        </button>
                    </div>
                </form>
            @else
                <!-- Banner Ajakan Login Bagi Pengunjung yang Belum Login (Guest) -->
                <div class="bg-bone-200/70 rounded-3xl p-6 sm:p-8 border border-bone-300 text-center space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-rose-100 text-maroon-700 flex items-center justify-center mx-auto text-lg shadow-sm">
                        <i class="fa-solid fa-user-lock"></i>
                    </div>
                    <div class="max-w-md mx-auto space-y-1">
                        <h4 class="font-extrabold text-sm sm:text-base text-slate-900">
                            Ingin Memberikan Komentar pada Berita Ini?
                        </h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Untuk menjaga kualitas diskusi ilmiah dan keterbukaan publik yang sehat, silakan masuk ke akun portal Anda terlebih dahulu sebelum menulis komentar.
                        </p>
                    </div>
                    <div class="flex flex-wrap items-center justify-center gap-3 pt-1">
                        <a href="{{ route('auth.google') }}" class="inline-flex items-center gap-2.5 bg-white hover:bg-bone-100 text-slate-800 border-2 border-bone-300 hover:border-maroon-700 font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-sm">
                            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                                <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                                <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.11-6.72-4.96H1.29v3.14C3.26 21.3 7.31 24 12 24z"/>
                                <path fill="#FBBC05" d="M5.28 14.24c-.24-.72-.38-1.49-.38-2.24s.14-1.52.38-2.24V6.62H1.29C.47 8.24 0 10.06 0 12s.47 3.76 1.29 5.38l3.99-3.14z"/>
                                <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.29 6.62l3.99 3.14c.95-2.85 3.6-4.96 6.72-4.96z"/>
                            </svg>
                            <span>Masuk / Daftar dengan Google</span>
                        </a>
                    </div>
                </div>
            @endauth

            <!-- Daftar Komentar yang Telah Masuk -->
            <div class="space-y-4 pt-2">
                @forelse($berita->komentars as $item)
                @php
                    $isCommenterAdmin = $item->user && $item->user->hasRole('Admin');
                    $commenterLabel = $isCommenterAdmin ? 'Admin BRIDA' : 'User';
                    $roleBadge = $isCommenterAdmin
                        ? 'bg-rose-100 text-maroon-800 border-rose-200'
                        : 'bg-bone-200 text-slate-700 border-bone-300';
                @endphp
                <div class="bg-white rounded-2xl p-5 border border-bone-300 shadow-sm space-y-2.5">
                    <div class="flex items-start justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-bone-200 border border-bone-300 text-maroon-800 font-black text-xs flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($item->user->name ?? 'U', 0, 2)) }}
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <strong class="text-xs font-bold text-slate-900">{{ $item->user->name ?? 'Pengguna' }}</strong>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $roleBadge }}">
                                        {{ $commenterLabel }}
                                    </span>
                                </div>
                                <span class="text-[10px] text-slate-400 block mt-0.5">
                                    <i class="fa-regular fa-clock mr-1"></i> {{ $item->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        @auth
                            @if(Auth::id() === $item->user_id || Auth::user()->hasRole('Admin'))
                            <form method="POST" action="{{ route('berita.komentar.destroy', $item->id) }}" data-confirm="Apakah Anda yakin ingin menghapus komentar ini?" data-confirm-title="Hapus Komentar" data-confirm-btn="Ya, Hapus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-rose-600 p-1 rounded-lg transition text-xs" title="Hapus Komentar">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                            @endif
                        @endauth
                    </div>

                    <p class="text-xs sm:text-sm text-slate-700 leading-relaxed pl-12">
                        {{ $item->komentar }}
                    </p>
                </div>
                @empty
                <div class="py-8 text-center text-slate-400 text-xs bg-white/60 rounded-2xl border border-dashed border-bone-300">
                    <i class="fa-regular fa-comment-dots text-2xl text-slate-300 block mb-1.5"></i>
                    Belum ada tanggapan pada berita ini. Jadilah yang pertama memberikan komentar!
                </div>
                @endforelse
            </div>
        </section>
        @endif

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
