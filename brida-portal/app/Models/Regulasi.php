<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulasi extends Model
{
    use HasFactory;

    protected $table = 'regulasis';

    protected $fillable = [
        'user_id',
        'judul_regulasi',
        'nomor_peraturan',
        'kategori',
        'tahun',
        'tentang',
        'file_dokumen',
        'ukuran_file',
        'download_count',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * URL file PDF dokumen
     */
    public function getFileUrlAttribute()
    {
        if (!$this->file_dokumen) {
            return asset('docs/Panduan_Pengguna_BRIDA_Makassar.txt');
        }

        return asset('storage/' . $this->file_dokumen);
    }
}
