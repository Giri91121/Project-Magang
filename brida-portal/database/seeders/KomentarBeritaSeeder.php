<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\KomentarBerita;
use App\Models\User;
use Illuminate\Database\Seeder;

class KomentarBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beritaUtama = Berita::first();
        if (!$beritaUtama) return;

        $peneliti = User::role('Peneliti')->first() ?? User::first();
        $pemohon = User::role('Pemohon')->first() ?? User::first();

        $samples = [
            [
                'berita_id' => $beritaUtama->id,
                'user_id' => $peneliti->id,
                'komentar' => 'Langkah strategis yang sangat tepat. Peta Jalan Riset Rendah Karbon ini akan menjadi acuan penting bagi rekan-rekan peneliti perguruan tinggi di Kota Makassar.',
                'is_approved' => true,
            ],
            [
                'berita_id' => $beritaUtama->id,
                'user_id' => $pemohon->id,
                'komentar' => 'Sangat menginspirasi! Semoga kolaborasi riset mahasiswa dengan program Lorong Wisata rendah karbon semakin diperluas tahun depan.',
                'is_approved' => true,
            ],
        ];

        foreach ($samples as $item) {
            KomentarBerita::firstOrCreate(
                ['berita_id' => $item['berita_id'], 'komentar' => $item['komentar']],
                $item
            );
        }
    }
}
