@extends('layouts.landing')

@section('title', 'Pemerintahan & Profil BRIDA Kota Makassar')
@section('meta_description', 'Profil kelembagaan, visi misi, struktur organisasi, serta tugas pokok dan fungsi Badan Riset dan Inovasi Daerah (BRIDA) Pemerintah Kota Makassar.')

@section('content')
<main>
    <!-- Header Banner Halaman (Breadcrumb & Title) -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <!-- Breadcrumbs -->
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">Pemerintahan</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                Profil & Tata Kelola Kelembagaan
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                Mengenal lebih dekat Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar, fungsi penunjang urusan pemerintahan daerah di bidang penelitian, pengembangan, pengkajian, dan inovasi.
            </p>
        </div>
    </section>

    <!-- Konten Utama Pemerintahan -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">
        
        <!-- Bagian 1: Tentang Lembaga & Kedudukan (Dinamis dari Editor Landing Page) -->
        <section id="profil" class="grid lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-5">
                <div class="relative rounded-2xl overflow-hidden border-2 border-bone-300 shadow-xl bg-slate-900">
                    <img src="{{ $portalSettings['gov_office_photo'] ?? 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=800&q=80' }}" alt="Gedung Balai Kota Makassar" class="w-full h-80 object-cover opacity-90">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute bottom-5 left-5 right-5 text-white">
                        <span class="text-[10px] uppercase font-bold tracking-wider text-rose-300">Pemerintah Kota Makassar</span>
                        <h4 class="font-bold text-sm sm:text-base">{{ $portalSettings['gov_office_caption'] ?? 'Sekretariat BRIDA Kota Makassar' }}</h4>
                        <p class="text-xs text-bone-300 mt-1">{{ $portalSettings['office_address'] ?? 'Balai Kota Makassar, Jl. Ahmad Yani No. 2' }}</p>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 space-y-4">
                <div>
                    <span class="text-xs font-bold tracking-widest uppercase text-maroon-700">Profil Lembaga</span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">
                        {{ $portalSettings['gov_profile_title'] ?? 'Badan Riset dan Inovasi Daerah (BRIDA)' }}
                    </h2>
                </div>

                <p class="text-sm text-slate-600 leading-relaxed">
                    {{ $portalSettings['gov_profile_p1'] ?? 'Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar merupakan unsur penunjang urusan pemerintahan di bidang penelitian dan pengembangan yang menjadi kewenangan daerah. BRIDA dibentuk untuk mengintegrasikan seluruh ekosistem riset terapan dan inovasi demi memperkuat pengambilan kebijakan berbasis data dan bukti ilmiah.' }}
                </p>

                <p class="text-sm text-slate-600 leading-relaxed">
                    {{ $portalSettings['gov_profile_p2'] ?? 'Sesuai dengan amanat peraturan perundang-undangan dan koordinasi bersama Badan Riset dan Inovasi Nasional (BRIN), BRIDA Kota Makassar berfungsi sebagai jembatan strategis antara akademisi, industri, masyarakat, dan pemerintah (Pentahelix) guna mempercepat terwujudnya Makassar sebagai Kota Dunia yang Maju, Tangguh, dan Rendah Karbon.' }}
                </p>

                <div class="pt-2 flex flex-wrap gap-4 text-xs font-semibold text-slate-700">
                    <div class="flex items-center gap-2 bg-bone-200/60 px-3.5 py-2 rounded-xl border border-bone-300">
                        <i class="fa-solid fa-landmark text-maroon-700"></i>
                        <span>SKPD Penunjang Resmi Pemkot Makassar</span>
                    </div>
                    <div class="flex items-center gap-2 bg-bone-200/60 px-3.5 py-2 rounded-xl border border-bone-300">
                        <i class="fa-solid fa-handshake text-maroon-700"></i>
                        <span>Mitra Strategis BRIN RI</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bagian 2: Visi & Misi (Dinamis dari Editor Landing Page) -->
        <section id="visi-misi" class="bg-bone-100/80 rounded-3xl p-8 sm:p-12 border border-bone-300 shadow-sm space-y-8">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Arah & Haluan Strategis</span>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900">Visi & Misi BRIDA Kota Makassar</h3>
                <p class="text-xs sm:text-sm text-slate-500">Peta jalan transformasi riset dan penguatan inovasi daerah jangka panjang.</p>
            </div>

            <div class="grid md:grid-cols-12 gap-8 items-stretch">
                <!-- Visi (Kiri - 5 Kolom) -->
                <div class="md:col-span-5 bg-gradient-to-br from-maroon-900 to-slate-900 text-white rounded-2xl p-7 flex flex-col justify-between shadow-md">
                    <div class="space-y-4">
                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-rose-300 text-xl border border-white/20">
                            <i class="fa-solid fa-bullseye"></i>
                        </div>
                        <span class="text-xs font-bold uppercase tracking-wider text-rose-300">Visi Pembangunan</span>
                        <h4 class="text-xl sm:text-2xl font-bold leading-snug">
                            {{ $portalSettings['gov_visi'] ?? '"Menjadi Pusat Rujukan Riset dan Inovasi yang Adaptif Menuju Makassar Kota Dunia yang Berdaya Saing."' }}
                        </h4>
                    </div>
                    <p class="text-xs text-bone-300 mt-6 pt-4 border-t border-white/20 leading-relaxed italic">
                        Mewujudkan perumusan kebijakan kota berbasis data ilmiah dan keberlanjutan masa depan masyarakat.
                    </p>
                </div>

                <!-- Misi (Kanan - 7 Kolom) -->
                <div class="md:col-span-7 bg-white rounded-2xl p-7 border border-bone-300 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2.5 mb-5">
                            <div class="w-10 h-10 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-lg">
                                <i class="fa-solid fa-list-check"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-base text-slate-900">Misi Kelembagaan</h4>
                                <p class="text-xs text-slate-400">Komitmen aksi nyata BRIDA Kota Makassar</p>
                            </div>
                        </div>

                        <div class="space-y-4 text-xs sm:text-sm text-slate-600">
                            <div class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full bg-maroon-700 text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">1</span>
                                <p class="leading-relaxed">{{ $portalSettings['gov_misi_1'] ?? 'Meningkatkan Kualitas Riset Kebijakan: Menyusun kajian ilmiah tematik strategis untuk mendukung respon kebijakan Wali Kota terhadap tantangan perkotaan terkini.' }}</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full bg-maroon-700 text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">2</span>
                                <p class="leading-relaxed">{{ $portalSettings['gov_misi_2'] ?? 'Mengakselerasi Ekosistem Inovasi SKPD: Mendorong dan mendampingi karya inovasi pelayanan publik dan tata kelola di lingkungan perangkat daerah Kota Makassar.' }}</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full bg-maroon-700 text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">3</span>
                                <p class="leading-relaxed">{{ $portalSettings['gov_misi_3'] ?? 'Memperkuat Kemitraan Pentahelix: Membangun kolaborasi riset terapan bersama perguruan tinggi (Unhas, UNM, dll.), industri, dan lembaga riset nasional (BRIN).' }}</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="w-6 h-6 rounded-full bg-maroon-700 text-white flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">4</span>
                                <p class="leading-relaxed">{{ $portalSettings['gov_misi_4'] ?? 'Mendorong Difusi & Hilirisasi Inovasi: Memastikan hasil riset terapan dapat diaplikasikan langsung untuk meningkatkan mutu taraf hidup warga kota.' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bagian 3: Tugas Pokok & Fungsi (Tupoksi) -->
        <section id="tupoksi" class="space-y-8">
            <div class="border-b border-bone-300 pb-4">
                <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Tugas Pokok & Fungsi</span>
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">Urusan & Kewenangan Kedinasan</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Mengacu pada Peraturan Wali Kota dan Regulasi Pembentukan BRIDA.</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Tupoksi 1 -->
                <div class="bg-white p-6 rounded-2xl border border-bone-300 shadow-sm hover:border-maroon-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <h4 class="font-bold text-base text-slate-900">Perumusan Kebijakan Teknis</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Penyusunan kebijakan teknis daerah di bidang riset, pengkajian, penerapan ilmu pengetahuan dan teknologi, serta invensi dan inovasi daerah.
                    </p>
                </div>

                <!-- Tupoksi 2 -->
                <div class="bg-white p-6 rounded-2xl border border-bone-300 shadow-sm hover:border-maroon-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-microscope"></i>
                    </div>
                    <h4 class="font-bold text-base text-slate-900">Pelaksanaan Riset Terapan</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pelaksanaan penelitian, pengembangan, dan pengkajian ilmiah terapan lintas sektor (sosial ekonomi, lingkungan rendah karbon, dan teknologi cerdas).
                    </p>
                </div>

                <!-- Tupoksi 3 -->
                <div class="bg-white p-6 rounded-2xl border border-bone-300 shadow-sm hover:border-maroon-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <h4 class="font-bold text-base text-slate-900">Pembinaan Inovasi Daerah</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Fasilitasi, pengawalan, dan penilaian kematangan inovasi perangkat daerah (OPD) untuk pengukuran Indeks Inovasi Daerah (IID) tahunan Kemendagri.
                    </p>
                </div>

                <!-- Tupoksi 4 -->
                <div class="bg-white p-6 rounded-2xl border border-bone-300 shadow-sm hover:border-maroon-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-route"></i>
                    </div>
                    <h4 class="font-bold text-base text-slate-900">Peta Jalan RIRD</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Penyusunan Rencana Induk Riset Daerah (RIRD) sebagai pedoman arah riset dan pengembangan teknologi jangka menengah dan panjang Pemerintah Kota.
                    </p>
                </div>

                <!-- Tupoksi 5 -->
                <div class="bg-white p-6 rounded-2xl border border-bone-300 shadow-sm hover:border-maroon-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-certificate"></i>
                    </div>
                    <h4 class="font-bold text-base text-slate-900">Fasilitasi Kekayaan Intelektual</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Pendampingan perolehan Hak Cipta, Paten, dan perlindungan Hak Kekayaan Intelektual (HAKI) bagi para inovator dan periset di lingkungan kota.
                    </p>
                </div>

                <!-- Tupoksi 6 -->
                <div class="bg-white p-6 rounded-2xl border border-bone-300 shadow-sm hover:border-maroon-700 transition space-y-3">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-maroon-700 flex items-center justify-center text-xl">
                        <i class="fa-solid fa-handshake-angle"></i>
                    </div>
                    <h4 class="font-bold text-base text-slate-900">Sinergi & Kemitraan Ilmiah</h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Koordinasi dan sinkronisasi kerja sama riset dengan BRIN, perguruan tinggi, lembaga penelitian swasta, serta pemangku kepentingan masyarakat.
                    </p>
                </div>
            </div>
        </section>

        <!-- Bagian 4: Struktur Organisasi Bidang -->
        <section class="bg-white rounded-2xl p-8 border border-bone-300 shadow-sm space-y-6">
            <div class="border-b border-bone-300 pb-4">
                <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Struktur Kelembagaan</span>
                <h3 class="text-2xl font-black text-slate-900 mt-1">Susunan Bidang Kerja BRIDA Kota Makassar</h3>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Pembagian unit kerja dalam menjalankan tugas operasional riset dan inovasi.</p>
            </div>

            <div class="grid sm:grid-cols-3 gap-6 text-xs">
                <div class="p-5 rounded-xl bg-bone-100 border border-bone-300 space-y-2">
                    <div class="w-9 h-9 rounded-lg bg-maroon-700 text-white flex items-center justify-center font-bold text-sm">01</div>
                    <h4 class="font-bold text-sm text-slate-900">Sekretariat Badan</h4>
                    <p class="text-slate-600 leading-relaxed">Mengoordinasikan urusan perencanaan program, pengelolaan keuangan daerah, kepegawaian, perlengkapan umum, dan administrasi kedinasan.</p>
                </div>

                <div class="p-5 rounded-xl bg-bone-100 border border-bone-300 space-y-2">
                    <div class="w-9 h-9 rounded-lg bg-maroon-700 text-white flex items-center justify-center font-bold text-sm">02</div>
                    <h4 class="font-bold text-sm text-slate-900">Bidang Riset & Kebijakan</h4>
                    <p class="text-slate-600 leading-relaxed">Menyelenggarakan kajian kebijakan strategis, telaah staf ilmiah, fasilitasi rekomendasi riset kampus, dan kerja sama kemitraan BRIN.</p>
                </div>

                <div class="p-5 rounded-xl bg-bone-100 border border-bone-300 space-y-2">
                    <div class="w-9 h-9 rounded-lg bg-maroon-700 text-white flex items-center justify-center font-bold text-sm">03</div>
                    <h4 class="font-bold text-sm text-slate-900">Bidang Fasilitasi & Inovasi</h4>
                    <p class="text-slate-600 leading-relaxed">Melaksanakan pemetaan karya inovasi perangkat daerah, bimbingan teknis IGA Kemendagri, difusi replikasi inovasi, serta fasilitasi HAKI.</p>
                </div>
            </div>
        </section>

    </div>
</main>
@endsection
