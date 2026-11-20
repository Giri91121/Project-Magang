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
        // 1. Tabel Menu Navbar & Submenu Dropdown
        Schema::create('navbar_menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('navbar_menus')->onDelete('cascade');
            $table->string('label');
            $table->string('url')->default('#');
            $table->string('icon')->nullable(); // Contoh: fa-solid fa-landmark
            $table->boolean('target_blank')->default(false); // Buka di tab baru
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Tabel Gambar Slideshow Background Hero Beranda
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('judul_alt')->nullable();
            $table->string('gambar_path');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 3. Tabel Kartu Layanan Utama di Beranda
        Schema::create('landing_services', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('icon')->default('fa-solid fa-microscope');
            $table->string('link_text')->default('Selengkapnya');
            $table->string('link_url')->default('/layanan');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_services');
        Schema::dropIfExists('hero_slides');
        Schema::dropIfExists('navbar_menus');
    }
};
