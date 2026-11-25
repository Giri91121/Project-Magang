<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BRIDA Kota Makassar - Badan Riset dan Inovasi Daerah')</title>
    <meta name="description" content="@yield('meta_description', 'Portal Resmi Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar.')">
    
    <!-- Favicon Resmi BRIDA Kota Makassar -->
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO-FIX-BRIDA.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/LOGO-FIX-BRIDA.png') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS Framework CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/tailwind.config.js') }}"></script>

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body class="bg-bone-100 text-slate-800 font-sans antialiased selection:bg-maroon-700 selection:text-white flex flex-col min-h-screen">

    <!-- Top Announcement Bar Resmi Pemkot (Dapat Diatur dari Editor Landing Page) -->
    @if(($portalSettings['topbar_enabled'] ?? '1') == '1')
    <aside style="background-color: {{ $portalSettings['topbar_bg_color'] ?? '#3D000E' }}; color: {{ $portalSettings['topbar_text_color'] ?? '#F5F4EE' }};" class="text-xs py-2 px-4 sm:px-6 lg:px-8 border-b border-maroon-900" aria-label="Informasi Operasional">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="flex items-center gap-2.5">
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-rose-600/30 text-rose-300 text-[10px]">
                    <i class="fa-solid fa-bullhorn"></i>
                </span>
                <span class="font-medium">{{ $portalSettings['topbar_text'] ?? 'Portal Resmi Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar' }}</span>
            </div>
            <div class="flex items-center gap-5 text-[11px] opacity-90">
                <span><i class="fa-regular fa-calendar-check mr-1.5 text-rose-400"></i> {{ $portalSettings['work_hours'] ?? 'Senin - Jumat, 08.00 - 16.00 WITA' }}</span>
                <span class="hidden md:inline"><i class="fa-solid fa-location-dot mr-1 text-rose-400"></i> Balai Kota Makassar</span>
            </div>
        </div>
    </aside>
    @endif

    <!-- Header / Navbar Resmi Portal Kota Makassar -->
    <header class="sticky top-0 z-50 glass-header border-b border-bone-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 sm:h-20">
                
                <!-- Sisi Kiri: Logo BRIDA Kota Makassar (Dinamis dari Dashboard) -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center justify-center focus:outline-none -translate-y-1">
                        <img
                            id="brida-logo"
                            src="{{ asset($portalSettings['logo_header'] ?? 'images\LOGO-FIX-BRIDA-removebg-preview.png') }}"
                            alt="BRIDA Kota Makassar"
                            class="h-12 sm:h-14 md:h-16 w-auto max-w-[280px] sm:max-w-[340px] object-contain drop-shadow-sm"
                        >
                    </a>
                </div>

                <!-- Navigasi Utama Desktop (Dinamis dari Database NavbarMenu) -->
                <nav class="hidden lg:flex items-center space-x-7 xl:space-x-9 text-[15px] font-semibold text-slate-700 ml-auto" aria-label="Navigasi Utama">
                    @foreach($navbarMenus as $menu)
                        @php
                            $isCurrent = ($menu->url === '/' && request()->routeIs('home')) || ($menu->url !== '/' && $menu->url !== '#' && request()->is(ltrim($menu->url, '/')));
                        @endphp

                        @if($menu->children->count() > 0)
                            <!-- Menu dengan Submenu Dropdown -->
                            <div class="relative group">
                                <a href="{{ $menu->url }}" {{ $menu->target_blank ? 'target=_blank rel=noopener' : '' }} class="flex items-center gap-1 {{ $isCurrent ? 'text-maroon-700 font-bold border-b-2 border-maroon-700 pb-1' : 'hover:text-maroon-700 transition-colors py-2' }} focus:outline-none">
                                    <span>{{ $menu->label }}</span>
                                    <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 group-hover:rotate-180 transition-transform"></i>
                                </a>
                                <div class="dropdown-menu absolute top-full left-0 w-64 bg-white rounded-xl shadow-xl border border-bone-300 py-2 mt-1 z-50">
                                    @foreach($menu->children as $child)
                                        <a href="{{ $child->url }}" {{ $child->target_blank ? 'target=_blank rel=noopener' : '' }} class="flex items-center justify-between px-4 py-2.5 text-xs font-medium text-slate-700 hover:bg-bone-100 hover:text-maroon-700 transition-colors">
                                            <span>
                                                @if($child->icon)
                                                    <i class="{{ $child->icon }} mr-2 text-rose-500"></i>
                                                @endif
                                                {{ $child->label }}
                                            </span>
                                            @if($child->target_blank)
                                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px] text-slate-400"></i>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <!-- Menu Tunggal Biasa -->
                            <a href="{{ $menu->url }}" {{ $menu->target_blank ? 'target=_blank rel=noopener' : '' }} class="{{ $isCurrent ? 'text-maroon-700 font-bold border-b-2 border-maroon-700 pb-1' : 'hover:text-maroon-700 transition-colors' }}">
                                {{ $menu->label }}
                            </a>
                        @endif
                    @endforeach

                    <!-- Tombol Masuk Portal / Dashboard -->
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow">
                            <i class="fa-solid fa-gauge-high"></i>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            <span>Masuk Portal</span>
                        </a>
                    @endauth
                </nav>

                <!-- Tombol Hamburger Mobile -->
                <div class="flex items-center gap-2 lg:hidden">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-maroon-700 text-white text-xs px-3 py-1.5 rounded-lg font-bold">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-maroon-700 text-white text-xs px-3 py-1.5 rounded-lg font-bold">
                            Login
                        </a>
                    @endauth
                    <button id="mobile-menu-btn" class="p-2 rounded-xl text-slate-700 hover:text-maroon-700 hover:bg-bone-200 focus:outline-none" aria-label="Buka Menu Navigasi">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Navigasi (Dinamis dari Database NavbarMenu) -->
        <div id="mobile-menu" class="hidden lg:hidden bg-bone-50 border-b border-bone-300 px-4 pt-2 pb-6 space-y-2">
            @foreach($navbarMenus as $menu)
                @if($menu->children->count() > 0)
                    <div>
                        <button class="mobile-dropdown-toggle w-full flex items-center justify-between px-3 py-2 text-sm font-bold text-slate-700 rounded-lg hover:bg-bone-200">
                            <span>{{ $menu->label }}</span>
                            <i class="fa-solid fa-chevron-down text-xs transition-transform"></i>
                        </button>
                        <div class="hidden pl-6 py-1 space-y-1 bg-white/50 rounded-lg mt-1 border border-bone-200">
                            @if($menu->url !== '#')
                                <a href="{{ $menu->url }}" class="block py-1.5 text-xs font-bold text-maroon-700 hover:text-maroon-800">Halaman Utama {{ $menu->label }}</a>
                            @endif
                            @foreach($menu->children as $child)
                                <a href="{{ $child->url }}" {{ $child->target_blank ? 'target=_blank rel=noopener' : '' }} class="flex items-center justify-between py-1.5 pr-3 text-xs text-slate-600 hover:text-maroon-700">
                                    <span>{{ $child->label }}</span>
                                    @if($child->target_blank)
                                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <a href="{{ $menu->url }}" {{ $menu->target_blank ? 'target=_blank rel=noopener' : '' }} class="block px-3 py-2 text-sm font-bold text-slate-700 rounded-lg hover:bg-bone-200">
                        {{ $menu->label }}
                    </a>
                @endif
            @endforeach
        </div>
    </header>

    <!-- Konten Dinamis Halaman -->
    @yield('content')

    <!-- Footer Resmi Pemerintah Kota Makassar -->
    <footer class="bg-maroon-950 text-bone-300 py-12 text-xs border-t border-maroon-900 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center focus:outline-none py-1">
                            <img
                                id="brida-footer-logo"
                                src="{{ asset($portalSettings['logo_footer'] ?? 'images/logo-brida-white.png') }}"
                                alt="BRIDA Kota Makassar"
                                class="h-12 sm:h-14 md:h-16 w-auto max-w-[280px] sm:max-w-[340px] md:max-w-[380px] object-contain opacity-95 hover:opacity-100 transition-opacity {{ ($portalSettings['logo_footer_white'] ?? '0') === '1' ? 'brightness-0 invert' : '' }}"
                            >
                        </a>
                    </div>
                    <p class="text-bone-400 max-w-sm leading-relaxed text-xs">
                        {{ $portalSettings['tagline'] ?? 'Portal resmi layanan riset, kajian kebijakan strategis, serta fasilitasi ekosistem inovasi daerah Pemerintah Kota Makassar.' }}
                    </p>
                    <div class="text-[11px] text-bone-400 space-y-1 pt-1">
                        <p><i class="fa-solid fa-location-dot mr-1.5 text-rose-400"></i> {{ $portalSettings['office_address'] ?? 'Balai Kota Makassar, Jl. Ahmad Yani No. 2' }}</p>
                        <p><i class="fa-solid fa-envelope mr-1.5 text-rose-400"></i> {{ $portalSettings['contact_email'] ?? 'brida@makassarkota.go.id' }}</p>
                        <p><i class="fa-solid fa-phone mr-1.5 text-rose-400"></i> {{ $portalSettings['contact_phone'] ?? '112 (Bebas Pulsa)' }}</p>
                    </div>
                    <div class="flex items-center gap-3 pt-2 text-rose-300">
                        @if(!empty($portalSettings['social_instagram']))
                        <a href="{{ $portalSettings['social_instagram'] }}" target="_blank" class="hover:text-white transition" title="Instagram Resmi"><i class="fa-brands fa-instagram text-base"></i></a>
                        @endif
                    </div>
                </div>

                <div class="space-y-2">
                    <h5 class="text-white font-bold text-sm">Portal Terkait</h5>
                    <ul class="space-y-1.5 text-bone-400 text-xs">
                        <li><a href="{{ route('tentang') }}" class="hover:text-white transition">Tentang BRIDA &amp; Pengembang</a></li>
                        <li><a href="https://makassarkota.go.id" target="_blank" class="hover:text-white transition">Pemerintah Kota Makassar</a></li>
                        <li><a href="https://brin.go.id" target="_blank" class="hover:text-white transition">Badan Riset & Inovasi Nasional (BRIN)</a></li>
                        <li><a href="{{ asset('docs/Panduan_Pengguna_BRIDA_Makassar.txt') }}" download class="hover:text-white transition">Unduh Panduan Layanan</a></li>
                    </ul>
                </div>

                <div class="space-y-2">
                    <h5 class="text-white font-bold text-sm">Pemerintahan</h5>
                    <ul class="space-y-1.5 text-bone-400 text-xs">
                        <li><a href="{{ route('home') }}#tentang" class="hover:text-white transition">Profil BRIDA Makassar</a></li>
                        <li><a href="{{ route('layanan') }}" class="hover:text-white transition">Layanan Riset Terpadu</a></li>
                        <li><a href="{{ route('informasi-publik') }}" class="hover:text-white transition">Keterbukaan Informasi</a></li>
                    </ul>
                </div>

            </div>

            <div class="pt-8 border-t border-maroon-900/80 flex flex-col sm:flex-row items-center justify-between gap-4 text-bone-400 text-[11px]">
                <div>{!! $portalSettings['footer_copyright'] ?? ('&copy; ' . date('Y') . ' Badan Riset dan Inovasi Daerah Kota Makassar. Seluruh hak cipta dilindungi.') !!}</div>
                <div>Portal Resmi BRIDA Kota Makassar &bull; Pemerintah Kota Makassar</div>
            </div>
        </div>
    </footer>

    <!-- Eksternal Main Application Script -->
    <script src="{{ asset('js/app.js') }}"></script>
    @include('components.popup-alert')
    @stack('scripts')
</body>
</html>
