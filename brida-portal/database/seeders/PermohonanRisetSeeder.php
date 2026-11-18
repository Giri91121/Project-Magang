<?php

namespace Database\Seeders;

use App\Models\PermohonanRiset;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermohonanRisetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemohon = User::role('Pemohon')->first() ?? User::first();
        if (!$pemohon) return;

        $samples = [
            [
                'user_id' => $pemohon->id,
                'nomor_registrasi' => 'RST-2026-089',
                'nama_pemohon' => 'Andi Muhammad Ilham',
                'institusi' => 'Universitas Hasanuddin (Unhas)',
                'jurusan_fakultas' => 'Teknik Sipil / Perencanaan Wilayah Kota',
                'kontak_wa' => '081234567890',
                'judul_penelitian' => 'Kajian Transformasi Transportasi Publik Rendah Karbon Kota Makassar',
                'bidang_fokus' => 'Infrastruktur & Lingkungan Hidup',
                'lokasi_penelitian' => 'Dinas Perhubungan & Koridor Teman Bus Makassar',
                'tanggal_mulai' => '2026-12-01',
                'tanggal_selesai' => '2027-02-28',
                'status' => 'Menunggu Review',
                'catatan_reviewer' => 'Menunggu verifikasi lampiran surat pengantar kampus dari sub-bidang pengkajian.',
            ],
            [
                'user_id' => $pemohon->id,
                'nomor_registrasi' => 'RST-2026-088',
                'nama_pemohon' => 'Nurul Aulia Rahman',
                'institusi' => 'Universitas Negeri Makassar (UNM)',
                'jurusan_fakultas' => 'Pendidikan Ekonomi & Bisnis',
                'kontak_wa' => '082198765432',
                'judul_penelitian' => 'Efektivitas Program Lorong Wisata terhadap Kesejahteraan UMKM Pesisir',
                'bidang_fokus' => 'Ekonomi Kreatif & UMKM',
                'lokasi_penelitian' => 'Lorong Wisata Kec. Ujung Pandang & Kec. Tallo',
                'tanggal_mulai' => '2026-11-20',
                'tanggal_selesai' => '2027-01-20',
                'status' => 'Sedang Ditelaah',
                'catatan_reviewer' => 'Proposal telah didisposisikan ke Peneliti Bidang Sosial Ekonomi.',
            ],
            [
                'user_id' => $pemohon->id,
                'nomor_registrasi' => 'RST-2026-087',
                'nama_pemohon' => 'Tim Riset Fakultas Kedokteran Unhas',
                'institusi' => 'Universitas Hasanuddin',
                'jurusan_fakultas' => 'Kedokteran Komunitas & Gizi',
                'kontak_wa' => '085244556677',
                'judul_penelitian' => 'Pemetaan Stunting dan Intervensi Nutrisi Cerdas di Wilayah Kepulauan Sangkarrang',
                'bidang_fokus' => 'Kesehatan Masyarakat',
                'lokasi_penelitian' => 'Puskesmas Pulau Barrang Lompo & Kantor Camat Sangkarrang',
                'tanggal_mulai' => '2026-11-15',
                'tanggal_selesai' => '2027-03-15',
                'status' => 'Disetujui',
                'catatan_reviewer' => 'Surat rekomendasi resmi telah ditandatangani dan diterbitkan.',
            ],
            [
                'user_id' => $pemohon->id,
                'nomor_registrasi' => 'RST-2026-086',
                'nama_pemohon' => 'Bappeda Litbang Kota Parepare',
                'institusi' => 'Pemerintah Kota Parepare',
                'jurusan_fakultas' => 'Bidang Penelitian & Pengembangan',
                'kontak_wa' => '081144002211',
                'judul_penelitian' => 'Studi Komparasi Kebijakan Lorong Wisata untuk Pengentasan Kemiskinan Ekstrem',
                'bidang_fokus' => 'Sosial & Pemerintahan',
                'lokasi_penelitian' => 'Kantor BRIDA Kota Makassar & Bappeda Makassar',
                'tanggal_mulai' => '2026-10-10',
                'tanggal_selesai' => '2026-11-10',
                'status' => 'Disetujui',
                'catatan_reviewer' => 'Pelaksanaan riset telah selesai dan laporan kajian telah diserahkan.',
            ],
        ];

        foreach ($samples as $sample) {
            PermohonanRiset::updateOrCreate(
                ['nomor_registrasi' => $sample['nomor_registrasi']],
                $sample
            );
        }
    }
}
