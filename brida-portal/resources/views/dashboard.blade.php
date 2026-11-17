<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-slate-900 leading-tight">
                    {{ __('Dashboard Portal BRIDA Kota Makassar') }}
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">
                    Selamat datang kembali, <strong>{{ $user->name }}</strong>. Anda login sebagai 
                    <span class="font-bold text-maroon-700 uppercase tracking-wide">[{{ $primaryRole }}]</span>.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-2 bg-white border border-bone-300 hover:border-maroon-700 text-slate-700 text-xs font-bold px-4 py-2.5 rounded-xl transition shadow-sm">
                    <i class="fa-solid fa-arrow-up-right-from-square text-rose-600"></i>
                    <span>Kunjungi Portal Landing</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <!-- Banner Sambutan Sesuai Hak Akses Role Spatie -->
            <div class="bg-gradient-to-r from-maroon-900 via-maroon-800 to-slate-900 rounded-2xl p-6 sm:p-8 text-white shadow-lg relative overflow-hidden">
                <div class="relative z-10 max-w-2xl space-y-2">
                    <span class="inline-flex items-center gap-1.5 bg-rose-500/20 text-rose-300 text-[11px] font-bold px-3 py-1 rounded-full border border-rose-400/30">
                        <i class="fa-solid fa-id-badge"></i> Otoritas Role: {{ $primaryRole }}
                    </span>
                    <h3 class="text-2xl font-black text-white">
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
                            Anda memiliki akses penuh untuk memantau data riset, inovasi daerah, verifikasi berkas, manajemen pengguna, serta publikasi berita resmi.
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

            <!-- Kartu Statistik Utama -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Usulan Riset</div>
                        <div class="text-2xl font-black text-slate-900 mt-1">{{ $stats['total_riset'] }} Berkas</div>
                        <span class="text-[11px] text-emerald-600 font-semibold"><i class="fa-solid fa-arrow-up mr-1"></i> +12% bulan ini</span>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-book-open-reader"></i>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Menunggu Review</div>
                        <div class="text-2xl font-black text-amber-600 mt-1">{{ $stats['riset_pending'] }} Usulan</div>
                        <span class="text-[11px] text-slate-400">Perlu telaah tim teknis</span>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Inovasi Terdaftar</div>
                        <div class="text-2xl font-black text-indigo-600 mt-1">{{ $stats['total_inovasi'] }} Inovasi</div>
                        <span class="text-[11px] text-slate-500">Dari {{ $stats['skpd_terlibat'] }} SKPD Pemkot</span>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-bone-300 shadow-sm flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">Indeks Inovasi (IID)</div>
                        <div class="text-2xl font-black text-emerald-600 mt-1">{{ $stats['kategori_iga'] }}</div>
                        <span class="text-[11px] text-slate-400">Predikat Kemendagri RI</span>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                        <i class="fa-solid fa-award"></i>
                    </div>
                </div>

            </div>

            <!-- Konten Grid Utama: Tabel Usulan Riset & Panel Aksi Cepat Role -->
            <div class="grid lg:grid-cols-12 gap-8">
                
                <!-- Tabel Usulan Riset Terkini (8 Kolom) -->
                <div class="lg:col-span-8 bg-white rounded-2xl border border-bone-300 shadow-sm overflow-hidden flex flex-col justify-between">
                    <div class="p-6 border-b border-bone-300 flex items-center justify-between">
                        <div>
                            <h4 class="font-bold text-base text-slate-900">Permohonan Izin & Rekomendasi Riset Terkini</h4>
                            <p class="text-xs text-slate-500">Daftar berkas permohonan penelitian masuk di wilayah Kota Makassar.</p>
                        </div>
                        <span class="text-xs font-bold text-maroon-700 bg-rose-50 px-3 py-1 rounded-full border border-rose-200">
                            Terbaru 2026
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead>
                                <tr class="bg-bone-100/70 border-b border-bone-300 text-slate-500 uppercase tracking-wider text-[11px]">
                                    <th class="py-3.5 px-5 font-bold">No. Berkas</th>
                                    <th class="py-3.5 px-5 font-bold">Pemohon</th>
                                    <th class="py-3.5 px-5 font-bold">Judul Penelitian</th>
                                    <th class="py-3.5 px-5 font-bold">Status</th>
                                    <th class="py-3.5 px-5 font-bold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-bone-300">
                                @foreach($recentPermohonan as $item)
                                    <tr class="hover:bg-bone-50/60 transition">
                                        <td class="py-3.5 px-5 font-mono text-[11px] font-bold text-slate-700">
                                            {{ $item['id'] }}
                                        </td>
                                        <td class="py-3.5 px-5">
                                            <div class="font-bold text-slate-800">{{ $item['pemohon'] }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $item['tanggal'] }}</div>
                                        </td>
                                        <td class="py-3.5 px-5 max-w-xs text-slate-600 line-clamp-2">
                                            {{ $item['judul'] }}
                                        </td>
                                        <td class="py-3.5 px-5">
                                            <span class="text-[10px] font-bold px-2.5 py-1 rounded-full {{ $item['status_color'] }}">
                                                {{ $item['status'] }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-5 text-right space-x-2">
                                            @if($primaryRole === 'Admin' || $primaryRole === 'Peneliti')
                                                <button class="bg-maroon-700 hover:bg-maroon-800 text-white font-bold px-2.5 py-1 rounded-md text-[11px] transition">
                                                    Review
                                                </button>
                                            @else
                                                <button class="bg-bone-200 hover:bg-bone-300 text-slate-700 font-bold px-2.5 py-1 rounded-md text-[11px] transition">
                                                    Detail
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-t border-bone-300 bg-bone-50/50 flex items-center justify-between text-xs text-slate-500">
                        <span>Menampilkan 4 permohonan terkini</span>
                        <a href="#" class="font-bold text-maroon-700 hover:underline">Lihat Semua Berkas &rarr;</a>
                    </div>
                </div>

                <!-- Panel Aksi Cepat Sesuai Hak Akses Role (4 Kolom) -->
                <div class="lg:col-span-4 space-y-6">
                    
                    <!-- Box Aksi Cepat -->
                    <div class="bg-white p-6 rounded-2xl border border-bone-300 shadow-sm space-y-4">
                        <div class="flex items-center gap-2 border-b border-bone-300 pb-3">
                            <i class="fa-solid fa-bolt text-maroon-700"></i>
                            <h4 class="font-bold text-sm text-slate-900">Aksi Cepat Menu</h4>
                        </div>

                        <div class="space-y-2 text-xs">
                            @if($primaryRole === 'Admin')
                                <a href="#" class="flex items-center justify-between p-3 rounded-xl bg-bone-100 hover:bg-rose-50 hover:text-maroon-700 transition font-bold text-slate-700 border border-bone-300">
                                    <span class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-users-gear text-maroon-700"></i>
                                        <span>Kelola Pengguna & Role</span>
                                    </span>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                                <a href="#" class="flex items-center justify-between p-3 rounded-xl bg-bone-100 hover:bg-rose-50 hover:text-maroon-700 transition font-bold text-slate-700 border border-bone-300">
                                    <span class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-newspaper text-maroon-700"></i>
                                        <span>Publikasi Kabar BRIDA</span>
                                    </span>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            @endif

                            @if($primaryRole === 'Peneliti' || $primaryRole === 'Admin')
                                <a href="#" class="flex items-center justify-between p-3 rounded-xl bg-bone-100 hover:bg-rose-50 hover:text-maroon-700 transition font-bold text-slate-700 border border-bone-300">
                                    <span class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-file-signature text-maroon-700"></i>
                                        <span>Validasi Naskah Riset</span>
                                    </span>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            @endif

                            @if($primaryRole === 'Fasilitator Inovasi' || $primaryRole === 'Admin')
                                <a href="#" class="flex items-center justify-between p-3 rounded-xl bg-bone-100 hover:bg-rose-50 hover:text-maroon-700 transition font-bold text-slate-700 border border-bone-300">
                                    <span class="flex items-center gap-2.5">
                                        <i class="fa-solid fa-folder-plus text-maroon-700"></i>
                                        <span>Input Evaluasi Inovasi OPD</span>
                                    </span>
                                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                                </a>
                            @endif

                            <a href="#" class="flex items-center justify-between p-3 rounded-xl bg-bone-100 hover:bg-rose-50 hover:text-maroon-700 transition font-bold text-slate-700 border border-bone-300">
                                <span class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-file-circle-plus text-maroon-700"></i>
                                    <span>Buat Permohonan Riset Baru</span>
                                </span>
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Box Info Akun Demo & Bantuan -->
                    <div class="bg-bone-100/70 p-5 rounded-2xl border border-bone-300 space-y-3 text-xs">
                        <div class="font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-circle-info text-maroon-700"></i>
                            <span>Daftar Akun Demo Role</span>
                        </div>
                        <p class="text-slate-500 text-[11px] leading-relaxed">
                            Anda dapat mencoba login dengan akun demo lain (Password: <code>password123</code>):
                        </p>
                        <div class="space-y-1.5 text-[11px] text-slate-600 font-mono">
                            <div>• <strong>Admin</strong>: admin@brida.makassarkota.go.id</div>
                            <div>• <strong>Peneliti</strong>: peneliti@brida.makassarkota.go.id</div>
                            <div>• <strong>Fasilitator</strong>: fasilitator@brida.makassarkota.go.id</div>
                            <div>• <strong>Pemohon</strong>: pemohon@brida.makassarkota.go.id</div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>
