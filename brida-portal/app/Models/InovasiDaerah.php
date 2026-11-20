<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InovasiDaerah extends Model
{
    use HasFactory;

    protected $table = 'inovasi_daerahs';

    protected $fillable = [
        'user_id',
        'kode_inovasi',
        'nama_inovasi',
        'perangkat_daerah',
        'tahapan_inovasi',
        'inisiator',
        'jenis_inovasi',
        'urusan_pemerintahan',
        'ringkasan',
        'kebaruan',
        'skor_kematangan',
        'status_verifikasi',
        'tahun_penerapan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status_verifikasi) {
            'Terverifikasi' => 'bg-emerald-100 text-emerald-800 border border-emerald-300',
            'Menunggu Verifikasi' => 'bg-amber-100 text-amber-800 border border-amber-300',
            default => 'bg-slate-100 text-slate-800 border border-slate-300',
        };
    }
}
