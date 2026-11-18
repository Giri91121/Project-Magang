@extends('layouts.landing')

@section('title', '404 - Halaman Tidak Ditemukan | BRIDA Kota Makassar')

@section('content')
<main class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full text-center space-y-6">
        
        <!-- Ilustrasi / Ikon 404 -->
        <div class="relative w-28 h-28 mx-auto flex items-center justify-center rounded-3xl bg-rose-50 border border-rose-200 shadow-sm text-maroon-700">
            <i class="fa-solid fa-compass-drafting text-5xl"></i>
            <span class="absolute -top-2 -right-2 bg-maroon-700 text-white font-black text-xs px-2.5 py-1 rounded-full shadow">
                404
            </span>
        </div>

        <div class="space-y-2">
            <span class="text-xs font-bold uppercase tracking-widest text-maroon-700">Tautan Tidak Tersedia</span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Halaman Tidak Ditemukan
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                Mohon maaf, halaman dokumen atau rute portal yang Anda tuju tidak ditemukan, telah dipindahkan, atau alamat URL yang dimasukkan kurang tepat.
            </p>
        </div>

        <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('home') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl transition shadow">
                <i class="fa-solid fa-house text-xs"></i>
                <span>Kembali ke Beranda Utama</span>
            </a>
            <a href="{{ route('layanan') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white hover:bg-bone-100 text-slate-700 border border-bone-300 font-bold text-xs px-5 py-2.5 rounded-xl transition shadow-sm">
                <i class="fa-solid fa-book-open text-xs"></i>
                <span>Layanan Riset</span>
            </a>
        </div>

        <div class="pt-6 border-t border-bone-300 text-[11px] text-slate-400">
            Butuh bantuan informasi? Hubungi Sekretariat BRIDA Kota Makassar melalui layanan WhatsApp di <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $portalSettings['contact_whatsapp'] ?? '081144002233') }}" target="_blank" class="text-maroon-700 font-bold hover:underline">{{ $portalSettings['contact_whatsapp'] ?? '081144002233' }}</a>.
        </div>

    </div>
</main>
@endsection
