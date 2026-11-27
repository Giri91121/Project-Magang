<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Setting;
use App\Models\StrukturOrganisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StrukturOrganisasiController extends Controller
{
    public function index()
    {
        $tree = StrukturOrganisasi::getTree(false);
        $allNodes = StrukturOrganisasi::orderBy('sort_order')->orderBy('id')->get();
        $dasarHukum = Setting::where('key', 'struktur_dasar_hukum')->value('value') ?? '';

        $parentChoices = [];

        return view('dashboard.struktur.index', compact('tree', 'allNodes', 'dasarHukum'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jabatan' => 'required|string|max:255',
            'nama_pejabat' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'warna_badge' => 'required|in:maroon,slate,emerald,amber,indigo',
            'deskripsi' => 'required|string|max:2000',
            'is_active' => 'nullable|boolean',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('struktur', 'public');
        }

        $maxOrder = StrukturOrganisasi::whereNull('parent_id')->max('sort_order') ?? 0;

        $node = StrukturOrganisasi::create([
            'parent_id' => null,
            'jabatan' => $validated['jabatan'],
            'nama_pejabat' => $validated['nama_pejabat'],
            'nip' => $validated['nip'],
            'foto' => $fotoPath,
            'tipe_garis' => 'komando',
            'warna_badge' => $validated['warna_badge'],
            'deskripsi' => $validated['deskripsi'],
            'sort_order' => $maxOrder + 1,
            'is_active' => $request->boolean('is_active', true),
        ]);

        ActivityLog::log('struktur_create', "Menambahkan jabatan struktur organisasi: {$node->jabatan}");

        return redirect()->route('dashboard.struktur.index')
            ->with('success', "Jabatan \"{$node->jabatan}\" berhasil ditambahkan ke bagan.");
    }

    public function update(Request $request, $id)
    {
        $node = StrukturOrganisasi::findOrFail($id);

        $validated = $request->validate([
            'jabatan' => 'required|string|max:255',
            'nama_pejabat' => 'required|string|max:255',
            'nip' => 'required|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'warna_badge' => 'required|in:maroon,slate,emerald,amber,indigo',
            'deskripsi' => 'required|string|max:2000',
            'is_active' => 'nullable|boolean',
        ]);

        $fotoPath = $node->foto;
        if ($request->boolean('hapus_foto') && $fotoPath) {
            Storage::disk('public')->delete($fotoPath);
            $fotoPath = null;
        }
        if ($request->hasFile('foto')) {
            if ($fotoPath) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('struktur', 'public');
        }

        $node->update([
            'jabatan' => $validated['jabatan'],
            'nama_pejabat' => $validated['nama_pejabat'],
            'nip' => $validated['nip'],
            'foto' => $fotoPath,
            'warna_badge' => $validated['warna_badge'],
            'deskripsi' => $validated['deskripsi'],
            'is_active' => $request->boolean('is_active', false),
        ]);

        ActivityLog::log('struktur_update', "Memperbarui jabatan struktur organisasi: {$node->jabatan}");

        return redirect()->route('dashboard.struktur.index')
            ->with('success', "Jabatan \"{$node->jabatan}\" berhasil diperbarui.");
    }

    public function move(Request $request, $id)
    {
        $node = StrukturOrganisasi::findOrFail($id);
        $direction = $request->input('direction', 'left');

        $siblings = StrukturOrganisasi::where('parent_id', $node->parent_id)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get()
            ->values();

        $index = $siblings->search(fn ($item) => $item->id === $node->id);
        if ($index === false) {
            return redirect()->route('dashboard.struktur.index');
        }

        $swapIndex = $direction === 'left' ? $index - 1 : $index + 1;
        if ($swapIndex >= 0 && $swapIndex < $siblings->count()) {
            $other = $siblings[$swapIndex];
            $currentOrder = $node->sort_order;
            $otherOrder = $other->sort_order;

            if ($currentOrder === $otherOrder) {
                foreach ($siblings as $idx => $sib) {
                    $sib->update(['sort_order' => $idx + 1]);
                }
                $node->refresh();
                $other->refresh();
                $currentOrder = $node->sort_order;
                $otherOrder = $other->sort_order;
            }

            $node->update(['sort_order' => $otherOrder]);
            $other->update(['sort_order' => $currentOrder]);
        }

        return redirect()->route('dashboard.struktur.index')
            ->with('success', 'Urutan posisi bagan berhasil diperbarui.');
    }

    public function reparent(Request $request, $id)
    {
        $node = StrukturOrganisasi::findOrFail($id);
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:struktur_organisasis,id',
            'tipe_garis' => 'nullable|in:komando,koordinasi',
        ]);

        $newParentId = $validated['parent_id'] ?? null;
        if ($newParentId !== null) {
            if ((int) $newParentId === (int) $node->id || in_array((int) $newParentId, $this->getDescendantIds($node->id), true)) {
                return response()->json([
                    'message' => 'Tidak dapat memindahkan jabatan ke diri sendiri atau bawahannya.',
                ], 422);
            }
        }

        $maxOrder = StrukturOrganisasi::where('parent_id', $newParentId)->max('sort_order') ?? 0;
        $node->update([
            'parent_id' => $newParentId,
            'sort_order' => $maxOrder + 1,
            'tipe_garis' => $validated['tipe_garis'] ?? $node->tipe_garis,
        ]);

        ActivityLog::log('struktur_reparent', "Memindahkan posisi atasan jabatan: {$node->jabatan}");

        return response()->json([
            'ok' => true,
            'message' => "Jabatan \"{$node->jabatan}\" berhasil dipindahkan.",
        ]);
    }

    public function updateLineType(Request $request, $id)
    {
        $node = StrukturOrganisasi::findOrFail($id);
        $validated = $request->validate([
            'tipe_garis' => 'required|in:komando,koordinasi',
        ]);

        $node->update(['tipe_garis' => $validated['tipe_garis']]);

        ActivityLog::log('struktur_line_type', "Mengubah jenis garis {$node->jabatan} menjadi {$validated['tipe_garis']}");

        return response()->json([
            'ok' => true,
            'tipe_garis' => $node->tipe_garis,
            'message' => "Jenis garis \"{$node->jabatan}\" diubah ke " . ($node->tipe_garis === 'koordinasi' ? 'Koordinasi' : 'Komando') . '.',
        ]);
    }

    public function toggleActive($id)
    {
        $node = StrukturOrganisasi::findOrFail($id);
        $node->update(['is_active' => !$node->is_active]);

        $stateLabel = $node->is_active ? 'ditampilkan di publik' : 'disembunyikan dari publik';
        ActivityLog::log('struktur_toggle', "Status kartu {$node->jabatan} diubah: {$stateLabel}");

        return response()->json([
            'ok' => true,
            'is_active' => (bool) $node->is_active,
            'message' => "Kartu \"{$node->jabatan}\" {$stateLabel}.",
        ]);
    }

    public function duplicate($id)
    {
        $node = StrukturOrganisasi::findOrFail($id);
        $maxOrder = StrukturOrganisasi::where('parent_id', $node->parent_id)->max('sort_order') ?? 0;

        $copy = StrukturOrganisasi::create([
            'parent_id' => $node->parent_id,
            'jabatan' => mb_substr($node->jabatan . ' (Salinan)', 0, 255),
            'nama_pejabat' => null,
            'nip' => null,
            'foto' => null,
            'tipe_garis' => $node->tipe_garis,
            'warna_badge' => $node->warna_badge,
            'deskripsi' => $node->deskripsi,
            'sort_order' => $maxOrder + 1,
            'is_active' => $node->is_active,
        ]);

        ActivityLog::log('struktur_duplicate', "Menduplikat jabatan struktur organisasi: {$node->jabatan}");

        return redirect()->route('dashboard.struktur.index')
            ->with('success', "Jabatan \"{$copy->jabatan}\" berhasil diduplikat.");
    }

    public function destroy(Request $request, $id)
    {
        $node = StrukturOrganisasi::findOrFail($id);
        $jabatan = $node->jabatan;

        // Naikkan bawahan langsung ke atasan node yang dihapus agar bagan tidak terputus
        StrukturOrganisasi::where('parent_id', $node->id)
            ->update(['parent_id' => $node->parent_id]);

        if ($node->foto) {
            Storage::disk('public')->delete($node->foto);
        }

        $node->delete();

        ActivityLog::log('struktur_delete', "Menghapus jabatan struktur organisasi: {$jabatan}");

        if ($request->expectsJson()) {
            return response()->json([
                'ok' => true,
                'message' => "Jabatan \"{$jabatan}\" berhasil dihapus.",
            ]);
        }

        return redirect()->route('dashboard.struktur.index')
            ->with('success', "Jabatan \"{$jabatan}\" berhasil dihapus.");
    }

    public function seedSample()
    {
        if (StrukturOrganisasi::count() > 0) {
            return redirect()->route('dashboard.struktur.index')
                ->with('error', 'Data struktur sudah ada. Hapus data terlebih dahulu jika ingin memuat contoh.');
        }

        $kepala = StrukturOrganisasi::create([
            'jabatan' => 'Kepala Badan (BRIDA)',
            'nama_pejabat' => 'Dr. Ir. H. Nama Kepala Badan, M.Si.',
            'nip' => '19700101 199503 1 001',
            'tipe_garis' => 'komando',
            'warna_badge' => 'maroon',
            'deskripsi' => 'Memimpin, mengoordinasikan, dan mengendalikan seluruh pelaksanaan tugas pokok dan fungsi Badan Riset dan Inovasi Daerah Kota Makassar.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $sekretaris = StrukturOrganisasi::create([
            'parent_id' => $kepala->id,
            'jabatan' => 'Sekretaris Badan',
            'nama_pejabat' => 'Nama Sekretaris, S.STP., M.Si.',
            'tipe_garis' => 'komando',
            'warna_badge' => 'slate',
            'deskripsi' => 'Mengoordinasikan penyelenggaraan administrasi umum, kepegawaian, keuangan, serta perencanaan dan pelaporan internal BRIDA.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        StrukturOrganisasi::create([
            'parent_id' => $sekretaris->id,
            'jabatan' => 'Subbagian Umum & Kepegawaian',
            'tipe_garis' => 'komando',
            'warna_badge' => 'emerald',
            'deskripsi' => 'Mengelola tata usaha, perlengkapan, rumah tangga, dan administrasi kepegawaian.',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        StrukturOrganisasi::create([
            'parent_id' => $sekretaris->id,
            'jabatan' => 'Subbagian Keuangan & Program',
            'tipe_garis' => 'komando',
            'warna_badge' => 'emerald',
            'deskripsi' => 'Mengelola penyusunan anggaran, penatausahaan keuangan, dan evaluasi program.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        StrukturOrganisasi::create([
            'parent_id' => $kepala->id,
            'jabatan' => 'Bidang Riset & Inovasi Daerah',
            'tipe_garis' => 'komando',
            'warna_badge' => 'indigo',
            'deskripsi' => 'Menyelenggarakan fasilitasi penelitian, pengembangan, pengkajian, serta diseminasi inovasi daerah dan HKI.',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        StrukturOrganisasi::create([
            'parent_id' => $kepala->id,
            'jabatan' => 'Bidang Kebijakan Pembangunan Daerah',
            'tipe_garis' => 'komando',
            'warna_badge' => 'indigo',
            'deskripsi' => 'Menyusun rekomendasi kebijakan berbasis bukti (evidence-based policy) untuk pembangunan Kota Makassar.',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        StrukturOrganisasi::create([
            'parent_id' => $kepala->id,
            'jabatan' => 'Kelompok Jabatan Fungsional',
            'tipe_garis' => 'koordinasi',
            'warna_badge' => 'amber',
            'deskripsi' => 'Melaksanakan tugas fungsional peneliti, perekayasa, dan analis kebijakan sesuai keahlian masing-masing.',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        ActivityLog::log('struktur_seed', 'Memuat contoh struktur organisasi awal BRIDA Kota Makassar');

        return redirect()->route('dashboard.struktur.index')
            ->with('success', 'Contoh struktur organisasi BRIDA berhasil dimuat!');
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'struktur_dasar_hukum' => 'nullable|string|max:500',
        ]);

        Setting::updateOrCreate(
            ['key' => 'struktur_dasar_hukum'],
            ['value' => $validated['struktur_dasar_hukum'] ?? '']
        );

        ActivityLog::log('struktur_settings', 'Memperbarui dasar hukum struktur organisasi');

        return redirect()->route('dashboard.struktur.index')
            ->with('success', 'Keterangan dasar hukum struktur organisasi berhasil disimpan.');
    }

    private function resolveParentId(Request $request): ?int
    {
        $choice = trim((string) $request->input('parent_id', ''));
        if ($choice === '') {
            return null;
        }

        if ($choice === '__new__') {
            $request->validate(['new_parent_name' => 'required|string|max:255']);
            $name = trim((string) $request->input('new_parent_name'));
            $existing = StrukturOrganisasi::where('jabatan', $name)->first();
            if ($existing) {
                return $existing->id;
            }
            $defaultRootId = StrukturOrganisasi::whereNull('parent_id')->orderBy('sort_order')->orderBy('id')->value('id');
            $maxOrder = StrukturOrganisasi::where('parent_id', $defaultRootId)->max('sort_order') ?? 0;
            $created = StrukturOrganisasi::create([
                'parent_id' => $defaultRootId,
                'jabatan' => $name,
                'tipe_garis' => 'komando',
                'warna_badge' => 'indigo',
                'sort_order' => $maxOrder + 1,
                'is_active' => true,
                'is_parent' => true,
            ]);
            return $created->id;
        }

        if (str_starts_with($choice, 'preset:')) {
            $presetName = trim(substr($choice, 7));
            $existing = StrukturOrganisasi::where('jabatan', $presetName)->first();
            if ($existing) {
                return $existing->id;
            }
            $kaban = $presetName !== 'Kaban' ? StrukturOrganisasi::where('jabatan', 'Kaban')->first() : null;
            $parentId = $kaban?->id;
            $maxOrder = StrukturOrganisasi::where('parent_id', $parentId)->max('sort_order') ?? 0;
            $created = StrukturOrganisasi::create([
                'parent_id' => $parentId,
                'jabatan' => $presetName,
                'tipe_garis' => 'komando',
                'warna_badge' => $presetName === 'Kaban' ? 'maroon' : ($presetName === 'Sekban' ? 'slate' : 'indigo'),
                'sort_order' => $maxOrder + 1,
                'is_active' => true,
            ]);
            return $created->id;
        }

        if (ctype_digit($choice)) {
            $exists = StrukturOrganisasi::find((int) $choice);
            return $exists?->id;
        }

        return null;
    }

    private function buildIndentedParentChoices($nodes, int $depth = 0): array
    {
        $choices = [];
        foreach ($nodes as $node) {
            $children = $node->childrenRecursive ?? collect();
            if ($node->is_parent || $children->isNotEmpty()) {
                $choices[] = [
                    'value' => (string) $node->id,
                    'label' => $node->jabatan . ($node->nama_pejabat ? ' (' . $node->nama_pejabat . ')' : ''),
                    'depth' => $depth,
                ];
            }
            if ($children->isNotEmpty()) {
                $choices = array_merge($choices, $this->buildIndentedParentChoices($children, $depth + 1));
            }
        }
        return $choices;
    }

    private function getDescendantIds(int $nodeId): array
    {
        $all = StrukturOrganisasi::select('id', 'parent_id')->get();
        $childrenMap = [];
        foreach ($all as $item) {
            if ($item->parent_id !== null) {
                $childrenMap[$item->parent_id][] = $item->id;
            }
        }

        $result = [];
        $queue = $childrenMap[$nodeId] ?? [];
        while (!empty($queue)) {
            $current = array_shift($queue);
            $result[] = $current;
            foreach ($childrenMap[$current] ?? [] as $childId) {
                $queue[] = $childId;
            }
        }

        return $result;
    }
}
