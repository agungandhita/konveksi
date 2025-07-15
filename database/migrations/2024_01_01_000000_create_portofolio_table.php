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
        Schema::create('portofolio', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi_singkat')->nullable();
            $table->string('gambar_utama')->nullable();
            $table->string('video_url')->nullable(); // YouTube URL
            $table->string('video_file')->nullable(); // Uploaded video file path
            $table->date('tanggal_proyek');
            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->timestamps();
            
            // Indexes for better performance
            $table->index('status');
            $table->index('tanggal_proyek');
            $table->index(['status', 'tanggal_proyek']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portofolio');
    }
};