@if($tree->isEmpty())
    <div class="py-16 text-center space-y-3 max-w-md mx-auto">
        <div class="w-14 h-14 rounded-2xl bg-bone-200 text-maroon-700 flex items-center justify-center mx-auto text-2xl">
            <i class="fa-solid fa-sitemap"></i>
        </div>
        <h3 class="text-base font-extrabold text-slate-800">Belum Ada Kartu Struktur</h3>
        <p class="text-xs text-slate-500">Klik tombol <strong>Tambah Kartu</strong> di kanan atas untuk mulai menambahkan kartu jabatan.</p>
    </div>
@else
    <div id="dashboard-org-tree" class="org-tree inline-block min-w-full origin-top transition-transform duration-150">
        <ul>
            @foreach($tree as $rootNode)
                @include('dashboard.struktur._node', [
                    'node' => $rootNode,
                    'loopIndex' => $loop->index,
                    'siblingsCount' => $tree->count(),
                ])
            @endforeach
        </ul>
    </div>
@endif
