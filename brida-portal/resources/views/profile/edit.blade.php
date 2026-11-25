<x-app-layout>
    @php
        $roles = $user->getRoleNames();
        $primaryRole = $user->hasRole('Admin') ? 'Admin' : 'User';
        $subRoles = $roles->reject(fn($r) => in_array($r, ['Admin', 'User']))->values()->all();
    @endphp

    <div class="space-y-6" x-data="{ editOpen: false }">

        <!-- Kartu Utama Profil -->
        <div class="bg-white rounded-3xl border border-bone-300 shadow-sm overflow-hidden">

            <!-- Header Profil: Avatar + Nama + Badge + 1 Tombol Edit Profil -->
            <div class="p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-5 border-b border-bone-200">
                <div class="flex items-center gap-5 min-w-0">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-bone-100 border-2 border-bone-300 flex items-center justify-center text-2xl font-black text-slate-600 shrink-0">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0 space-y-2">
                        <h1 class="text-xl sm:text-2xl font-black text-slate-900 truncate">{{ $user->name }}</h1>
                        <div class="flex flex-wrap items-center gap-2 text-[11px] font-bold">
                            <span class="px-2.5 py-1 rounded-lg bg-rose-50 border border-rose-200 text-maroon-700">
                                {{ strtoupper($primaryRole) }}
                            </span>
                            @foreach($subRoles as $sr)
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-700">
                                    {{ $sr }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <button type="button" @click="editOpen = true" class="inline-flex items-center justify-center gap-2 bg-maroon-700 hover:bg-maroon-800 text-white text-xs font-bold px-5 py-2.5 rounded-xl transition shadow-sm shrink-0">
                    <i class="fa-solid fa-pen-to-square text-[11px]"></i>
                    <span>Edit Profil</span>
                </button>
            </div>

            <!-- 4 Kartu Informasi Inti -->
            <div class="p-6 sm:p-8 grid sm:grid-cols-2 gap-4">
                <div class="rounded-2xl border border-bone-200 bg-bone-50/50 p-4 space-y-1">
                    <span class="text-[11px] font-semibold text-slate-400 block">Nama Lengkap</span>
                    <p class="text-xs sm:text-sm font-bold text-slate-900">{{ $user->name }}</p>
                </div>
                <div class="rounded-2xl border border-bone-200 bg-bone-50/50 p-4 space-y-1">
                    <span class="text-[11px] font-semibold text-slate-400 block">Alamat Email</span>
                    <p class="text-xs sm:text-sm font-bold text-slate-900 truncate">{{ $user->email }}</p>
                </div>
                <div class="rounded-2xl border border-bone-200 bg-bone-50/50 p-4 space-y-1">
                    <span class="text-[11px] font-semibold text-slate-400 block">Role &amp; Hak Akses</span>
                    <p class="text-xs sm:text-sm font-bold text-slate-900">
                        {{ $primaryRole }}{{ !empty($subRoles) ? ' (' . implode(', ', $subRoles) . ')' : '' }}
                    </p>
                </div>
                <div class="rounded-2xl border border-bone-200 bg-bone-50/50 p-4 space-y-1">
                    <span class="text-[11px] font-semibold text-slate-400 block">Bergabung Sejak</span>
                    <p class="text-xs sm:text-sm font-bold text-slate-900">{{ $user->created_at ? $user->created_at->format('d F Y') : '—' }}</p>
                </div>
            </div>
        </div>

        <!-- Modal Pop-up Edit Profil -->
        <div x-show="editOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div @click.away="editOpen = false" class="bg-white rounded-3xl border border-bone-300 shadow-2xl w-full max-w-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-bone-200 flex items-center justify-between bg-bone-50">
                    <h4 class="text-sm font-black text-slate-900">Edit Profil Akun</h4>
                    <button type="button" @click="editOpen = false" class="text-slate-400 hover:text-slate-700">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
