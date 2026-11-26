@extends('layouts.landing')

@section('title', 'Struktur Organisasi - BRIDA Kota Makassar')
@section('meta_description', 'Struktur Organisasi Badan Riset dan Inovasi Daerah (BRIDA) Pemerintah Kota Makassar.')

@section('content')
<style>
    .org-tree ul {
        padding-top: 24px;
        position: relative;
        display: flex;
        justify-content: center;
        gap: 16px;
    }
    .org-tree > ul {
        padding-top: 0;
    }
    .org-tree li {
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 24px 6px 0 6px;
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
        height: 24px;
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
        height: 24px;
    }
    .org-tree > ul > li::before,
    .org-tree > ul > li::after {
        display: none;
    }

    @media print {
        header, footer, .no-print {
            display: none !important;
        }
        .org-tree {
            transform: scale(0.85) !important;
        }
    }
</style>

@php
    $publicNodesJson = $allNodes->mapWithKeys(function ($n) {
        return [$n->id => [
            'id' => $n->id,
            'jabatan' => $n->jabatan,
            'nama_pejabat' => $n->nama_pejabat ?? '',
            'nip' => $n->nip ?? '',
            'foto_url' => $n->foto ? asset('storage/' . $n->foto) : '',
            'tipe_garis' => $n->tipe_garis,
            'deskripsi' => $n->deskripsi ?? '',
        ]];
    });
@endphp

<script>
    window.__publicStrukturNodes = @json($publicNodesJson);
</script>

<main>
    <!-- Header Banner Halaman -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <a href="{{ route('pemerintahan') }}" class="hover:text-white transition">Pemerintahan</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">Struktur Organisasi</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                Struktur Organisasi
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                Susunan organisasi dan tata kerja Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar.
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
        @if($tree->isEmpty())
            <div class="py-16 flex items-center justify-center">
                <div class="text-center space-y-3 max-w-md">
                    <div class="w-16 h-16 rounded-2xl bg-bone-200 border border-bone-300 text-maroon-700 flex items-center justify-center mx-auto text-2xl">
                        <i class="fa-solid fa-sitemap"></i>
                    </div>
                    <h2 class="text-lg font-extrabold text-slate-800">Struktur Organisasi BRIDA Kota Makassar</h2>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Halaman ini sedang disiapkan dan akan segera dilengkapi dengan bagan serta detail struktur organisasi resmi.
                    </p>
                </div>
            </div>
        @else
            <!-- Toolbar Interaktif -->
            <div class="no-print bg-white rounded-2xl border border-bone-300 shadow-sm p-4 mb-6 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="relative flex-1 max-w-md">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input type="text" oninput="filterPublicStruktur(this.value)" placeholder="Cari jabatan atau nama pejabat..." class="w-full text-xs pl-9 pr-3 py-2.5 rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700">
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <div class="inline-flex rounded-xl border border-bone-300 bg-bone-50 p-1">
                        <button type="button" id="btn-view-tree" onclick="setPublicStrukturView('tree')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition bg-maroon-700 text-white shadow-sm">
                            <i class="fa-solid fa-sitemap mr-1"></i> Bagan
                        </button>
                        <button type="button" id="btn-view-list" onclick="setPublicStrukturView('list')" class="px-3 py-1.5 rounded-lg text-xs font-bold transition text-slate-600 hover:text-maroon-700">
                            <i class="fa-solid fa-list-ul mr-1"></i> Daftar
                        </button>
                    </div>

                    <div id="public-zoom-controls" class="inline-flex items-center gap-1 border border-bone-300 rounded-xl px-2 py-1 bg-white">
                        <button type="button" onclick="changePublicZoom(-0.1)" class="p-1.5 text-xs text-slate-600 hover:text-maroon-700" title="Perkecil">
                            <i class="fa-solid fa-magnifying-glass-minus"></i>
                        </button>
                        <span id="public-zoom-label" class="text-xs font-bold text-slate-600 w-10 text-center">100%</span>
                        <button type="button" onclick="changePublicZoom(0.1)" class="p-1.5 text-xs text-slate-600 hover:text-maroon-700" title="Perbesar">
                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                        </button>
                        <button type="button" onclick="changePublicZoom(0)" class="px-2 py-1 text-[11px] font-bold text-slate-600 hover:text-maroon-700">Reset</button>
                    </div>

                    <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl border border-bone-300 bg-white hover:bg-bone-100 text-slate-700 text-xs font-bold transition">
                        <i class="fa-solid fa-print text-maroon-700"></i> Cetak
                    </button>
                </div>
            </div>

            <!-- Tampilan Bagan Pohon -->
            <div id="public-view-tree" class="bg-white rounded-3xl border border-bone-300 shadow-sm p-6 sm:p-10 overflow-x-auto">
                <div id="public-org-tree" class="org-tree inline-block min-w-full origin-top transition-transform duration-150">
                    <ul>
                        @foreach($tree as $rootNode)
                            @include('landing._struktur-node', ['node' => $rootNode])
                        @endforeach
                    </ul>
                </div>

                <div class="mt-8 pt-4 border-t border-bone-200 flex flex-wrap items-center justify-between gap-3 text-[11px] text-slate-500">
                    <div class="flex items-center gap-4">
                        <span class="inline-flex items-center gap-1.5"><span class="w-5 border-t-2 border-slate-400 inline-block"></span> Garis Komando</span>
                        <span class="inline-flex items-center gap-1.5"><span class="w-5 border-t-2 border-dashed border-slate-400 inline-block"></span> Garis Koordinasi</span>
                    </div>
                    <span>Klik kartu jabatan untuk melihat detail pejabat &amp; tupoksi.</span>
                </div>
            </div>

            <!-- Tampilan Daftar Hierarki (Ramah Mobile) -->
            <div id="public-view-list" class="hidden space-y-3">
                @foreach($allNodes as $item)
                    @php
                        $itemSearch = strtolower(trim(($item->jabatan ?? '') . ' ' . ($item->nama_pejabat ?? '') . ' ' . ($item->nip ?? '')));
                    @endphp
                    <button
                        type="button"
                        data-search="{{ $itemSearch }}"
                        onclick="openPublicStrukturDetail({{ $item->id }})"
                        class="public-struktur-list-item w-full text-left bg-white rounded-2xl border border-bone-300 p-4 shadow-sm hover:shadow-md transition flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3.5 min-w-0">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_pejabat ?: $item->jabatan }}" class="w-12 h-12 rounded-xl object-cover border border-bone-300 shrink-0">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-bone-100 border border-bone-300 text-maroon-700 flex items-center justify-center font-extrabold text-sm shrink-0">
                                    {{ strtoupper(mb_substr($item->nama_pejabat ?: $item->jabatan, 0, 2)) }}
                                </div>
                            @endif
                            <div class="min-w-0">
                                <div class="text-sm font-extrabold text-slate-900 truncate">{{ $item->jabatan }}</div>
                                @if($item->nama_pejabat)
                                    <div class="text-xs font-semibold text-maroon-700 truncate">{{ $item->nama_pejabat }}</div>
                                @endif
                                @if($item->nip)
                                    <div class="text-[11px] text-slate-400">NIP. {{ $item->nip }}</div>
                                @endif
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-right text-slate-400 text-xs shrink-0"></i>
                    </button>
                @endforeach
            </div>

            @if(!empty($dasarHukum))
                <div class="mt-6 p-4 rounded-2xl bg-bone-100 border border-bone-300 text-xs text-slate-600 flex items-start gap-2.5">
                    <i class="fa-solid fa-scale-balanced text-maroon-700 mt-0.5"></i>
                    <span>{{ $dasarHukum }}</span>
                </div>
            @endif
        @endif
    </div>

    <!-- Modal Detail Pejabat & Tupoksi -->
    <div id="public-struktur-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" onclick="if (event.target === this) closePublicStrukturDetail()">
        <div class="bg-white rounded-3xl border border-bone-300 shadow-2xl w-full max-w-lg overflow-hidden">
            <div class="bg-gradient-to-r from-maroon-900 to-slate-900 px-6 py-5 text-white flex items-start justify-between gap-4">
                <div class="flex items-center gap-4 min-w-0">
                    <img id="pub-modal-foto" src="" alt="Foto Pejabat" class="hidden w-16 h-16 rounded-2xl object-cover border-2 border-white/30 shrink-0">
                    <div id="pub-modal-avatar" class="w-16 h-16 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center text-2xl font-black shrink-0">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <div class="min-w-0">
                        <span id="pub-modal-jalur" class="inline-block text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-white/15 text-rose-200 mb-1">Jalur Komando</span>
                        <h3 id="pub-modal-jabatan" class="text-base font-black leading-snug"></h3>
                    </div>
                </div>
                <button type="button" onclick="closePublicStrukturDetail()" class="text-white/70 hover:text-white p-1">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid sm:grid-cols-2 gap-3 text-xs">
                    <div class="p-3 rounded-xl bg-bone-50 border border-bone-200">
                        <div class="text-[10px] font-bold uppercase text-slate-400">Nama Pejabat</div>
                        <div id="pub-modal-nama" class="font-bold text-slate-800 mt-0.5">-</div>
                    </div>
                    <div class="p-3 rounded-xl bg-bone-50 border border-bone-200">
                        <div class="text-[10px] font-bold uppercase text-slate-400">NIP</div>
                        <div id="pub-modal-nip" class="font-bold text-slate-800 mt-0.5">-</div>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <div class="text-xs font-extrabold text-slate-800">Tugas Pokok &amp; Fungsi</div>
                    <p id="pub-modal-deskripsi" class="text-xs text-slate-600 leading-relaxed whitespace-pre-line"></p>
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="button" onclick="closePublicStrukturDetail()" class="px-5 py-2 rounded-xl bg-maroon-700 hover:bg-maroon-800 text-white text-xs font-bold transition">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    let publicZoom = 1;

    window.changePublicZoom = function (delta) {
        publicZoom = delta === 0 ? 1 : Math.min(1.4, Math.max(0.5, +(publicZoom + delta).toFixed(1)));
        const tree = document.getElementById('public-org-tree');
        const label = document.getElementById('public-zoom-label');
        if (tree) tree.style.transform = `scale(${publicZoom})`;
        if (label) label.textContent = Math.round(publicZoom * 100) + '%';
    };

    window.setPublicStrukturView = function (mode) {
        const treeView = document.getElementById('public-view-tree');
        const listView = document.getElementById('public-view-list');
        const zoomControls = document.getElementById('public-zoom-controls');
        const btnTree = document.getElementById('btn-view-tree');
        const btnList = document.getElementById('btn-view-list');

        if (mode === 'tree') {
            treeView.classList.remove('hidden');
            listView.classList.add('hidden');
            zoomControls.classList.remove('hidden');
            btnTree.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition bg-maroon-700 text-white shadow-sm';
            btnList.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition text-slate-600 hover:text-maroon-700';
        } else {
            treeView.classList.add('hidden');
            listView.classList.remove('hidden');
            zoomControls.classList.add('hidden');
            btnList.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition bg-maroon-700 text-white shadow-sm';
            btnTree.className = 'px-3 py-1.5 rounded-lg text-xs font-bold transition text-slate-600 hover:text-maroon-700';
        }
    };

    window.filterPublicStruktur = function (query) {
        const q = (query || '').trim().toLowerCase();
        document.querySelectorAll('.public-struktur-node').forEach(el => {
            const hay = el.getAttribute('data-search') || '';
            el.classList.remove('opacity-35', 'scale-95', 'ring-2', 'ring-maroon-600', 'shadow-lg');
            if (q !== '') {
                if (hay.includes(q)) {
                    el.classList.add('ring-2', 'ring-maroon-600', 'shadow-lg');
                } else {
                    el.classList.add('opacity-35', 'scale-95');
                }
            }
        });
        document.querySelectorAll('.public-struktur-list-item').forEach(el => {
            const hay = el.getAttribute('data-search') || '';
            if (q === '' || hay.includes(q)) {
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        });
    };

    window.openPublicStrukturDetail = function (id) {
        const node = window.__publicStrukturNodes[id];
        if (!node) return;

        const foto = document.getElementById('pub-modal-foto');
        const avatar = document.getElementById('pub-modal-avatar');
        if (node.foto_url) {
            foto.src = node.foto_url;
            foto.classList.remove('hidden');
            avatar.classList.add('hidden');
        } else {
            foto.src = '';
            foto.classList.add('hidden');
            avatar.classList.remove('hidden');
        }

        document.getElementById('pub-modal-jalur').textContent = node.tipe_garis === 'koordinasi' ? 'Jalur Koordinasi' : 'Jalur Komando';
        document.getElementById('pub-modal-jabatan').textContent = node.jabatan || '-';
        document.getElementById('pub-modal-nama').textContent = node.nama_pejabat || '-';
        document.getElementById('pub-modal-nip').textContent = node.nip || '-';
        document.getElementById('pub-modal-deskripsi').textContent = node.deskripsi || 'Belum ada keterangan tupoksi untuk jabatan ini.';

        document.getElementById('public-struktur-modal').classList.remove('hidden');
    };

    window.closePublicStrukturDetail = function () {
        document.getElementById('public-struktur-modal').classList.add('hidden');
    };
</script>
@endsection
