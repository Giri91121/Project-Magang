@extends('layouts.landing')

@section('title', 'PPID Pelaksana BRIDA - Badan Riset dan Inovasi Daerah Kota Makassar')
@section('meta_description', 'Profil PPID Pelaksana, Dokumen Perencanaan, dan Daftar Informasi Publik Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar.')

@section('content')
<main>
    <!-- Header Banner Halaman -->
    <section class="bg-gradient-to-r from-maroon-950 via-maroon-900 to-slate-900 text-white py-12 px-4 sm:px-6 lg:px-8 border-b border-maroon-900">
        <div class="max-w-7xl mx-auto">
            <nav class="flex items-center text-xs text-rose-200/80 mb-3" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <a href="{{ route('informasi-publik') }}" class="hover:text-white transition">PPID</a>
                <i class="fa-solid fa-chevron-right text-[10px] mx-2 text-rose-300/60"></i>
                <span class="text-white font-medium">PPID Pelaksana BRIDA</span>
            </nav>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white">
                {{ $portalSettings['ppid_header_title'] ?? 'PPID Pelaksana BRIDA Kota Makassar' }}
            </h1>
            <p class="text-sm sm:text-base text-bone-200 mt-2 max-w-2xl leading-relaxed">
                {{ $portalSettings['ppid_header_subtitle'] ?? 'Pejabat Pengelola Informasi dan Dokumentasi (PPID) Pelaksana Badan Riset dan Inovasi Daerah Pemerintah Kota Makassar.' }}
            </p>
        </div>
    </section>

    <!-- Konten Utama Kartu PPID Pelaksana -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 w-full">
        <div class="bg-white rounded-3xl border border-bone-300 shadow-sm overflow-hidden">

            <!-- Header Instansi -->
            <div class="p-6 sm:p-8 flex items-center gap-4 border-b border-bone-200">
                <div class="w-14 h-14 rounded-2xl bg-rose-50 border border-rose-200 flex items-center justify-center text-maroon-700 text-2xl shrink-0">
                    <i class="fa-regular fa-building"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">
                        {{ $portalSettings['ppid_subtitle'] ?? 'PPID PELAKSANA BADAN RISET DAN INOVASI DAERAH' }}
                    </span>
                    <h2 class="text-lg sm:text-xl font-black text-slate-900 mt-0.5">
                        {{ $portalSettings['ppid_title'] ?? 'Badan Riset dan Inovasi Daerah Kota Makassar' }}
                    </h2>
                </div>
            </div>

            <!-- Navigasi 3 Tab -->
            <div class="px-6 sm:px-8 border-b border-bone-200 flex flex-wrap gap-6 text-xs sm:text-sm font-bold">
                <button type="button"
                        data-ppid-tab="profil"
                        onclick="switchPpidTab('profil')"
                        class="py-4 inline-flex items-center gap-2 transition border-b-2 border-maroon-700 text-maroon-700">
                    <i class="fa-regular fa-file-lines"></i>
                    <span>Profil &amp; Visi Misi</span>
                </button>
                <button type="button"
                        data-ppid-tab="perencanaan"
                        onclick="switchPpidTab('perencanaan')"
                        class="py-4 inline-flex items-center gap-2 transition border-b-2 border-transparent text-slate-500 hover:text-slate-800">
                    <i class="fa-regular fa-folder-open"></i>
                    <span>Dokumen Perencanaan</span>
                </button>
                <button type="button"
                        data-ppid-tab="informasi"
                        onclick="switchPpidTab('informasi')"
                        class="py-4 inline-flex items-center gap-2 transition border-b-2 border-transparent text-slate-500 hover:text-slate-800">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Daftar Informasi</span>
                </button>
            </div>

            <!-- Isi Konten Tab -->
            <div class="p-6 sm:p-8">

                <!-- TAB 1: Profil & Visi Misi -->
                <div id="ppid-panel-profil">
                    @php
                        $hasPpidProfil = !empty($portalSettings['ppid_profil_title']) || !empty($portalSettings['ppid_profil_desc']) || !empty($portalSettings['ppid_visi']) || !empty($portalSettings['ppid_misi']);
                    @endphp
                    @if($hasPpidProfil)
                        <div class="space-y-6 text-sm text-slate-700 leading-relaxed">
                            @if(!empty($portalSettings['ppid_profil_title']) || !empty($portalSettings['ppid_profil_desc']))
                            <div class="space-y-2">
                                @if(!empty($portalSettings['ppid_profil_title']))
                                    <h3 class="text-base font-black text-slate-900">{{ $portalSettings['ppid_profil_title'] }}</h3>
                                @endif
                                @if(!empty($portalSettings['ppid_profil_desc']))
                                    <p class="whitespace-pre-line">{{ $portalSettings['ppid_profil_desc'] }}</p>
                                @endif
                            </div>
                            @endif

                            @if(!empty($portalSettings['ppid_visi']))
                            <div class="p-5 rounded-2xl bg-bone-50 border border-bone-200 space-y-2">
                                <span class="text-[11px] font-extrabold uppercase tracking-wider text-maroon-700 block">Visi</span>
                                <p class="font-bold text-slate-900">{{ $portalSettings['ppid_visi'] }}</p>
                            </div>
                            @endif

                            @if(!empty($portalSettings['ppid_misi']))
                            <div class="p-5 rounded-2xl bg-bone-50 border border-bone-200 space-y-2">
                                <span class="text-[11px] font-extrabold uppercase tracking-wider text-maroon-700 block">Misi</span>
                                <ul class="list-disc pl-5 space-y-1.5 text-slate-700">
                                    @foreach(array_filter(array_map('trim', explode("\n", $portalSettings['ppid_misi']))) as $misiItem)
                                        <li>{{ $misiItem }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-bone-300 bg-bone-50/40 py-14 px-6 text-center space-y-3">
                            <div class="w-12 h-12 rounded-full bg-bone-200/70 text-slate-400 flex items-center justify-center mx-auto text-lg">
                                <i class="fa-regular fa-file-lines"></i>
                            </div>
                            <h3 class="text-sm font-black text-slate-800">Profil &amp; Visi Misi Belum Diunggah</h3>
                            <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                                Informasi profil instansi ini belum diperbarui oleh pengelola PPID Pelaksana terkait.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- TAB 2: Dokumen Perencanaan -->
                <div id="ppid-panel-perencanaan" class="space-y-4 hidden">
                    @php
                        $dokumenPerencanaan = [
                            ['key' => 'renstra', 'setting' => 'ppid_renstra_file', 'judul' => 'Rencana Strategis (Renstra)', 'badge' => '5 TAHUNAN', 'desc' => 'Dokumen perencanaan jangka menengah instansi'],
                            ['key' => 'renja', 'setting' => 'ppid_renja_file', 'judul' => 'Rencana Kerja (Renja)', 'badge' => 'TAHUNAN', 'desc' => 'Dokumen rencana kerja dan anggaran tahunan'],
                            ['key' => 'lakip', 'setting' => 'ppid_lakip_file', 'judul' => 'Laporan Kinerja (Lakip)', 'badge' => 'LAKIP', 'desc' => 'Laporan akuntabilitas kinerja instansi pemerintah'],
                        ];
                    @endphp
                    @foreach($dokumenPerencanaan as $dok)
                    <div class="rounded-2xl border border-bone-300 bg-white p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:border-maroon-700/40 transition">
                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2.5">
                                <h3 class="text-sm font-black text-slate-900">{{ $dok['judul'] }}</h3>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wide uppercase border border-bone-300 bg-bone-50 text-slate-500">
                                    {{ $dok['badge'] }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-500">{{ $dok['desc'] }}</p>
                        </div>
                        @if(!empty($portalSettings[$dok['setting']]))
                            <a href="{{ route('ppid-pelaksana.download', $dok['key']) }}" class="inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold bg-maroon-700 hover:bg-maroon-800 text-white transition shadow-sm shrink-0">
                                <i class="fa-solid fa-file-pdf text-[11px]"></i>
                                <span>Unduh PDF</span>
                            </a>
                        @else
                            <span class="inline-flex items-center justify-center px-3.5 py-1.5 rounded-xl text-xs font-semibold bg-bone-100 text-slate-500 border border-bone-300 shrink-0">
                                Belum Tersedia
                            </span>
                        @endif
                    </div>
                    @endforeach
                </div>

                <!-- TAB 3: Daftar Informasi -->
                <div id="ppid-panel-informasi" class="hidden space-y-4">
                    @if(!empty($portalSettings['ppid_info_title']) || !empty($portalSettings['ppid_info_desc']))
                    <div class="pb-2">
                        @if(!empty($portalSettings['ppid_info_title']))
                            <h3 class="text-sm font-black text-slate-900">{{ $portalSettings['ppid_info_title'] }}</h3>
                        @endif
                        @if(!empty($portalSettings['ppid_info_desc']))
                            <p class="text-xs text-slate-500 mt-0.5">{{ $portalSettings['ppid_info_desc'] }}</p>
                        @endif
                    </div>
                    @endif

                    @if(($portalSettings['ppid_info_show_regulasi'] ?? '1') === '1' && $regulasiList->count() > 0)
                        <div class="divide-y divide-bone-200 border border-bone-200 rounded-2xl overflow-hidden">
                            @foreach($regulasiList as $reg)
                            <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 hover:bg-bone-50 transition">
                                <div class="space-y-1">
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-maroon-700">{{ $reg->kategori ?? 'Informasi Publik' }}</span>
                                    <h4 class="text-xs sm:text-sm font-bold text-slate-900">{{ $reg->judul_regulasi }}</h4>
                                    @if($reg->nomor_peraturan)
                                        <p class="text-[11px] text-slate-500">Nomor: {{ $reg->nomor_peraturan }}</p>
                                    @endif
                                </div>
                                <a href="{{ route('regulasi.download', $reg->id) }}" class="inline-flex items-center gap-1.5 bg-maroon-700 hover:bg-maroon-800 text-white text-xs font-bold px-3.5 py-2 rounded-xl transition shrink-0">
                                    <i class="fa-solid fa-download text-[10px]"></i>
                                    <span>Unduh</span>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-bone-300 bg-bone-50/40 py-14 px-6 text-center space-y-3">
                            <div class="w-12 h-12 rounded-full bg-bone-200/70 text-slate-400 flex items-center justify-center mx-auto text-lg">
                                <i class="fa-solid fa-circle-info"></i>
                            </div>
                            <h3 class="text-sm font-black text-slate-800">Daftar Informasi Belum Diunggah</h3>
                            <p class="text-xs text-slate-500 max-w-md mx-auto leading-relaxed">
                                Daftar informasi publik instansi ini belum diperbarui oleh pengelola PPID Pelaksana terkait.
                            </p>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Footer Kartu: Bagikan Profil Instansi -->
            <div class="px-6 sm:px-8 py-4 border-t border-bone-200 bg-bone-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                <span class="text-slate-500 font-medium">Bagikan Profil Instansi:</span>
                <div class="flex items-center gap-2">
                    <button type="button"
                            onclick="navigator.clipboard.writeText(window.location.href); window.showBridaAlert ? window.showBridaAlert('success', 'Tautan Tersalin!', 'Tautan halaman PPID Pelaksana berhasil disalin.') : alert('Tautan tersalin!');"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-bone-300 hover:border-maroon-700 text-slate-700 font-bold transition shadow-sm">
                        <i class="fa-regular fa-copy text-[11px]"></i>
                        <span>Salin Link</span>
                    </button>
                    <a href="{{ !empty($portalSettings['social_instagram']) ? $portalSettings['social_instagram'] : 'https://instagram.com/bridakotamakassar' }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white border border-bone-300 hover:border-rose-600 hover:text-maroon-700 text-slate-700 font-bold transition shadow-sm">
                        <i class="fa-brands fa-instagram text-xs"></i>
                        <span>IG</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</main>

<script>
function switchPpidTab(tabName) {
    const tabs = ['profil', 'perencanaan', 'informasi'];
    tabs.forEach(t => {
        const panel = document.getElementById('ppid-panel-' + t);
        const btn = document.querySelector('[data-ppid-tab="' + t + '"]');
        if (!panel || !btn) return;
        if (t === tabName) {
            panel.classList.remove('hidden');
            btn.classList.add('border-maroon-700', 'text-maroon-700');
            btn.classList.remove('border-transparent', 'text-slate-500', 'hover:text-slate-800');
        } else {
            panel.classList.add('hidden');
            btn.classList.remove('border-maroon-700', 'text-maroon-700');
            btn.classList.add('border-transparent', 'text-slate-500', 'hover:text-slate-800');
        }
    });
}
</script>
@endsection
