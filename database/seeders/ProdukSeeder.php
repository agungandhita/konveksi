<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $produk = [
            [
                'nama_produk' => 'Kaos Polos Cotton Combed 30s',
                'deskripsi_singkat' => 'Kaos polos berkualitas tinggi dengan bahan cotton combed 30s yang nyaman dan tidak mudah kusut. Tersedia berbagai warna dan ukuran.',
                'harga' => 45000,
                'foto_produk' => null,
                'link_pembelian' => 'https://wa.me/6281234567890?text=Halo, saya tertarik dengan Kaos Polos Cotton Combed 30s',
                'status' => 'aktif'
            ],
            [
                'nama_produk' => 'Hoodie Premium Fleece',
                'deskripsi_singkat' => 'Hoodie premium dengan bahan fleece berkualitas tinggi, hangat dan nyaman dipakai. Cocok untuk cuaca dingin dan gaya kasual.',
                'harga' => 125000,
                'foto_produk' => null,
                'link_pembelian' => 'https://wa.me/6281234567890?text=Halo, saya tertarik dengan Hoodie Premium Fleece',
                'status' => 'aktif'
            ],
            [
                'nama_produk' => 'Masker Kain 3 Lapis',
                'deskripsi_singkat' => 'Masker kain 3 lapis dengan bahan katun berkualitas, nyaman digunakan sehari-hari. Dapat dicuci dan digunakan berulang kali.',
                'harga' => 15000,
                'foto_produk' => null,
                'link_pembelian' => 'https://shopee.co.id/masker-kain-3-lapis',
                'status' => 'aktif'
            ],
            [
                'nama_produk' => 'Polo Shirt Lacoste',
                'deskripsi_singkat' => 'Polo shirt dengan desain klasik dan elegan, cocok untuk acara formal maupun kasual. Bahan berkualitas tinggi dan tahan lama.',
                'harga' => 85000,
                'foto_produk' => null,
                'link_pembelian' => 'https://tokopedia.com/polo-shirt-lacoste',
                'status' => 'aktif'
            ],
            [
                'nama_produk' => 'Jaket Bomber Custom',
                'deskripsi_singkat' => 'Jaket bomber dengan desain custom sesuai keinginan. Bahan parasut berkualitas tinggi, ringan namun hangat dan tahan angin.',
                'harga' => 175000,
                'foto_produk' => null,
                'link_pembelian' => 'https://wa.me/6281234567890?text=Halo, saya tertarik dengan Jaket Bomber Custom',
                'status' => 'aktif'
            ],
            [
                'nama_produk' => 'Kemeja Flanel Kotak-kotak',
                'deskripsi_singkat' => 'Kemeja flanel dengan motif kotak-kotak yang trendy. Bahan flanel berkualitas, nyaman dan cocok untuk gaya kasual maupun semi formal.',
                'harga' => 95000,
                'foto_produk' => null,
                'link_pembelian' => 'https://wa.me/6281234567890?text=Halo, saya tertarik dengan Kemeja Flanel Kotak-kotak',
                'status' => 'aktif'
            ]
        ];

        foreach ($produk as $item) {
            Produk::create($item);
        }
    }
}