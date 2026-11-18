<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Breadcrumb & Header -->
        <div class="pb-2 border-b border-bone-300">
            <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                <a href="{{ route('dashboard.regulasi.index') }}" class="hover:text-maroon-700 transition">Repositori Dokumen</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                <span class="text-slate-800 font-bold">Unggah Dokumen</span>
            </nav>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                Unggah Dokumen Regulasi / Informasi Publik
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Tambahkan arsip Perda, Perwali, panduan SOP teknis, atau dokumen PPID agar dapat diunduh publik.
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

        <form method="POST" action="{{ route('dashboard.regulasi.store') }}" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-6">
            @csrf

            <div class="space-y-4">
                <div class="space-y-1">
                    <label for="judul_regulasi" class="block text-xs font-bold text-slate-700">Judul Dokumen / Nama Regulasi <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul_regulasi" id="judul_regulasi" value="{{ old('judul_regulasi') }}" required placeholder="Contoh: Peraturan Walikota Makassar tentang Tata Kelola Inovasi Daerah" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                </div>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <label for="nomor_peraturan" class="block text-xs font-bold text-slate-700">Nomor Peraturan / SK <span class="text-rose-500">*</span></label>
                        <input type="text" name="nomor_peraturan" id="nomor_peraturan" value="{{ old('nomor_peraturan') }}" required placeholder="Contoh: Perwali No. 42 Tahun 2024" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>

                    <div class="space-y-1">
                        <label for="kategori" class="block text-xs font-bold text-slate-700">Jenis Dokumen <span class="text-rose-500">*</span></label>
                        <select name="kategori" id="kategori" required class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                            <option value="Peraturan Walikota">Peraturan Walikota</option>
                            <option value="Peraturan Daerah">Peraturan Daerah</option>
                            <option value="Pedoman Teknis">Pedoman Teknis / SOP</option>
                            <option value="Dokumen PPID">Dokumen PPID</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="tahun" class="block text-xs font-bold text-slate-700">Tahun Penerbitan <span class="text-rose-500">*</span></label>
                        <input type="number" name="tahun" id="tahun" value="{{ old('tahun', date('Y')) }}" required min="2015" max="2030" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="tentang" class="block text-xs font-bold text-slate-700">Tentang / Ringkasan Pokok Peraturan <span class="text-rose-500">*</span></label>
                    <textarea name="tentang" id="tentang" rows="3" required placeholder="Jelaskan secara ringkas maksud dan pokok isi dari peraturan ini..." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3">{{ old('tentang') }}</textarea>
                </div>

                <div class="space-y-1">
                    <label for="file_dokumen" class="block text-xs font-bold text-slate-700">Berkas Dokumen PDF</label>
                    <p class="text-[11px] text-slate-400">Format: Dokumen PDF (Maksimal 15 MB)</p>
                    <input type="file" name="file_dokumen" id="file_dokumen" accept=".pdf" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-maroon-700 file:text-white hover:file:bg-maroon-800">
                </div>

                <input type="hidden" name="status" value="Aktif">
            </div>

            <!-- Tombol Simpan -->
            <div class="pt-4 border-t border-bone-200 flex items-center justify-between">
                <a href="{{ route('dashboard.regulasi.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    <span>Simpan Dokumen</span>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
