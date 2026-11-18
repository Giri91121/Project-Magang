<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Breadcrumb & Header -->
        <div class="pb-2 border-b border-bone-300">
            <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                <a href="{{ route('dashboard.inovasi.index') }}" class="hover:text-maroon-700 transition">Inovasi Daerah</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                <span class="text-slate-800 font-bold">Input Inovasi Baru</span>
            </nav>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                Registrasi Inovasi Perangkat Daerah
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Tambahkan profil inovasi SKPD untuk pendampingan indikator kematangan IGA Kemendagri oleh Fasilitator BRIDA.
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

        <form method="POST" action="{{ route('dashboard.inovasi.store') }}" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-6">
            @csrf

            <div class="space-y-4">
                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="nama_inovasi" class="block text-xs font-bold text-slate-700">Nama Inovasi <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_inovasi" id="nama_inovasi" value="{{ old('nama_inovasi') }}" required placeholder="Contoh: Lorong Wisata Digital Terpadu" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>

                    <div class="space-y-1">
                        <label for="perangkat_daerah" class="block text-xs font-bold text-slate-700">Perangkat Daerah / Unit Kerja <span class="text-rose-500">*</span></label>
                        <input type="text" name="perangkat_daerah" id="perangkat_daerah" value="{{ old('perangkat_daerah') }}" required placeholder="Contoh: Dinas Ketahanan Pangan" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label for="tahapan_inovasi" class="block text-xs font-bold text-slate-700">Tahapan Inovasi <span class="text-rose-500">*</span></label>
                        <select name="tahapan_inovasi" id="tahapan_inovasi" required class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                            <option value="Inisiatif">Inisiatif</option>
                            <option value="Uji Coba">Uji Coba</option>
                            <option value="Penerapan" selected>Penerapan</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="jenis_inovasi" class="block text-xs font-bold text-slate-700">Bentuk Inovasi <span class="text-rose-500">*</span></label>
                        <select name="jenis_inovasi" id="jenis_inovasi" required class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                            <option value="Digital">Digital (Aplikasi/Web/IoT)</option>
                            <option value="Non-Digital">Non-Digital (Kebijakan/Tata Kelola/Alat)</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="inisiator" class="block text-xs font-bold text-slate-700">Inisiator <span class="text-rose-500">*</span></label>
                        <select name="inisiator" id="inisiator" required class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                            <option value="OPD" selected>OPD / Perangkat Daerah</option>
                            <option value="Kepala Daerah">Kepala Daerah (Walikota)</option>
                            <option value="ASN">ASN Perorangan</option>
                            <option value="Masyarakat">Masyarakat / Komunitas</option>
                        </select>
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2 space-y-1">
                        <label for="urusan_pemerintahan" class="block text-xs font-bold text-slate-700">Urusan Pemerintahan <span class="text-rose-500">*</span></label>
                        <input type="text" name="urusan_pemerintahan" id="urusan_pemerintahan" value="{{ old('urusan_pemerintahan') }}" required placeholder="Contoh: Ketahanan Pangan, Kesehatan, Pendidikan" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>

                    <div class="space-y-1">
                        <label for="tahun_penerapan" class="block text-xs font-bold text-slate-700">Tahun Penerapan <span class="text-rose-500">*</span></label>
                        <input type="number" name="tahun_penerapan" id="tahun_penerapan" value="{{ old('tahun_penerapan', date('Y')) }}" required min="2020" max="2030" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="ringkasan" class="block text-xs font-bold text-slate-700">Ringkasan / Latar Belakang Inovasi <span class="text-rose-500">*</span></label>
                    <textarea name="ringkasan" id="ringkasan" rows="3" required placeholder="Jelaskan masalah pokok dan terobosan ide yang dilakukan..." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3">{{ old('ringkasan') }}</textarea>
                </div>

                <div class="space-y-1">
                    <label for="kebaruan" class="block text-xs font-bold text-slate-700">Unsur Kebaruan (Novelty)</label>
                    <textarea name="kebaruan" id="kebaruan" rows="2" placeholder="Apa yang membedakan inovasi ini dari praktik sebelumnya..." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3">{{ old('kebaruan') }}</textarea>
                </div>
            </div>

            <!-- Tombol Kirim Form -->
            <div class="pt-4 border-t border-bone-200 flex items-center justify-between">
                <a href="{{ route('dashboard.inovasi.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Batal & Kembali
                </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Data Inovasi</span>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
