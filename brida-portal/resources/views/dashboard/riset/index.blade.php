<x-app-layout>
    <div class="space-y-6">

        <!-- Top Header & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <span class="text-slate-800 font-bold">Layanan Izin Riset</span>
                </nav>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    Daftar Permohonan Rekomendasi Riset
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Data pengajuan surat izin/rekomendasi penelitian mahasiswa, akademisi, dan institusi di Kota Makassar.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('dashboard.export.riset.csv') }}" class="inline-flex items-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs px-3.5 py-2.5 rounded-xl transition shadow-sm">
                    <i class="fa-solid fa-file-excel text-emerald-600"></i>
                    <span>Ekspor CSV / Excel</span>
                </a>
                <a href="{{ route('dashboard.riset.create') }}" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Ajukan Permohonan Riset</span>
                </a>
            </div>
        </div>

        <!-- 4 Kotak Ringkasan Status -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('dashboard.riset.index') }}" class="bg-white p-4 rounded-xl border border-bone-300 shadow-sm hover:border-slate-400 transition">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Total Pengajuan</span>
                <span class="text-xl font-black text-slate-900 mt-1 block">{{ $stats['total'] }} Berkas</span>
            </a>
            <a href="{{ route('dashboard.riset.index', ['status' => 'Menunggu Review']) }}" class="bg-white p-4 rounded-xl border border-amber-200 shadow-sm hover:border-amber-400 transition">
                <span class="text-[11px] font-bold text-amber-600 uppercase tracking-wider block">Menunggu Review</span>
                <span class="text-xl font-black text-amber-700 mt-1 block">{{ $stats['pending'] }} Usulan</span>
            </a>
            <a href="{{ route('dashboard.riset.index', ['status' => 'Sedang Ditelaah']) }}" class="bg-white p-4 rounded-xl border border-blue-200 shadow-sm hover:border-blue-400 transition">
                <span class="text-[11px] font-bold text-blue-600 uppercase tracking-wider block">Sedang Ditelaah</span>
                <span class="text-xl font-black text-blue-700 mt-1 block">{{ $stats['review'] }} Usulan</span>
            </a>
            <a href="{{ route('dashboard.riset.index', ['status' => 'Disetujui']) }}" class="bg-white p-4 rounded-xl border border-emerald-200 shadow-sm hover:border-emerald-400 transition">
                <span class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider block">Telah Disetujui</span>
                <span class="text-xl font-black text-emerald-700 mt-1 block">{{ $stats['approved'] }} Surat</span>
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Card Datatable & Filter -->
        <div class="bg-white rounded-2xl border border-bone-300 shadow-sm overflow-hidden">
            <!-- Filter Bar -->
            <div class="p-5 border-b border-bone-300 bg-white">
                <form method="GET" action="{{ route('dashboard.riset.index') }}" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                    <div class="relative w-full sm:w-80">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, pemohon, atau institusi..." class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700">
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <select name="status" onchange="this.form.submit()" class="text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-1.5 px-3">
                            <option value="">-- Semua Status --</option>
                            <option value="Menunggu Review" {{ request('status') === 'Menunggu Review' ? 'selected' : '' }}>Menunggu Review</option>
                            <option value="Sedang Ditelaah" {{ request('status') === 'Sedang Ditelaah' ? 'selected' : '' }}>Sedang Ditelaah</option>
                            <option value="Disetujui" {{ request('status') === 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="Ditolak" {{ request('status') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @if(request('search') || request('status'))
                            <a href="{{ route('dashboard.riset.index') }}" class="text-xs text-rose-600 hover:underline px-2 py-1">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabel Data -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-bone-100/70 border-b border-bone-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-6">No. Registrasi</th>
                            <th class="py-3.5 px-6">Pemohon & Institusi</th>
                            <th class="py-3.5 px-6">Judul Penelitian</th>
                            <th class="py-3.5 px-6">Bidang Fokus</th>
                            <th class="py-3.5 px-6">Status</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bone-200 text-xs text-slate-700">
                        @forelse($permohonan as $item)
                        <tr class="hover:bg-bone-50/80 transition">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                {{ $item->nomor_registrasi }}
                            </td>
                            <td class="py-4 px-6">
                                <strong class="text-slate-900 block">{{ $item->nama_pemohon }}</strong>
                                <span class="text-[11px] text-slate-500">{{ $item->institusi }}</span>
                            </td>
                            <td class="py-4 px-6 max-w-xs truncate text-slate-600" title="{{ $item->judul_penelitian }}">
                                {{ $item->judul_penelitian }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-slate-500 text-[11px]">
                                {{ $item->bidang_fokus }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $item->status_badge }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <a href="{{ route('dashboard.riset.show', $item->id) }}" class="inline-flex items-center gap-1.5 bg-white hover:bg-bone-100 text-slate-700 border border-bone-300 text-xs font-bold px-3 py-1.5 rounded-lg transition shadow-sm">
                                    <span>Periksa</span>
                                    <i class="fa-solid fa-arrow-right text-[10px] text-slate-400"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                                <i class="fa-solid fa-folder-open text-2xl text-slate-300 block mb-2"></i>
                                Tidak ada data permohonan riset yang sesuai dengan pencarian atau filter.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-bone-200 bg-bone-50/50">
                {{ $permohonan->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
