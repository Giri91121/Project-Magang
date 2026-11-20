<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarBerita extends Model
{
    use HasFactory;

    protected $table = 'komentar_beritas';

    protected $fillable = [
        'berita_id',
        'user_id',
        'komentar',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
