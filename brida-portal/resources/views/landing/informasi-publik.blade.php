@extends('layouts.landing')

@section('title', 'Informasi Publik & Regulasi Riset - BRIDA Kota Makassar')

@section('content')
<!-- Header Banner Halaman -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">Informasi Publik & Regulasi</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                Keterbukaan Informasi Publik & Regulasi Riset
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                Dokumentasi regulasi inovasi daerah, laporan kinerja, statistik ekosistem riset, dan layanan Pejabat Pengelola Informasi dan Dokumentasi (PPID) BRIDA Kota Makassar.
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full space-y-16">

        <!-- Statistik Keterbukaan Informasi & Capaian -->
        <section class="grid sm:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-bone-300 shadow-sm text-center">
                <div class="text-3xl font-black text-maroon-700">120+</div>
                <div class="text-xs font-bold text-slate-800 uppercase mt-1">Inovasi Terdaftar</div>
                <p class="text-[11px] text-slate-500 mt-1">Basis data inovasi perangkat daerah dalam database IGA Kemendagri.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-bone-300 shadow-sm text-center">
                <div class="text-3xl font-black text-emerald-600">Sangat Inovatif</div>
                <div class="text-xs font-bold text-slate-800 uppercase mt-1">Predikat IID Nasional</div>
                <p class="text-[11px] text-slate-500 mt-1">Penilaian Indeks Inovasi Daerah Kementerian Dalam Negeri RI.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-bone-300 shadow-sm text-center">
                <div class="text-3xl font-black text-maroon-700">100%</div>
                <div class="text-xs font-bold text-slate-800 uppercase mt-1">Keterbukaan Informasi</div>
                <p class="text-[11px] text-slate-500 mt-1">Akses publik terhadap dokumen kebijakan dan telaahan staf terbuka.</p>
            </div>
        </section>

        <!-- Regulasi & Dasar Hukum -->
        <section id="regulasi" class="space-y-6">
            <div class="border-b border-bone-300 pb-4">
                <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Payung Hukum</span>
                <h2 class="text-2xl font-black text-slate-900 mt-1">Regulasi Riset & Inovasi Daerah</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Dasar hukum penyelenggaraan riset, pembinaan inovasi daerah, serta keterbukaan informasi.</p>
            </div>

            <div class="space-y-3">
                
                <div class="bg-white p-5 rounded-xl border border-bone-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-maroon-700 transition">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-rose-50 text-maroon-700 flex items-center justify-center text-lg shrink-0 mt-0.5">
                            <i class="fa-solid fa-gavel"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-maroon-700 bg-rose-50 px-2 py-0.5 rounded">Peraturan Pemerintah</span>
                            <h3 class="font-bold text-sm text-slate-900 mt-1">PP No. 38 Tahun 2017 tentang Inovasi Daerah</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Mengatur pedoman pengusulan, tata kelola, perlindungan, dan penilaian kemanfaatan inovasi perangkat daerah.</p>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <span class="inline-flex items-center gap-1.5 text-xs text-slate-500 bg-bone-100 px-3 py-1.5 rounded-lg border border-bone-300">
                            <i class="fa-solid fa-file-shield text-emerald-600"></i> Berlaku Nasional
                        </span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-bone-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-maroon-700 transition">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-rose-50 text-maroon-700 flex items-center justify-center text-lg shrink-0 mt-0.5">
                            <i class="fa-solid fa-gavel"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-maroon-700 bg-rose-50 px-2 py-0.5 rounded">Peraturan Menteri</span>
                            <h3 class="font-bold text-sm text-slate-900 mt-1">Permendagri No. 104 Tahun 2018 tentang Penilaian & Pemberian Penghargaan Inovasi Daerah</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Petunjuk teknis pengukuran Indeks Inovasi Daerah (IID) dan Innovative Government Award.</p>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <span class="inline-flex items-center gap-1.5 text-xs text-slate-500 bg-bone-100 px-3 py-1.5 rounded-lg border border-bone-300">
                            <i class="fa-solid fa-file-shield text-emerald-600"></i> Standar Kemendagri
                        </span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl border border-bone-300 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-maroon-700 transition">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-lg bg-rose-50 text-maroon-700 flex items-center justify-center text-lg shrink-0 mt-0.5">
                            <i class="fa-solid fa-gavel"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold uppercase text-maroon-700 bg-rose-50 px-2 py-0.5 rounded">Peraturan Daerah Kota Makassar</span>
                            <h3 class="font-bold text-sm text-slate-900 mt-1">Perda Kota Makassar tentang Pembentukan Badan Riset dan Inovasi Daerah (BRIDA)</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Landasan operasional kedudukan, susunan organisasi, tugas pokok dan fungsi BRIDA Kota Makassar.</p>
                        </div>
                    </div>
                    <div class="shrink-0">
                        <span class="inline-flex items-center gap-1.5 text-xs text-slate-500 bg-bone-100 px-3 py-1.5 rounded-lg border border-bone-300">
                            <i class="fa-solid fa-file-shield text-emerald-600"></i> Regulasi Daerah
                        </span>
                    </div>
                </div>

            </div>
        </section>

        <!-- Layanan PPID BRIDA (Pejabat Pengelola Informasi & Dokumentasi) -->
        <section id="ppid-layanan" class="bg-white rounded-2xl p-8 border border-bone-300 shadow-sm space-y-6">
            <div class="border-b border-bone-300 pb-4">
                <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Layanan PPID</span>
                <h2 class="text-2xl font-black text-slate-900 mt-1">Mekanisme Permohonan Informasi Publik</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Sesuai amanat Undang-Undang No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6 text-xs">
                <div class="bg-bone-100 p-5 rounded-xl border border-bone-300">
                    <div class="text-maroon-700 text-2xl font-bold mb-2">01</div>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">Pengajuan Permohonan</h4>
                    <p class="text-slate-600 leading-relaxed">
                        Pemohon mengisi formulir permohonan informasi publik dengan melampirkan identitas diri (KTP/Akta Pendirian) dan menyatakan tujuan penggunaan informasi.
                    </p>
                </div>
                <div class="bg-bone-100 p-5 rounded-xl border border-bone-300">
                    <div class="text-maroon-700 text-2xl font-bold mb-2">02</div>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">Pemeriksaan & Konfirmasi</h4>
                    <p class="text-slate-600 leading-relaxed">
                        Petugas PPID memeriksa kelayakan informasi (apakah informasi terbuka atau dikecualikan) dalam jangka waktu paling lambat 10 hari kerja.
                    </p>
                </div>
                <div class="bg-bone-100 p-5 rounded-xl border border-bone-300">
                    <div class="text-maroon-700 text-2xl font-bold mb-2">03</div>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">Penyerahan Dokumen</h4>
                    <p class="text-slate-600 leading-relaxed">
                        Dokumen yang diminta diserahkan melalui salinan digital (surel) atau cetak fisik secara transparan dan akuntabel.
                    </p>
                </div>
            </div>

            <div class="bg-rose-50 p-4 rounded-xl border border-rose-200 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-headset text-2xl text-maroon-700"></i>
                    <div>
                        <span class="font-bold text-slate-900 block">Meja Pelayanan Informasi PPID BRIDA Makassar</span>
                        <span class="text-slate-600 text-[11px]">Gedung Balai Kota Makassar, Lantai 3 &bull; Surel: brida@makassarkota.go.id</span>
                    </div>
                </div>
                <a href="mailto:brida@makassarkota.go.id?subject=Permohonan%20Informasi%20Publik%20PPID" class="bg-maroon-700 hover:bg-maroon-800 text-white font-bold px-4 py-2 rounded-lg transition shadow">
                    Hubungi Petugas PPID
                </a>
            </div>
        </section>

        <!-- Unduhan Dokumen Publik -->
        <section id="unduhan" class="space-y-6">
            <div class="border-b border-bone-300 pb-4">
                <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Pusat Unduhan</span>
                <h2 class="text-2xl font-black text-slate-900 mt-1">Dokumen & Publikasi Resmi</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Unduh berkas panduan teknis, formulir pengusulan, dan ringkasan kajian riset daerah.</p>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                
                <div class="bg-white p-5 rounded-xl border border-bone-300 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <i class="fa-solid fa-file-lines text-2xl text-maroon-700"></i>
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900">Buku Panduan Layanan & Informasi BRIDA</h4>
                            <span class="text-[11px] text-slate-400">Format TXT/Dokumen &bull; 2.5 KB</span>
                        </div>
                    </div>
                    <a href="{{ asset('docs') }}/Panduan_Pengguna_BRIDA_Makassar.txt" download class="bg-maroon-700 hover:bg-maroon-800 text-white text-xs font-bold px-3 py-2 rounded-lg transition shrink-0">
                        <i class="fa-solid fa-download mr-1"></i> Unduh
                    </a>
                </div>

                <div class="bg-white p-5 rounded-xl border border-bone-300 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <i class="fa-solid fa-file-pdf text-2xl text-maroon-700"></i>
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900">Formulir Permohonan Izin Riset Mahasiswa</h4>
                            <span class="text-[11px] text-slate-400">Format Standar Rekomendasi Kampus</span>
                        </div>
                    </div>
                    <a href="{{ route('layanan') }}" class="bg-bone-200 hover:bg-bone-300 text-slate-800 text-xs font-bold px-3 py-2 rounded-lg transition shrink-0">
                        Lihat Prosedur
                    </a>
                </div>

            </div>
        </section>

    </main>
@endsection
