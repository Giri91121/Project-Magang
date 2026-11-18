<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Rekomendasi Riset - {{ $permohonan->nomor_registrasi }}</title>
    <!-- Google Fonts: Times New Roman Style atau Serif Resmi -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Times New Roman', Times, serif; }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; padding: 0; background: white; }
            @page { size: A4; margin: 20mm; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 min-h-screen py-8">

    <!-- Tombol Aksi Cetak di Browser (Sembunyi saat cetak / Save as PDF) -->
    <div class="max-w-3xl mx-auto mb-6 px-4 no-print flex items-center justify-between font-sans">
        <a href="{{ route('dashboard.riset.show', $permohonan->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-slate-900 bg-white border border-slate-300 px-4 py-2 rounded-xl shadow-sm">
            ← Kembali ke Dashboard
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-2 bg-rose-700 hover:bg-rose-800 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-md">
            🖨️ Cetak / Unduh Dokumen Resmi (PDF)
        </button>
    </div>

    <!-- Kertas Surat Resmi Standar A4 -->
    <div class="max-w-3xl mx-auto bg-white p-10 sm:p-14 border border-slate-300 shadow-xl print:shadow-none print:border-none">
        
        <!-- Kop Surat Resmi Pemerintah Kota Makassar -->
        <div class="border-b-4 border-double border-slate-900 pb-3 text-center relative">
            <img src="{{ asset('images/LOGO-FIX-BRIDA.png') }}" alt="Logo BRIDA Makassar" class="h-16 w-auto absolute left-2 top-1 object-contain hidden sm:block">
            <h3 class="text-sm sm:text-base font-bold tracking-wide uppercase">Pemerintah Kota Makassar</h3>
            <h2 class="text-lg sm:text-xl font-black uppercase tracking-wider">Badan Riset dan Inovasi Daerah</h2>
            <h2 class="text-xl sm:text-2xl font-black uppercase tracking-widest text-slate-900">( B R I D A )</h2>
            <p class="text-[11px] sm:text-xs text-slate-600 mt-1 font-sans">
                Jl. Ahmad Yani No. 2, Baru, Kec. Ujung Pandang, Balai Kota Makassar, Sulawesi Selatan 90111<br>
                Laman: https://brida.makassarkota.go.id | Surel: brida@makassarkota.go.id
            </p>
        </div>

        <!-- Nomor & Perihal Surat -->
        <div class="mt-6 text-center">
            <h4 class="text-base font-bold uppercase underline tracking-wider">Surat Rekomendasi Penelitian</h4>
            <p class="text-xs text-slate-700 mt-0.5">Nomor: {{ $permohonan->nomor_registrasi }}/BRIDA-MKS/{{ date('Y') }}</p>
        </div>

        <!-- Isi Surat Rekomendasi -->
        <div class="mt-6 space-y-4 text-xs sm:text-sm leading-relaxed text-justify">
            <p>
                Kepala Badan Riset dan Inovasi Daerah (BRIDA) Kota Makassar, berdasarkan permohonan yang diajukan oleh pemohon dan hasil telaah teknis keselarasan substansi kajian dengan program pembangunan daerah, dengan ini memberikan <strong>REKOMENDASI PENELITIAN</strong> kepada:
            </p>

            <table class="w-full border-collapse my-2 ml-4">
                <tr>
                    <td class="w-36 py-1 font-bold">Nama Peneliti</td>
                    <td class="w-4 py-1">:</td>
                    <td class="py-1 font-bold text-slate-900">{{ $permohonan->nama_pemohon }}</td>
                </tr>
                <tr>
                    <td class="py-1">Institusi / Lembaga</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $permohonan->institusi }}</td>
                </tr>
                <tr>
                    <td class="py-1">Program Studi / Fakultas</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $permohonan->jurusan_fakultas ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="py-1">Nomor Kontak / WhatsApp</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $permohonan->kontak_wa }}</td>
                </tr>
                <tr>
                    <td class="py-1 align-top font-bold">Judul Penelitian</td>
                    <td class="py-1 align-top">:</td>
                    <td class="py-1 align-top font-semibold text-slate-900 italic">"{{ $permohonan->judul_penelitian }}"</td>
                </tr>
                <tr>
                    <td class="py-1">Bidang Fokus Inovasi</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $permohonan->bidang_fokus }}</td>
                </tr>
                <tr>
                    <td class="py-1">Lokasi Penelitian</td>
                    <td class="py-1">:</td>
                    <td class="py-1">{{ $permohonan->lokasi_penelitian }}</td>
                </tr>
                <tr>
                    <td class="py-1">Waktu Pelaksanaan</td>
                    <td class="py-1">:</td>
                    <td class="py-1">
                        {{ $permohonan->tanggal_mulai ? date('d F Y', strtotime($permohonan->tanggal_mulai)) : '1 Desember 2026' }}
                        s/d 
                        {{ $permohonan->tanggal_selesai ? date('d F Y', strtotime($permohonan->tanggal_selesai)) : '28 Februari 2027' }}
                    </td>
                </tr>
            </table>

            <p>
                Dengan ketentuan sebagai berikut:
            </p>
            <ol class="list-decimal pl-6 space-y-1 text-xs">
                <li>Sebelum melaksanakan kegiatan penelitian, peneliti wajib melapor kepada pimpinan instansi / perangkat daerah pada lokasi penelitian yang bersangkutan.</li>
                <li>Penelitian tidak menyimpang dari judul dan rencana penelitian yang telah diajukan.</li>
                <li>Mentaati seluruh norma kearifan lokal, etika ilmiah, dan ketentuan perundang-undangan yang berlaku di wilayah Kota Makassar.</li>
                <li>Menyerahkan 1 (satu) eksemplar salinan laporan hasil penelitian / naskah kebijakan kepada Kepala BRIDA Kota Makassar setelah penelitian selesai dilaksanakan.</li>
            </ol>

            <p class="pt-2">
                Demikian surat rekomendasi penelitian ini diberikan untuk dipergunakan sebagaimana mestinya dan kepada instansi terkait dimohon kerjasamanya guna kelancaran pelaksanaan penelitian ini.
            </p>
        </div>

        <!-- Tanda Tangan Resmi & QR Code Keabsahan -->
        <div class="mt-10 flex justify-between items-end">
            <!-- QR Code Validasi Digital -->
            <div class="text-center font-sans border border-slate-300 p-2 rounded-lg bg-slate-50 text-[10px]">
                <div class="w-20 h-20 bg-slate-200 mx-auto flex items-center justify-center font-mono font-bold text-slate-700">
                    [QR VALID]
                </div>
                <span class="block mt-1 font-bold text-slate-800">Verifikasi Digital</span>
                <span class="text-slate-500 font-mono">{{ $permohonan->nomor_registrasi }}</span>
            </div>

            <!-- Bagian Pejabat Penandatangan -->
            <div class="text-center w-64 text-xs">
                <p>Makassar, {{ date('d F Y') }}</p>
                <p class="font-bold mt-1 uppercase">Kepala Badan Riset dan Inovasi Daerah<br>Kota Makassar</p>
                
                <div class="h-16 flex items-center justify-center font-sans text-slate-400 italic text-[11px]">
                    ( Ditandatangani secara elektronik )
                </div>

                <p class="font-bold underline text-sm uppercase">Nirman Mungkasa, S.T., M.Si.</p>
                <p class="text-[11px] text-slate-600">Pembina Utama Muda / IV c</p>
                <p class="text-[11px] text-slate-600">NIP. 19740512 199903 1 004</p>
            </div>
        </div>

    </div>

</body>
</html>
