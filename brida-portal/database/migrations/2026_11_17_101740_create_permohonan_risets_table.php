<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permohonan_risets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nomor_registrasi')->unique(); // Contoh: RST-2026-001
            $table->string('nama_pemohon');
            $table->string('institusi'); // Kampus / Lembaga / Perguruan Tinggi
            $table->string('jurusan_fakultas')->nullable();
            $table->string('kontak_wa');
            $table->string('judul_penelitian');
            $table->string('bidang_fokus')->default('Sosial & Pemerintahan'); // Inovasi Daerah, Sains Teknologi, Kebijakan, dll.
            $table->string('lokasi_penelitian'); // Contoh: Lorong Wisata, Dinas Kesehatan, dll.
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('file_surat_pengantar')->nullable();
            $table->string('file_proposal')->nullable();
            $table->enum('status', ['Menunggu Review', 'Sedang Ditelaah', 'Disetujui', 'Ditolak'])->default('Menunggu Review');
            $table->text('catatan_reviewer')->nullable();
            $table->string('file_surat_rekomendasi')->nullable(); // Surat izin resmi yang diterbitkan BRIDA
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_risets');
    }
};
