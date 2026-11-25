<x-app-layout>
    <div class="space-y-6">

        <!-- Top Header & Breadcrumb -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-bone-300">
            <div>
                <nav class="flex items-center text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}" class="hover:text-maroon-700 transition">Dashboard</a>
                    <i class="fa-solid fa-chevron-right text-[9px] mx-2 text-slate-300"></i>
                    <span class="text-slate-800 font-bold">Pusat Notifikasi & Log</span>
                </nav>
                <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                    Pemberitahuan & Riwayat Aktivitas
                </h1>
                <p class="text-xs text-slate-500 mt-0.5">
                    Informasi status pengajuan izin riset, pembaruan inovasi, dan jejak aktivitas akun Anda.
                </p>
            </div>

            @if(Auth::user()->unreadNotifications->count() > 0)
            <form method="POST" action="{{ route('dashboard.notifications.mark-all-read') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 bg-white border border-bone-300 hover:bg-bone-100 text-slate-700 text-xs font-bold px-3.5 py-2 rounded-xl transition shadow-sm">
                    <i class="fa-solid fa-check-double text-emerald-600"></i>
                    <span>Tandai Semua Dibaca</span>
                </button>
            </form>
            @endif
        </div>

        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid lg:grid-cols-12 gap-6 items-start">

            <!-- Kolom Kiri: Daftar Notifikasi Masuk -->
            <div class="lg:col-span-7 bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-bone-200 pb-3">
                    <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-regular fa-bell text-maroon-700"></i>
                        <span>Notifikasi Terkini</span>
                    </h3>
                    <span class="text-[11px] font-bold text-slate-400">
                        {{ Auth::user()->unreadNotifications->count() }} Belum Dibaca
                    </span>
                </div>

                <div class="divide-y divide-bone-200">
                    @forelse($notifications as $notif)
                    @php $data = $notif->data; @endphp
                    <div class="py-4 flex items-start gap-4 {{ $notif->read_at ? 'opacity-70' : 'bg-rose-50/40 -mx-4 px-4 rounded-2xl' }} transition">
                        <div class="w-9 h-9 rounded-xl bg-white border border-bone-300 flex items-center justify-center text-sm shrink-0 shadow-sm">
                            <i class="fa-solid {{ $data['icon'] ?? 'fa-bell text-maroon-700' }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2">
                                <h4 class="text-xs font-bold text-slate-900 truncate">
                                    {{ $data['nomor_registrasi'] ?? 'Pemberitahuan Sistem' }}
                                </h4>
                                <span class="text-[10px] text-slate-400 whitespace-nowrap">
                                    {{ $notif->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 mt-0.5 leading-relaxed">
                                {{ $data['keterangan'] ?? 'Ada pembaruan status pada berkas Anda.' }}
                            </p>
                            @if(isset($data['url']))
                            <div class="mt-2 flex items-center gap-3">
                                <form method="POST" action="{{ route('dashboard.notifications.read', $notif->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-[11px] font-bold text-maroon-700 hover:underline inline-flex items-center gap-1">
                                        <span>Buka Dokumen</span>
                                        <i class="fa-solid fa-arrow-right text-[9px]"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="py-10 text-center text-slate-400 text-xs">
                        <i class="fa-regular fa-bell-slash text-2xl text-slate-300 block mb-2"></i>
                        Belum ada notifikasi baru untuk akun Anda.
                    </div>
                    @endforelse
                </div>

                <div class="pt-4 border-t border-bone-200">
                    {{ $notifications->links() }}
                </div>
            </div>

            <!-- Kolom Kanan: Log Aktivitas Sistem (Audit Trail) -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-6 sm:p-8 border border-bone-300 shadow-sm space-y-4">
                <div class="border-b border-bone-200 pb-3 flex items-center justify-between">
                    <h3 class="font-black text-sm text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-clock-rotate-left text-maroon-700"></i>
                        <span>Audit Trail & Log Aktivitas</span>
                    </h3>
                    <span class="text-[10px] bg-bone-100 text-slate-600 font-bold px-2 py-0.5 rounded-full">Real-time</span>
                </div>

                <div class="space-y-4">
                    @forelse($activityLogs as $log)
                    @php
                        $act = strtolower($log->action ?? '');
                        $isSecurity = str_contains($act, 'honeypot') || str_contains($act, 'trap') || str_contains($act, 'security') || str_contains($act, 'bot');
                        $isSpam = !$isSecurity && (str_contains($act, 'spam') || str_contains($act, 'link'));
                        $isDelete = !$isSecurity && !$isSpam && (str_contains($act, 'delete') || str_contains($act, 'hapus') || str_contains($act, 'destroy'));
                        $isAuth = !$isSecurity && !$isSpam && !$isDelete && (str_contains($act, 'login') || str_contains($act, 'register'));

                        if ($isSecurity) {
                            $wrapClass = 'p-3 rounded-2xl bg-rose-50/90 border border-rose-200 border-l-4 border-l-rose-600';
                            $iconBox = 'bg-rose-100 text-rose-700';
                            $icon = 'fa-shield-virus';
                            $tag = 'KEAMANAN';
                            $tagClass = 'bg-rose-600 text-white';
                            $textClass = 'text-rose-950 font-bold';
                        } elseif ($isSpam) {
                            $wrapClass = 'p-3 rounded-2xl bg-amber-50/90 border border-amber-200 border-l-4 border-l-amber-500';
                            $iconBox = 'bg-amber-100 text-amber-700';
                            $icon = 'fa-triangle-exclamation';
                            $tag = 'SPAM';
                            $tagClass = 'bg-amber-500 text-white';
                            $textClass = 'text-amber-950 font-bold';
                        } elseif ($isDelete) {
                            $wrapClass = '';
                            $iconBox = 'bg-rose-50 text-rose-600';
                            $icon = 'fa-trash-can';
                            $tag = null;
                            $textClass = 'text-slate-800 font-medium';
                        } elseif ($isAuth) {
                            $wrapClass = '';
                            $iconBox = 'bg-emerald-50 text-emerald-600';
                            $icon = 'fa-right-to-bracket';
                            $tag = null;
                            $textClass = 'text-slate-800 font-medium';
                        } else {
                            $wrapClass = '';
                            $iconBox = 'bg-bone-100 text-slate-500';
                            $icon = 'fa-clock-rotate-left';
                            $tag = null;
                            $textClass = 'text-slate-800 font-medium';
                        }
                    @endphp
                    <div class="flex items-start gap-3 text-xs {{ $wrapClass }}">
                        <div class="w-7 h-7 rounded-lg {{ $iconBox }} flex items-center justify-center text-xs shrink-0 mt-0.5">
                            <i class="fa-solid {{ $icon }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            @if($tag)
                                <span class="inline-block px-2 py-0.5 rounded-md text-[9px] font-extrabold tracking-wider uppercase mb-1 {{ $tagClass }}">
                                    {{ $tag }}
                                </span>
                            @endif
                            <p class="{{ $textClass }} leading-snug">
                                {{ $log->description }}
                            </p>
                            <div class="flex flex-wrap items-center gap-2 text-[10px] text-slate-400 mt-1">
                                <span><i class="fa-regular fa-user mr-1"></i>{{ $log->user->name ?? 'Sistem' }}</span>
                                <span>•</span>
                                <span>{{ $log->created_at->diffForHumans() }}</span>
                                @if(($isSecurity || $isSpam) && !empty($log->ip_address))
                                    <span>•</span>
                                    <span class="font-mono text-slate-500">IP: {{ $log->ip_address }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 text-center text-slate-400 text-xs">
                        Belum ada riwayat log tercatat di sistem.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</x-app-layout>
