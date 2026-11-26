<!-- Tom Select & Quill.js (Gratis & Open-Source) -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
    .ts-control { border-radius: 0.75rem !important; border-color: #d6d3c9 !important; padding: 0.5rem 0.75rem !important; font-size: 0.75rem !important; }
    .ql-toolbar.ql-snow { border-radius: 0.75rem 0.75rem 0 0; border-color: #d6d3c9; background: #faf9f5; }
    .ql-container.ql-snow { border-radius: 0 0 0.75rem 0.75rem; border-color: #d6d3c9; min-height: 260px; font-size: 0.875rem; }
</style>

<!-- Modal Kelola Kategori Berita -->
<div x-show="catModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div @click.away="catModalOpen = false" class="bg-white rounded-3xl border border-bone-300 shadow-2xl w-full max-w-md overflow-hidden">
        <div class="px-6 py-4 border-b border-bone-200 flex items-center justify-between bg-bone-50">
            <h4 class="text-sm font-black text-slate-900">Kelola Daftar Kategori Berita</h4>
            <button type="button" @click="catModalOpen = false" class="text-slate-400 hover:text-slate-700"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form method="POST" action="{{ route('dashboard.berita.categories.update') }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-[11px] font-bold text-slate-600 uppercase mb-1">Daftar Kategori (Pisahkan dengan koma)</label>
                <textarea name="categories_text" rows="3" required class="w-full rounded-xl border border-bone-300 text-xs p-3 focus:ring-maroon-700 focus:border-maroon-700">{{ implode(', ', $categories) }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Tambah atau hapus nama kategori di atas. Perubahan otomatis sinkron dengan filter halaman publik.</p>
            </div>
            <div class="flex justify-end gap-2 pt-2 border-t border-bone-200">
                <button type="button" @click="catModalOpen = false" class="px-4 py-2 rounded-xl border border-bone-300 text-xs font-bold text-slate-600">Batal</button>
                <button type="submit" class="px-5 py-2 rounded-xl bg-maroon-700 hover:bg-maroon-800 text-white text-xs font-bold">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Searchable Kategori Dropdown
    if (document.getElementById('berita-kategori')) {
        new TomSelect('#berita-kategori', {
            create: true,
            sortField: { field: 'text', direction: 'asc' },
            placeholder: 'Cari atau ketik kategori baru...'
        });
    }

    // 2. Multiple Tag Dropdown
    if (document.getElementById('berita-tags')) {
        new TomSelect('#berita-tags', {
            plugins: ['remove_button'],
            create: true,
            persist: false,
            placeholder: 'Pilih atau ketik tag baru...'
        });
    }

    // 3. WYSIWYG Quill.js Editor
    const quillEl = document.getElementById('quill-editor');
    const kontenHidden = document.getElementById('konten-hidden');
    if (quillEl && kontenHidden) {
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            placeholder: 'Tuliskan narasi lengkap berita di sini...',
            modules: {
                toolbar: [
                    [{ header: [2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ list: 'ordered' }, { list: 'bullet' }],
                    ['blockquote', 'link'],
                    ['clean']
                ]
            }
        });

        const form = kontenHidden.closest('form');
        if (form) {
            form.addEventListener('submit', function () {
                const html = quill.root.innerHTML;
                kontenHidden.value = (quill.getText().trim().length === 0) ? '' : html;
            });
        }
    }

    // 4. Client-Side Image Compression (Canvas API)
    const imgInput = document.getElementById('gambar_sampul');
    const imgInfo = document.getElementById('gambar-compress-info');
    const imgPreview = document.getElementById('gambar-compress-preview');
    if (imgInput) {
        imgInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file || !file.type.startsWith('image/')) return;

            const origKB = (file.size / 1024).toFixed(1);
            const reader = new FileReader();
            reader.onload = function (ev) {
                const img = new Image();
                img.onload = function () {
                    const maxW = 1280;
                    let w = img.width;
                    let h = img.height;
                    if (w > maxW) {
                        h = Math.round((h * maxW) / w);
                        w = maxW;
                    }
                    const canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, w, h);

                    canvas.toBlob(function (blob) {
                        if (!blob) return;
                        const compressedFile = new File([blob], file.name.replace(/\.[^.]+$/, '.jpg'), {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });
                        const dt = new DataTransfer();
                        dt.items.add(compressedFile);
                        imgInput.files = dt.files;

                        const newKB = (compressedFile.size / 1024).toFixed(1);
                        if (imgInfo) {
                            imgInfo.innerHTML = '<i class="fa-solid fa-compress text-emerald-600 mr-1"></i> Dikompresi di browser: <strong>' + origKB + ' KB &rarr; ' + newKB + ' KB</strong> (' + w + 'x' + h + 'px)';
                            imgInfo.classList.remove('hidden');
                        }
                        if (imgPreview) {
                            imgPreview.src = URL.createObjectURL(compressedFile);
                            imgPreview.classList.remove('hidden');
                        }
                    }, 'image/jpeg', 0.8);
                };
                img.src = ev.target.result;
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>
