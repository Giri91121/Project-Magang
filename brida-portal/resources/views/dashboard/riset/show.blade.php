<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-6">

        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <a href="{{ route('dashboard.riset.index') }}" class="hover:text-maroon-700 transition">Layanan Izin Riset</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <span class="text-slate-800 font-bold">Detail Usulan</span>
                </nav>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                        Berkas Registrasi: {{ $permohonan->nomor_registrasi }}
                    </h1>
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $permohonan->status_badge }}">
                        {{ $permohonan->status }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if($permohonan->status === 'Disetujui')
                <a href="{{ route('dashboard.export.riset.surat', $permohonan->id) }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-4 py-2 rounded-xl transition shadow">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Surat Rekomendasi Resmi</span>
                </a>
                @endif
                <a href="{{ route('dashboard.riset.index') }}" class="inline-flex items-center gap-1.5 bg-white border border-bone-300 hover:bg-bone-100 text-slate-700 text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-sm">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid lg:grid-cols-12 gap-6 items-start">

            <!-- Kolom Kiri: Rincian Lengkap Permohonan -->
            <div class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-6">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-maroon-700">Judul Penelitian</span>
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 leading-snug mt-1">
                        {{ $permohonan->judul_penelitian }}
                    </h2>
                </div>

                <div class="grid sm:grid-cols-2 gap-4 py-4 border-y border-bone-200 text-xs">
                    <div>
                        <span class="text-slate-400 block">Nama Peneliti</span>
                        <strong class="text-slate-800 text-sm block mt-0.5">{{ $permohonan->nama_pemohon }}</strong>
                        <span class="text-slate-500 text-[11px]">{{ $permohonan->institusi }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Fakultas / Program Studi</span>
                        <strong class="text-slate-800 block mt-0.5">{{ $permohonan->jurusan_fakultas ?? '-' }}</strong>
                        <span class="text-emerald-700 font-semibold text-[11px]">WA: {{ $permohonan->kontak_wa }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Bidang Fokus Inovasi</span>
                        <span class="inline-block bg-bone-100 text-slate-700 px-2.5 py-1 rounded-md font-semibold mt-1">
                            {{ $permohonan->bidang_fokus }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Lokus / Lokasi Penelitian</span>
                        <strong class="text-slate-800 block mt-1"><i class="fa-solid fa-location-dot text-rose-500 mr-1"></i> {{ $permohonan->lokasi_penelitian }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Periode Pelaksanaan</span>
                        <span class="text-slate-700 font-medium block mt-0.5">
                            {{ $permohonan->tanggal_mulai ? date('d M Y', strtotime($permohonan->tanggal_mulai)) : 'Belum ditentukan' }}
                            s/d 
                            {{ $permohonan->tanggal_selesai ? date('d M Y', strtotime($permohonan->tanggal_selesai)) : 'Selesai' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-400 block">Waktu Registrasi Masuk</span>
                        <span class="text-slate-700 font-medium block mt-0.5">
                            {{ $permohonan->created_at->format('d M Y, H:i') }} WITA
                        </span>
                    </div>
                </div>

                <!-- Catatan Evaluasi Reviewer -->
                <div class="p-4 rounded-2xl bg-bone-100/70 border border-bone-300 space-y-1.5">
                    <div class="flex items-center gap-2 text-xs font-bold text-slate-900">
                        <i class="fa-solid fa-comment-dots text-maroon-700"></i>
                        <span>Catatan Telaah dari Tim Reviewer BRIDA:</span>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed italic">
                        {{ $permohonan->catatan_reviewer ?? 'Belum ada catatan telaah untuk permohonan ini.' }}
                    </p>
                </div>

                <!-- Berkas Lampiran Dokumen -->
                <div class="space-y-3">
                    <h4 class="font-bold text-xs text-slate-900">Dokumen Berkas Terlampir:</h4>
                    <div class="grid sm:grid-cols-2 gap-3">
                        <div class="p-3.5 rounded-xl border border-bone-300 flex items-center justify-between bg-white text-xs">
                            <div class="flex items-center gap-2.5">
                                <i class="fa-regular fa-file-pdf text-rose-600 text-lg"></i>
                                <div>
                                    <span class="font-bold text-slate-800 block">Surat Pengantar</span>
                                    <span class="text-[10px] text-slate-400">{{ $permohonan->file_surat_pengantar ? 'File Tersedia' : 'Belum Dilampirkan' }}</span>
                                </div>
                            </div>
                            @if($permohonan->file_surat_pengantar)
                                <a href="{{ asset('storage/' . $permohonan->file_surat_pengantar) }}" target="_blank" class="text-maroon-700 hover:underline font-bold text-[11px]">Unduh</a>
                            @endif
                        </div>

                        <div class="p-3.5 rounded-xl border border-bone-300 flex items-center justify-between bg-white text-xs">
                            <div class="flex items-center gap-2.5">
                                <i class="fa-solid fa-book text-indigo-600 text-lg"></i>
                                <div>
                                    <span class="font-bold text-slate-800 block">Proposal Penelitian</span>
                                    <span class="text-[10px] text-slate-400">{{ $permohonan->file_proposal ? 'File Tersedia' : 'Belum Dilampirkan' }}</span>
                                </div>
                            </div>
                            @if($permohonan->file_proposal)
                                <a href="{{ asset('storage/' . $permohonan->file_proposal) }}" target="_blank" class="text-maroon-700 hover:underline font-bold text-[11px]">Unduh</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Panel Tindakan Khusus Admin & Verifikator Riset -->
            <div class="lg:col-span-4 space-y-6">
                @if(Auth::user()->hasRole(['Admin', 'verif_riset']))
                    <div class="bg-white rounded-3xl p-6 border border-bone-300 shadow-sm space-y-4">
                        <div class="border-b border-bone-200 pb-3">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-maroon-700">Aksi Otoritas Verifikator</span>
                            <h3 class="font-black text-sm text-slate-900 mt-0.5">Telaah & Verifikasi Berkas</h3>
                        </div>

                        <form method="POST" action="{{ route('dashboard.riset.update-status', $permohonan->id) }}" class="space-y-4">
                            @csrf
                            @method('PATCH')

                            <div class="space-y-1">
                                <label for="status" class="block text-xs font-bold text-slate-700">Perbarui Status Berkas</label>
                                <select name="status" id="status" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3">
                                    <option value="Menunggu Review" {{ $permohonan->status == 'Menunggu Review' ? 'selected' : '' }}>Menunggu Review</option>
                                    <option value="Sedang Ditelaah" {{ $permohonan->status == 'Sedang Ditelaah' ? 'selected' : '' }}>Sedang Ditelaah (Disposisi)</option>
                                    <option value="Disetujui" {{ $permohonan->status == 'Disetujui' ? 'selected' : '' }}>Disetujui (Terbitkan Izin)</option>
                                    <option value="Ditolak" {{ $permohonan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak (Perlu Revisi)</option>
                                </select>
                            </div>

                            <div class="space-y-1">
                                <label for="catatan_reviewer" class="block text-xs font-bold text-slate-700">Catatan Disposisi / Hasil Telaah</label>
                                <textarea name="catatan_reviewer" id="catatan_reviewer" rows="4" placeholder="Tuliskan catatan teknis atau alasan perbaikan berkas..." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3">{{ old('catatan_reviewer', $permohonan->catatan_reviewer) }}</textarea>
                            </div>

                            <button type="submit" class="w-full bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs py-2.5 rounded-xl transition shadow">
                                Simpan Perubahan Status
                            </button>
                        </form>
                    </div>
                @endif

                <!-- Kartu Status Alur Verifikasi -->
                <div class="bg-bone-100 rounded-3xl p-6 border border-bone-300 space-y-3 text-xs">
                    <h4 class="font-bold text-slate-900">Alur Standar Rekomendasi Riset:</h4>
                    <ol class="space-y-2 text-slate-600 list-decimal pl-4">
                        <li>Pengajuan berkas online oleh pemohon.</li>
                        <li>Verifikasi berkas administrasi dan surat kampus.</li>
                        <li>Telaah subtansi oleh Tim Riset BRIDA Makassar.</li>
                        <li>Penerbitan surat rekomendasi resmi ke instansi tujuan.</li>
                    </ol>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
