<x-guest-layout>
    <div class="space-y-6 text-center">
        
        <!-- Header Sambutan Registrasi -->
        <div class="space-y-1.5">
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                Registrasi Akun Portal BRIDA
            </h1>
            <p class="text-xs text-slate-500 leading-relaxed">
                Daftar secara instan hanya dengan 1 klik menggunakan akun Google aktif Anda.
            </p>
        </div>

        <!-- Tombol Utama: Daftar dengan Google -->
        <div class="pt-2">
            <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center gap-3.5 bg-white hover:bg-bone-100 text-slate-800 font-extrabold text-sm py-3.5 px-6 rounded-2xl border-2 border-bone-300 hover:border-maroon-700 shadow-sm hover:shadow-md transition-all group">
                <!-- Ikon Resmi Google SVG Berwarna -->
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.11-6.72-4.96H1.29v3.14C3.26 21.3 7.31 24 12 24z"/>
                    <path fill="#FBBC05" d="M5.28 14.24c-.24-.72-.38-1.49-.38-2.24s.14-1.52.38-2.24V6.62H1.29C.47 8.24 0 10.06 0 12s.47 3.76 1.29 5.38l3.99-3.14z"/>
                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.29 6.62l3.99 3.14c.95-2.85 3.6-4.96 6.72-4.96z"/>
                </svg>
                <span>Daftar / Masuk dengan Google</span>
            </a>
        </div>

        <div class="p-4 rounded-2xl bg-bone-100 border border-bone-300 text-left space-y-2 text-xs text-slate-600">
            <p class="leading-relaxed">
                Dengan mendaftar menggunakan Google, akun Anda otomatis mendapatkan hak akses sebagai <strong>User</strong> untuk mengajukan permohonan surat rekomendasi penelitian dan berdiskusi pada artikel berita.
            </p>
        </div>

        <div class="pt-2 border-t border-bone-200 text-xs text-slate-500">
            Sudah pernah terdaftar sebelumnya? <a href="{{ route('auth.google') }}" class="text-maroon-700 font-bold hover:underline">Langsung masuk via Google</a>
        </div>

    </div>
</x-guest-layout>
