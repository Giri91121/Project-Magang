@extends('layouts.landing')

@section('title', 'Hubungi Kami & Sekretariat BRIDA Kota Makassar')
@section('meta_description', 'Kontak resmi, lokasi sekretariat kantor, saluran aduan, dan formulir pesan langsung Badan Riset dan Inovasi Daerah (BRIDA) Pemerintah Kota Makassar.')

@section('content')
<main>
    <!-- Header Banner Halaman (Breadcrumb & Title) -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <!-- Breadcrumbs -->
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">Kontak</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                Kontak & Saluran Komunikasi Resmi
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                Kami siap melayani kebutuhan konsultasi riset, fasilitasi inovasi daerah, serta koordinasi kelembagaan. Silakan hubungi kami melalui saluran komunikasi tertera di bawah.
            </p>
        </div>
    </section>

    <!-- Konten Utama Kontak -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 space-y-16">

        <!-- Grid 3 Kartu Saluran Utama -->
        <section class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Kartu Alamat -->
            <div class="bg-white rounded-2xl p-6 border border-bone-300 shadow-sm hover:shadow-md transition space-y-4">
                <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-center text-maroon-700 text-xl">
                    <i class="fa-solid fa-building-flag"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Alamat Sekretariat</h3>
                    <p class="text-xs text-slate-500 mt-1">Kantor Balai Kota Makassar</p>
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    {{ $portalSettings['office_address'] ?? 'Gedung Balai Kota Makassar Lantai 2, Jl. Ahmad Yani No. 2, Baru, Kec. Ujung Pandang, Kota Makassar, Sulawesi Selatan 90111' }}
                </p>
                <div class="pt-2 text-xs font-semibold text-maroon-700">
                    <a href="https://maps.google.com/?q=Balai+Kota+Makassar" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 hover:underline">
                        <span>Buka di Google Maps</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Kartu Jam Kerja & Telepon -->
            <div class="bg-white rounded-2xl p-6 border border-bone-300 shadow-sm hover:shadow-md transition space-y-4">
                <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-center text-maroon-700 text-xl">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Jam Operasional & Kontak</h3>
                    <p class="text-xs text-slate-500 mt-1">Pelayanan Tatap Muka & Daring</p>
                </div>
                <div class="text-xs text-slate-600 space-y-2">
                    <p class="font-medium text-slate-700 leading-relaxed">{{ $portalSettings['work_hours'] ?? 'Senin - Kamis (08.00 - 16.00 WITA), Jumat (08.00 - 16.30 WITA)' }}</p>
                    <div class="flex justify-between border-t border-bone-200 pt-1.5">
                        <span class="text-slate-500">Sabtu - Minggu / Libur</span>
                        <span class="font-bold text-rose-600">Tutup</span>
                    </div>
                </div>
                <div class="pt-1 text-xs">
                    <span class="text-slate-500 block">Call Center Pemkot Makassar:</span>
                    <span class="font-bold text-slate-900 text-sm">{{ $portalSettings['contact_phone'] ?? '112 (Bebas Pulsa)' }}</span>
                </div>
            </div>

            <!-- Kartu Surel & Surat Kedinasan -->
            <div class="bg-white rounded-2xl p-6 border border-bone-300 shadow-sm hover:shadow-md transition space-y-4 sm:col-span-2 lg:col-span-1">
                <div class="w-12 h-12 rounded-xl bg-rose-50 border border-rose-200 flex items-center justify-center text-maroon-700 text-xl">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-base">Surat Elektronik & Media</h3>
                    <p class="text-xs text-slate-500 mt-1">Korespondensi Resmi Lembaga</p>
                </div>
                <div class="text-xs text-slate-600 space-y-2">
                    <div>
                        <span class="text-slate-500 block">Email Sekretariat:</span>
                        <a href="mailto:{{ $portalSettings['contact_email'] ?? 'brida@makassarkota.go.id' }}" class="font-semibold text-maroon-700 hover:underline">{{ $portalSettings['contact_email'] ?? 'brida@makassarkota.go.id' }}</a>
                    </div>
                    <div>
                        <span class="text-slate-500 block">WhatsApp Layanan:</span>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $portalSettings['contact_whatsapp'] ?? '081144002233') }}" target="_blank" class="font-semibold text-emerald-700 hover:underline">{{ $portalSettings['contact_whatsapp'] ?? '081144002233' }}</a>
                    </div>
                </div>
                <div class="pt-2 flex items-center gap-3">
                    @if(!empty($portalSettings['social_instagram']))
                    <a href="{{ $portalSettings['social_instagram'] }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-bone-200 hover:bg-maroon-700 hover:text-white text-slate-700 flex items-center justify-center transition" title="Instagram Resmi">
                        <i class="fa-brands fa-instagram text-sm"></i>
                    </a>
                    @endif
                    @if(!empty($portalSettings['social_youtube']))
                    <a href="{{ $portalSettings['social_youtube'] }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-bone-200 hover:bg-maroon-700 hover:text-white text-slate-700 flex items-center justify-center transition" title="YouTube Resmi">
                        <i class="fa-brands fa-youtube text-sm"></i>
                    </a>
                    @endif
                    @if(!empty($portalSettings['social_facebook']))
                    <a href="{{ $portalSettings['social_facebook'] }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-bone-200 hover:bg-maroon-700 hover:text-white text-slate-700 flex items-center justify-center transition" title="Facebook Resmi">
                        <i class="fa-brands fa-facebook text-sm"></i>
                    </a>
                    @endif
                    <a href="https://makassarkota.go.id" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-lg bg-bone-200 hover:bg-maroon-700 hover:text-white text-slate-700 flex items-center justify-center transition" title="Portal Makassar">
                        <i class="fa-solid fa-globe text-sm"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- Bagian 2: Formulir Hubungi Kami & Peta Interaktif -->
        <section class="grid lg:grid-cols-12 gap-10">
            <!-- Kolom Kiri: Formulir Kirim Pesan / Aduan / Konsultasi -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-8 border border-bone-300 shadow-sm space-y-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Formulir Komunikasi</span>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight mt-1">Kirimkan Pesan atau Pertanyaan</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 leading-relaxed">
                        Silakan lengkapi formulir di bawah ini. Tim kami akan merespons pesan Anda ke alamat email yang dicantumkan.
                    </p>
                </div>

                <form onsubmit="event.preventDefault(); window.showBridaAlert('success', 'Pesan Terkirim!', 'Terima kasih. Pesan atau pertanyaan Anda telah diterima oleh Sekretariat BRIDA Kota Makassar.'); this.reset();" class="space-y-4">
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="nama" class="block text-xs font-bold text-slate-700">Nama Lengkap <span class="text-rose-500">*</span></label>
                            <input type="text" id="nama" required placeholder="Contoh: Andi Pratama, S.T." class="w-full text-xs rounded-xl border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 bg-bone-50/50 py-2.5 px-3">
                        </div>
                        <div class="space-y-1.5">
                            <label for="instansi" class="block text-xs font-bold text-slate-700">Instansi / Universitas / Lembaga</label>
                            <input type="text" id="instansi" placeholder="Contoh: Universitas Hasanuddin / Umum" class="w-full text-xs rounded-xl border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 bg-bone-50/50 py-2.5 px-3">
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="email" class="block text-xs font-bold text-slate-700">Alamat Email <span class="text-rose-500">*</span></label>
                            <input type="email" id="email" required placeholder="nama@email.com" class="w-full text-xs rounded-xl border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 bg-bone-50/50 py-2.5 px-3">
                        </div>
                        <div class="space-y-1.5">
                            <label for="telepon" class="block text-xs font-bold text-slate-700">Nomor WhatsApp / HP</label>
                            <input type="tel" id="telepon" placeholder="08xxxxxxxxxx" class="w-full text-xs rounded-xl border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 bg-bone-50/50 py-2.5 px-3">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="kategori" class="block text-xs font-bold text-slate-700">Perihal / Kategori Pesan <span class="text-rose-500">*</span></label>
                        <select id="kategori" required class="w-full text-xs rounded-xl border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 bg-bone-50/50 py-2.5 px-3 text-slate-700">
                            <option value="">-- Pilih Kategori Layanan --</option>
                            <option value="fasilitasi-inovasi">Konsultasi & Fasilitasi Inovasi Daerah</option>
                            <option value="izin-riset">Rekomendasi Penelitian / Kaji Terap</option>
                            <option value="hki-paten">Pendampingan Paten / HKI</option>
                            <option value="ppid">Permohonan Informasi Publik (PPID)</option>
                            <option value="kerjasama">Kerjasama Riset & Mitra Universitas</option>
                            <option value="lainnya">Lainnya / Masukan Umum</option>
                        </select>
                    </div>

                    <div class="space-y-1.5">
                        <label for="pesan" class="block text-xs font-bold text-slate-700">Isi Pesan / Pertanyaan <span class="text-rose-500">*</span></label>
                        <textarea id="pesan" rows="5" required placeholder="Tuliskan secara jelas pokok maksud, pertanyaan, atau permohonan yang ingin Anda sampaikan..." class="w-full text-xs rounded-xl border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 bg-bone-50/50 py-2.5 px-3"></textarea>
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md w-full sm:w-auto">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Kirim Pesan Sekarang</span>
                    </button>
                </form>
            </div>

            <!-- Kolom Kanan: Peta Lokasi & Informasi Publik Terkait -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Frame Peta Google Maps Balai Kota Makassar -->
                <div class="bg-white rounded-3xl p-6 border border-bone-300 shadow-sm space-y-4">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-sm text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-map-location-dot text-maroon-700"></i>
                            <span>Peta Lokasi Kantor</span>
                        </h4>
                        <span class="text-[10px] bg-rose-100 text-maroon-700 font-semibold px-2 py-0.5 rounded-full">Balai Kota</span>
                    </div>

                    <div class="rounded-2xl overflow-hidden border border-bone-200 h-64 sm:h-72 w-full">
                        <iframe 
                            title="Lokasi Kantor Balai Kota Makassar"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3973.8118318855523!2d119.4069811756598!3d-5.133932794843075!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dbf02939e60be1b%3A0xe54e5658fe969418!2sKantor%20Walikota%20Makassar!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <p class="text-[11px] text-slate-500 leading-relaxed">
                        Berada di pusat pemerintahan Balai Kota Makassar, memudahkan koordinasi antar-OPD dan akses masyarakat kota.
                    </p>
                </div>

                <!-- Saluran Pengaduan Resmi SP4N LAPOR -->
                <div class="bg-gradient-to-br from-bone-100 to-bone-200 rounded-3xl p-6 border border-bone-300 space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center font-bold text-base shadow">
                            <i class="fa-solid fa-bullhorn"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-slate-900">Saluran Aspirasi & Aduan Resmi</h4>
                            <p class="text-[11px] text-slate-500">SP4N-LAPOR! Pemerintah Kota Makassar</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        Masyarakat dapat menyampaikan aspirasi, keluhan, dan laporan pelayanan publik secara terintegrasi melalui portal nasional SP4N LAPOR.
                    </p>
                    <a href="https://www.lapor.go.id/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-xs font-bold text-maroon-700 hover:text-maroon-800 transition pt-1">
                        <span>Akses Portal SP4N-LAPOR!</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </section>

    </div>
</main>
@endsection
