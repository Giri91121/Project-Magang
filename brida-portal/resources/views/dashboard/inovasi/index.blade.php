<x-app-layout>
    <div class="space-y-6">

        <!-- Top Header & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <span class="text-slate-800 font-bold">Inovasi Daerah & IGA</span>
                </nav>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    Katalog Inovasi Daerah Kota Makassar
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Basis data inovasi OPD dan persiapan pelaporan Innovative Government Award (IGA) Kemendagri.
                </p>
            </div>

            <div>
                <a href="{{ route('dashboard.inovasi.create') }}" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Inovasi Baru</span>
                </a>
            </div>
        </div>

        <!-- 4 Kotak Ringkasan Statistik IGA -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl border border-bone-300 shadow-sm">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Inovasi</span>
                <span class="text-xl font-black text-slate-900 mt-1 block">{{ $stats['total'] }} Inovasi</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-emerald-200 shadow-sm">
                <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Tahap Penerapan</span>
                <span class="text-xl font-black text-emerald-700 mt-1 block">{{ $stats['penerapan'] }} Inovasi</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-amber-200 shadow-sm">
                <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider block">Tahap Uji Coba</span>
                <span class="text-xl font-black text-amber-700 mt-1 block">{{ $stats['uji_coba'] }} Inovasi</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-indigo-200 shadow-sm">
                <span class="text-[11px] font-bold text-indigo-600 uppercase tracking-wider block">Rata-rata Skor Kematangan</span>
                <span class="text-xl font-black text-indigo-700 mt-1 block">{{ $stats['rata_skor'] }} / 130</span>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Card Datatable Inovasi -->
        <div class="bg-white rounded-2xl border border-bone-300 shadow-sm overflow-hidden">
            <!-- Filter Bar -->
            <div class="p-5 border-b border-bone-300 bg-white">
                <form method="GET" action="{{ route('dashboard.inovasi.index') }}" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                    <div class="relative w-full sm:w-80">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama inovasi / OPD..." class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700">
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <select name="tahapan" onchange="this.form.submit()" class="text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-1.5 px-3">
                            <option value="">-- Semua Tahapan --</option>
                            <option value="Penerapan" {{ request('tahapan') === 'Penerapan' ? 'selected' : '' }}>Penerapan</option>
                            <option value="Uji Coba" {{ request('tahapan') === 'Uji Coba' ? 'selected' : '' }}>Uji Coba</option>
                            <option value="Inisiatif" {{ request('tahapan') === 'Inisiatif' ? 'selected' : '' }}>Inisiatif</option>
                        </select>
                        @if(request('search') || request('tahapan'))
                            <a href="{{ route('dashboard.inovasi.index') }}" class="text-xs text-rose-600 hover:underline px-2 py-1">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabel Data -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-bone-100/70 border-b border-bone-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Kode</th>
                            <th class="py-3.5 px-6">Nama Inovasi & OPD</th>
                            <th class="py-3.5 px-6">Tahapan</th>
                            <th class="py-3.5 px-6">Bentuk Inovasi</th>
                            <th class="py-3.5 px-6">Skor Kematangan</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bone-200 text-xs text-slate-700">
                        @forelse($inovasiList as $item)
                        <tr class="hover:bg-bone-50/80 transition">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                {{ $item->kode_inovasi }}
                            </td>
                            <td class="py-4 px-6">
                                <strong class="text-slate-900 block text-xs">{{ $item->nama_inovasi }}</strong>
                                <span class="text-[11px] text-slate-500">{{ $item->perangkat_daerah }}</span>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $item->tahapan_inovasi == 'Penerapan' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $item->tahapan_inovasi }}
                                </span>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-600 text-[11px]">
                                <span class="inline-flex items-center gap-1">
                                    <i class="fa-solid {{ $item->jenis_inovasi == 'Digital' ? 'fa-laptop-code text-indigo-500' : 'fa-people-group text-emerald-500' }}"></i>
                                    <span>{{ $item->jenis_inovasi }}</span>
                                </span>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="font-extrabold text-slate-900">{{ $item->skor_kematangan }}</span>
                                    <span class="text-[10px] text-slate-400">/ 130</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <a href="{{ route('dashboard.inovasi.show', $item->id) }}" class="inline-flex items-center gap-1.5 bg-white hover:bg-bone-100 text-slate-700 border border-bone-300 text-xs font-bold px-3 py-1.5 rounded-lg transition shadow-sm">
                                    <span>Detail</span>
                                    <i class="fa-solid fa-arrow-right text-[10px] text-slate-400"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                                Belum ada inovasi daerah yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-bone-200 bg-bone-50/50">
                {{ $inovasiList->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
