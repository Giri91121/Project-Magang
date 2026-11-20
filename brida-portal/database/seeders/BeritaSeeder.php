<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::first();
        if (!$admin) return;

        $articles = [
            [
                'judul' => 'BRIDA Kota Makassar Matangkan Rencana Induk Riset Daerah Menuju Makassar Rendah Karbon 2027',
                'slug' => 'brida-makassar-matangkan-rencana-induk-riset-daerah-rendah-karbon-2027',
                'kategori' => 'Kebijakan Riset',
                'ringkasan' => 'Pemerintah Kota Makassar melalui Badan Riset dan Inovasi Daerah (BRIDA) menggelar lokakarya strategis bersama pakar lingkungan, perwakilan perguruan tinggi, dan BRIN guna merumuskan Peta Jalan Riset Rendah Karbon (Low Carbon City).',
                'konten' => '<p>Pemerintah Kota Makassar melalui Badan Riset dan Inovasi Daerah (BRIDA) menggelar lokakarya strategis bersama pakar lingkungan, perwakilan perguruan tinggi, dan BRIN RI guna merumuskan Peta Jalan Riset Rendah Karbon (Low Carbon City) yang berbasis bukti ilmiah dan indikator terukur.</p><p>Kepala BRIDA Kota Makassar menegaskan bahwa seluruh program pembangunan strategis di Kota Makassar, mulai dari elektrifikasi armada transportasi umum hingga pengelolaan sampah sirkular di Lorong Wisata, wajib didasari oleh kajian saintifik yang mendalam.</p><p>"Kita ingin Makassar tidak sekadar bertransformasi menjadi kota cerdas (Smart City), tetapi juga kota yang tangguh terhadap perubahan iklim dan ramah generasi masa depan," tegasnya.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1200&q=80',
                'status' => 'Publikasi',
                'views' => 248,
                'published_at' => now()->subDays(2),
            ],
            [
                'judul' => 'Pendampingan Teknis Pengukuran Indeks Inovasi Daerah (IID) Lingkup Perangkat Daerah Kota Makassar',
                'slug' => 'pendampingan-teknis-pengukuran-indeks-inovasi-daerah-makassar',
                'kategori' => 'Inovasi Daerah',
                'ringkasan' => 'Fasilitator Inovasi BRIDA memberikan asistensi pengisian 20 indikator kematangan inovasi bagi operator OPD se-Kota Makassar sebagai persiapan penilaian Innovative Government Award (IGA) Kemendagri.',
                'konten' => '<p>Dalam rangka mempertahankan predikat Kota Sangat Inovatif pada ajang Innovative Government Award (IGA) Kementerian Dalam Negeri, BRIDA Kota Makassar menyelenggarakan bimbingan teknis intensif bagi seluruh inovator SKPD.</p><p>Kegiatan ini memfokuskan pada pemenuhan data dukung regulasi, video dokumentasi, hingga sertifikasi kemanfaatan inovasi bagi masyarakat lapis bawah di Kota Makassar.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=800&q=80',
                'status' => 'Publikasi',
                'views' => 185,
                'published_at' => now()->subDays(4),
            ],
            [
                'judul' => 'Kolaborasi Riset Terapan BRIDA dan Unhas dalam Tata Kelola UMKM Pesisir dan Kepulauan',
                'slug' => 'kolaborasi-riset-terapan-brida-unhas-umkm-pesisir-kepulauan',
                'kategori' => 'Kemitraan Kampus',
                'ringkasan' => 'Penandatanganan Perjanjian Kerjasama (PKS) pelaksanaan riset aksi pemberdayaan ekonomi masyarakat pulau dan peningkatan nilai tambah produk olahan perikanan tangkap.',
                'konten' => '<p>BRIDA Kota Makassar bersama Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM) Universitas Hasanuddin resmi menandatangani nota kesepahaman penelitian aksi di gugusan Kepulauan Sangkarrang.</p><p>Riset terapan ini bertujuan mengidentifikasi kendala rantai pasok dingin (cold chain) bagi nelayan tangkap pulau dan menghadirkan solusi teknologi tepat guna bertenaga surya.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80',
                'status' => 'Publikasi',
                'views' => 142,
                'published_at' => now()->subDays(7),
            ],
            [
                'judul' => 'Sosialisasi Fasilitasi Pendaftaran Hak Cipta dan Paten Sederhana bagi Inovator Muda Makassar',
                'slug' => 'sosialisasi-fasilitasi-hak-cipta-paten-inovator-muda-makassar',
                'kategori' => 'Agenda BRIDA',
                'ringkasan' => 'BRIDA memfasilitasi perlindungan kekayaan intelektual (HKI) tanpa dipungut biaya untuk riset teknologi dan karya inovasi karya pemuda serta ASN Pemerintah Kota.',
                'konten' => '<p>Perlindungan terhadap ide dan hak kekayaan intelektual (HKI) menjadi salah satu program unggulan BRIDA Kota Makassar tahun anggaran 2026.</p><p>Bekerjasama dengan Kantor Wilayah Kemenkumham Sulawesi Selatan, BRIDA membuka loket pendampingan pendaftaran hak cipta dan paten sederhana secara terpadu di Mall Pelayanan Publik (MPP) Balai Kota Makassar.</p>',
                'gambar_sampul' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?auto=format&fit=crop&w=800&q=80',
                'status' => 'Publikasi',
                'views' => 97,
                'published_at' => now()->subDays(10),
            ],
        ];

        foreach ($articles as $art) {
            $art['user_id'] = $admin->id;
            Berita::updateOrCreate(['slug' => $art['slug']], $art);
        }
    }
}
