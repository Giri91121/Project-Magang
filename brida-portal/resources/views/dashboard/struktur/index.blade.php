<x-app-layout>
    <style>
        .org-tree ul {
            padding-top: 22px;
            position: relative;
            display: flex;
            justify-content: center;
            gap: 14px;
        }
        .org-tree > ul {
            padding-top: 0;
        }
        .org-tree li {
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 22px 6px 0 6px;
        }
        .org-tree > ul > li {
            padding-top: 0;
        }
        .org-tree li::before,
        .org-tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 2px solid #cbd5e1;
            width: 50%;
            height: 22px;
        }
        .org-tree li::after {
            right: auto;
            left: 50%;
            border-left: 2px solid #cbd5e1;
        }
        .org-tree li.org-node-koordinasi::after {
            border-left-style: dashed;
        }
        .org-tree li:only-child::after,
        .org-tree li:only-child::before {
            display: none;
        }
        .org-tree li:only-child {
            padding-top: 0;
        }
        .org-tree li:first-child::before,
        .org-tree li:last-child::after {
            border: 0 none;
        }
        .org-tree li:last-child::before {
            border-right: 2px solid #cbd5e1;
            border-radius: 0 8px 0 0;
        }
        .org-tree li:first-child::after {
            border-radius: 8px 0 0 0;
        }
        .org-tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 2px solid #cbd5e1;
            width: 0;
            height: 22px;
        }
        .org-tree > ul > li::before,
        .org-tree > ul > li::after {
            display: none;
        }
    </style>

    @php
        $nodesJson = $allNodes->mapWithKeys(function ($n) {
            return [$n->id => [
                'id' => $n->id,
                'parent_id' => $n->parent_id,
                'jabatan' => $n->jabatan,
                'nama_pejabat' => $n->nama_pejabat ?? '',
                'nip' => $n->nip ?? '',
                'foto_url' => $n->foto ? asset('storage/' . $n->foto) : '',
                'tipe_garis' => $n->tipe_garis,
                'warna_badge' => $n->warna_badge,
                'deskripsi' => $n->deskripsi ?? '',
                'is_active' => (bool) $n->is_active,
            ]];
        });
    @endphp

    <script>
        window.__strukturNodes = @json($nodesJson);
    </script>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 pb-3 border-b border-bone-300">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Struktur Organisasi
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Kelola bagan hierarki BRIDA Kota Makassar. Perubahan di sini otomatis tampil pada halaman publik.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('struktur-organisasi') }}" target="_blank" class="inline-flex items-center gap-2 bg-white border border-bone-300 hover:border-maroon-700 text-slate-700 hover:text-maroon-700 text-xs font-bold px-3.5 py-2.5 rounded-xl transition shadow-sm">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    <span>Lihat Halaman Publik</span>
                </a>

                @if($allNodes->isEmpty())
                    <form method="POST" action="{{ route('dashboard.struktur.seed-sample') }}">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold px-3.5 py-2.5 rounded-xl transition shadow">
                            <i class="fa-solid fa-wand-magic-sparkles text-xs"></i>
                            <span>Muat Contoh Struktur BRIDA</span>
                        </button>
                    </form>
                @endif

                <button type="button" onclick="openStrukturAdd(null)" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Jabatan Baru</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-center gap-2">
                <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1">
                <div class="font-bold">Terjadi kesalahan validasi:</div>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Live Preview Bagan -->
        <div class="bg-white rounded-3xl border border-bone-300 shadow-sm overflow-hidden">
            <div class="px-5 py-3.5 border-b border-bone-200 bg-bone-50 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3 text-xs text-slate-600">
                    <span class="font-extrabold text-slate-800"><i class="fa-solid fa-sitemap mr-1.5 text-maroon-700"></i>Live Preview Bagan</span>
                    <span class="hidden sm:inline text-slate-300">|</span>
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px]"><span class="w-4 border-t-2 border-slate-400 inline-block"></span> Garis Komando</span>
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px]"><span class="w-4 border-t-2 border-dashed border-slate-400 inline-block"></span> Garis Koordinasi</span>
                </div>

                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="changeDashboardZoom(-0.1)" class="px-2.5 py-1.5 text-xs font-bold bg-white border border-bone-300 rounded-lg hover:bg-bone-100" title="Perkecil">
                        <i class="fa-solid fa-magnifying-glass-minus"></i>
                    </button>
                    <span id="dashboard-zoom-label" class="text-xs font-bold text-slate-600 w-12 text-center">100%</span>
                    <button type="button" onclick="changeDashboardZoom(0.1)" class="px-2.5 py-1.5 text-xs font-bold bg-white border border-bone-300 rounded-lg hover:bg-bone-100" title="Perbesar">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                    </button>
                    <button type="button" onclick="changeDashboardZoom(0)" class="px-2.5 py-1.5 text-xs font-bold bg-white border border-bone-300 rounded-lg hover:bg-bone-100">
                        Reset
                    </button>
                </div>
            </div>

            <div class="p-6 sm:p-8 overflow-x-auto bg-slate-50/60 min-h-[340px]">
                @if($tree->isEmpty())
                    <div class="py-16 text-center space-y-3 max-w-md mx-auto">
                        <div class="w-14 h-14 rounded-2xl bg-bone-200 text-maroon-700 flex items-center justify-center mx-auto text-2xl">
                            <i class="fa-solid fa-sitemap"></i>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-800">Belum Ada Data Struktur Organisasi</h3>
                        <p class="text-xs text-slate-500">Klik <strong>Tambah Jabatan Baru</strong> untuk mulai menyusun dari pucuk pimpinan, atau gunakan tombol <strong>Muat Contoh Struktur BRIDA</strong> di atas.</p>
                    </div>
                @else
                    <div id="dashboard-org-tree" class="org-tree inline-block min-w-full origin-top transition-transform duration-150">
                        <ul>
                            @foreach($tree as $rootNode)
                                @include('dashboard.struktur._node', [
                                    'node' => $rootNode,
                                    'loopIndex' => $loop->index,
                                    'siblingsCount' => $tree->count(),
                                ])
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pengaturan Dasar Hukum -->
        <div class="bg-white rounded-3xl border border-bone-300 shadow-sm p-6">
            <form method="POST" action="{{ route('dashboard.struktur.settings') }}" class="flex flex-col sm:flex-row sm:items-end gap-4">
                @csrf
                <div class="flex-1 space-y-1">
                    <label for="struktur_dasar_hukum" class="block text-xs font-bold text-slate-700">
                        Keterangan Dasar Hukum / Perwali (Opsional)
                    </label>
                    <input type="text" name="struktur_dasar_hukum" id="struktur_dasar_hukum" value="{{ old('struktur_dasar_hukum', $dasarHukum) }}" maxlength="500" placeholder="Contoh: Berdasarkan Peraturan Wali Kota Makassar Nomor ... Tahun ... tentang Susunan Organisasi BRIDA" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                </div>
                <button type="submit" class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shrink-0">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Keterangan
                </button>
            </form>
        </div>

        <!-- Modal Tambah / Edit Jabatan -->
        <div id="struktur-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" onclick="if (event.target === this) closeStrukturModal()">
            <div class="bg-white rounded-3xl border border-bone-300 shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-4 border-b border-bone-200 flex items-center justify-between sticky top-0 bg-white z-10">
                    <h3 id="struktur-modal-title" class="text-base font-black text-slate-900">Tambah Jabatan Struktur</h3>
                    <button type="button" onclick="closeStrukturModal()" class="text-slate-400 hover:text-slate-700 p-1">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form id="struktur-form" action="{{ route('dashboard.struktur.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="_method" id="struktur-method" value="POST" disabled>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Atasan Langsung (Parent)</label>
                            <select name="parent_id" id="struktur-parent-id" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                                <option value="">-- Tidak Ada (Pucuk Pimpinan / Root) --</option>
                                @foreach($allNodes as $opt)
                                    <option value="{{ $opt->id }}">
                                        {{ $opt->jabatan }}{{ $opt->nama_pejabat ? ' (' . $opt->nama_pejabat . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Nama Jabatan / Unit Kerja <span class="text-rose-500">*</span></label>
                            <input type="text" name="jabatan" id="struktur-jabatan" required maxlength="255" placeholder="Contoh: Kepala Badan / Sekretaris / Kepala Bidang..." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nama Pejabat (Opsional)</label>
                            <input type="text" name="nama_pejabat" id="struktur-nama-pejabat" maxlength="255" placeholder="Nama lengkap & gelar" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">NIP (Opsional)</label>
                            <input type="text" name="nip" id="struktur-nip" maxlength="50" placeholder="19700101 199503 1 001" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Tipe Garis Hubung</label>
                            <select name="tipe_garis" id="struktur-tipe-garis" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                                <option value="komando">Garis Komando (Solid)</option>
                                <option value="koordinasi">Garis Koordinasi (Putus-putus)</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Warna Aksen Kartu</label>
                            <select name="warna_badge" id="struktur-warna-badge" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                                <option value="maroon">Maroon (Utama)</option>
                                <option value="slate">Slate (Sekretariat)</option>
                                <option value="indigo">Indigo (Bidang)</option>
                                <option value="emerald">Emerald (Subbagian)</option>
                                <option value="amber">Amber (Fungsional / UPT)</option>
                            </select>
                        </div>

                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Foto Pejabat (Opsional, otomatis dikompres)</label>
                            <div class="flex items-center gap-3">
                                <img id="struktur-photo-preview" src="" alt="Preview" class="hidden w-12 h-12 rounded-xl object-cover border border-bone-300 shrink-0">
                                <input type="file" name="foto" id="struktur-foto-input" onchange="compressStrukturPhoto(this)" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-bone-200 file:text-maroon-800 hover:file:bg-bone-300">
                            </div>
                            <label id="struktur-remove-photo-wrap" class="hidden inline-flex items-center gap-2 mt-1.5 text-[11px] text-rose-600 font-semibold cursor-pointer">
                                <input type="checkbox" name="hapus_foto" id="struktur-hapus-foto" value="1" class="rounded border-bone-300 text-rose-600 focus:ring-rose-500">
                                <span>Hapus foto saat ini</span>
                            </label>
                        </div>

                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Tugas Pokok &amp; Fungsi / Keterangan (Opsional)</label>
                            <textarea name="deskripsi" id="struktur-deskripsi" rows="3" maxlength="2000" placeholder="Ringkasan tupoksi yang akan tampil saat kartu diklik di halaman publik..." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3"></textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="inline-flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                                <input type="checkbox" name="is_active" id="struktur-is-active" value="1" checked class="rounded border-bone-300 text-maroon-700 focus:ring-maroon-700">
                                <span>Tampilkan di Halaman Publik</span>
                            </label>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-bone-200 flex items-center justify-end gap-2">
                        <button type="button" onclick="closeStrukturModal()" class="px-4 py-2 text-xs font-bold text-slate-600 bg-bone-100 hover:bg-bone-200 rounded-xl transition">Batal</button>
                        <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-maroon-700 hover:bg-maroon-800 rounded-xl transition shadow">
                            <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let dashboardZoom = 1;

        window.changeDashboardZoom = function (delta) {
            dashboardZoom = delta === 0 ? 1 : Math.min(1.4, Math.max(0.5, +(dashboardZoom + delta).toFixed(1)));
            const tree = document.getElementById('dashboard-org-tree');
            const label = document.getElementById('dashboard-zoom-label');
            if (tree) tree.style.transform = `scale(${dashboardZoom})`;
            if (label) label.textContent = Math.round(dashboardZoom * 100) + '%';
        };

        window.closeStrukturModal = function () {
            document.getElementById('struktur-modal').classList.add('hidden');
        };

        window.openStrukturAdd = function (parentId) {
            const form = document.getElementById('struktur-form');
            const methodInput = document.getElementById('struktur-method');
            form.action = "{{ route('dashboard.struktur.store') }}";
            methodInput.disabled = true;
            methodInput.value = 'POST';

            document.getElementById('struktur-modal-title').textContent = 'Tambah Jabatan Struktur';
            document.getElementById('struktur-parent-id').value = parentId ? String(parentId) : '';
            Array.from(document.getElementById('struktur-parent-id').options).forEach(opt => { opt.disabled = false; });
            document.getElementById('struktur-jabatan').value = '';
            document.getElementById('struktur-nama-pejabat').value = '';
            document.getElementById('struktur-nip').value = '';
            document.getElementById('struktur-tipe-garis').value = 'komando';
            document.getElementById('struktur-warna-badge').value = parentId ? 'indigo' : 'maroon';
            document.getElementById('struktur-deskripsi').value = '';
            document.getElementById('struktur-is-active').checked = true;
            document.getElementById('struktur-foto-input').value = '';
            document.getElementById('struktur-hapus-foto').checked = false;
            document.getElementById('struktur-remove-photo-wrap').classList.add('hidden');

            const preview = document.getElementById('struktur-photo-preview');
            preview.src = '';
            preview.classList.add('hidden');

            document.getElementById('struktur-modal').classList.remove('hidden');
        };

        window.openStrukturEdit = function (id) {
            const node = window.__strukturNodes[id];
            if (!node) return;

            const form = document.getElementById('struktur-form');
            const methodInput = document.getElementById('struktur-method');
            form.action = "{{ url('dashboard/struktur-organisasi') }}/" + id;
            methodInput.disabled = false;
            methodInput.value = 'PUT';

            document.getElementById('struktur-modal-title').textContent = 'Edit Jabatan Struktur';
            const parentSelect = document.getElementById('struktur-parent-id');
            parentSelect.value = node.parent_id ? String(node.parent_id) : '';
            Array.from(parentSelect.options).forEach(opt => {
                opt.disabled = (opt.value === String(id));
            });

            document.getElementById('struktur-jabatan').value = node.jabatan || '';
            document.getElementById('struktur-nama-pejabat').value = node.nama_pejabat || '';
            document.getElementById('struktur-nip').value = node.nip || '';
            document.getElementById('struktur-tipe-garis').value = node.tipe_garis || 'komando';
            document.getElementById('struktur-warna-badge').value = node.warna_badge || 'maroon';
            document.getElementById('struktur-deskripsi').value = node.deskripsi || '';
            document.getElementById('struktur-is-active').checked = !!node.is_active;
            document.getElementById('struktur-foto-input').value = '';
            document.getElementById('struktur-hapus-foto').checked = false;

            const preview = document.getElementById('struktur-photo-preview');
            const removeWrap = document.getElementById('struktur-remove-photo-wrap');
            if (node.foto_url) {
                preview.src = node.foto_url;
                preview.classList.remove('hidden');
                removeWrap.classList.remove('hidden');
            } else {
                preview.src = '';
                preview.classList.add('hidden');
                removeWrap.classList.add('hidden');
            }

            document.getElementById('struktur-modal').classList.remove('hidden');
        };

        window.compressStrukturPhoto = function (input) {
            const file = input.files[0];
            if (!file || !file.type.startsWith('image/')) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    const maxDim = 600;
                    let w = img.width;
                    let h = img.height;
                    if (w > maxDim || h > maxDim) {
                        if (w > h) { h = Math.round(h * maxDim / w); w = maxDim; }
                        else { w = Math.round(w * maxDim / h); h = maxDim; }
                    }
                    const canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    canvas.getContext('2d').drawImage(img, 0, 0, w, h);
                    canvas.toBlob((blob) => {
                        if (!blob) return;
                        const compressed = new File([blob], file.name.replace(/\.[^.]+$/, '.webp'), { type: 'image/webp' });
                        const dt = new DataTransfer();
                        dt.items.add(compressed);
                        input.files = dt.files;
                        const preview = document.getElementById('struktur-photo-preview');
                        preview.src = URL.createObjectURL(compressed);
                        preview.classList.remove('hidden');
                    }, 'image/webp', 0.82);
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        };
    </script>
</x-app-layout>
