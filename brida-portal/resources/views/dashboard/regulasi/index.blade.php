<x-app-layout>
    <div class="space-y-6">

        <!-- Top Header & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <span class="text-slate-800 font-bold">Repositori Dokumen</span>
                </nav>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    Manajemen Regulasi & Dokumen Publik
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Kelola berkas Peraturan Walikota, Perda, SOP Riset, dan materi keterbukaan informasi publik (PPID).
                </p>
            </div>

            <div>
                <a href="{{ route('dashboard.regulasi.create') }}" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow">
                    <i class="fa-solid fa-file-arrow-up text-xs"></i>
                    <span>Unggah Dokumen Baru</span>
                </a>
            </div>
        </div>

        <!-- 4 Kotak Ringkasan Statistik Regulasi -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl border border-bone-300 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Regulasi</span>
                <span class="text-xl font-black text-slate-900 mt-1 block">{{ $stats['total'] }} Berkas</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-emerald-200 shadow-sm">
                <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Peraturan Walikota</span>
                <span class="text-xl font-black text-emerald-700 mt-1 block">{{ $stats['perwali'] }} Dokumen</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-indigo-200 shadow-sm">
                <span class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider block">Pedoman & SOP</span>
                <span class="text-xl font-black text-indigo-700 mt-1 block">{{ $stats['sop'] }} Juknis</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-rose-200 shadow-sm">
                <span class="text-[11px] font-bold text-rose-600 uppercase tracking-wider block">Total Diunduh Publik</span>
                <span class="text-xl font-black text-rose-700 mt-1 block">{{ number_format($stats['total_unduhan']) }} Kali</span>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Card Datatable Regulasi -->
        <div class="bg-white rounded-2xl border border-bone-300 shadow-sm overflow-hidden">
            <!-- Filter Bar -->
            <div class="p-5 border-b border-bone-300 bg-white">
                <form method="GET" action="{{ route('dashboard.regulasi.index') }}" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                    <div class="relative w-full sm:w-80">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama regulasi / nomor..." class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700">
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <select name="kategori" onchange="this.form.submit()" class="text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-1.5 px-3">
                            <option value="">-- Semua Kategori --</option>
                            <option value="Peraturan Walikota" {{ request('kategori') === 'Peraturan Walikota' ? 'selected' : '' }}>Peraturan Walikota</option>
                            <option value="Peraturan Daerah" {{ request('kategori') === 'Peraturan Daerah' ? 'selected' : '' }}>Peraturan Daerah</option>
                            <option value="Pedoman Teknis" {{ request('kategori') === 'Pedoman Teknis' ? 'selected' : '' }}>Pedoman Teknis / SOP</option>
                            <option value="Dokumen PPID" {{ request('kategori') === 'Dokumen PPID' ? 'selected' : '' }}>Dokumen PPID</option>
                        </select>
                        @if(request('search') || request('kategori'))
                            <a href="{{ route('dashboard.regulasi.index') }}" class="text-xs text-rose-600 hover:underline px-2 py-1">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabel Data Regulasi -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-bone-100/70 border-b border-bone-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Nomor Peraturan</th>
                            <th class="py-3.5 px-6">Judul Dokumen & Deskripsi</th>
                            <th class="py-3.5 px-6">Kategori</th>
                            <th class="py-3.5 px-6">Ukuran</th>
                            <th class="py-3.5 px-6">Unduhan</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bone-200 text-xs text-slate-700">
                        @forelse($regulasis as $item)
                        <tr class="hover:bg-bone-50/80 transition">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900 whitespace-nowrap">
                                {{ $item->nomor_peraturan }}
                            </td>
                            <td class="py-4 px-6">
                                <strong class="text-slate-900 block text-xs">{{ $item->judul_regulasi }}</strong>
                                <span class="text-[11px] text-slate-500 block truncate max-w-md mt-0.5">{{ $item->tentang }}</span>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-600 font-semibold text-[11px]">
                                {{ $item->kategori }} ({{ $item->tahun }})
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-500 text-[11px]">
                                {{ $item->ukuran_file ?? '1.2 MB' }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-500 text-[11px]">
                                <i class="fa-solid fa-download mr-1"></i> {{ $item->download_count }} x
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('regulasi.download', $item->id) }}" class="p-1.5 text-slate-500 hover:text-maroon-700 hover:bg-bone-200 rounded-lg transition" title="Unduh File">
                                        <i class="fa-solid fa-file-arrow-down"></i>
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.regulasi.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumen ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Regulasi">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                                Belum ada dokumen regulasi yang diunggah.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-bone-200 bg-bone-50/50">
                {{ $regulasis->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
