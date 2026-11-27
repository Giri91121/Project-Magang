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
    $isLeafGroup = $children->isNotEmpty() && $children->every(fn ($c) => ($c->childrenRecursive ?? collect())->isEmpty());
    $searchText = strtolower(trim(($node->jabatan ?? '') . ' ' . ($node->nama_pejabat ?? '') . ' ' . ($node->nip ?? '')));
@endphp

<li class="{{ $isKoordinasi ? 'org-node-koordinasi' : '' }}">
    <div class="inline-flex flex-col items-center">
        <button
            type="button"
            data-search="{{ $searchText }}"
            onclick="openPublicStrukturDetail({{ $node->id }})"
            class="public-struktur-node org-card inline-block text-left bg-white rounded-2xl border border-bone-300 {{ $ringClass }} shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all w-56 p-3.5 cursor-pointer focus:outline-none">
            <div class="flex items-start gap-3">
                @if($node->foto)
                    <img src="{{ asset('storage/' . $node->foto) }}" alt="{{ $node->nama_pejabat ?: $node->jabatan }}" class="w-11 h-11 rounded-xl object-cover border border-bone-300 shrink-0">
                @else
                    <div class="w-11 h-11 rounded-xl bg-bone-100 border border-bone-300 text-maroon-700 flex items-center justify-center font-extrabold text-xs shrink-0">
                        {{ strtoupper(mb_substr($node->nama_pejabat ?: $node->jabatan, 0, 2)) }}
                    </div>
                @endif

                <div class="min-w-0 flex-1">
                    <div class="text-xs font-extrabold text-slate-900 leading-snug line-clamp-2">
                        {{ $node->jabatan }}
                    </div>
                    @if($node->nama_pejabat)
                        <div class="text-[11px] font-semibold text-maroon-700 truncate mt-0.5">
                            {{ $node->nama_pejabat }}
                        </div>
                    @endif
                    @if($node->nip)
                        <div class="text-[10px] text-slate-400 truncate mt-0.5">NIP. {{ $node->nip }}</div>
                    @endif
                </div>
            </div>

            @if($node->deskripsi)
                <div class="mt-2.5 pt-2 border-t border-bone-200 flex items-center justify-between text-[10px] font-bold text-slate-500">
                    <span><i class="fa-solid fa-circle-info text-maroon-600 mr-1"></i>Lihat Tupoksi</span>
                    <i class="fa-solid fa-chevron-right text-[9px] text-slate-400"></i>
                </div>
            @endif
        </button>

        @if($children->isNotEmpty())
            <button type="button" onclick="event.stopPropagation(); togglePublicBranch(this, {{ $node->id }})" class="pub-branch-toggle no-print mt-1.5 inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-bone-100 hover:bg-bone-200 border border-bone-300 text-[10px] font-bold text-slate-600 shadow-sm transition">
                <i class="fa-solid fa-chevron-up text-[9px]"></i>
                <span>{{ $children->count() }} Unit</span>
            </button>
        @endif
    </div>

    @if($children->isNotEmpty())
        <ul data-branch-for="{{ $node->id }}" class="{{ $isLeafGroup ? 'org-leaf-group' : '' }}">
            @foreach($children as $child)
                @include('landing._struktur-node', ['node' => $child])
            @endforeach
        </ul>
    @endif
</li>
