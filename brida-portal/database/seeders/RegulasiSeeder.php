<?php

namespace Database\Seeders;

use App\Models\Regulasi;
use App\Models\User;
use Illuminate\Database\Seeder;

class RegulasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        if (!$admin) return;

        $samples = [
            [
                'judul_regulasi' => 'Peraturan Walikota Makassar tentang Tata Kelola Inovasi Daerah',
                'nomor_peraturan' => 'Perwali No. 42 Tahun 2024',
                'kategori' => 'Peraturan Walikota',
                'tahun' => 2024,
                'tentang' => 'Pedoman pelaksanaan inisiasi, uji coba, penerapan, dan replikasi inovasi daerah di lingkungan Pemerintah Kota Makassar.',
                'file_dokumen' => null,
                'ukuran_file' => '2.4 MB',
                'download_count' => 142,
                'status' => 'Aktif',
            ],
            [
                'judul_regulasi' => 'Peraturan Daerah Kota Makassar tentang Pembentukan dan Susunan Perangkat Daerah BRIDA',
                'nomor_peraturan' => 'Perda No. 5 Tahun 2023',
                'kategori' => 'Peraturan Daerah',
                'tahun' => 2023,
                'tentang' => 'Dasar hukum pendirian Badan Riset dan Inovasi Daerah (BRIDA) sebagai unsur penunjang urusan pemerintahan daerah.',
                'file_dokumen' => null,
                'ukuran_file' => '4.1 MB',
                'download_count' => 289,
                'status' => 'Aktif',
            ],
            [
                'judul_regulasi' => 'Pedoman Standar Operasional Prosedur (SOP) Rekomendasi Izin Penelitian',
                'nomor_peraturan' => 'Keputusan Kepala BRIDA No. 12/2025',
                'kategori' => 'Pedoman Teknis',
                'tahun' => 2025,
                'tentang' => 'Alur dan persyaratan layanan penerbitan surat rekomendasi riset tugas akhir mahasiswa dan lembaga litbang.',
                'file_dokumen' => null,
                'ukuran_file' => '1.2 MB',
                'download_count' => 310,
                'status' => 'Aktif',
            ],
            [
                'judul_regulasi' => 'Daftar Informasi Publik Berkala dan Serta-Merta PPID BRIDA Kota Makassar',
                'nomor_peraturan' => 'SK PPID Pelaksana No. 04/2026',
                'kategori' => 'Dokumen PPID',
                'tahun' => 2026,
                'tentang' => 'Katalog keterbukaan informasi publik dan ringkasan laporan kinerja penelitian daerah semester I.',
                'file_dokumen' => null,
                'ukuran_file' => '1.8 MB',
                'download_count' => 88,
                'status' => 'Aktif',
            ],
        ];

        foreach ($samples as $reg) {
            $reg['user_id'] = $admin->id;
            Regulasi::updateOrCreate(['nomor_peraturan' => $reg['nomor_peraturan']], $reg);
        }
    }
}
