<x-app-layout>
    <div class="space-y-6">

        <!-- Top Header & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <span class="text-slate-800 font-bold">CMS Berita & Publikasi</span>
                </nav>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    Manajemen Berita & Rilis Resmi
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Kelola artikel kegiatan riset, berita inovasi, dan publikasi agenda BRIDA Kota Makassar.
                </p>
            </div>

            <div>
                <a href="{{ route('dashboard.berita.create') }}" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow">
                    <i class="fa-solid fa-pen-nib text-xs"></i>
                    <span>Tulis Berita Baru</span>
                </a>
            </div>
        </div>

        <!-- 4 Kotak Ringkasan Statistik Berita -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl border border-bone-300 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Artikel</span>
                <span class="text-xl font-black text-slate-900 mt-1 block">{{ $stats['total'] }} Rilis</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-emerald-200 shadow-sm">
                <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Terpublikasi</span>
                <span class="text-xl font-black text-emerald-700 mt-1 block">{{ $stats['publikasi'] }} Berita</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-amber-200 shadow-sm">
                <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider block">Draft Tersimpan</span>
                <span class="text-xl font-black text-amber-700 mt-1 block">{{ $stats['draft'] }} Draft</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-indigo-200 shadow-sm">
                <span class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider block">Total Pembaca</span>
                <span class="text-xl font-black text-indigo-700 mt-1 block">{{ number_format($stats['total_views']) }} Kali</span>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Card Datatable Berita -->
        <div class="bg-white rounded-2xl border border-bone-300 shadow-sm overflow-hidden">
            <!-- Filter Bar -->
            <div class="p-5 border-b border-bone-300 bg-white">
                <form method="GET" action="{{ route('dashboard.berita.index') }}" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                    <div class="relative w-full sm:w-80">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul berita..." class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700">
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <select name="kategori" onchange="this.form.submit()" class="text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-1.5 px-3">
                            <option value="">-- Semua Kategori --</option>
                            <option value="Kebijakan Riset" {{ request('kategori') === 'Kebijakan Riset' ? 'selected' : '' }}>Kebijakan Riset</option>
                            <option value="Inovasi Daerah" {{ request('kategori') === 'Inovasi Daerah' ? 'selected' : '' }}>Inovasi Daerah</option>
                            <option value="Kemitraan Kampus" {{ request('kategori') === 'Kemitraan Kampus' ? 'selected' : '' }}>Kemitraan Kampus</option>
                            <option value="Agenda BRIDA" {{ request('kategori') === 'Agenda BRIDA' ? 'selected' : '' }}>Agenda BRIDA</option>
                        </select>
                        @if(request('search') || request('kategori'))
                            <a href="{{ route('dashboard.berita.index') }}" class="text-xs text-rose-600 hover:underline px-2 py-1">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabel Data Berita -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-bone-100/70 border-b border-bone-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Foto & Judul Artikel</th>
                            <th class="py-3.5 px-6">Kategori</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6">Pembaca</th>
                            <th class="py-3.5 px-6">Tanggal Rilis</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bone-200 text-xs text-slate-700">
                        @forelse($beritas as $item)
                        <tr class="hover:bg-bone-50/80 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $item->gambar_url }}" alt="{{ $item->judul }}" class="w-12 h-12 rounded-xl object-cover shrink-0 border border-bone-300">
                                    <div class="min-w-0 max-w-md">
                                        <a href="{{ route('berita.detail', $item->slug) }}" target="_blank" class="font-bold text-slate-900 hover:text-maroon-700 transition block truncate text-xs">
                                            {{ $item->judul }}
                                        </a>
                                        <span class="text-[11px] text-slate-400 block truncate mt-0.5">{{ $item->ringkasan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-600 font-semibold text-[11px]">
                                {{ $item->kategori }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $item->status === 'Publikasi' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-500 text-[11px]">
                                <i class="fa-regular fa-eye mr-1"></i> {{ $item->views }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-500 text-[11px]">
                                {{ $item->published_at ? $item->published_at->format('d M Y') : 'Draft' }}
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('dashboard.berita.edit', $item->id) }}" class="p-1.5 text-slate-500 hover:text-maroon-700 hover:bg-bone-200 rounded-lg transition" title="Edit Berita">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.berita.destroy', $item->id) }}" data-confirm="Apakah Anda yakin ingin menghapus artikel berita '{{ $item->judul }}'?" data-confirm-title="Hapus Artikel Berita" data-confirm-btn="Ya, Hapus" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Berita">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                                Belum ada artikel berita yang dibuat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-bone-200 bg-bone-50/50">
                {{ $beritas->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
