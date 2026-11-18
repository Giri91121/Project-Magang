<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Breadcrumb & Header -->
        <div class="pb-2 border-b border-bone-300">
            <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                <a href="{{ route('dashboard.berita.index') }}" class="hover:text-maroon-700 transition">CMS Berita</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                <span class="text-slate-800 font-bold">Tulis Artikel Baru</span>
            </nav>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                Publikasi Berita & Kabar Kegiatan
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Rilis artikel informasi resmi, dokumentasi kegiatan, dan publikasi agenda BRIDA Kota Makassar.
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

        <form method="POST" action="{{ route('dashboard.berita.store') }}" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-6">
            @csrf

            <div class="space-y-4">
                <div class="space-y-1">
                    <label for="judul" class="block text-xs font-bold text-slate-700">Judul Berita / Rilis <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" required placeholder="Contoh: BRIDA Kota Makassar Fasilitasi Pendaftaran HKI bagi Inovator Muda" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="kategori" class="block text-xs font-bold text-slate-700">Kategori Berita <span class="text-rose-500">*</span></label>
                        <select name="kategori" id="kategori" required class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                            <option value="Kebijakan Riset" {{ old('kategori') == 'Kebijakan Riset' ? 'selected' : '' }}>Kebijakan Riset</option>
                            <option value="Inovasi Daerah" {{ old('kategori') == 'Inovasi Daerah' ? 'selected' : '' }}>Inovasi Daerah</option>
                            <option value="Kemitraan Kampus" {{ old('kategori') == 'Kemitraan Kampus' ? 'selected' : '' }}>Kemitraan Kampus</option>
                            <option value="Agenda BRIDA" {{ old('kategori') == 'Agenda BRIDA' ? 'selected' : '' }}>Agenda BRIDA</option>
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="status" class="block text-xs font-bold text-slate-700">Status Publikasi <span class="text-rose-500">*</span></label>
                        <select name="status" id="status" required class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                            <option value="Publikasi" selected>Langsung Publikasikan (Online)</option>
                            <option value="Draft">Simpan Sebagai Draft (Konsep)</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-1">
                    <label for="gambar_sampul" class="block text-xs font-bold text-slate-700">Foto Sampul / Dokumentasi Kegiatan</label>
                    <p class="text-[11px] text-slate-400">Format: JPG, PNG, WEBP (Maksimal 5MB)</p>
                    <input type="file" name="gambar_sampul" id="gambar_sampul" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-maroon-700 file:text-white hover:file:bg-maroon-800">
                </div>

                <div class="space-y-1">
                    <label for="ringkasan" class="block text-xs font-bold text-slate-700">Ringkasan Berita (Lead Paragraph) <span class="text-rose-500">*</span></label>
                    <textarea name="ringkasan" id="ringkasan" rows="2" required placeholder="Tuliskan 1-2 kalimat ringkas untuk pengantar dan deskripsi preview artikel..." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3">{{ old('ringkasan') }}</textarea>
                </div>

                <div class="space-y-1">
                    <label for="konten" class="block text-xs font-bold text-slate-700">Isi Naskah Berita Lengkap <span class="text-rose-500">*</span></label>
                    <textarea name="konten" id="konten" rows="10" required placeholder="Tuliskan narasi berita lengkap di sini..." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3 leading-relaxed">{{ old('konten') }}</textarea>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="pt-4 border-t border-bone-200 flex items-center justify-between">
                <a href="{{ route('dashboard.berita.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan & Rilis Berita</span>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
