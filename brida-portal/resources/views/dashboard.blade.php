<x-app-layout>
    <div class="space-y-8">

        <!-- Header Atas Dashboard & Tombol Aksi Cepat -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Dashboard Ikhtisar Operasional
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Selamat datang kembali, <strong>{{ $user->name }}</strong>. Terhubung dengan otoritas 
                    <span class="font-bold text-maroon-700 uppercase tracking-wide">[{{ $primaryRole }}]</span>.
                </p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white border border-bone-300 hover:border-slate-400 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm">
                    <i class="fa-solid fa-arrows-rotate text-slate-400"></i>
                    <span>Refresh</span>
                </a>
                @if(Auth::user()->hasAnyRole(['Admin', 'verif_berita']))
                <a href="{{ route('dashboard.berita.create') }}" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tulis Berita Baru</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Banner Sambutan Sesuai Hak Akses Role & Sub-Role Spatie -->
        <div class="bg-gradient-to-r from-maroon-900 via-maroon-800 to-slate-900 rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10 max-w-2xl space-y-2">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 bg-rose-500/20 text-rose-300 text-[11px] font-bold px-3 py-1 rounded-full border border-rose-400/30">
                        <i class="fa-solid fa-id-badge"></i> Role Utama: {{ $primaryRole }}
                    </span>
                    @foreach($subRoles as $sr)
                        <span class="inline-flex items-center gap-1 bg-emerald-500/20 text-emerald-300 text-[11px] font-bold px-2.5 py-1 rounded-full border border-emerald-400/30">
                            <i class="fa-solid fa-check-circle"></i> Sub-Role: {{ $sr }}
                        </span>
                    @endforeach
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-white">
                    @if($primaryRole === 'Admin')
                        Panel Kontrol Pusat Administrasi & Tata Kelola BRIDA
                    @elseif(!empty($subRoles))
                        Workspace Layanan Mandiri & Otoritas Verifikator Khusus
                    @else
                        Portal Layanan Mandiri Pengguna BRIDA Kota Makassar
                    @endif
                </h3>
                <p class="text-xs sm:text-sm text-rose-100/90 leading-relaxed">
                    @if($primaryRole === 'Admin')
                        Anda memiliki akses penuh sebagai Administrator untuk mengelola berita, regulasi, editor landing page, serta memberikan sub-role kepada pengguna.
                    @else
                        Kelola komentar pada berita dan akses modul khusus sesuai sub-role yang telah diizinkan oleh Admin
                        @if(!empty($subRoles))
                            (<strong>{{ implode(', ', $subRoles) }}</strong>).
                        @else
                            .
                        @endif
                    @endif
                </p>
            </div>
        </div>

        <!-- Kartu Statistik Utama (KPI Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Berita Publikasi</div>
                    <div class="text-2xl font-black text-slate-900 mt-1">{{ $stats['total_berita'] }} Artikel</div>
                    <span class="text-[11px] text-emerald-600 font-semibold inline-flex items-center gap-1 mt-1">
                        <i class="fa-solid fa-check-circle"></i> Tayang di portal
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-100 text-maroon-700 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Komentar Publik</div>
                    <div class="text-2xl font-black text-amber-600 mt-1">{{ $stats['total_komentar'] }} Komentar</div>
                    <span class="text-[11px] text-slate-400 block mt-1">Interaksi pembaca</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-regular fa-comments"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dokumen Regulasi</div>
                    <div class="text-2xl font-black text-slate-900 mt-1">{{ $stats['total_regulasi'] }} Dokumen</div>
                    <span class="text-[11px] text-indigo-600 font-semibold block mt-1">Repositori publik</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-700 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-scale-balanced"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Pengguna Terdaftar</div>
                    <div class="text-2xl font-black text-emerald-600 mt-1">{{ $stats['total_users'] }} Akun</div>
                    <span class="text-[11px] text-slate-400 block mt-1">Admin & User aktif</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>

        </div>

        <!-- Tabel Publikasi Berita Terkini -->
        <div class="bg-white rounded-2xl border border-bone-300 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-bone-300 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="font-black text-base text-slate-900">Publikasi Berita Terkini</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar rilis artikel dan kabar kegiatan terbaru portal BRIDA Kota Makassar</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-bone-100/70 border-b border-bone-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Judul Berita</th>
                            <th class="py-3.5 px-6">Kategori</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6">Tanggal</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bone-200 text-xs text-slate-700">
                        @forelse($recentBerita as $item)
                        <tr class="hover:bg-bone-50/80 transition">
                            <td class="py-4 px-6 font-semibold text-slate-900 max-w-md truncate" title="{{ $item->judul }}">
                                {{ $item->judul }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-600">
                                {{ $item->kategori }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $item->status === 'Publikasi' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-500 whitespace-nowrap">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                @if(Auth::user()->hasAnyRole(['Admin', 'verif_berita']))
                                <a href="{{ route('dashboard.berita.edit', $item->id) }}" class="bg-white hover:bg-bone-100 text-slate-700 border border-bone-300 text-xs font-bold px-3 py-1.5 rounded-lg transition shadow-sm inline-flex items-center gap-1">
                                    <span>Edit</span>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                                </a>
                                @else
                                <a href="{{ route('berita.detail', $item->slug) }}" target="_blank" class="bg-white hover:bg-bone-100 text-slate-700 border border-bone-300 text-xs font-bold px-3 py-1.5 rounded-lg transition shadow-sm inline-flex items-center gap-1">
                                    <span>Baca</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-slate-400 text-xs">
                                Belum ada artikel berita yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(Auth::user()->hasAnyRole(['Admin', 'verif_berita']))
            <div class="p-4 border-t border-bone-200 bg-bone-50/50 flex items-center justify-between text-xs text-slate-500">
                <span>Menampilkan 5 berita terbaru</span>
                <a href="{{ route('dashboard.berita.index') }}" class="font-bold text-maroon-700 hover:underline inline-flex items-center gap-1">
                    <span>Kelola Semua Berita</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
            @endif
        </div>

    </div>
</x-app-layout>
