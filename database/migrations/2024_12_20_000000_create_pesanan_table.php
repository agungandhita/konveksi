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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
            $table->string('nama_pemesan');
            $table->string('nomor_whatsapp');
            $table->integer('jumlah_order');
            $table->enum('ukuran_baju', ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL']);
            $table->string('ukuran_custom')->nullable();
            $table->string('file_desain_baju')->nullable();
            $table->boolean('tambahan_bordir')->default(false);
            $table->string('file_desain_bordir')->nullable();
            $table->text('keterangan_bordir')->nullable();
            $table->string('file_nama_tag')->nullable();
            $table->text('keterangan_tambahan')->nullable();
            $table->decimal('total_harga', 12, 2)->nullable();
            $table->enum('status', ['pending', 'menunggu_pembayaran', 'menunggu_verifikasi', 'diproses', 'selesai', 'dibatalkan'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
