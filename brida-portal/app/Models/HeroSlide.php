<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HeroSlide extends Model
{
    use HasFactory;

    protected $table = 'hero_slides';

    protected $fillable = [
        'judul_alt',
        'gambar_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getGambarUrlAttribute()
    {
        if (Str::startsWith($this->gambar_path, ['http://', 'https://'])) {
            return $this->gambar_path;
        }

        if (Str::startsWith($this->gambar_path, 'images/')) {
            return asset($this->gambar_path);
        }

        return asset('storage/' . $this->gambar_path);
    }
}
