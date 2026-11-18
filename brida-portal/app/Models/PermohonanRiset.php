<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanRiset extends Model
{
    use HasFactory;

    protected $table = 'permohonan_risets';

    protected $fillable = [
        'user_id',
        'nomor_registrasi',
        'nama_pemohon',
        'institusi',
        'jurusan_fakultas',
        'kontak_wa',
        'judul_penelitian',
        'bidang_fokus',
        'lokasi_penelitian',
        'tanggal_mulai',
        'tanggal_selesai',
        'file_surat_pengantar',
        'file_proposal',
        'status',
        'catatan_reviewer',
        'file_surat_rekomendasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper untuk styling warna status
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'Disetujui' => 'bg-emerald-100 text-emerald-800 border border-emerald-300',
            'Sedang Ditelaah' => 'bg-blue-100 text-blue-800 border border-blue-300',
            'Ditolak' => 'bg-rose-100 text-rose-800 border border-rose-300',
            default => 'bg-amber-100 text-amber-800 border border-amber-300',
        };
    }
}
