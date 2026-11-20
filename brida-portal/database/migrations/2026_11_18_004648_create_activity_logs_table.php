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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('action'); // e.g. login, create_riset, update_status, create_inovasi, change_role
            $table->string('subject_type')->nullable(); // e.g. PermohonanRiset, InovasiDaerah, User
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->text('description'); // e.g. "Pemohon mengajukan berkas riset RST-2026-089"
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
