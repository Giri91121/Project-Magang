@php
    $badgeStyles = [
        'maroon' => 'border-t-4 border-t-maroon-700',
        'slate' => 'border-t-4 border-t-slate-700',
        'emerald' => 'border-t-4 border-t-emerald-600',
        'amber' => 'border-t-4 border-t-amber-500',
        'indigo' => 'border-t-4 border-t-indigo-600',
    ];
    $ringClass = $badgeStyles[$node->warna_badge] ?? $badgeStyles['maroon'];
    $isKoordinasi = $node->tipe_garis === 'koordinasi';
    $children = $node->childrenRecursive ?? collect();
@endphp

<li class="{{ $isKoordinasi ? 'org-node-koordinasi' : '' }}">
    <div class="org-card inline-block text-left bg-white rounded-2xl border {{ $node->is_active ? 'border-bone-300' : 'border-dashed border-rose-300 opacity-70' }} {{ $ringClass }} shadow-sm hover:shadow-md transition w-56 p-3 relative">
        @if(!$node->is_active)
            <span class="absolute top-2 right-2 text-[9px] font-bold uppercase px-1.5 py-0.5 rounded bg-rose-100 text-rose-700">Nonaktif</span>
        @endif

        <div class="flex items-start gap-2.5">
            @if($node->foto)
                <img src="{{ asset('storage/' . $node->foto) }}" alt="{{ $node->nama_pejabat ?: $node->jabatan }}" class="w-10 h-10 rounded-xl object-cover border border-bone-300 shrink-0">
            @else
                <div class="w-10 h-10 rounded-xl bg-bone-100 border border-bone-300 text-maroon-700 flex items-center justify-center font-extrabold text-xs shrink-0">
                    {{ strtoupper(mb_substr($node->nama_pejabat ?: $node->jabatan, 0, 2)) }}
                </div>
            @endif

            <div class="min-w-0 flex-1">
                <div class="text-[11px] font-extrabold text-slate-900 leading-snug line-clamp-2" title="{{ $node->jabatan }}">
                    {{ $node->jabatan }}
                </div>
                @if($node->nama_pejabat)
                    <div class="text-[11px] font-semibold text-maroon-700 truncate mt-0.5" title="{{ $node->nama_pejabat }}">
                        {{ $node->nama_pejabat }}
                    </div>
                @endif
                @if($node->nip)
                    <div class="text-[10px] text-slate-400 truncate">NIP. {{ $node->nip }}</div>
                @endif
            </div>
        </div>

        <div class="mt-2.5 pt-2 border-t border-bone-200 flex items-center justify-between gap-1">
            <button type="button" onclick="openStrukturAdd({{ $node->id }})" title="Tambah Bawahan" class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-2 py-1 rounded-lg transition">
                <i class="fa-solid fa-plus"></i> Bawahan
            </button>

            <div class="flex items-center gap-1">
                @if($siblingsCount > 1)
                    @if($loopIndex > 0)
                        <form method="POST" action="{{ route('dashboard.struktur.move', $node->id) }}" class="inline">
                            @csrf
                            <input type="hidden" name="direction" value="left">
                            <button type="submit" title="Geser ke Kiri" class="p-1 text-[10px] text-slate-500 hover:text-maroon-700 hover:bg-bone-100 rounded-md transition">
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                        </form>
                    @endif
                    @if($loopIndex < $siblingsCount - 1)
                        <form method="POST" action="{{ route('dashboard.struktur.move', $node->id) }}" class="inline">
                            @csrf
                            <input type="hidden" name="direction" value="right">
                            <button type="submit" title="Geser ke Kanan" class="p-1 text-[10px] text-slate-500 hover:text-maroon-700 hover:bg-bone-100 rounded-md transition">
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </form>
                    @endif
                @endif

                <button type="button" onclick="openStrukturEdit({{ $node->id }})" title="Edit Jabatan" class="p-1 text-[10px] text-indigo-600 hover:bg-indigo-50 rounded-md transition">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>

                <form method="POST" action="{{ route('dashboard.struktur.destroy', $node->id) }}" class="inline" onsubmit="return confirm('Hapus jabatan ini? Bawahan langsung akan otomatis dinaikkan ke atasan di atasnya.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" title="Hapus Jabatan" class="p-1 text-[10px] text-rose-600 hover:bg-rose-50 rounded-md transition">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>

    @if($children->isNotEmpty())
        <ul>
            @foreach($children as $child)
                @include('dashboard.struktur._node', [
                    'node' => $child,
                    'loopIndex' => $loop->index,
                    'siblingsCount' => $children->count(),
                ])
            @endforeach
        </ul>
    @endif
</li>
