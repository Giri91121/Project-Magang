<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'kategori',
        'tags',
        'ringkasan',
        'konten',
        'gambar_sampul',
        'status',
        'views',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function komentars()
    {
        return $this->hasMany(KomentarBerita::class, 'berita_id');
    }

    /**
     * URL Gambar Sampul
     */
    public function getGambarUrlAttribute()
    {
        if (!$this->gambar_sampul) {
            return 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1200&q=80';
        }

        if (Str::startsWith($this->gambar_sampul, ['http://', 'https://'])) {
            return $this->gambar_sampul;
        }

        return asset('storage/' . $this->gambar_sampul);
    }
}
