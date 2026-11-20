<?php

namespace Database\Seeders;

use App\Models\InovasiDaerah;
use App\Models\User;
use Illuminate\Database\Seeder;

class InovasiDaerahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fasilitator = User::role('Fasilitator Inovasi')->first() ?? User::first();
        if (!$fasilitator) return;

        $samples = [
            [
                'user_id' => $fasilitator->id,
                'kode_inovasi' => 'INOV-MKS-001',
                'nama_inovasi' => 'Lorong Wisata Terpadu (Longwis)',
                'perangkat_daerah' => 'Dinas Ketahanan Pangan & Dinas Pariwisata',
                'tahapan_inovasi' => 'Penerapan',
                'inisiator' => 'Kepala Daerah',
                'jenis_inovasi' => 'Non-Digital',
                'urusan_pemerintahan' => 'Ekonomi & Ketahanan Pangan',
                'ringkasan' => 'Pengembangan 1.000 lorong wisata berbasis sirkular ekonomi lokal melalui urban farming, budidaya lobster air tawar, dan UMKM lorong.',
                'kebaruan' => 'Model pentahelix berbasis lorong permukiman padat perkotaan yang mandiri pangan.',
                'skor_kematangan' => 112,
                'status_verifikasi' => 'Terverifikasi',
                'tahun_penerapan' => 2024,
            ],
            [
                'user_id' => $fasilitator->id,
                'kode_inovasi' => 'INOV-MKS-002',
                'nama_inovasi' => 'Dottoro\'ta - Home Care Telemedicine',
                'perangkat_daerah' => 'Dinas Kesehatan Kota Makassar',
                'tahapan_inovasi' => 'Penerapan',
                'inisiator' => 'OPD',
                'jenis_inovasi' => 'Digital',
                'urusan_pemerintahan' => 'Kesehatan Masyarakat',
                'ringkasan' => 'Layanan kunjungan dokter dan tim medis 24 jam ke rumah warga terintegrasi dengan mobil ambulans pintar dan panggilan darurat 112.',
                'kebaruan' => 'Pertolongan medis pratranspor dengan monitor vital real-time ke RSUD.',
                'skor_kematangan' => 118,
                'status_verifikasi' => 'Terverifikasi',
                'tahun_penerapan' => 2025,
            ],
            [
                'user_id' => $fasilitator->id,
                'kode_inovasi' => 'INOV-MKS-003',
                'nama_inovasi' => 'SIGAP Makassar (Sistem Informasi Riset & Inovasi)',
                'perangkat_daerah' => 'Badan Riset dan Inovasi Daerah (BRIDA)',
                'tahapan_inovasi' => 'Penerapan',
                'inisiator' => 'OPD',
                'jenis_inovasi' => 'Digital',
                'urusan_pemerintahan' => 'Penelitian & Pengembangan',
                'ringkasan' => 'Platform terpadu satu pintu fasilitasi izin riset daerah, repositori kajian kebijakan, dan pendampingan indeks kematangan inovasi SKPD.',
                'kebaruan' => 'Digitalisasi rantai data riset menjadi rekomendasi kebijakan pemerintah kota.',
                'skor_kematangan' => 105,
                'status_verifikasi' => 'Terverifikasi',
                'tahun_penerapan' => 2026,
            ],
            [
                'user_id' => $fasilitator->id,
                'kode_inovasi' => 'INOV-MKS-004',
                'nama_inovasi' => 'Bank Sampah Sektoral & Kompos Organik Terintegrasi',
                'perangkat_daerah' => 'Dinas Lingkungan Hidup',
                'tahapan_inovasi' => 'Uji Coba',
                'inisiator' => 'ASN',
                'jenis_inovasi' => 'Non-Digital',
                'urusan_pemerintahan' => 'Lingkungan Hidup & Persampahan',
                'ringkasan' => 'Pengurangan timbulan sampah residu ke TPA Tamangapa melalui penukaran saldo digital sampah terpilah di tingkat RW.',
                'kebaruan' => 'Insentif saldo e-wallet untuk warga yang memilah sampah organik secara konsisten.',
                'skor_kematangan' => 78,
                'status_verifikasi' => 'Menunggu Verifikasi',
                'tahun_penerapan' => 2026,
            ],
        ];

        foreach ($samples as $sample) {
            InovasiDaerah::updateOrCreate(
                ['kode_inovasi' => $sample['kode_inovasi']],
                $sample
            );
        }
    }
}
