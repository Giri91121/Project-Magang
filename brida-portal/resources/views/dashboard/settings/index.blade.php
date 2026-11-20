<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Top Header & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <span class="text-slate-800 font-bold">Pengaturan Instansi</span>
                </nav>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    Pengaturan Profil Lembaga & Kontak
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Konfigurasi informasi resmi instansi, kontak sekretariat, pimpinan badan, dan tautan media sosial.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 bg-rose-50 border border-rose-200 text-maroon-700 text-xs font-bold px-3 py-1.5 rounded-xl">
                <i class="fa-solid fa-gear"></i>
                <span>Pengaturan Sistem</span>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.settings.update') }}" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-8">
            @csrf

            <!-- Bagian 1: Identitas & Pimpinan Lembaga -->
            <div class="space-y-4">
                <div class="border-b border-bone-200 pb-2">
                    <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-rose-100 text-maroon-700 text-xs flex items-center justify-center font-bold">1</span>
                        <span>Identitas Lembaga & Pejabat Penandatangan</span>
                    </h3>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Nama Lembaga Resmi</label>
                        <input type="text" name="agency_name" value="{{ $settings['agency_name'] ?? 'Badan Riset dan Inovasi Daerah' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Singkatan / Akronim</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'BRIDA Kota Makassar' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Nama Kepala Badan (Beserta Gelar)</label>
                        <input type="text" name="kepala_badan_nama" value="{{ $settings['kepala_badan_nama'] ?? 'Nirman Mungkasa, S.T., M.Si.' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">NIP Kepala Badan</label>
                        <input type="text" name="kepala_badan_nip" value="{{ $settings['kepala_badan_nip'] ?? '19740512 199903 1 004' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Tagline / Visi Singkat Portal</label>
                    <input type="text" name="tagline" value="{{ $settings['tagline'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                </div>
            </div>

            <!-- Bagian 2: Kontak & Alamat Sekretariat -->
            <div class="space-y-4">
                <div class="border-b border-bone-200 pb-2">
                    <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-rose-100 text-maroon-700 text-xs flex items-center justify-center font-bold">2</span>
                        <span>Kontak Sekretariat & Jam Operasional</span>
                    </h3>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Alamat Kantor Balai Kota</label>
                    <textarea name="office_address" rows="2" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3">{{ $settings['office_address'] ?? '' }}</textarea>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Email Resmi Instansi</label>
                        <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? 'brida@makassarkota.go.id' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Nomor Telepon Kantor / Hotline</label>
                        <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">WhatsApp Helpdesk Layanan</label>
                        <input type="text" name="contact_whatsapp" value="{{ $settings['contact_whatsapp'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700">Jadwal Operasional Kantor</label>
                        <input type="text" name="work_hours" value="{{ $settings['work_hours'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Media Sosial Resmi -->
            <div class="space-y-4">
                <div class="border-b border-bone-200 pb-2">
                    <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-rose-100 text-maroon-700 text-xs flex items-center justify-center font-bold">3</span>
                        <span>Tautan Saluran Media Sosial</span>
                    </h3>
                </div>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700"><i class="fa-brands fa-instagram text-rose-500 mr-1"></i> Instagram</label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700"><i class="fa-brands fa-youtube text-rose-600 mr-1"></i> YouTube Channel</label>
                        <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold text-slate-700"><i class="fa-brands fa-facebook text-blue-600 mr-1"></i> Facebook Page</label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="pt-4 border-t border-bone-200 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Seluruh Pengaturan</span>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
