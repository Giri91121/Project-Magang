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

<li data-node-id="{{ $node->id }}" class="{{ $isKoordinasi ? 'org-node-koordinasi' : '' }}">
    <div
        draggable="true"
        data-card-id="{{ $node->id }}"
        onclick="handleDashboardCardClick(event, {{ $node->id }})"
        ondragstart="handleCardDragStart(event, {{ $node->id }})"
        ondragover="handleCardDragOver(event, {{ $node->id }})"
        ondragleave="handleCardDragLeave(event)"
        ondrop="handleCardDrop(event, {{ $node->id }})"
        ondragend="handleCardDragEnd(event)"
        class="group org-card inline-block text-left bg-white rounded-2xl border {{ $node->is_active ? 'border-bone-300' : 'border-dashed border-rose-300 opacity-70' }} {{ $ringClass }} shadow-sm hover:shadow-md transition w-56 p-3.5 relative cursor-pointer">
        <!-- Bundaran Penghubung Atas (Tarik ke Atasan / Klik Opsi Garis) -->
        <button
            type="button"
            onmousedown="startDragConnect(event, {{ $node->id }}, {{ json_encode($node->jabatan) }}, 'up', {{ $node->parent_id !== null ? 'true' : 'false' }}, '{{ $node->tipe_garis }}')"
            onclick="event.stopPropagation();"
            title="Tarik ke kartu atasan, atau klik untuk opsi garis"
            class="absolute -top-2.5 left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-white border-2 {{ $node->parent_id !== null ? ($isKoordinasi ? 'border-dashed border-amber-500 text-amber-600' : 'border-maroon-700 text-maroon-700') : 'border-indigo-500 text-indigo-600' }} shadow-sm hover:scale-125 transition flex items-center justify-center z-10 cursor-crosshair">
            <span class="w-1.5 h-1.5 rounded-full {{ $node->parent_id !== null ? ($isKoordinasi ? 'bg-amber-500' : 'bg-maroon-700') : 'bg-indigo-500' }}"></span>
        </button>

        @if(!$node->is_active)
            <span class="inline-block mb-1.5 text-[9px] font-bold uppercase px-1.5 py-0.5 rounded bg-rose-100 text-rose-700">Nonaktif</span>
        @endif

        <div class="flex items-start gap-2.5">
            @if($node->foto)
                <img src="{{ asset('storage/' . $node->foto) }}" alt="{{ $node->nama_pejabat ?: $node->jabatan }}" class="w-10 h-10 rounded-xl object-cover border border-bone-300 shrink-0 pointer-events-none">
            @else
                <div class="w-10 h-10 rounded-xl bg-bone-100 border border-bone-300 text-maroon-700 flex items-center justify-center font-extrabold text-xs shrink-0">
                    {{ strtoupper(mb_substr($node->nama_pejabat ?: $node->jabatan, 0, 2)) }}
                </div>
            @endif

            <div class="min-w-0 flex-1">
                <div class="text-xs font-extrabold text-slate-900 leading-snug line-clamp-2" title="{{ $node->jabatan }}">
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

        <div class="mt-2.5 pt-2 border-t border-bone-200 flex items-center justify-between text-[10px]" onclick="event.stopPropagation()">
            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                @if(($siblingsCount ?? 1) > 1)
                    @if(($loopIndex ?? 0) > 0)
                        <button type="button" onclick="moveStrukturCard({{ $node->id }}, 'left')" title="Geser ke Kiri" class="p-1 text-slate-500 hover:text-maroon-700 hover:bg-bone-100 rounded-md transition">
                            <i class="fa-solid fa-arrow-left"></i>
                        </button>
                    @endif
                    @if(($loopIndex ?? 0) < ($siblingsCount ?? 1) - 1)
                        <button type="button" onclick="moveStrukturCard({{ $node->id }}, 'right')" title="Geser ke Kanan" class="p-1 text-slate-500 hover:text-maroon-700 hover:bg-bone-100 rounded-md transition">
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    @endif
                @endif
            </div>
            <div class="flex items-center gap-0.5">
                <button type="button" onclick="toggleCardActive(this, {{ $node->id }})" title="{{ $node->is_active ? 'Sembunyikan dari Publik' : 'Tampilkan di Publik' }}" class="p-1 {{ $node->is_active ? 'text-emerald-600 hover:bg-emerald-50' : 'text-slate-400 hover:bg-bone-100' }} rounded-md transition">
                    <i class="fa-regular {{ $node->is_active ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                </button>
                <button type="button" onclick="duplicateStrukturCard({{ $node->id }})" title="Copy Kartu" class="p-1 text-amber-600 hover:bg-amber-50 rounded-md transition">
                    <i class="fa-regular fa-copy"></i>
                </button>
                <button type="button" onclick="openStrukturEdit({{ $node->id }})" title="Edit Kartu" class="p-1 text-indigo-600 hover:bg-indigo-50 rounded-md transition">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button type="button" onclick="deleteStrukturCard({{ $node->id }})" title="Hapus Kartu" class="p-1 text-rose-600 hover:bg-rose-50 rounded-md transition">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>

        <!-- Bundaran Penghubung Bawah (Klik atau Tarik Garis ke Sub-unit) -->
        <button
            type="button"
            onmousedown="startDragConnect(event, {{ $node->id }}, {{ json_encode($node->jabatan) }}, 'down', false, '{{ $node->tipe_garis }}')"
            onclick="event.stopPropagation();"
            title="Tarik ke kartu bawahan (sub-unit)"
            class="absolute -bottom-2.5 left-1/2 -translate-x-1/2 w-5 h-5 rounded-full bg-maroon-700 hover:bg-maroon-800 text-white border-2 border-white shadow hover:scale-125 transition flex items-center justify-center z-10 cursor-crosshair">
            <i class="fa-solid fa-link text-[8px]"></i>
        </button>
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
