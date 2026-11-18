<x-app-layout>
    <div class="space-y-6">

        <!-- Top Header & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <span class="text-slate-800 font-bold">Komentar Berita</span>
                </nav>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    {{ $canManageAll ? 'Daftar & Moderasi Komentar Berita' : 'Riwayat Komentar Saya pada Berita' }}
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ $canManageAll ? 'Kelola seluruh tanggapan masyarakat dan pengguna pada berita portal.' : 'Daftar tanggapan dan komentar yang pernah Anda berikan pada artikel berita BRIDA Makassar.' }}
                </p>
            </div>

            <a href="{{ route('berita') }}" target="_blank" class="inline-flex items-center gap-2 bg-white border border-bone-300 hover:bg-bone-100 text-slate-700 font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-sm">
                <i class="fa-regular fa-newspaper text-maroon-700"></i>
                <span>Baca Berita Portal</span>
            </a>
        </div>

        @if(session('success_komentar'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success_komentar') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-bone-300 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-bone-100/70 border-b border-bone-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Pengirim</th>
                            <th class="py-3.5 px-6">Isi Komentar / Tanggapan</th>
                            <th class="py-3.5 px-6">Pada Artikel Berita</th>
                            <th class="py-3.5 px-6">Waktu</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bone-200 text-xs text-slate-700">
                        @forelse($komentars as $item)
                        <tr class="hover:bg-bone-50/80 transition">
                            <td class="py-4 px-6 whitespace-nowrap">
                                <strong class="text-slate-900 block">{{ $item->user->name ?? 'Pengguna' }}</strong>
                                <span class="text-[11px] text-slate-400">{{ $item->user->email ?? '' }}</span>
                            </td>
                            <td class="py-4 px-6 max-w-md text-slate-700 leading-relaxed">
                                "{{ $item->komentar }}"
                            </td>
                            <td class="py-4 px-6 max-w-xs">
                                @if($item->berita)
                                    <a href="{{ route('berita.detail', $item->berita->slug) }}#kolom-komentar" target="_blank" class="font-bold text-maroon-700 hover:underline line-clamp-2">
                                        {{ $item->berita->judul }}
                                    </a>
                                @else
                                    <span class="text-slate-400 italic">Artikel telah dihapus</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-500 text-[11px]">
                                {{ $item->created_at->diffForHumans() }}
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <form method="POST" action="{{ route('berita.komentar.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Komentar">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400 text-xs">
                                <i class="fa-regular fa-comments text-2xl text-slate-300 block mb-2"></i>
                                Belum ada riwayat komentar berita yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-bone-200 bg-bone-50/50">
                {{ $komentars->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
