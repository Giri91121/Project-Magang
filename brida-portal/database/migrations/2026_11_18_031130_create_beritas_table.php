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
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori')->default('Kebijakan Riset'); // Kebijakan Riset, Inovasi Daerah, Kemitraan Kampus, Agenda BRIDA
            $table->text('ringkasan');
            $table->longText('konten');
            $table->string('gambar_sampul')->nullable();
            $table->enum('status', ['Publikasi', 'Draft'])->default('Publikasi');
            $table->unsignedInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
