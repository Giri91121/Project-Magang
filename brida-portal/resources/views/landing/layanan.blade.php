@extends('layouts.landing')

@section('title', 'Layanan Riset & Inovasi Daerah - BRIDA Kota Makassar')

@section('content')
<!-- Header Banner Halaman (Breadcrumb & Title) -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <!-- Breadcrumbs -->
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">Layanan Riset & Inovasi</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                Katalog Layanan Terpadu BRIDA
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                Fasilitasi riset kebijakan berbasis bukti ilmiah, rekomendasi izin penelitian, pendampingan inovasi perangkat daerah, serta kemitraan riset perguruan tinggi dan BRIN.
            </p>
        </div>
    </section>

    <!-- Main Content Layanan -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full space-y-16">
        
        <!-- 4 Pilar Layanan Utama Detail -->
        <section class="space-y-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Pelayanan Prima</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">4 Klaster Layanan Resmi BRIDA Kota Makassar</h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-2">Disediakan secara transparan, akuntabel, dan bebas biaya retribusi (gratis) bagi seluruh pemangku kepentingan.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                
                <!-- Layanan 1: Rekomendasi Riset & Izin Penelitian -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-bone-300 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-book-open-reader"></i>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-maroon-700 bg-rose-50 px-2.5 py-1 rounded-full">Akademisi & Peneliti</span>
                    <h3 class="text-xl font-bold text-slate-900 mt-3 mb-2">1. Layanan Rekomendasi & Izin Penelitian</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                        Pelayanan penerbitan surat rekomendasi riset bagi mahasiswa (S1/S2/S3), dosen, lembaga survei, dan peneliti independen yang berlokasi penelitian di wilayah kerja Pemerintah Kota Makassar.
                    </p>
                    <div class="bg-bone-100 rounded-xl p-4 border border-bone-300 space-y-2 text-xs">
                        <h4 class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i> Persyaratan Berkas:
                        </h4>
                        <ul class="list-disc list-inside text-slate-600 space-y-1 pl-1">
                            <li>Surat Pengantar dari Dekan/Rektor/Pimpinan Lembaga Penelitian.</li>
                            <li>Proposal Riset yang memuat judul, tujuan, dan metode.</li>
                            <li>KTP / Tanda Pengenal Peneliti & Nomor WhatsApp Aktif.</li>
                            <li>Surat persetujuan lokasi OPD yang dituju (bila riset kedinasan).</li>
                        </ul>
                        <div class="pt-2 border-t border-bone-300/80 flex items-center justify-between text-[11px] text-slate-500">
                            <span><i class="fa-regular fa-clock mr-1"></i> Estimasi: 1 - 3 Hari Kerja</span>
                            <span class="font-bold text-emerald-600">Biaya: Rp 0 (Gratis)</span>
                        </div>
                    </div>
                </div>

                <!-- Layanan 2: Fasilitasi & Pendampingan Inovasi Daerah -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-bone-300 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-maroon-700 bg-rose-50 px-2.5 py-1 rounded-full">Perangkat Daerah & Masyarakat</span>
                    <h3 class="text-xl font-bold text-slate-900 mt-3 mb-2">2. Pendampingan Inovasi Daerah (IGA)</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                        Bimbingan teknis bagi Organisasi Perangkat Daerah (OPD), BLUD, BUMD, dan inovator masyarakat dalam menyusun proposal inovasi, uji coba kematangan, hingga pelaporan Innovative Government Award (IGA) Kemendagri.
                    </p>
                    <div class="bg-bone-100 rounded-xl p-4 border border-bone-300 space-y-2 text-xs">
                        <h4 class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i> Cakupan Pendampingan:
                        </h4>
                        <ul class="list-disc list-inside text-slate-600 space-y-1 pl-1">
                            <li>Pemetaan 36 Indikator Kematangan Inovasi Daerah.</li>
                            <li>Penyusunan Video & Proposal Dokumentasi Replikasi.</li>
                            <li>Klinik Inovasi berkala untuk penguatan mutu pelayanan publik.</li>
                            <li>Verifikasi lapangan dan validasi dampak kemanfaatan sosial.</li>
                        </ul>
                        <div class="pt-2 border-t border-bone-300/80 flex items-center justify-between text-[11px] text-slate-500">
                            <span><i class="fa-regular fa-calendar-check mr-1"></i> Jadwal: Sesuai Kalender IID</span>
                            <span class="font-bold text-emerald-600">Status: Aktif</span>
                        </div>
                    </div>
                </div>

                <!-- Layanan 3: Kajian Kebijakan Berbasis Bukti Ilmiah -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-bone-300 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-scale-balanced"></i>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-maroon-700 bg-rose-50 px-2.5 py-1 rounded-full">Pemerintah & Kebijakan</span>
                    <h3 class="text-xl font-bold text-slate-900 mt-3 mb-2">3. Penyusunan Riset & Rekomendasi Kebijakan</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                        Penyusunan telaahan staf, naskah akademik, dan riset strategis guna mendukung perumusan peraturan wali kota, rencana pembangunan jangka menengah, serta respon saintifik terhadap isu perkotaan.
                    </p>
                    <div class="bg-bone-100 rounded-xl p-4 border border-bone-300 space-y-2 text-xs">
                        <h4 class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i> Fokus Telaah Strategis:
                        </h4>
                        <ul class="list-disc list-inside text-slate-600 space-y-1 pl-1">
                            <li>Makassar Low Carbon City & Manajemen Lingkungan.</li>
                            <li>Inklusivitas Ekonomi Lorong Wisata & UMKM Cerdas.</li>
                            <li>Tata Kelola Digital & Ketahanan Siber Birokrasi.</li>
                            <li>Kajian Dampak Sosial Ekonomi Program Unggulan Pemda.</li>
                        </ul>
                        <div class="pt-2 border-t border-bone-300/80 flex items-center justify-between text-[11px] text-slate-500">
                            <span><i class="fa-solid fa-microscope mr-1"></i> Tim: Peneliti Ahli & Akademisi</span>
                            <span class="font-bold text-maroon-700">Rekomendasi Resmi</span>
                        </div>
                    </div>
                </div>

                <!-- Layanan 4: Kemitraan Akademisi, Universitas & BRIN -->
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-bone-300 shadow-sm hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl mb-4">
                        <i class="fa-solid fa-handshake-angle"></i>
                    </div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-maroon-700 bg-rose-50 px-2.5 py-1 rounded-full">Kolaborasi Pentahelix</span>
                    <h3 class="text-xl font-bold text-slate-900 mt-3 mb-2">4. Fasilitasi Kerja Sama Riset (BRIN & Kampus)</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4">
                        Penyediaan kanal kerja sama riset terapan antara Pemerintah Kota Makassar dengan Badan Riset dan Inovasi Nasional (BRIN), LPPM Perguruan Tinggi, dan industri melalui skema kerja sama mutualisme.
                    </p>
                    <div class="bg-bone-100 rounded-xl p-4 border border-bone-300 space-y-2 text-xs">
                        <h4 class="font-bold text-slate-800 flex items-center gap-1.5">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i> Bentuk Fasilitasi:
                        </h4>
                        <ul class="list-disc list-inside text-slate-600 space-y-1 pl-1">
                            <li>Penyusunan Nota Kesepahaman (MoU) dan PKS Penelitian.</li>
                            <li>Penyediaan data sekunder sektoral untuk analisis akademis.</li>
                            <li>Pemanfaatan hasil riset untuk regulasi daerah (*hilirisasi*).</li>
                            <li>Fasilitasi seminar desiminasi hasil riset tahunan.</li>
                        </ul>
                        <div class="pt-2 border-t border-bone-300/80 flex items-center justify-between text-[11px] text-slate-500">
                            <span><i class="fa-solid fa-building-columns mr-1"></i> Mitra: Unhas, UNM, dll.</span>
                            <span class="font-bold text-maroon-700">MoU Kedinasan</span>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Alur Standar Pelayanan (SOP) -->
        <section class="bg-white rounded-2xl p-8 border border-bone-300 shadow-sm">
            <div class="border-b border-bone-300 pb-4 mb-6">
                <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Standar Operasional Prosedur</span>
                <h3 class="text-2xl font-black text-slate-900 mt-1">Alur Pengajuan Permohonan Layanan Riset</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Tahapan resmi pemohon riset untuk mendapatkan rekomendasi dari BRIDA Kota Makassar.</p>
            </div>

            <div class="grid sm:grid-cols-4 gap-6 relative">
                <!-- Langkah 1 -->
                <div class="bg-bone-100 p-5 rounded-xl border border-bone-300 text-center relative">
                    <div class="w-10 h-10 rounded-full bg-maroon-700 text-white font-bold flex items-center justify-center mx-auto mb-3 shadow">
                        1
                    </div>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">Pengajuan Berkas</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pemohon menyerahkan surat permohonan dan proposal riset ke loket BRIDA atau surel resmi.
                    </p>
                </div>

                <!-- Langkah 2 -->
                <div class="bg-bone-100 p-5 rounded-xl border border-bone-300 text-center relative">
                    <div class="w-10 h-10 rounded-full bg-maroon-700 text-white font-bold flex items-center justify-center mx-auto mb-3 shadow">
                        2
                    </div>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">Verifikasi & Telaah</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Petugas fungsional menelaah kesesuaian lokus, tema riset, dan kelengkapan administratif.
                    </p>
                </div>

                <!-- Langkah 3 -->
                <div class="bg-bone-100 p-5 rounded-xl border border-bone-300 text-center relative">
                    <div class="w-10 h-10 rounded-full bg-maroon-700 text-white font-bold flex items-center justify-center mx-auto mb-3 shadow">
                        3
                    </div>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">Penerbitan Surat</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Kepala BRIDA menandatangani surat rekomendasi riset / izin penelitian resmi.
                    </p>
                </div>

                <!-- Langkah 4 -->
                <div class="bg-bone-100 p-5 rounded-xl border border-bone-300 text-center relative">
                    <div class="w-10 h-10 rounded-full bg-maroon-700 text-white font-bold flex items-center justify-center mx-auto mb-3 shadow">
                        4
                    </div>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">Serah Terima & Riset</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Surat diserahkan kepada pemohon dalam format fisik atau PDF resmi ber-barcode untuk mulai riset.
                    </p>
                </div>
            </div>
        </section>

        <!-- Call to Action Bantuan & Unduh Dokumen -->
        <section class="bg-maroon-900 text-white rounded-2xl p-8 sm:p-10 flex flex-col md:flex-row items-center justify-between gap-6 shadow-lg">
            <div class="space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-rose-300 bg-rose-950/60 px-3 py-1 rounded-full border border-rose-500/30">Meja Bantuan Riset</span>
                <h3 class="text-2xl font-bold text-white">Butuh Konsultasi Riset atau Inovasi?</h3>
                <p class="text-xs sm:text-sm text-rose-100/90 max-w-xl leading-relaxed">
                    Kunjungi kantor kami di Balai Kota Makassar atau hubungi tim fungsional periset BRIDA melalui surel resmi untuk jadwal konsultasi langsung.
                </p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 shrink-0">
                <a href="mailto:brida@makassarkota.go.id" class="inline-flex items-center justify-center gap-2 bg-white text-maroon-800 hover:bg-bone-100 font-bold text-xs px-5 py-3 rounded-xl transition shadow">
                    <i class="fa-solid fa-envelope"></i>
                    <span>Kirim Surel Permohonan</span>
                </a>
                <a href="{{ asset('docs') }}/Panduan_Pengguna_BRIDA_Makassar.txt" download class="inline-flex items-center justify-center gap-2 bg-maroon-800 hover:bg-maroon-950 text-white border border-rose-400/30 font-bold text-xs px-5 py-3 rounded-xl transition shadow">
                    <i class="fa-solid fa-download"></i>
                    <span>Unduh Panduan Layanan (TXT)</span>
                </a>
            </div>
        </section>

    </main>
@endsection
