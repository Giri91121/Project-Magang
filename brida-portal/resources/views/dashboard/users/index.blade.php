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
                    Hak Akses & Pengguna Portal (RBAC Spatie)
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Kelola peran akun staf, peneliti, fasilitator, dan pemohon izin riset di lingkungan portal BRIDA Makassar.
                </p>
            </div>

            <div class="inline-flex items-center gap-2 bg-rose-50 border border-rose-200 text-maroon-700 text-xs font-bold px-3 py-1.5 rounded-xl">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Akses Khusus Administrator</span>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Card Datatable Pengguna -->
        <div class="bg-white rounded-2xl border border-bone-300 shadow-sm overflow-hidden">
            <!-- Filter Bar -->
            <div class="p-5 border-b border-bone-300 bg-white">
                <form method="GET" action="{{ route('dashboard.users.index') }}" class="flex flex-col sm:flex-row gap-3 items-center justify-between">
                    <div class="relative w-full sm:w-80">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-xs text-slate-400"></i>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="w-full pl-9 pr-3 py-1.5 text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700">
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto">
                        <select name="role" onchange="this.form.submit()" class="text-xs rounded-xl border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-1.5 px-3">
                            <option value="">-- Semua Role --</option>
                            @foreach($roles as $r)
                                <option value="{{ $r->name }}" {{ request('role') === $r->name ? 'selected' : '' }}>{{ $r->name }}</option>
                            @endforeach
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
                            <th class="py-3.5 px-6">Pengguna</th>
                            <th class="py-3.5 px-6">Email Akun</th>
                            <th class="py-3.5 px-6">Peran Saat Ini (Role)</th>
                            <th class="py-3.5 px-6">Terdaftar Sejak</th>
                            <th class="py-3.5 px-6 text-right">Ubah Hak Akses</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bone-200 text-xs text-slate-700">
                        @foreach($users as $u)
                        @php
                            $userRole = $u->getRoleNames()->first() ?? 'Pemohon';
                            $badgeClass = match($userRole) {
                                'Admin' => 'bg-rose-100 text-maroon-800 border-rose-300',
                                'Peneliti' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                'Fasilitator Inovasi' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                default => 'bg-amber-100 text-amber-800 border-amber-300',
                            };
                        @endphp
                        <tr class="hover:bg-bone-50/80 transition">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-maroon-700 text-white font-bold text-xs flex items-center justify-center">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                    <strong class="text-slate-900 block">{{ $u->name }}</strong>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                {{ $u->email }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $badgeClass }}">
                                    {{ $userRole }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-500 whitespace-nowrap">
                                {{ $u->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <form method="POST" action="{{ route('dashboard.users.update-role', $u->id) }}" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="text-xs rounded-lg border border-bone-300 focus:border-maroon-700 focus:ring-maroon-700 py-1 px-2.5 bg-white">
                                        @foreach($roles as $r)
                                            <option value="{{ $r->name }}" {{ $userRole === $r->name ? 'selected' : '' }}>
                                                {{ $r->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-maroon-700 hover:bg-maroon-800 text-white font-bold text-[11px] px-3 py-1.5 rounded-lg transition shadow-sm">
                                        Simpan
                                    </button>
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
