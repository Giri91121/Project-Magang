<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Breadcrumb & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <a href="{{ route('dashboard.inovasi.index') }}" class="hover:text-maroon-700 transition">Inovasi Daerah</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <span class="text-slate-800 font-bold">Rincian Inovasi</span>
                </nav>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                        {{ $inovasi->nama_inovasi }}
                    </h1>
                    <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $inovasi->status_badge }}">
                        {{ $inovasi->status_verifikasi }}
                    </span>
                </div>
            </div>

            <a href="{{ route('dashboard.inovasi.index') }}" class="inline-flex items-center gap-1.5 bg-white border border-bone-300 hover:bg-bone-100 text-slate-700 text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-sm">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali</span>
            </a>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-6">
            <div class="grid sm:grid-cols-3 gap-4 pb-6 border-b border-bone-200">
                <div>
                    <span class="text-[11px] text-slate-400 block">Kode Registrasi</span>
                    <strong class="font-mono text-slate-900 text-sm">{{ $inovasi->kode_inovasi }}</strong>
                </div>
                <div>
                    <span class="text-[11px] text-slate-400 block">Perangkat Daerah Pengusul</span>
                    <strong class="text-slate-900 text-sm">{{ $inovasi->perangkat_daerah }}</strong>
                </div>
                <div>
                    <span class="text-[11px] text-slate-400 block">Skor Kematangan IGA</span>
                    <strong class="text-emerald-700 text-lg font-black">{{ $inovasi->skor_kematangan }} <span class="text-xs text-slate-400">/ 130</span></strong>
                </div>
            </div>

            <div class="grid sm:grid-cols-3 gap-4 text-xs">
                <div>
                    <span class="text-slate-400 block">Tahapan Inovasi</span>
                    <span class="font-bold text-slate-800">{{ $inovasi->tahapan_inovasi }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Bentuk Inovasi</span>
                    <span class="font-bold text-slate-800">{{ $inovasi->jenis_inovasi }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Inisiator</span>
                    <span class="font-bold text-slate-800">{{ $inovasi->inisiator }}</span>
                </div>
            </div>

            <div class="space-y-2">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Ringkasan & Gambaran Umum</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed bg-bone-50 p-4 rounded-2xl border border-bone-200">
                    {{ $inovasi->ringkasan }}
                </p>
            </div>

            @if($inovasi->kebaruan)
            <div class="space-y-2">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Unsur Kebaruan (Novelty)</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed bg-bone-50 p-4 rounded-2xl border border-bone-200">
                    {{ $inovasi->kebaruan }}
                </p>
            </div>
            @endif
        </div>

    </div>
</x-app-layout>
