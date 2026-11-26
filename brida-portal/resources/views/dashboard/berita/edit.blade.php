<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6" x-data="{ catModalOpen: false }">

        <!-- Breadcrumb & Header -->
        <div class="pb-2 border-b border-bone-300">
            <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                <a href="{{ route('dashboard.berita.index') }}" class="hover:text-maroon-700 transition">CMS Berita</a>
                <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                <span class="text-slate-800 font-bold">Edit Berita</span>
            </nav>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                Edit Berita: {{ $berita->judul }}
            </h1>
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

        <form method="POST" action="{{ route('dashboard.berita.update', $berita->id) }}" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div class="space-y-1">
                    <label for="judul" class="block text-xs font-bold text-slate-700">Judul Berita / Rilis <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $berita->judul) }}" required maxlength="255" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <div class="flex items-center justify-between">
                            <label for="berita-kategori" class="block text-xs font-bold text-slate-700">Kategori Berita <span class="text-rose-500">*</span></label>
                            <button type="button" @click="catModalOpen = true" class="text-[11px] font-bold text-maroon-700 hover:underline">
                                + Kelola Kategori
                            </button>
                        </div>
                        <select name="kategori" id="berita-kategori" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('kategori', $berita->kategori) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-1">
                        <label for="status" class="block text-xs font-bold text-slate-700">Status Publikasi <span class="text-rose-500">*</span></label>
                        <select name="status" id="status" required class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                            <option value="Publikasi" {{ old('status', $berita->status) == 'Publikasi' ? 'selected' : '' }}>Publikasi (Online)</option>
                            <option value="Draft" {{ old('status', $berita->status) == 'Draft' ? 'selected' : '' }}>Draft (Konsep)</option>
                        </select>
                    </div>
                </div>

                @php
                    $selectedTags = old('tags', $berita->tags ? array_map('trim', explode(',', $berita->tags)) : []);
                    $allTagOptions = array_unique(array_merge($existingTags, (array)$selectedTags));
                @endphp
                <div class="space-y-1">
                    <label for="berita-tags" class="block text-xs font-bold text-slate-700">Tag Berita (Opsional, Bisa Pilih/Ketik Banyak)</label>
                    <select name="tags[]" id="berita-tags" multiple>
                        @foreach($allTagOptions as $t)
                            <option value="{{ $t }}" {{ in_array($t, (array)$selectedTags) ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-700">Foto Sampul Saat Ini</label>
                    <img src="{{ $berita->gambar_url }}" alt="Sampul" class="h-32 w-auto rounded-xl object-cover border border-bone-300">
                    <p class="text-[11px] text-slate-400">Otomatis dikompresi di browser sebelum diunggah (Maks. lebar 1280px).</p>
                    <input type="file" name="gambar_sampul" id="gambar_sampul" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-maroon-700 file:text-white hover:file:bg-maroon-800">
                    <p id="gambar-compress-info" class="hidden text-[11px] text-emerald-700 pt-1"></p>
                    <img id="gambar-compress-preview" class="hidden mt-2 max-h-40 rounded-xl border border-bone-300 object-cover" alt="Preview">
                </div>

                <div class="space-y-1">
                    <label for="ringkasan" class="block text-xs font-bold text-slate-700">Ringkasan Berita <span class="text-rose-500">*</span></label>
                    <textarea name="ringkasan" id="ringkasan" rows="2" required maxlength="500" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3">{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-slate-700">Isi Naskah Berita Lengkap <span class="text-rose-500">*</span></label>
                    <input type="hidden" name="konten" id="konten-hidden" value="{{ old('konten', $berita->konten) }}">
                    <div id="quill-editor">{!! old('konten', $berita->konten) !!}</div>
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div class="pt-4 border-t border-bone-200 flex items-center justify-between">
                <a href="{{ route('dashboard.berita.index') }}" class="text-xs font-bold text-slate-600 hover:text-slate-900">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-6 py-3 rounded-xl transition shadow-md">
                    <i class="fa-solid fa-check"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>

        @include('dashboard.berita._editor-assets')
    </div>
</x-app-layout>
