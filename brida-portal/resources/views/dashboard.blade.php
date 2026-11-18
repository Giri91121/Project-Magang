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
                    <span>Segarkan Data</span>
                </a>
                <a href="{{ route('dashboard.riset.create') }}" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Buat Permohonan Baru</span>
                </a>
            </div>
        </div>

        <!-- Banner Sambutan Sesuai Hak Akses Role Spatie -->
        <div class="bg-gradient-to-r from-maroon-900 via-maroon-800 to-slate-900 rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10 max-w-2xl space-y-2">
                <span class="inline-flex items-center gap-1.5 bg-rose-500/20 text-rose-300 text-[11px] font-bold px-3 py-1 rounded-full border border-rose-400/30">
                    <i class="fa-solid fa-id-badge"></i> Otoritas Role: {{ $primaryRole }}
                </span>
                <h3 class="text-xl sm:text-2xl font-black text-white">
                    @if($primaryRole === 'Admin')
                        Panel Kontrol Pusat Administrasi & Tata Kelola
                    @elseif($primaryRole === 'Peneliti')
                        Workspace Tim Riset & Kajian Kebijakan Strategis
                    @elseif($primaryRole === 'Fasilitator Inovasi')
                        Pusat Pendampingan & Monitoring Inovasi OPD
                    @else
                        Portal Layanan Mandiri Permohonan Izin Riset
                    @endif
                </h3>
                <p class="text-xs sm:text-sm text-rose-100/90 leading-relaxed">
                    @if($primaryRole === 'Admin')
                        Anda memiliki akses penuh untuk memantau data riset, inovasi daerah, verifikasi berkas perizinan, manajemen pengguna, serta publikasi berita resmi.
                    @elseif($primaryRole === 'Peneliti')
                        Kelola telaah staf, review proposal ilmiah mahasiswa/akademisi, serta susun naskah rekomendasi kebijakan berbasis bukti ilmiah.
                    @elseif($primaryRole === 'Fasilitator Inovasi')
                        Pantau penginputan indikator kematangan inovasi perangkat daerah dan persiapan pelaporan IGA (Innovative Government Award) Kemendagri.
                    @else
                        Ajukan surat rekomendasi penelitian untuk tugas akhir/skripsi/tesis Anda dan pantau proses verifikasi dokumen secara real-time.
                    @endif
                </p>
            </div>
        </div>

        <!-- Kartu Statistik Utama (KPI Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Usulan Riset</div>
                    <div class="text-2xl font-black text-slate-900 mt-1">{{ $stats['total_riset'] }} Berkas</div>
                    <span class="text-[11px] text-emerald-600 font-semibold inline-flex items-center gap-1 mt-1">
                        <i class="fa-solid fa-arrow-trend-up"></i> +12% bulan ini
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-100 text-maroon-700 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-book-open-reader"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Menunggu Review</div>
                    <div class="text-2xl font-black text-amber-600 mt-1">{{ $stats['riset_pending'] }} Usulan</div>
                    <span class="text-[11px] text-slate-400 block mt-1">Perlu telaah teknis</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Inovasi Daerah Terdaftar</div>
                    <div class="text-2xl font-black text-slate-900 mt-1">{{ $stats['total_inovasi'] }} Inovasi</div>
                    <span class="text-[11px] text-indigo-600 font-semibold block mt-1">{{ $stats['skpd_terlibat'] }} SKPD Aktif</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-700 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-lightbulb"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Predikat IGA Kemendagri</div>
                    <div class="text-xl font-black text-emerald-600 mt-1">{{ $stats['kategori_iga'] }}</div>
                    <span class="text-[11px] text-slate-400 block mt-1">Indeks Kematangan Tinggi</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-award"></i>
                </div>
            </div>

        </div>

        <!-- Tabel Monitoring Usulan Izin Riset Terkini (Modern Datatable UI) -->
        <div id="tabel-permohonan" class="bg-white rounded-2xl border border-bone-300 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-bone-300 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h3 class="font-black text-base text-slate-900">Berkas Permohonan Rekomendasi Riset Terkini</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar registrasi usulan riset akademisi, mahasiswa, dan OPD di Kota Makassar</p>
                </div>
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                        <input type="text" placeholder="Cari pemohon / judul..." class="pl-8 pr-3 py-1.5 text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 w-48 sm:w-60">
                    </div>
                    <button class="bg-bone-100 hover:bg-bone-200 text-slate-700 text-xs font-semibold px-3 py-2 rounded-xl border border-bone-300 transition">
                        <i class="fa-solid fa-filter mr-1 text-slate-500"></i> Filter
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-bone-100/70 border-b border-bone-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-6">No. Registrasi</th>
                            <th class="py-3.5 px-6">Pemohon & Institusi</th>
                            <th class="py-3.5 px-6">Judul Penelitian / Kajian</th>
                            <th class="py-3.5 px-6">Tanggal Masuk</th>
                            <th class="py-3.5 px-6">Status Berkas</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bone-200 text-xs text-slate-700">
                        @forelse($recentPermohonan as $item)
                        <tr class="hover:bg-bone-50/80 transition">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900 text-xs">
                                {{ $item->nomor_registrasi }}
                            </td>
                            <td class="py-4 px-6 font-semibold text-slate-900">
                                {{ $item->nama_pemohon }}
                                <span class="text-[11px] text-slate-500 font-normal block">{{ $item->institusi }}</span>
                            </td>
                            <td class="py-4 px-6 max-w-xs truncate text-slate-600" title="{{ $item->judul_penelitian }}">
                                {{ $item->judul_penelitian }}
                            </td>
                            <td class="py-4 px-6 text-slate-500 whitespace-nowrap">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold {{ $item->status_badge }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <a href="{{ route('dashboard.riset.show', $item->id) }}" class="bg-white hover:bg-bone-100 text-slate-700 border border-bone-300 text-xs font-bold px-3 py-1.5 rounded-lg transition shadow-sm inline-flex items-center gap-1">
                                    <span>Detail</span>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-6 text-center text-slate-400 text-xs">
                                Belum ada berkas usulan riset yang terdaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-bone-200 bg-bone-50/50 flex items-center justify-between text-xs text-slate-500">
                <span>Menampilkan usulan riset terbaru</span>
                <a href="{{ route('dashboard.riset.index') }}" class="font-bold text-maroon-700 hover:underline inline-flex items-center gap-1">
                    <span>Lihat Semua Permohonan Riset</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

    </div>
</x-app-layout>
