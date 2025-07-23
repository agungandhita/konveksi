<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Layanan;
use App\Models\LayananHargaUkuran;

class LayananHargaUkuranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua layanan yang ada
        $layanan = Layanan::all();

        // Daftar ukuran dan harga default
        $ukuranHarga = [
            'XS' => 45000,
            'S' => 50000,
            'M' => 55000,
            'L' => 60000,
            'XL' => 65000,
            '2XL' => 70000,
            '3XL' => 75000,
            '4XL' => 80000
        ];

        foreach ($layanan as $item) {
            foreach ($ukuranHarga as $ukuran => $harga) {
                LayananHargaUkuran::create([
                    'layanan_id' => $item->id,
                    'ukuran' => $ukuran,
                    'harga' => $harga
                ]);
            }
        }
    }
}
