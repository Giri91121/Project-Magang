<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingService extends Model
{
    use HasFactory;

    protected $table = 'landing_services';

    protected $fillable = [
        'judul',
        'kategori_badge',
        'deskripsi',
        'detail_title',
        'detail_items',
        'estimasi_info',
        'biaya_info',
        'icon',
        'link_text',
        'link_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Memecah teks detail_items (dipisahkan baris baru) menjadi array untuk ditampilkan sebagai bullet list
     */
    public function getDetailItemsArrayAttribute(): array
    {
        if (empty($this->detail_items)) {
            return [];
        }

        $lines = preg_split('/\r\n|\r|\n/', $this->detail_items);
        return array_values(array_filter(array_map('trim', $lines)));
    }
}
