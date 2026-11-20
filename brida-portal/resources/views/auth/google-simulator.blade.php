<x-guest-layout>
    <div class="space-y-6">
        
        <!-- Header Google Account Chooser -->
        <div class="text-center space-y-2 border-b border-bone-200 pb-4">
            <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white border border-bone-300 shadow-sm mb-1">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"/>
                    <path fill="#34A853" d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.11-6.72-4.96H1.29v3.14C3.26 21.3 7.31 24 12 24z"/>
                    <path fill="#FBBC05" d="M5.28 14.24c-.24-.72-.38-1.49-.38-2.24s.14-1.52.38-2.24V6.62H1.29C.47 8.24 0 10.06 0 12s.47 3.76 1.29 5.38l3.99-3.14z"/>
                    <path fill="#EA4335" d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.31 0 3.26 2.7 1.29 6.62l3.99 3.14c.95-2.85 3.6-4.96 6.72-4.96z"/>
                </svg>
            </div>
            <h2 class="text-lg font-black text-slate-900">Pilih Akun Google</h2>
            <p class="text-xs text-slate-500">
                untuk melanjutkan ke <strong>BRIDA Kota Makassar</strong>
            </p>
        </div>

        <!-- Daftar Akun Terdaftar (Klik untuk Langsung Masuk) -->
        <div class="space-y-2">
            <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block px-1">Pilih Akun yang Tersedia:</span>
            <div class="divide-y divide-bone-200 border border-bone-300 rounded-2xl overflow-hidden bg-bone-50/50">
                @foreach($demoUsers as $u)
                <form method="POST" action="{{ route('auth.google.simulate') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $u->email }}">
                    <input type="hidden" name="name" value="{{ $u->name }}">
                    <button type="submit" class="w-full p-3.5 hover:bg-rose-50/70 transition flex items-center justify-between text-left group">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-full bg-maroon-700 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                {{ strtoupper(substr($u->name, 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 group-hover:text-maroon-700 truncate">{{ $u->name }}</p>
                                <p class="text-[11px] text-slate-500 truncate">{{ $u->email }}</p>
                            </div>
                        </div>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-white border border-bone-300 text-slate-600 shrink-0 ml-2">
                            {{ implode(', ', $u->getRoleNames()->toArray()) ?: 'User' }}
                        </span>
                    </button>
                </form>
                @endforeach
            </div>
        </div>

        <!-- Atau Gunakan / Daftarkan Akun Google Baru -->
        <div class="pt-3 border-t border-bone-200 space-y-3" x-data="{ customAccount: false }">
            <button type="button" @click="customAccount = !customAccount" class="w-full flex items-center justify-center gap-2 text-xs font-bold text-maroon-700 hover:underline py-1">
                <i class="fa-solid fa-user-plus text-[11px]"></i>
                <span>Gunakan atau Daftarkan Akun Google Lain</span>
            </button>

            <form x-show="customAccount" method="POST" action="{{ route('auth.google.simulate') }}" class="space-y-3 bg-bone-100 p-4 rounded-2xl border border-bone-300">
                @csrf
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold text-slate-700">Nama Akun Google</label>
                    <input type="text" name="name" required placeholder="Contoh: Budi Santoso" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3 bg-white">
                </div>
                <div class="space-y-1">
                    <label class="block text-[11px] font-bold text-slate-700">Alamat Gmail</label>
                    <input type="email" name="email" required placeholder="nama@gmail.com" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3 bg-white">
                </div>
                <button type="submit" class="w-full bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs py-2.5 rounded-xl transition shadow">
                    Lanjutkan dengan Akun Ini
                </button>
            </form>
        </div>

    </div>
</x-guest-layout>
