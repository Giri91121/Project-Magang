<x-app-layout>
    <style>
        .org-tree ul {
            padding-top: 22px;
            position: relative;
            display: flex;
            justify-content: center;
        }
        .org-tree > ul {
            padding-top: 0;
        }
        .org-tree li {
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 22px 10px 0 10px;
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
                'jabatan' => $n->jabatan,
                'nama_pejabat' => $n->nama_pejabat ?? '',
                'nip' => $n->nip ?? '',
                'foto_url' => $n->foto ? asset('storage/' . $n->foto) : '',
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
                    Tambahkan kartu jabatan lalu hubungkan menggunakan bundaran penghubung di atas/bawah kartu.
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('struktur-organisasi') }}" target="_blank" class="inline-flex items-center gap-2 bg-white border border-bone-300 hover:border-maroon-700 text-slate-700 hover:text-maroon-700 text-xs font-bold px-3.5 py-2.5 rounded-xl transition shadow-sm">
                    <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    <span>Lihat Halaman Publik</span>
                </a>

                <button type="button" onclick="openStrukturAdd()" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition shadow">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Tambah Kartu</span>
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

        <!-- Bagan Struktur -->
        <div class="bg-white rounded-3xl border border-bone-300 shadow-sm overflow-hidden">
            <div class="px-5 py-3.5 border-b border-bone-200 bg-bone-50 flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3 text-xs text-slate-600">
                    <span class="font-extrabold text-slate-800"><i class="fa-solid fa-sitemap mr-1.5 text-maroon-700"></i>Bagan Struktur</span>
                    <span class="hidden sm:inline text-slate-300">|</span>
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px]"><span class="w-4 border-t-2 border-slate-400 inline-block"></span> Komando</span>
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-[11px]"><span class="w-4 border-t-2 border-dashed border-slate-400 inline-block"></span> Koordinasi</span>
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

            <!-- Bar Mode Hubungkan (Klik Bundaran Bawah) -->
            <div id="connect-mode-bar" class="hidden mx-5 mt-4 p-3 rounded-2xl bg-maroon-50 border border-maroon-200 flex flex-wrap items-center justify-between gap-3 text-xs">
                <div class="flex items-center gap-2 text-maroon-900 font-bold">
                    <i class="fa-solid fa-link text-maroon-700"></i>
                    <span><span id="connect-mode-action">Pilih kartu tujuan untuk dihubungkan di bawah:</span> <strong id="connect-source-label" class="underline"></strong></span>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" id="btn-connect-komando" onclick="setConnectLineType('komando')" class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-maroon-700 text-white transition">─── Komando</button>
                    <button type="button" id="btn-connect-koordinasi" onclick="setConnectLineType('koordinasi')" class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white border border-bone-300 text-slate-700 transition">- - - Koordinasi</button>
                    <button type="button" onclick="cancelConnectMode()" class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-200 hover:bg-slate-300 text-slate-700 transition">Batal</button>
                </div>
            </div>

            <div id="dashboard-canvas" class="p-6 sm:p-10 overflow-x-auto bg-slate-50/60 min-h-[360px] cursor-grab active:cursor-grabbing select-none">
                @if($tree->isEmpty())
                    <div class="py-16 text-center space-y-3 max-w-md mx-auto">
                        <div class="w-14 h-14 rounded-2xl bg-bone-200 text-maroon-700 flex items-center justify-center mx-auto text-2xl">
                            <i class="fa-solid fa-sitemap"></i>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-800">Belum Ada Kartu Struktur</h3>
                        <p class="text-xs text-slate-500">Klik tombol <strong>Tambah Kartu</strong> di kanan atas untuk mulai menambahkan kartu jabatan.</p>
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

        <!-- Modal Tambah / Edit Kartu -->
        <div id="struktur-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" onclick="if (event.target === this) closeStrukturModal()">
            <div class="bg-white rounded-3xl border border-bone-300 shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="px-6 py-4 border-b border-bone-200 flex items-center justify-between sticky top-0 bg-white z-10">
                    <h3 id="struktur-modal-title" class="text-base font-black text-slate-900">Tambah Kartu</h3>
                    <button type="button" onclick="closeStrukturModal()" class="text-slate-400 hover:text-slate-700 p-1">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form id="struktur-form" action="{{ route('dashboard.struktur.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" name="_method" id="struktur-method" value="POST" disabled>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="space-y-1 sm:col-span-2">
                            <label class="block text-xs font-bold text-slate-700">Jabatan / Unit Kerja <span class="text-rose-500">*</span></label>
                            <input type="text" name="jabatan" id="struktur-jabatan" required maxlength="255" placeholder="Contoh: Kepala Badan / Sekretaris / Kepala Bidang..." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">Nama Pejabat <span class="text-rose-500">*</span></label>
                            <input type="text" name="nama_pejabat" id="struktur-nama-pejabat" required maxlength="255" placeholder="Nama lengkap & gelar" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                        </div>

                        <div class="space-y-1">
                            <label class="block text-xs font-bold text-slate-700">NIP <span class="text-rose-500">*</span></label>
                            <input type="text" name="nip" id="struktur-nip" required maxlength="50" placeholder="19700101 199503 1 001" class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2.5 px-3">
                        </div>

                        <div class="space-y-1 sm:col-span-2">
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
                            <label class="block text-xs font-bold text-slate-700">Foto Pejabat (otomatis dikompres)</label>
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
                            <label class="block text-xs font-bold text-slate-700">Tugas Pokok &amp; Fungsi <span class="text-rose-500">*</span></label>
                            <textarea name="deskripsi" id="struktur-deskripsi" rows="3" required maxlength="2000" placeholder="Ringkasan tupoksi yang tampil saat kartu diklik di halaman publik..." class="w-full text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-2 px-3"></textarea>
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

    <!-- Floating Toast Notifikasi -->
    <div id="struktur-toast" class="hidden fixed bottom-5 right-5 z-50 px-4 py-3 rounded-2xl shadow-xl text-xs font-bold text-white flex items-center gap-2 transition"></div>

    <!-- Live SVG Drag-to-Connect Overlay -->
    <svg id="drag-connect-svg" class="hidden pointer-events-none fixed inset-0 w-full h-full z-40">
        <path id="drag-connect-path" d="" fill="none" stroke="#881337" stroke-width="2.5" stroke-dasharray="6 4" stroke-linecap="round" />
    </svg>

    <!-- Popover Mini Jenis Garis (Klik Bundaran Atas Kartu) -->
    <div id="line-type-popover" class="hidden fixed z-50 bg-white rounded-2xl border border-bone-300 shadow-2xl p-2 w-52 space-y-1 text-xs">
        <div class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-slate-400">Jenis Garis Hubung</div>
        <button type="button" id="pop-btn-komando" onclick="updateNodeLineType('komando')" class="w-full text-left px-3 py-2 rounded-xl hover:bg-bone-100 font-bold text-slate-700 flex items-center justify-between">
            <span>─── Garis Komando</span>
            <i class="fa-solid fa-check text-maroon-700 hidden"></i>
        </button>
        <button type="button" id="pop-btn-koordinasi" onclick="updateNodeLineType('koordinasi')" class="w-full text-left px-3 py-2 rounded-xl hover:bg-bone-100 font-bold text-slate-700 flex items-center justify-between">
            <span>- - - Garis Koordinasi</span>
            <i class="fa-solid fa-check text-amber-600 hidden"></i>
        </button>
        <div class="border-t border-bone-200 my-1"></div>
        <button type="button" onclick="disconnectNodeToRoot()" class="w-full text-left px-3 py-2 rounded-xl hover:bg-rose-50 font-bold text-rose-600 flex items-center gap-2">
            <i class="fa-solid fa-link-slash text-[11px]"></i>
            <span>Putuskan Hubungan</span>
        </button>
    </div>

    <script>
        let dashboardZoom = 1;
        let connectSourceId = null;
        let connectDirection = 'down';
        let connectLineType = 'komando';
        let activeLineNodeId = null;

        window.changeDashboardZoom = function (delta) {
            dashboardZoom = delta === 0 ? 1 : Math.min(1.4, Math.max(0.45, +(dashboardZoom + delta).toFixed(2)));
            const tree = document.getElementById('dashboard-org-tree');
            const label = document.getElementById('dashboard-zoom-label');
            if (tree) tree.style.transform = `scale(${dashboardZoom})`;
            if (label) label.textContent = Math.round(dashboardZoom * 100) + '%';
        };

        window.showStrukturToast = function (msg, type = 'success') {
            const toast = document.getElementById('struktur-toast');
            if (!toast) return;
            toast.className = `fixed bottom-5 right-5 z-50 px-4 py-3 rounded-2xl shadow-xl text-xs font-bold text-white flex items-center gap-2 ${type === 'error' ? 'bg-rose-600' : 'bg-emerald-600'}`;
            toast.innerHTML = `<i class="fa-solid ${type === 'error' ? 'fa-triangle-exclamation' : 'fa-circle-check'}"></i><span>${msg}</span>`;
            setTimeout(() => toast.classList.add('hidden'), 3200);
        };

        window.closeStrukturModal = function () {
            document.getElementById('struktur-modal').classList.add('hidden');
        };

        window.openStrukturAdd = function () {
            const form = document.getElementById('struktur-form');
            const methodInput = document.getElementById('struktur-method');
            form.action = "{{ route('dashboard.struktur.store') }}";
            methodInput.disabled = true;
            methodInput.value = 'POST';

            document.getElementById('struktur-modal-title').textContent = 'Tambah Kartu';
            document.getElementById('struktur-jabatan').value = '';
            document.getElementById('struktur-nama-pejabat').value = '';
            document.getElementById('struktur-nip').value = '';
            document.getElementById('struktur-warna-badge').value = 'maroon';
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

            document.getElementById('struktur-modal-title').textContent = 'Edit Kartu';
            document.getElementById('struktur-jabatan').value = node.jabatan || '';
            document.getElementById('struktur-nama-pejabat').value = node.nama_pejabat || '';
            document.getElementById('struktur-nip').value = node.nip || '';
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

        window.handleDashboardCardClick = async function (event, id) {
            if (connectSourceId !== null) {
                if (connectSourceId === id) {
                    cancelConnectMode();
                    return;
                }
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                const childId = connectDirection === 'up' ? connectSourceId : id;
                const parentId = connectDirection === 'up' ? id : connectSourceId;
                try {
                    const res = await fetch(`{{ url('dashboard/struktur-organisasi') }}/${childId}/reparent`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ parent_id: parentId, tipe_garis: connectLineType }),
                    });
                    const data = await res.json();
                    if (!res.ok) {
                        showStrukturToast(data.message || 'Gagal menghubungkan kartu.', 'error');
                        return;
                    }
                    showStrukturToast(data.message || 'Kartu berhasil dihubungkan.', 'success');
                    setTimeout(() => window.location.reload(), 400);
                } catch (e) {
                    showStrukturToast('Terjadi kesalahan jaringan.', 'error');
                }
                return;
            }
            openStrukturEdit(id);
        };

        window.startConnectMode = function (sourceId, label, direction = 'down') {
            closeLinePopover();
            connectSourceId = sourceId;
            connectDirection = direction;
            document.getElementById('connect-mode-action').textContent = direction === 'up'
                ? 'Pilih kartu untuk dijadikan atasan dari:'
                : 'Pilih kartu untuk dijadikan sub-unit di bawah:';
            document.getElementById('connect-source-label').textContent = label;
            document.getElementById('connect-mode-bar').classList.remove('hidden');
            document.querySelectorAll('#dashboard-org-tree .org-card').forEach(card => {
                const cid = Number(card.getAttribute('data-card-id'));
                if (cid === sourceId) {
                    card.classList.add('ring-2', 'ring-maroon-700');
                } else {
                    card.classList.add('ring-2', 'ring-dashed', 'ring-emerald-500');
                }
            });
        };

        window.cancelConnectMode = function () {
            connectSourceId = null;
            document.getElementById('connect-mode-bar')?.classList.add('hidden');
            document.querySelectorAll('#dashboard-org-tree .org-card').forEach(card => {
                card.classList.remove('ring-2', 'ring-maroon-700', 'ring-dashed', 'ring-emerald-500');
            });
        };

        window.setConnectLineType = function (type) {
            connectLineType = type;
            const btnKom = document.getElementById('btn-connect-komando');
            const btnKoo = document.getElementById('btn-connect-koordinasi');
            if (type === 'komando') {
                btnKom.className = 'px-2.5 py-1 rounded-lg text-[11px] font-bold bg-maroon-700 text-white transition';
                btnKoo.className = 'px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white border border-bone-300 text-slate-700 transition';
            } else {
                btnKoo.className = 'px-2.5 py-1 rounded-lg text-[11px] font-bold bg-amber-500 text-white transition';
                btnKom.className = 'px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white border border-bone-300 text-slate-700 transition';
            }
        };

        window.openLinePopover = function (eventOrEl, id, currentType) {
            cancelConnectMode();
            activeLineNodeId = id;
            const pop = document.getElementById('line-type-popover');
            const targetEl = eventOrEl.currentTarget || eventOrEl;
            const rect = targetEl.getBoundingClientRect();
            pop.style.top = (rect.bottom + 6) + 'px';
            pop.style.left = Math.min(window.innerWidth - 220, Math.max(12, rect.left - 90)) + 'px';
            pop.classList.remove('hidden');

            document.querySelector('#pop-btn-komando i').classList.toggle('hidden', currentType !== 'komando');
            document.querySelector('#pop-btn-koordinasi i').classList.toggle('hidden', currentType !== 'koordinasi');
        };

        window.closeLinePopover = function () {
            activeLineNodeId = null;
            document.getElementById('line-type-popover')?.classList.add('hidden');
        };

        window.updateNodeLineType = async function (type) {
            if (!activeLineNodeId) return;
            const id = activeLineNodeId;
            closeLinePopover();
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            try {
                const res = await fetch(`{{ url('dashboard/struktur-organisasi') }}/${id}/line-type`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ tipe_garis: type }),
                });
                const data = await res.json();
                if (!res.ok) {
                    showStrukturToast(data.message || 'Gagal mengubah jenis garis.', 'error');
                    return;
                }
                showStrukturToast(data.message || 'Jenis garis diperbarui.', 'success');
                setTimeout(() => window.location.reload(), 350);
            } catch (e) {
                showStrukturToast('Terjadi kesalahan jaringan.', 'error');
            }
        };

        window.disconnectNodeToRoot = async function () {
            if (!activeLineNodeId) return;
            const id = activeLineNodeId;
            closeLinePopover();
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            try {
                const res = await fetch(`{{ url('dashboard/struktur-organisasi') }}/${id}/reparent`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                    body: JSON.stringify({ parent_id: null }),
                });
                const data = await res.json();
                if (!res.ok) {
                    showStrukturToast(data.message || 'Gagal memutus hubungan.', 'error');
                    return;
                }
                showStrukturToast('Hubungan diputuskan.', 'success');
                setTimeout(() => window.location.reload(), 350);
            } catch (e) {
                showStrukturToast('Terjadi kesalahan jaringan.', 'error');
            }
        };

        document.addEventListener('click', (e) => {
            if (!e.target.closest('#line-type-popover')) closeLinePopover();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                cancelConnectMode();
                closeLinePopover();
            }
        });

        // Toggle Tampil / Sembunyi di Publik 1-Klik
        window.toggleCardActive = async function (btn, id) {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            try {
                const res = await fetch(`{{ url('dashboard/struktur-organisasi') }}/${id}/toggle-active`, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                });
                const data = await res.json();
                if (!res.ok) {
                    showStrukturToast(data.message || 'Gagal mengubah status.', 'error');
                    return;
                }
                const card = btn.closest('.org-card');
                const icon = btn.querySelector('i');
                if (data.is_active) {
                    card?.classList.remove('border-dashed', 'border-rose-300', 'opacity-70');
                    card?.classList.add('border-bone-300');
                    btn.className = 'p-1 text-emerald-600 hover:bg-emerald-50 rounded-md transition';
                    btn.title = 'Sembunyikan dari Publik';
                    if (icon) icon.className = 'fa-regular fa-eye';
                } else {
                    card?.classList.remove('border-bone-300');
                    card?.classList.add('border-dashed', 'border-rose-300', 'opacity-70');
                    btn.className = 'p-1 text-slate-400 hover:bg-bone-100 rounded-md transition';
                    btn.title = 'Tampilkan di Publik';
                    if (icon) icon.className = 'fa-regular fa-eye-slash';
                }
                if (window.__strukturNodes[id]) window.__strukturNodes[id].is_active = data.is_active;
                showStrukturToast(data.message, 'success');
            } catch (e) {
                showStrukturToast('Terjadi kesalahan jaringan.', 'error');
            }
        };

        // Tarik Garis Langsung (Live SVG Drag-to-Connect: Atas -> Atasan, Bawah -> Sub-unit)
        window.startDragConnect = function (event, sourceId, label, direction = 'down', hasParent = false, currentLineType = 'komando') {
            event.stopPropagation();
            event.preventDefault();
            const triggerBtn = event.currentTarget;
            const startX = event.clientX;
            const startY = event.clientY;
            let moved = false;
            let hoveredCard = null;

            const svg = document.getElementById('drag-connect-svg');
            const path = document.getElementById('drag-connect-path');
            path.setAttribute('stroke', direction === 'up' ? '#4f46e5' : '#881337');

            function onMove(e) {
                const dx = e.clientX - startX;
                const dy = e.clientY - startY;
                if (!moved && Math.hypot(dx, dy) > 6) {
                    moved = true;
                    svg.classList.remove('hidden');
                }
                if (!moved) return;

                const midY = (startY + e.clientY) / 2;
                path.setAttribute('d', `M ${startX} ${startY} C ${startX} ${midY}, ${e.clientX} ${midY}, ${e.clientX} ${e.clientY}`);

                const el = document.elementFromPoint(e.clientX, e.clientY);
                const card = el?.closest('.org-card');
                if (hoveredCard && hoveredCard !== card) {
                    hoveredCard.classList.remove('ring-2', 'ring-emerald-500');
                }
                if (card && Number(card.getAttribute('data-card-id')) !== sourceId) {
                    card.classList.add('ring-2', 'ring-emerald-500');
                    hoveredCard = card;
                } else {
                    hoveredCard = null;
                }
            }

            async function onUp(e) {
                window.removeEventListener('mousemove', onMove);
                window.removeEventListener('mouseup', onUp);
                svg.classList.add('hidden');
                path.setAttribute('d', '');
                if (hoveredCard) hoveredCard.classList.remove('ring-2', 'ring-emerald-500');

                if (!moved) {
                    if (direction === 'up' && hasParent) {
                        openLinePopover(triggerBtn, sourceId, currentLineType);
                    } else {
                        startConnectMode(sourceId, label, direction);
                    }
                    return;
                }

                const targetId = hoveredCard ? Number(hoveredCard.getAttribute('data-card-id')) : null;
                if (!targetId || targetId === sourceId) return;

                const childId = direction === 'up' ? sourceId : targetId;
                const parentId = direction === 'up' ? targetId : sourceId;
                const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                try {
                    const res = await fetch(`{{ url('dashboard/struktur-organisasi') }}/${childId}/reparent`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        body: JSON.stringify({ parent_id: parentId, tipe_garis: connectLineType }),
                    });
                    const data = await res.json();
                    if (!res.ok) {
                        showStrukturToast(data.message || 'Gagal menghubungkan kartu.', 'error');
                        return;
                    }
                    showStrukturToast(data.message || 'Kartu berhasil dihubungkan.', 'success');
                    setTimeout(() => window.location.reload(), 350);
                } catch (err) {
                    showStrukturToast('Terjadi kesalahan jaringan.', 'error');
                }
            }

            window.addEventListener('mousemove', onMove);
            window.addEventListener('mouseup', onUp);
        };

        // Drag-to-pan 2D & Ctrl+Scroll Zoom pada canvas kosong
        (function initDashboardPan() {
            const canvas = document.getElementById('dashboard-canvas');
            if (!canvas) return;
            let isPanning = false;
            let startX = 0, startY = 0;
            let scrollLeft = 0, scrollTop = 0;
            canvas.addEventListener('mousedown', (e) => {
                if (e.target.closest('.org-card, button, a, input, select, form')) return;
                isPanning = true;
                startX = e.pageX - canvas.offsetLeft;
                startY = e.pageY - canvas.offsetTop;
                scrollLeft = canvas.scrollLeft;
                scrollTop = canvas.scrollTop;
            });
            window.addEventListener('mouseup', () => { isPanning = false; });
            canvas.addEventListener('mousemove', (e) => {
                if (!isPanning) return;
                e.preventDefault();
                canvas.scrollLeft = scrollLeft - ((e.pageX - canvas.offsetLeft) - startX);
                canvas.scrollTop = scrollTop - ((e.pageY - canvas.offsetTop) - startY);
            });
            canvas.addEventListener('wheel', (e) => {
                if (!e.ctrlKey) return;
                e.preventDefault();
                changeDashboardZoom(e.deltaY < 0 ? 0.1 : -0.1);
            }, { passive: false });
        })();
    </script>
</x-app-layout>
