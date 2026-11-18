<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Breadcrumb & Header -->
        <div class="pb-2 border-b border-bone-300">
            <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                <a href="{{ route('dashboard.riset.index') }}" class="hover:text-maroon-700 transition">Layanan Izin Riset</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                <span class="text-slate-800 font-bold">Formulir Pengajuan</span>
            </nav>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                Permohonan Rekomendasi Penelitian Baru
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Lengkapi rincian data peneliti dan dokumen pendukung guna penerbitan surat rekomendasi resmi BRIDA Kota Makassar.
            </p>
        </div>

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                <div class="font-bold flex items-center gap-1.5 text-rose-700">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>Terdapat beberapa kesalahan pengisian formulir:</span>
                </div>
                <ul class="list-disc pl-5 space-y-0.5 text-[11px]">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulir Input -->
        <form method="POST" action="{{ route('dashboard.riset.store') }}" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-8">
            @csrf

            <!-- Bagian 1: Data Pemohon / Peneliti -->
            <div class="space-y-4">
                <div class="border-b border-bone-200 pb-2">
                    <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-rose-100 text-maroon-700 text-xs flex items-center justify-center font-bold">1</span>
                        <span>Identitas Peneliti / Pemohon</span>
                    </h3>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="nama_pemohon" class="block text-xs font-bold text-slate-700">Nama Lengkap Peneliti <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_pemohon" id="nama_pemohon" value="{{ old('nama_pemohon', Auth::user()->name) }}" required placeholder="Contoh: Muhammad Rezky, S.T." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>

                    <div class="space-y-1">
                        <label for="kontak_wa" class="block text-xs font-bold text-slate-700">Nomor WhatsApp Aktif <span class="text-rose-500">*</span></label>
                        <input type="tel" name="kontak_wa" id="kontak_wa" value="{{ old('kontak_wa') }}" required placeholder="08xxxxxxxxxx" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="institusi" class="block text-xs font-bold text-slate-700">Institusi / Universitas / Lembaga <span class="text-rose-500">*</span></label>
                        <input type="text" name="institusi" id="institusi" value="{{ old('institusi') }}" required placeholder="Contoh: Universitas Hasanuddin" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>

                    <div class="space-y-1">
                        <label for="jurusan_fakultas" class="block text-xs font-bold text-slate-700">Fakultas / Program Studi / Divisi</label>
                        <input type="text" name="jurusan_fakultas" id="jurusan_fakultas" value="{{ old('jurusan_fakultas') }}" placeholder="Contoh: Fakultas Ilmu Sosial dan Ilmu Politik" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Rencana & Judul Penelitian -->
            <div class="space-y-4">
                <div class="border-b border-bone-200 pb-2">
                    <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-rose-100 text-maroon-700 text-xs flex items-center justify-center font-bold">2</span>
                        <span>Materi & Lokasi Penelitian</span>
                    </h3>
                </div>

                <div class="space-y-1">
                    <label for="judul_penelitian" class="block text-xs font-bold text-slate-700">Judul Riset / Tugas Akhir / Kajian <span class="text-rose-500">*</span></label>
                    <textarea name="judul_penelitian" id="judul_penelitian" rows="3" required placeholder="Tuliskan judul lengkap penelitian yang akan diajukan..." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3">{{ old('judul_penelitian') }}</textarea>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="bidang_fokus" class="block text-xs font-bold text-slate-700">Bidang Fokus Inovasi & Riset <span class="text-rose-500">*</span></label>
                        <select name="bidang_fokus" id="bidang_fokus" required class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3 text-slate-700">
                            <option value="Sosial & Pemerintahan" {{ old('bidang_fokus') == 'Sosial & Pemerintahan' ? 'selected' : '' }}>Sosial, Kebijakan Publik & Pemerintahan</option>
                            <option value="Infrastruktur & Lingkungan Hidup" {{ old('bidang_fokus') == 'Infrastruktur & Lingkungan Hidup' ? 'selected' : '' }}>Infrastruktur, Perkotaan & Lingkungan Hidup</option>
                            <option value="Ekonomi Kreatif & UMKM" {{ old('bidang_fokus') == 'Ekonomi Kreatif & UMKM' ? 'selected' : '' }}>Ekonomi Kreatif, Pariwisata & UMKM</option>
                            <option value="Kesehatan Masyarakat" {{ old('bidang_fokus') == 'Kesehatan Masyarakat' ? 'selected' : '' }}>Kesehatan Masyarakat & Penanganan Stunting</option>
                            <option value="Teknologi Informasi & Smart City" {{ old('bidang_fokus') == 'Teknologi Informasi & Smart City' ? 'selected' : '' }}>Teknologi Informasi, AI & Smart City</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="lokasi_penelitian" class="block text-xs font-bold text-slate-700">Lokasi / SKPD / Lokus Penelitian <span class="text-rose-500">*</span></label>
                        <input type="text" name="lokasi_penelitian" id="lokasi_penelitian" value="{{ old('lokasi_penelitian') }}" required placeholder="Contoh: Kantor Dinas Kesehatan / Lorong Wisata Kec. Panakkukang" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="tanggal_mulai" class="block text-xs font-bold text-slate-700">Rencana Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                    <div class="space-y-1">
                        <label for="tanggal_selesai" class="block text-xs font-bold text-slate-700">Rencana Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Dokumen Berkas -->
            <div class="space-y-4">
                <div class="border-b border-bone-200 pb-2">
                    <h3 class="text-sm font-black text-slate-900 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-lg bg-rose-100 text-maroon-700 text-xs flex items-center justify-center font-bold">3</span>
                        <span>Lampiran Berkas (Opsional / Dapat Diunggah Bertahap)</span>
                    </h3>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-2xl bg-bone-50 border border-bone-300 space-y-2">
                        <label for="file_surat_pengantar" class="block text-xs font-bold text-slate-700">Surat Pengantar Kampus / Instansi</label>
                        <p class="text-[11px] text-slate-500">Format PDF/JPG/PNG (Maks. 5 MB)</p>
                        <input type="file" name="file_surat_pengantar" id="file_surat_pengantar" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-maroon-700 file:text-white hover:file:bg-maroon-800">
                    </div>

                    <div class="p-4 rounded-2xl bg-bone-50 border border-bone-300 space-y-2">
                        <label for="file_proposal" class="block text-xs font-bold text-slate-700">Naskah Ringkas Proposal Penelitian</label>
                        <p class="text-[11px] text-slate-500">Format PDF (Maks. 10 MB)</p>
                        <input type="file" name="file_proposal" id="file_proposal" accept=".pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-maroon-700 file:text-white hover:file:bg-maroon-800">
                    </div>
                </div>
            </div>

            <!-- Tombol Kirim Form -->
            <div class="pt-4 border-t border-bone-200 flex items-center justify-between">
                <a href="{{ route('dashboard.riset.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar
                </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Pengajuan Izin Riset</span>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
