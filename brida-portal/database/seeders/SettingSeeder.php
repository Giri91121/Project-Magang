<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            // General / Profil Instansi
            ['key' => 'site_name', 'value' => 'BRIDA Kota Makassar', 'group' => 'general'],
            ['key' => 'agency_name', 'value' => 'Badan Riset dan Inovasi Daerah', 'group' => 'general'],
            ['key' => 'tagline', 'value' => 'Mendorong Inovasi Berbasis Riset, Mewujudkan Makassar Kota Dunia yang Berdaya Saing', 'group' => 'general'],
            ['key' => 'kepala_badan_nama', 'value' => 'Nirman Mungkasa, S.T., M.Si.', 'group' => 'general'],
            ['key' => 'kepala_badan_nip', 'value' => '19740512 199903 1 004', 'group' => 'general'],

            // Kontak & Operasional
            ['key' => 'office_address', 'value' => 'Gedung Balai Kota Makassar Lantai 2, Jl. Ahmad Yani No. 2, Baru, Kec. Ujung Pandang, Kota Makassar, Sulawesi Selatan 90111', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'brida@makassarkota.go.id', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '112 (Bebas Pulsa) / (0411) 361-102', 'group' => 'contact'],
            ['key' => 'contact_whatsapp', 'value' => '081144002233', 'group' => 'contact'],
            ['key' => 'work_hours', 'value' => 'Senin - Kamis (08.00 - 16.00 WITA), Jumat (08.00 - 16.30 WITA)', 'group' => 'contact'],

            // Media Sosial Resmi
            ['key' => 'social_instagram', 'value' => 'https://www.instagram.com/pemkotmakassar/', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => 'https://www.youtube.com/@PemerintahKotaMakassarOfficial', 'group' => 'social'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/HumasKotaMakassar', 'group' => 'social'],
        ];

        foreach ($defaults as $set) {
            Setting::updateOrCreate(['key' => $set['key']], $set);
        }
    }
}
