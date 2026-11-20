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
        Schema::create('regulasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('judul_regulasi');
            $table->string('nomor_peraturan'); // e.g. Peraturan Walikota No. 42 Tahun 2024
            $table->string('kategori'); // Peraturan Walikota, Peraturan Daerah, Keputusan Walikota, Pedoman Teknis, Dokumen PPID
            $table->year('tahun')->default(2026);
            $table->text('tentang'); // Deskripsi pokok bahasan regulasi
            $table->string('file_dokumen')->nullable(); // Path PDF
            $table->string('ukuran_file')->nullable(); // e.g. 1.8 MB
            $table->unsignedInteger('download_count')->default(0);
            $table->enum('status', ['Aktif', 'Draft'])->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regulasis');
    }
};
