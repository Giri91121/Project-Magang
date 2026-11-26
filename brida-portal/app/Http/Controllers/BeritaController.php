<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\ActivityLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class BeritaController extends Controller
{
    /**
     * Tampilkan daftar seluruh artikel berita di dashboard
     */
    public function index(Request $request)
    {
        $query = Berita::with('user')->latest();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('judul', 'like', "%{$search}%");
        }

        $beritas = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => Berita::count(),
            'publikasi' => Berita::where('status', 'Publikasi')->count(),
            'draft' => Berita::where('status', 'Draft')->count(),
            'total_views' => Berita::sum('views'),
        ];

        return view('dashboard.berita.index', compact('beritas', 'stats'));
    }

    /**
     * Tampilkan formulir tulis berita baru
     */
    public function create()
    {
        $categories = $this->getCategories();
        $existingTags = $this->getExistingTags();
        return view('dashboard.berita.create', compact('categories', 'existingTags'));
    }

    /**
     * Simpan berita baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'ringkasan' => 'required|string|max:500',
            'konten' => 'required|string',
            'gambar_sampul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:Publikasi,Draft',
        ]);

        $this->syncCategoryIfNew($validated['kategori']);

        $slug = Str::slug($validated['judul']);
        // Cek keunikan slug
        $count = Berita::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-" . ($count + 1);
        }

        $data = $validated;
        $data['tags'] = !empty($validated['tags']) ? implode(', ', array_unique(array_map('trim', $validated['tags']))) : null;
        $data['user_id'] = Auth::id();
        $data['slug'] = $slug;
        $data['published_at'] = $validated['status'] === 'Publikasi' ? now() : null;

        if ($request->hasFile('gambar_sampul')) {
            $data['gambar_sampul'] = $request->file('gambar_sampul')->store('berita', 'public');
        }

        $berita = Berita::create($data);

        ActivityLog::log('create_berita', "Berita baru '{$berita->judul}' diterbitkan oleh " . Auth::user()->name, $berita);

        return redirect()->route('dashboard.berita.index')
            ->with('success', "Berita '{$berita->judul}' berhasil disimpan.");
    }

    /**
     * Tampilkan form edit berita
     */
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $categories = $this->getCategories();
        $existingTags = $this->getExistingTags();
        return view('dashboard.berita.edit', compact('berita', 'categories', 'existingTags'));
    }

    /**
     * Perbarui artikel berita
     */
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'ringkasan' => 'required|string|max:500',
            'konten' => 'required|string',
            'gambar_sampul' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'status' => 'required|in:Publikasi,Draft',
        ]);

        $this->syncCategoryIfNew($validated['kategori']);

        $data = $validated;
        $data['tags'] = !empty($validated['tags']) ? implode(', ', array_unique(array_map('trim', $validated['tags']))) : null;
        if ($validated['status'] === 'Publikasi' && !$berita->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('gambar_sampul')) {
            $data['gambar_sampul'] = $request->file('gambar_sampul')->store('berita', 'public');
        }

        $berita->update($data);

        ActivityLog::log('update_berita', "Berita '{$berita->judul}' diperbarui oleh " . Auth::user()->name, $berita);

        return redirect()->route('dashboard.berita.index')
            ->with('success', "Berita berhasil diperbarui.");
    }

    /**
     * Hapus berita
     */
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $judul = $berita->judul;
        $berita->delete();

        ActivityLog::log('delete_berita', "Berita '{$judul}' dihapus oleh " . Auth::user()->name);

        return back()->with('success', "Berita '{$judul}' berhasil dihapus.");
    }

    /**
     * Tambah / Hapus daftar kategori berita secara dinamis
     */
    public function updateCategories(Request $request)
    {
        $request->validate([
            'categories_text' => 'required|string|max:1000',
        ]);

        $items = array_values(array_unique(array_filter(array_map('trim', explode(',', $request->categories_text)))));
        Setting::updateOrCreate(
            ['key' => 'berita_kategori_list'],
            ['value' => implode(', ', $items)]
        );

        return back()->with('success', 'Daftar kategori berita berhasil diperbarui!');
    }

    private function getCategories(): array
    {
        $raw = Setting::where('key', 'berita_kategori_list')->value('value')
            ?? 'Kebijakan Riset, Inovasi Daerah, Kemitraan Kampus, Agenda BRIDA';
        return array_values(array_filter(array_map('trim', explode(',', $raw))));
    }

    private function syncCategoryIfNew(string $kategori): void
    {
        $kategori = trim($kategori);
        if ($kategori === '') return;
        $cats = $this->getCategories();
        if (!in_array($kategori, $cats, true)) {
            $cats[] = $kategori;
            Setting::updateOrCreate(['key' => 'berita_kategori_list'], ['value' => implode(', ', $cats)]);
        }
    }

    private function getExistingTags(): array
    {
        if (!Schema::hasColumn('beritas', 'tags')) {
            return [];
        }
        $all = Berita::whereNotNull('tags')->pluck('tags');
        $tags = [];
        foreach ($all as $row) {
            foreach (explode(',', $row) as $t) {
                $t = trim($t);
                if ($t !== '') $tags[$t] = $t;
            }
        }
        return array_values($tags);
    }
}
