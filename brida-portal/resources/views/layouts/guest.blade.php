<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Autentikasi Portal - BRIDA Kota Makassar</title>

        <!-- Favicon Resmi BRIDA Kota Makassar -->
        <link rel="icon" type="image/png" href="{{ asset('images/LOGO-FIX-BRIDA.png') }}">

        <!-- Google Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Font Awesome Icons -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <!-- Tailwind CSS & Custom Config -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="{{ asset('js/tailwind.config.js') }}"></script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="font-sans text-slate-800 antialiased bg-bone-100">
        <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
            
            <!-- Ornamen Latar Belakang Halus -->
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-rose-200/30 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full bg-maroon-700/10 blur-3xl pointer-events-none"></div>

            <!-- Logo Resmi BRIDA Kota Makassar -->
            <div class="mb-6 text-center relative z-10">
                <a href="{{ route('home') }}" class="inline-block focus:outline-none">
                    <img src="{{ asset('images/LOGO-FIX-BRIDA-removebg-preview.png') }}" alt="BRIDA Kota Makassar" class="h-14 sm:h-16 w-auto mx-auto object-contain">
                </a>
                <p class="text-xs font-bold uppercase tracking-widest text-maroon-700 mt-2">
                    Portal Layanan Riset & Inovasi Daerah
                </p>
            </div>

            <!-- Kartu Utama Autentikasi -->
            <div class="w-full sm:max-w-md bg-white rounded-3xl p-8 border border-bone-300 shadow-xl relative z-10">
                {{ $slot }}
            </div>

            <!-- Tautan Kembali ke Beranda -->
            <div class="mt-6 text-center relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-500 hover:text-maroon-700 transition">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Kembali ke Beranda Portal Publik</span>
                </a>
            </div>
        </div>

        @include('components.popup-alert')
    </body>
</html>
