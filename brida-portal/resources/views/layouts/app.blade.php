<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BRIDA Kota Makassar') }} - Dashboard</title>

        <!-- Favicon Resmi BRIDA Kota Makassar -->
        <link rel="icon" type="image/png" href="{{ asset('images/LOGO-FIX-BRIDA.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/LOGO-FIX-BRIDA.png') }}">

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

            <!-- Modern Collapsible Sidebar (Tema Putih Tulang / Bone White) -->
            <aside 
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
                class="fixed inset-y-0 left-0 z-50 w-72 bg-bone-100 text-slate-800 flex flex-col transition-transform duration-300 ease-in-out border-r border-bone-300 shadow-xl">
                
                <!-- Sidebar Brand / Logo (Sejajar h-16 dengan Topbar Header dan Logo Berwarna) -->
                <div class="h-16 flex items-center justify-between px-5 border-b border-bone-300 bg-white">
                    <a href="{{ route('home') }}" class="flex items-center -translate-y-0.5">
                        <img src="{{ asset('images/LOGO-FIX-BRIDA.png') }}" alt="BRIDA Kota Makassar" class="h-10 sm:h-11 w-auto max-w-[200px] object-contain drop-shadow-sm">
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-500 hover:text-slate-800 p-1 rounded-lg focus:outline-none">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Navigasi Menu Sidebar (Menyesuaikan Role Admin, User, & Sub-Role) -->
                <div class="flex-1 overflow-y-auto py-6 px-4 space-y-6">
                    @php
                        $currentUser = Auth::user();
                        $isAdmin = $currentUser->hasRole('Admin');
                        $canVerifRiset = $currentUser->hasRole(['Admin', 'verif_riset']);
                        $canVerifBerita = $currentUser->hasRole(['Admin', 'verif_berita']);
                        $allRolesLabel = implode(', ', $currentUser->getRoleNames()->toArray());
                    @endphp
                    
                    <!-- Grup 1: Ringkasan Utama -->
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-extrabold uppercase tracking-widest text-slate-400">
                            Menu Utama
                        </div>
                        <nav class="space-y-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('dashboard') ? 'bg-maroon-700 text-white shadow-md' : 'text-slate-600 hover:bg-bone-200 hover:text-maroon-800' }}">
                                <i class="fa-solid fa-gauge-high w-5 text-center text-sm {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-maroon-700' }}"></i>
                                <span>Dashboard Ikhtisar</span>
                            </a>
                            <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 hover:bg-bone-200 hover:text-maroon-800 transition">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-arrow-up-right-from-square w-5 text-center text-sm text-slate-400"></i>
                                    <span>Lihat Portal Publik</span>
                                </div>
                                <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                            </a>
                        </nav>
                    </div>

                    <!-- Grup 2: Aktivitas & Layanan Mandiri User -->
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-extrabold uppercase tracking-widest text-slate-400">
                            {{ $canVerifRiset ? 'Layanan & Verifikasi Riset' : 'Layanan Mandiri Saya' }}
                        </div>
                        <nav class="space-y-1">
                            <a href="{{ route('dashboard.riset.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('dashboard.riset.index') || request()->routeIs('dashboard.riset.show') ? 'bg-maroon-700 text-white shadow-md' : 'text-slate-600 hover:bg-bone-200 hover:text-maroon-800' }}">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-file-signature w-5 text-center text-sm {{ request()->routeIs('dashboard.riset.index') || request()->routeIs('dashboard.riset.show') ? 'text-white' : 'text-slate-400' }}"></i>
                                    <span>{{ $canVerifRiset ? 'Dashboard Izin Riset' : 'Permohonan Riset Saya' }}</span>
                                </div>
                                @if($canVerifRiset)
                                    <span class="{{ request()->routeIs('dashboard.riset.*') ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-800 border border-emerald-200' }} text-[9px] font-bold px-2 py-0.5 rounded-full">Verif</span>
                                @endif
                            </a>
                            <a href="{{ route('dashboard.riset.create') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('dashboard.riset.create') ? 'bg-maroon-700 text-white shadow-md' : 'text-slate-600 hover:bg-bone-200 hover:text-maroon-800' }}">
                                <i class="fa-solid fa-plus-circle w-5 text-center text-sm {{ request()->routeIs('dashboard.riset.create') ? 'text-white' : 'text-slate-400' }}"></i>
                                <span>Ajukan Riset Baru</span>
                            </a>
                            <a href="{{ route('dashboard.komentar.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('dashboard.komentar.*') ? 'bg-maroon-700 text-white shadow-md' : 'text-slate-600 hover:bg-bone-200 hover:text-maroon-800' }}">
                                <i class="fa-regular fa-comments w-5 text-center text-sm {{ request()->routeIs('dashboard.komentar.*') ? 'text-white' : 'text-slate-400' }}"></i>
                                <span>{{ $canVerifBerita ? 'Moderasi Komentar' : 'Komentar Berita Saya' }}</span>
                            </a>
                        </nav>
                    </div>

                    <!-- Grup 3: Otoritas Publikasi & Inovasi (Muncul jika Admin atau Sub-Role Diizinkan) -->
                    @if($isAdmin || $canVerifBerita)
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-extrabold uppercase tracking-widest text-slate-400">
                            Publikasi & Konten
                        </div>
                        <nav class="space-y-1">
                            @if($canVerifBerita)
                            <a href="{{ route('dashboard.berita.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('dashboard.berita.*') ? 'bg-maroon-700 text-white shadow-md' : 'text-slate-600 hover:bg-bone-200 hover:text-maroon-800' }}">
                                <div class="flex items-center gap-3">
                                    <i class="fa-solid fa-newspaper w-5 text-center text-sm {{ request()->routeIs('dashboard.berita.*') ? 'text-white' : 'text-slate-400' }}"></i>
                                    <span>Dashboard Berita</span>
                                </div>
                                <span class="{{ request()->routeIs('dashboard.berita.*') ? 'bg-white/20 text-white' : 'bg-indigo-100 text-indigo-800 border border-indigo-200' }} text-[9px] font-bold px-2 py-0.5 rounded-full">Verif</span>
                            </a>
                            @endif

                            @if($isAdmin)
                            <a href="{{ route('dashboard.inovasi.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('dashboard.inovasi.*') ? 'bg-maroon-700 text-white shadow-md' : 'text-slate-600 hover:bg-bone-200 hover:text-maroon-800' }}">
                                <i class="fa-solid fa-lightbulb w-5 text-center text-sm {{ request()->routeIs('dashboard.inovasi.*') ? 'text-white' : 'text-slate-400' }}"></i>
                                <span>Katalog Inovasi OPD</span>
                            </a>
                            <a href="{{ route('dashboard.regulasi.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('dashboard.regulasi.*') ? 'bg-maroon-700 text-white shadow-md' : 'text-slate-600 hover:bg-bone-200 hover:text-maroon-800' }}">
                                <i class="fa-solid fa-scale-balanced w-5 text-center text-sm {{ request()->routeIs('dashboard.regulasi.*') ? 'text-white' : 'text-slate-400' }}"></i>
                                <span>Repositori Regulasi</span>
                            </a>
                            @endif
                        </nav>
                    </div>
                    @endif

                    <!-- Grup 4: Administrasi & Sistem (Khusus Admin & Profil) -->
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-extrabold uppercase tracking-widest text-slate-400">
                            Pengaturan & Akun
                        </div>
                        <nav class="space-y-1">
                            @if($isAdmin)
                            <a href="{{ route('dashboard.users.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('dashboard.users.*') ? 'bg-maroon-700 text-white shadow-md' : 'text-slate-600 hover:bg-bone-200 hover:text-maroon-800' }}">
                                <i class="fa-solid fa-users-gear w-5 text-center text-sm {{ request()->routeIs('dashboard.users.*') ? 'text-white' : 'text-slate-400' }}"></i>
                                <span>Manajemen Pengguna</span>
                            </a>
                            <a href="{{ route('dashboard.settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('dashboard.settings.*') ? 'bg-maroon-700 text-white shadow-md' : 'text-slate-600 hover:bg-bone-200 hover:text-maroon-800' }}">
                                <i class="fa-solid fa-sliders w-5 text-center text-sm {{ request()->routeIs('dashboard.settings.*') ? 'text-white' : 'text-slate-400' }}"></i>
                                <span>Pengaturan Instansi</span>
                            </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold transition {{ request()->routeIs('profile.edit') ? 'bg-maroon-700 text-white shadow-md' : 'text-slate-600 hover:bg-bone-200 hover:text-maroon-800' }}">
                                <i class="fa-solid fa-user-gear w-5 text-center text-sm {{ request()->routeIs('profile.edit') ? 'text-white' : 'text-slate-400' }}"></i>
                                <span>Profil Akun Saya</span>
                            </a>
                        </nav>
                    </div>

                </div>

                <!-- Bagian Bawah: Profil Singkat & Tombol Logout -->
                <div class="p-4 border-t border-bone-300 bg-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-maroon-700 text-white flex items-center justify-center font-black text-sm shrink-0 shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                <span class="text-[10px] text-maroon-700 font-semibold block truncate" title="{{ $allRolesLabel }}">
                                    {{ $allRolesLabel ?: 'User' }}
                                </span>
                            </div>
                        </div>

                        <!-- Form Logout Cepat -->
                        <form method="POST" action="{{ route('logout') }}" data-confirm="Apakah Anda yakin ingin keluar dari sesi dashboard ini?" data-confirm-title="Keluar Akun" data-confirm-btn="Ya, Keluar">
                            @csrf
                            <button type="submit" title="Keluar dari Dashboard" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition focus:outline-none">
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

                    <!-- Menu Kanan Topbar (Notifikasi, Peran & Sub-Role, Profil Dropdown) -->
                    <div class="flex items-center gap-2">
                        @php
                            $mainRoleBadge = $isAdmin ? 'Admin' : 'User';
                            $subRolesTop = $currentUser->getRoleNames()->reject(fn($r) => in_array($r, ['Admin', 'User']));
                        @endphp
                        
                        <!-- Lencana Role Utama -->
                        <span class="hidden sm:inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full border {{ $isAdmin ? 'bg-rose-50 text-maroon-700 border-rose-200' : 'bg-bone-100 text-slate-700 border-bone-300' }}">
                            <i class="fa-solid {{ $isAdmin ? 'fa-crown' : 'fa-user' }} text-[10px]"></i>
                            <span>{{ $mainRoleBadge }}</span>
                        </span>

                        <!-- Lencana Sub-Role jika ada -->
                        @foreach($subRolesTop as $sr)
                        <span class="hidden md:inline-flex items-center gap-1 text-[11px] font-bold px-2.5 py-1 rounded-full border bg-emerald-50 text-emerald-700 border-emerald-200">
                            <i class="fa-solid fa-check-circle text-[9px]"></i>
                            <span>{{ $sr }}</span>
                        </span>
                        @endforeach

                        <!-- Tombol Lonceng Notifikasi Terintegrasi Database -->
                        <div class="relative" x-data="{ notifDropdownOpen: false }">
                            <button @click="notifDropdownOpen = !notifDropdownOpen" class="relative p-2 rounded-xl text-slate-500 hover:text-maroon-700 hover:bg-bone-100 transition focus:outline-none">
                                <i class="fa-regular fa-bell text-base"></i>
                                @php $unreadCount = Auth::user()->unreadNotifications->count(); @endphp
                                @if($unreadCount > 0)
                                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-600 ring-2 ring-white"></span>
                                @endif
                            </button>

                            <!-- Dropdown Notifikasi Cepat -->
                            <div 
                                x-show="notifDropdownOpen" 
                                x-cloak
                                @click.away="notifDropdownOpen = false" 
                                class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-xl border border-bone-300 py-3 z-50">
                                
                                <div class="px-4 pb-2 border-b border-bone-200 flex items-center justify-between">
                                    <h4 class="text-xs font-bold text-slate-900">Pemberitahuan Sistem</h4>
                                    <a href="{{ route('dashboard.notifications.index') }}" class="text-[11px] font-semibold text-maroon-700 hover:underline">Lihat Semua</a>
                                </div>

                                <div class="divide-y divide-bone-100 max-h-72 overflow-y-auto">
                                    @forelse(Auth::user()->unreadNotifications->take(4) as $notif)
                                    <div class="p-3.5 hover:bg-bone-50 transition flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-rose-50 text-maroon-700 flex items-center justify-center text-xs shrink-0 mt-0.5">
                                            <i class="fa-solid fa-bell"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-bold text-slate-900 truncate">{{ $notif->data['nomor_registrasi'] ?? 'Notifikasi' }}</p>
                                            <p class="text-[11px] text-slate-500 truncate">{{ $notif->data['keterangan'] ?? '' }}</p>
                                            <span class="text-[10px] text-slate-400 mt-1 block">{{ $notif->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="py-6 text-center text-slate-400 text-xs">
                                        Tidak ada notifikasi baru
                                    </div>
                                    @endforelse
                                </div>

                                <div class="pt-2 px-4 border-t border-bone-200">
                                    <a href="{{ route('dashboard.notifications.index') }}" class="block text-center text-xs font-bold text-maroon-700 hover:underline py-1">
                                        Buka Pusat Notifikasi & Log Aktivitas →
                                    </a>
                                </div>
                            </div>
                        </div>

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
                                <form method="POST" action="{{ route('logout') }}" data-confirm="Apakah Anda yakin ingin keluar dari sesi dashboard ini?" data-confirm-title="Keluar Akun" data-confirm-btn="Ya, Keluar">
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

        <!-- Global Pop-Up Alert System (SweetAlert2) -->
        @include('components.popup-alert')
    </body>
</html>
