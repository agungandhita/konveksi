<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Layanan;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $layanan = [
            [
                'nama_layanan' => 'Sablon Kaos',
                'deskripsi_singkat' => 'Layanan sablon untuk kaos dengan berbagai desain dan warna. Menggunakan tinta berkualitas tinggi yang tahan lama.',
                'estimasi_waktu' => 3,
                'minimal_order' => 10,
                'satuan_order' => 'pcs',
                'perkiraan_harga' => 25000,
                'status' => 'aktif'
            ],
            [
                'nama_layanan' => 'Bordir Kemeja',
                'deskripsi_singkat' => 'Layanan bordir untuk kemeja dengan logo atau nama perusahaan. Hasil rapi dan berkualitas tinggi.',
                'estimasi_waktu' => 5,
                'minimal_order' => 5,
                'satuan_order' => 'pcs',
                'perkiraan_harga' => 45000,
                'status' => 'aktif'
            ],
            [
                'nama_layanan' => 'Jahit Seragam Sekolah',
                'deskripsi_singkat' => 'Pembuatan seragam sekolah lengkap dengan standar yang telah ditentukan. Bahan berkualitas dan jahitan rapi.',
                'estimasi_waktu' => 14,
                'minimal_order' => 20,
                'satuan_order' => 'pcs',
                'perkiraan_harga' => 85000,
                'status' => 'aktif'
            ],
            [
                'nama_layanan' => 'Konveksi Jaket',
                'deskripsi_singkat' => 'Pembuatan jaket custom dengan berbagai model dan bahan. Cocok untuk organisasi, komunitas, atau perusahaan.',
                'estimasi_waktu' => 10,
                'minimal_order' => 15,
                'satuan_order' => 'pcs',
                'perkiraan_harga' => 120000,
                'status' => 'aktif'
            ],
            [
                'nama_layanan' => 'Sablon Tote Bag',
                'deskripsi_singkat' => 'Layanan sablon untuk tote bag dengan desain custom. Cocok untuk souvenir atau merchandise.',
                'estimasi_waktu' => 2,
                'minimal_order' => 50,
                'satuan_order' => 'pcs',
                'perkiraan_harga' => 15000,
                'status' => 'aktif'
            ],
            [
                'nama_layanan' => 'Konveksi Celana Kerja',
                'deskripsi_singkat' => 'Pembuatan celana kerja dengan berbagai ukuran dan model. Bahan berkualitas dan nyaman digunakan.',
                'estimasi_waktu' => 7,
                'minimal_order' => 10,
                'satuan_order' => 'pcs',
                'perkiraan_harga' => 75000,
                'status' => 'aktif'
            ],
            [
                'nama_layanan' => 'Bordir Topi',
                'deskripsi_singkat' => 'Layanan bordir untuk topi dengan logo atau tulisan custom. Hasil bordir rapi dan tahan lama.',
                'estimasi_waktu' => 3,
                'minimal_order' => 25,
                'satuan_order' => 'pcs',
                'perkiraan_harga' => 35000,
                'status' => 'aktif'
            ],
            [
                'nama_layanan' => 'Jahit Baju Batik',
                'deskripsi_singkat' => 'Pembuatan baju batik dengan model modern dan tradisional. Menggunakan kain batik berkualitas.',
                'estimasi_waktu' => 12,
                'minimal_order' => 8,
                'satuan_order' => 'pcs',
                'perkiraan_harga' => 95000,
                'status' => 'non-aktif'
            ],
            [
                'nama_layanan' => 'Konveksi Masker Kain',
                'deskripsi_singkat' => 'Pembuatan masker kain dengan berbagai motif dan warna. Bahan yang nyaman dan dapat dicuci.',
                'estimasi_waktu' => 1,
                'minimal_order' => 100,
                'satuan_order' => 'pcs',
                'perkiraan_harga' => 8000,
                'status' => 'non-aktif'
            ],
            [
                'nama_layanan' => 'Sablon Jersey Tim',
                'deskripsi_singkat' => 'Layanan sablon untuk jersey tim olahraga dengan nomor punggung dan nama pemain.',
                'estimasi_waktu' => 4,
                'minimal_order' => 11,
                'satuan_order' => 'pcs',
                'perkiraan_harga' => 55000,
                'status' => 'aktif'
            ]
        ];

        foreach ($layanan as $item) {
            Layanan::create($item);
        }
    }
}