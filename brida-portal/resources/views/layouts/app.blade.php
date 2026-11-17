<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BRIDA Kota Makassar') }} - Dashboard</title>

        <!-- Google Fonts: Plus Jakarta Sans -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Font Awesome Icons 6 -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

        <!-- Tailwind CDN & Config (Menyelaraskan tema Maroon & Bone) -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="{{ asset('js/tailwind.config.js') }}"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="h-full font-sans antialiased text-slate-800" x-data="{ sidebarOpen: false }">
        <div class="min-h-full flex">

            <!-- Mobile Sidebar Backdrop -->
            <div 
                x-show="sidebarOpen" 
                x-cloak
                @click="sidebarOpen = false" 
                class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden transition-opacity"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
            </div>

            <!-- Modern Collapsible Sidebar -->
            <aside 
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-maroon-950 via-maroon-900 to-slate-950 text-white flex flex-col transition-transform duration-300 ease-in-out border-r border-maroon-800 shadow-2xl">
                
                <!-- Sidebar Brand / Logo -->
                <div class="h-20 flex items-center justify-between px-6 border-b border-maroon-800/80 bg-maroon-950/40">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/LOGO-FIX-BRIDA.png') }}" alt="BRIDA Makassar" class="h-10 w-auto object-contain brightness-0 invert">
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden text-rose-300 hover:text-white p-1 rounded-lg focus:outline-none">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Navigasi Menu Sidebar -->
                <div class="flex-1 overflow-y-auto py-6 px-4 space-y-6">
                    
                    <!-- Grup 1: Ringkasan Utama -->
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-extrabold uppercase tracking-widest text-rose-300/60">
                            Menu Utama
                        </div>
                        <nav class="space-y-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('dashboard') ? 'bg-rose-700/80 text-white shadow-md' : 'text-rose-100/70 hover:bg-white/10 hover:text-white' }}">
                                <i class="fa-solid fa-gauge-high w-5 text-center text-sm {{ request()->routeIs('dashboard') ? 'text-white' : 'text-rose-400' }}"></i>
                                <span>Dashboard Ikhtisar</span>
                            </a>
                            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-medium text-rose-100/70 hover:bg-white/10 hover:text-white transition">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center text-sm text-rose-400"></i>
                                    <span>Lihat Portal Publik</span>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[10px] text-rose-300/40"></i>
                            </a>
                        </nav>
                    </div>

                    <!-- Grup 2: Layanan Izin & Rekomendasi Riset -->
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-extrabold uppercase tracking-widest text-rose-300/60">
                            Layanan Penelitian
                        </div>
                        <nav class="space-y-1">
                            <a href="#" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-medium text-rose-100/70 hover:bg-white/10 hover:text-white transition">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-file-signature w-5 text-center text-sm text-rose-400"></i>
                                    <span>Pengajuan Izin Riset</span>
                                </div>
                                <span class="bg-amber-500/20 text-amber-300 border border-amber-400/30 text-[10px] font-bold px-2 py-0.5 rounded-full">5 Baru</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-rose-100/70 hover:bg-white/10 hover:text-white transition">
                                <i class="fa-solid fa-book-bookmark w-5 text-center text-sm text-rose-400"></i>
                                <span>Data Kajian & Rekomendasi</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Grup 3: Ekosistem Inovasi Daerah -->
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-extrabold uppercase tracking-widest text-rose-300/60">
                            Inovasi & Kemitraan
                        </div>
                        <nav class="space-y-1">
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-rose-100/70 hover:bg-white/10 hover:text-white transition">
                                <i class="fa-solid fa-lightbulb w-5 text-center text-sm text-rose-400"></i>
                                <span>Katalog Inovasi OPD</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-rose-100/70 hover:bg-white/10 hover:text-white transition">
                                <i class="fa-solid fa-award w-5 text-center text-sm text-rose-400"></i>
                                <span>Indeks IGA Kemendagri</span>
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium text-rose-100/70 hover:bg-white/10 hover:text-white transition">
                                <i class="fa-solid fa-certificate w-5 text-center text-sm text-rose-400"></i>
                                <span>Fasilitasi HKI & Paten</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Grup 4: Administrasi & Sistem (Khusus Admin & Profil) -->
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-extrabold uppercase tracking-widest text-rose-300/60">
                            Pengaturan
                        </div>
                        <nav class="space-y-1">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-medium transition {{ request()->routeIs('profile.edit') ? 'bg-rose-700/80 text-white' : 'text-rose-100/70 hover:bg-white/10 hover:text-white' }}">
                                <i class="fa-solid fa-user-gear w-5 text-center text-sm text-rose-400"></i>
                                <span>Profil Akun Saya</span>
                            </a>
                        </nav>
                    </div>

                </div>

                <!-- Bagian Bawah: Profil Singkat & Tombol Logout -->
                <div class="p-4 border-t border-maroon-800/80 bg-maroon-950/60">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-rose-600/30 border border-rose-400/40 text-rose-200 flex items-center justify-center font-black text-sm shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                                <span class="text-[10px] text-rose-300 font-semibold block truncate">
                                    {{ Auth::user()->getRoleNames()->first() ?? 'Pengguna' }}
                                </span>
                            </div>
                        </div>

                        <!-- Form Logout Cepat -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" title="Keluar dari Dashboard" class="p-2 text-rose-300 hover:text-white hover:bg-white/10 rounded-lg transition focus:outline-none">
                                <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </aside>

            <!-- Main Content Area (Bersebelahan dengan Sidebar di Layar Desktop) -->
            <div class="flex-1 flex flex-col lg:pl-72 min-w-0">
                
                <!-- Modern Topbar Header -->
                <header class="sticky top-0 z-30 h-16 bg-white border-b border-bone-300 flex items-center justify-between px-4 sm:px-6 lg:px-8 shadow-sm">
                    <div class="flex items-center gap-4">
                        <!-- Tombol Buka Sidebar Mobile -->
                        <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-bone-100 focus:outline-none">
                            <i class="fa-solid fa-bars-staggered text-lg"></i>
                        </button>

                        <!-- Breadcrumb & Judul Topbar -->
                        <div class="flex items-center gap-2 text-xs text-slate-500">
                            <span class="font-bold text-maroon-700">BRIDA Portal</span>
                            <i class="fa-solid fa-chevron-right text-[9px] text-slate-300"></i>
                            <span class="text-slate-800 font-medium">Dashboard Operasional</span>
                        </div>
                    </div>

                    <!-- Menu Kanan Topbar (Notifikasi, Peran, Profil Dropdown) -->
                    <div class="flex items-center gap-3">
                        @php
                            $roleName = Auth::user()->getRoleNames()->first() ?? 'Pengguna';
                            $badgeColor = match($roleName) {
                                'Admin' => 'bg-rose-50 text-maroon-700 border-rose-200',
                                'Peneliti' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'Fasilitator Inovasi' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                default => 'bg-amber-50 text-amber-700 border-amber-200',
                            };
                        @endphp
                        
                        <!-- Lencana Role Spatie -->
                        <span class="hidden sm:inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full border {{ $badgeColor }}">
                            <i class="fa-solid fa-shield-halved text-[10px]"></i>
                            <span>{{ $roleName }}</span>
                        </span>

                        <!-- Tombol Lonceng Notifikasi -->
                        <button class="relative p-2 rounded-xl text-slate-500 hover:text-slate-800 hover:bg-bone-100 transition focus:outline-none">
                            <i class="fa-regular fa-bell text-base"></i>
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-600 ring-2 ring-white"></span>
                        </button>

                        <div class="h-6 w-px bg-bone-300 mx-1"></div>

                        <!-- Dropdown Akun Profil -->
                        <div class="relative" x-data="{ userMenuOpen: false }">
                            <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-bone-100 transition focus:outline-none">
                                <div class="w-8 h-8 rounded-lg bg-maroon-700 text-white font-bold text-xs flex items-center justify-center">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden md:inline text-xs font-bold text-slate-800">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                            </button>

                            <div 
                                x-show="userMenuOpen" 
                                x-cloak
                                @click.away="userMenuOpen = false" 
                                class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-bone-300 py-2 z-50">
                                <div class="px-4 py-2 border-b border-bone-200">
                                    <p class="text-xs font-bold text-slate-900">{{ Auth::user()->name }}</p>
                                    <p class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-700 hover:bg-bone-100 transition">
                                    <i class="fa-regular fa-user text-slate-400"></i>
                                    <span>Pengaturan Akun</span>
                                </a>
                                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2.5 text-xs text-slate-700 hover:bg-bone-100 transition">
                                    <i class="fa-solid fa-globe text-slate-400"></i>
                                    <span>Kunjungi Beranda Web</span>
                                </a>
                                <div class="border-t border-bone-200 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 transition text-left">
                                        <i class="fa-solid fa-arrow-right-from-bracket text-rose-500"></i>
                                        <span>Keluar Akun (Log Out)</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </header>

                <!-- Page Content Body -->
                <main class="flex-1 p-4 sm:p-6 lg:px-8 py-8 bg-bone-100/70">
                    {{ $slot }}
                </main>

                <!-- Dashboard Footer -->
                <footer class="h-12 bg-white border-t border-bone-300 px-4 sm:px-6 lg:px-8 flex items-center justify-between text-[11px] text-slate-500">
                    <div>
                        © {{ date('Y') }} Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar
                    </div>
                    <div class="hidden sm:flex items-center gap-3">
                        <span>Sistem Informasi Riset & Inovasi (SIGAP)</span>
                        <span>•</span>
                        <span class="text-emerald-600 font-medium"><i class="fa-solid fa-circle text-[8px] mr-1"></i> Terhubung</span>
                    </div>
                </footer>

            </div>

        </div>
    </body>
</html>
