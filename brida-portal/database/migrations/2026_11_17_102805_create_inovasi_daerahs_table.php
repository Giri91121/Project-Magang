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
        Schema::create('inovasi_daerahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('kode_inovasi')->unique(); // e.g. INOV-MKS-001
            $table->string('nama_inovasi');
            $table->string('perangkat_daerah'); // OPD pengusul (e.g. Dinas Kesehatan, Dinas Pendidikan)
            $table->string('tahapan_inovasi')->default('Penerapan'); // Inisiatif, Uji Coba, Penerapan
            $table->string('inisiator')->default('OPD'); // OPD, Kepala Daerah, Anggota DPRD, ASN, Masyarakat
            $table->string('jenis_inovasi')->default('Digital'); // Digital atau Non-Digital
            $table->string('urusan_pemerintahan'); // Kesehatan, Pendidikan, Tata Kelola, Lingkungan
            $table->text('ringkasan'); // Deskripsi ide/latar belakang inovasi
            $table->text('kebaruan')->nullable(); // Unsur novelty/kebaruan
            $table->integer('skor_kematangan')->default(85); // Indeks kematangan IGA (0-130)
            $table->string('status_verifikasi')->default('Terverifikasi'); // Draft, Menunggu Verifikasi, Terverifikasi
            $table->year('tahun_penerapan')->default(2026);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inovasi_daerahs');
    }
};
