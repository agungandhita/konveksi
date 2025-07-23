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
        Schema::create('layanan_harga_ukuran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('layanan_id')->constrained('layanan')->onDelete('cascade');
            $table->enum('ukuran', ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL']);
            $table->decimal('harga', 12, 2);
            $table->timestamps();

            // Unique constraint untuk mencegah duplikasi ukuran pada layanan yang sama
            $table->unique(['layanan_id', 'ukuran']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_harga_ukuran');
    }
};
