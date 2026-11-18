<?php

namespace App\Http\Controllers;

use App\Models\PermohonanRiset;
use App\Models\InovasiDaerah;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * Tampilkan cetak Surat Rekomendasi Resmi BRIDA (Print / Save as PDF via Browser)
     */
    public function printSuratRekomendasi($id)
    {
        $permohonan = PermohonanRiset::with('user')->findOrFail($id);

        ActivityLog::log('print_surat', "Mencetak Surat Rekomendasi Riset {$permohonan->nomor_registrasi} untuk {$permohonan->nama_pemohon}", $permohonan);

        return view('dashboard.riset.surat-rekomendasi', compact('permohonan'));
    }

    /**
     * Ekspor Daftar Permohonan Riset ke CSV / Excel
     */
    public function exportRisetCsv(): StreamedResponse
    {
        ActivityLog::log('export_csv', "Mengekspor data permohonan riset ke format CSV");

        $fileName = 'Rekap_Permohonan_Riset_BRIDA_Makassar_' . date('Y-m-d') . '.csv';
        $permohonan = PermohonanRiset::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($permohonan) {
            $handle = fopen('php://output', 'w');
            
            // UTF-8 BOM untuk kompatibilitas Microsoft Excel
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header Kolom CSV
            fputcsv($handle, [
                'No.',
                'Nomor Registrasi',
                'Nama Pemohon',
                'Institusi / Kampus',
                'Fakultas / Prodi',
                'Kontak WA',
                'Judul Penelitian',
                'Bidang Fokus',
                'Lokasi Penelitian',
                'Status',
                'Tanggal Masuk',
                'Catatan Reviewer',
            ]);

            foreach ($permohonan as $index => $item) {
                fputcsv($handle, [
                    $index + 1,
                    $item->nomor_registrasi,
                    $item->nama_pemohon,
                    $item->institusi,
                    $item->jurusan_fakultas ?? '-',
                    $item->kontak_wa,
                    $item->judul_penelitian,
                    $item->bidang_fokus,
                    $item->lokasi_penelitian,
                    $item->status,
                    $item->created_at->format('Y-m-d H:i'),
                    $item->catatan_reviewer ?? '-',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Ekspor Katalog Inovasi Daerah ke CSV / Excel
     */
    public function exportInovasiCsv(): StreamedResponse
    {
        ActivityLog::log('export_csv', "Mengekspor katalog inovasi daerah ke format CSV");

        $fileName = 'Katalog_Inovasi_Daerah_BRIDA_Makassar_' . date('Y-m-d') . '.csv';
        $inovasi = InovasiDaerah::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($inovasi) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($handle, [
                'No.',
                'Kode Inovasi',
                'Nama Inovasi',
                'Perangkat Daerah (OPD)',
                'Tahapan',
                'Bentuk Inovasi',
                'Inisiator',
                'Urusan Pemerintahan',
                'Skor Kematangan (0-130)',
                'Tahun Penerapan',
                'Ringkasan',
            ]);

            foreach ($inovasi as $index => $item) {
                fputcsv($handle, [
                    $index + 1,
                    $item->kode_inovasi,
                    $item->nama_inovasi,
                    $item->perangkat_daerah,
                    $item->tahapan_inovasi,
                    $item->jenis_inovasi,
                    $item->inisiator,
                    $item->urusan_pemerintahan,
                    $item->skor_kematangan,
                    $item->tahun_penerapan,
                    $item->ringkasan,
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
