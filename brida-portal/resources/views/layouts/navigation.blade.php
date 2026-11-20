<nav x-data="{ open: false }" class="bg-white border-b border-bone-300 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-6">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/logo-brida.png') }}" alt="BRIDA Makassar" class="h-9 w-auto object-contain">
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 text-sm font-semibold text-slate-600 hover:text-maroon-700 transition">
                        <i class="fa-solid fa-globe mr-1.5 text-xs text-rose-500"></i>
                        <span>Lihat Portal Publik</span>
                    </a>

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-maroon-700 font-bold border-b-2 border-maroon-700">
                        <i class="fa-solid fa-gauge-high mr-1.5 text-xs"></i>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown & User Role Badge -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                <!-- Role Badge -->
                @php
                    $roleName = Auth::user()->getRoleNames()->first() ?? 'Pengguna';
                    $badgeColor = match($roleName) {
                        'Admin' => 'bg-maroon-100 text-maroon-800 border-maroon-300',
                        'Peneliti' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                        'Fasilitator Inovasi' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                        default => 'bg-amber-100 text-amber-800 border-amber-300',
                    };
                @endphp
                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full border {{ $badgeColor }}">
                    <i class="fa-solid fa-shield-halved text-[10px]"></i>
                    {{ $roleName }}
                </span>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-bone-300 text-sm leading-4 font-semibold rounded-xl text-slate-700 bg-white hover:bg-bone-100 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1.5">
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            <i class="fa-regular fa-user mr-2 text-slate-400"></i> {{ __('Profil Akun') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-rose-600 font-semibold hover:bg-rose-50">
                                <i class="fa-solid fa-arrow-right-from-bracket mr-2 text-rose-500"></i> {{ __('Keluar (Log Out)') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-slate-500 hover:bg-bone-200 focus:outline-none transition">
                    <i class="fa-solid fa-bars text-xl" :class="{'hidden': open, 'inline-flex': ! open }"></i>
                    <i class="fa-solid fa-xmark text-xl" :class="{'hidden': ! open, 'inline-flex': open }"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-bone-50 border-t border-bone-300">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('home') }}" class="block py-2 text-sm font-semibold text-slate-700 hover:text-maroon-700">
                <i class="fa-solid fa-globe mr-2 text-rose-500"></i> Lihat Portal Publik
            </a>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <i class="fa-solid fa-gauge-high mr-2"></i> {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-bone-300 px-4 space-y-2">
            <div class="flex items-center justify-between">
                <div>
                    <div class="font-bold text-base text-slate-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-500">{{ Auth::user()->email }}</div>
                </div>
                <span class="text-xs font-bold px-2.5 py-1 rounded-md border {{ $badgeColor }}">
                    {{ $roleName }}
                </span>
            </div>

            <div class="pt-2 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    <i class="fa-regular fa-user mr-2 text-slate-400"></i> {{ __('Profil Akun') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600 font-bold">
                        <i class="fa-solid fa-arrow-right-from-bracket mr-2 text-rose-500"></i> {{ __('Keluar') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
