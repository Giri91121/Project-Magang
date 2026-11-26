<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('struktur_organisasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('struktur_organisasis')->nullOnDelete();
            $table->string('jabatan', 255);
            $table->string('nama_pejabat', 255)->nullable();
            $table->string('nip', 50)->nullable();
            $table->string('foto', 255)->nullable();
            $table->enum('tipe_garis', ['komando', 'koordinasi'])->default('komando');
            $table->string('warna_badge', 30)->default('maroon');
            $table->text('deskripsi')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('struktur_organisasis');
    }
};
