<x-app-layout>
    <div class="space-y-6">

        <!-- Top Header & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <span class="text-slate-800 font-bold">Manajemen Pengguna</span>
                </nav>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    Manajemen Role & Sub-Role Pengguna
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Atur Role Utama (<strong>Admin</strong> / <strong>User</strong>) serta berikan Sub-Role khusus (<strong>verif_berita</strong> / <strong>verif_riset</strong>) kepada pengguna.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 bg-rose-50 border border-rose-200 text-maroon-700 text-xs font-bold px-3 py-1.5 rounded-xl">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Otoritas Administrator</span>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Panduan Singkat Sistem Role & Sub-Role -->
        <div class="grid sm:grid-cols-3 gap-4 text-xs">
            <div class="bg-white p-4 rounded-2xl border border-bone-300 shadow-sm space-y-1">
                <span class="font-extrabold text-maroon-700 flex items-center gap-1.5">
                    <i class="fa-solid fa-crown"></i> Role Utama: Admin
                </span>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Memiliki akses penuh ke seluruh modul, pengaturan instansi, dan manajemen pengguna tanpa perlu sub-role.
                </p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-bone-300 shadow-sm space-y-1">
                <span class="font-extrabold text-slate-800 flex items-center gap-1.5">
                    <i class="fa-solid fa-user"></i> Role Utama: User
                </span>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Hanya dapat mengakses layanan pribadinya (mengajukan permohonan riset, melihat komentar berita yang dibuatnya, dan profil).
                </p>
            </div>
            <div class="bg-white p-4 rounded-2xl border border-bone-300 shadow-sm space-y-1">
                <span class="font-extrabold text-emerald-700 flex items-center gap-1.5">
                    <i class="fa-solid fa-user-check"></i> Sub-Role (Khusus User)
                </span>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    <strong>verif_berita</strong> membuka akses Dashboard Berita. <strong>verif_riset</strong> membuka akses Verifikasi Riset.
                </p>
            </div>
        </div>

        <!-- Card Datatable Pengguna -->
        <div class="bg-white rounded-2xl border border-bone-300 shadow-sm overflow-hidden">
            <!-- Filter Bar -->
            <div class="p-5 border-b border-bone-300 bg-white">
                <form method="GET" action="{{ route('dashboard.users.index') }}" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                    <div class="relative w-full sm:w-80">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email pengguna..." class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700">
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <select name="role" onchange="this.form.submit()" class="text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-1.5 px-3">
                            <option value="">-- Filter Role / Sub-Role --</option>
                            <option value="Admin" {{ request('role') === 'Admin' ? 'selected' : '' }}>Role Utama: Admin</option>
                            <option value="User" {{ request('role') === 'User' ? 'selected' : '' }}>Role Utama: User</option>
                            <option value="verif_berita" {{ request('role') === 'verif_berita' ? 'selected' : '' }}>Sub-Role: verif_berita</option>
                            <option value="verif_riset" {{ request('role') === 'verif_riset' ? 'selected' : '' }}>Sub-Role: verif_riset</option>
                        </select>
                        @if(request('search') || request('role'))
                            <a href="{{ route('dashboard.users.index') }}" class="text-xs text-rose-600 hover:underline px-2 py-1">Reset</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Tabel Data Pengguna -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-bone-100/70 border-b border-bone-200 text-[11px] font-extrabold text-slate-500 uppercase tracking-wider">
                            <th class="py-3.5 px-6">Pengguna & Email</th>
                            <th class="py-3.5 px-6">Status Role & Sub-Role Aktif</th>
                            <th class="py-3.5 px-6">Pengaturan Role Utama & Sub-Role</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bone-200 text-xs text-slate-700">
                        @foreach($users as $u)
                        @php
                            $isAdmin = $u->hasRole('Admin');
                            $mainRole = $isAdmin ? 'Admin' : 'User';
                            $hasVerifBerita = $u->hasRole('verif_berita');
                            $hasVerifRiset = $u->hasRole('verif_riset');
                        @endphp
                        <tr class="hover:bg-bone-50/80 transition" x-data="{ selectedMain: '{{ $mainRole }}' }">
                            <td class="py-4 px-6 align-top">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl {{ $isAdmin ? 'bg-maroon-700 text-white' : 'bg-bone-200 text-slate-700' }} font-black text-xs flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($u->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <strong class="text-slate-900 block">{{ $u->name }}</strong>
                                        <span class="text-[11px] text-slate-500">{{ $u->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6 align-top">
                                <div class="flex flex-wrap items-center gap-1.5">
                                    @if($isAdmin)
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-maroon-800 border border-rose-300">
                                            <i class="fa-solid fa-crown mr-1 text-[10px]"></i> Admin (Akses Penuh)
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-800 border border-slate-300">
                                            <i class="fa-solid fa-user mr-1 text-[10px]"></i> User
                                        </span>
                                        @if($hasVerifRiset)
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                + verif_riset
                                            </span>
                                        @endif
                                        @if($hasVerifBerita)
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-indigo-100 text-indigo-800 border border-indigo-300">
                                                + verif_berita
                                            </span>
                                        @endif
                                    @endif
                                </div>
                            </td>

                            <td class="py-4 px-6 align-top">
                                <form method="POST" action="{{ route('dashboard.users.update-role', $u->id) }}" class="flex flex-col sm:flex-row sm:items-center gap-3">
                                    @csrf
                                    @method('PATCH')

                                    <!-- Pilih Role Utama -->
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Role Utama</label>
                                        <select name="main_role" x-model="selectedMain" class="text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-1.5 px-3 bg-white font-bold text-slate-800">
                                            <option value="User">User</option>
                                            <option value="Admin">Admin</option>
                                        </select>
                                    </div>

                                    <!-- Pilih Sub-Role (Hanya muncul/aktif jika Role Utama == User) -->
                                    <div x-show="selectedMain === 'User'" class="flex-1">
                                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Sub-Role Tambahan (Khusus User)</label>
                                        <div class="flex flex-wrap items-center gap-3 bg-bone-50 px-3 py-1.5 rounded-xl border border-bone-300">
                                            <label class="inline-flex items-center gap-1.5 cursor-pointer select-none">
                                                <input type="checkbox" name="sub_roles[]" value="verif_riset" {{ $hasVerifRiset ? 'checked' : '' }} class="rounded text-maroon-700 focus:ring-maroon-700 border-slate-300">
                                                <span class="text-xs font-semibold text-slate-700">verif_riset</span>
                                            </label>
                                            <label class="inline-flex items-center gap-1.5 cursor-pointer select-none">
                                                <input type="checkbox" name="sub_roles[]" value="verif_berita" {{ $hasVerifBerita ? 'checked' : '' }} class="rounded text-maroon-700 focus:ring-maroon-700 border-slate-300">
                                                <span class="text-xs font-semibold text-slate-700">verif_berita</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div x-show="selectedMain === 'Admin'" class="flex-1 text-[11px] text-slate-400 italic pt-3">
                                        Role Admin otomatis mengakses semua fitur tanpa sub-role.
                                    </div>

                                    <div class="pt-3 sm:pt-4">
                                        <button type="submit" class="bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-xs px-4 py-2 rounded-xl transition shadow-sm whitespace-nowrap">
                                            Simpan Akses
                                        </button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-4 border-t border-bone-200 bg-bone-50/50">
                {{ $users->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
