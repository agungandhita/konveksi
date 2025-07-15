# Katalog Produk - Website Konveksi

## Fitur yang Telah Dibuat

### 1. Halaman Katalog Produk (`/katalog`)
- **URL**: `http://localhost:8000/katalog`
- **Tampilan**: Grid responsif dengan 3 kolom di desktop, 2 kolom di tablet, 1 kolom di mobile
- **Fitur**:
  - Gambar produk dengan efek hover
  - Nama produk (dapat diklik untuk detail)
  - Harga dalam format Rupiah
  - Deskripsi singkat (maksimal 3 baris)
  - Tombol "Beli Sekarang" dengan deteksi platform:
    - WhatsApp: Tombol hijau dengan ikon WhatsApp
    - Tokopedia: Tombol dengan ikon shopping cart
    - Shopee: Tombol dengan ikon shopping bag
    - Link lainnya: Tombol umum "Beli Sekarang"

### 2. Halaman Detail Produk (`/katalog/{id}`)
- **URL**: `http://localhost:8000/katalog/{id}`
- **Fitur**:
  - Gambar produk besar
  - Informasi lengkap produk
  - Breadcrumb navigation
  - Tombol kembali ke katalog
  - Tombol pembelian yang sama seperti di katalog

### 3. Data Dummy Produk
Telah dibuat 6 produk contoh:
1. **Kaos Polos Cotton Combed 30s** - Rp 45.000
2. **Hoodie Premium Fleece** - Rp 125.000
3. **Masker Kain 3 Lapis** - Rp 15.000
4. **Polo Shirt Lacoste** - Rp 85.000
5. **Jaket Bomber Custom** - Rp 175.000
6. **Kemeja Flanel Kotak-kotak** - Rp 95.000

## File yang Dibuat/Dimodifikasi

### Controllers
- `app/Http/Controllers/frontend/KatalogController.php`

### Views
- `resources/views/frontend/katalog/index.blade.php` - Halaman utama katalog
- `resources/views/frontend/katalog/detail.blade.php` - Halaman detail produk

### Routes
- Ditambahkan di `routes/web.php`:
  - `GET /katalog` → `KatalogController@index`
  - `GET /katalog/{id}` → `KatalogController@show`

### Database
- `database/seeders/ProdukSeeder.php` - Data dummy produk
- Diupdate `database/seeders/DatabaseSeeder.php`

### Assets
- `public/img/no-image.svg` - Default image untuk produk tanpa foto

### Models
- Diupdate `app/Models/Produk.php` untuk menggunakan SVG default image

## Cara Menggunakan

1. **Menjalankan Server**:
   ```bash
   php artisan serve
   ```

2. **Mengakses Katalog**:
   - Buka browser dan kunjungi: `http://localhost:8000/katalog`

3. **Menambah Data Produk**:
   - Gunakan admin panel atau tambahkan manual ke database
   - Pastikan status produk = 'aktif' agar muncul di katalog

## Desain & Responsivitas

- **Mobile-First Design**: Tampilan optimal di semua ukuran layar
- **Modern UI**: Menggunakan gradient, shadow, dan animasi hover
- **Color Scheme**: 
  - Primary: #2c3e50 (Navy)
  - Secondary: #3498db (Blue)
  - Accent: #e74c3c (Red)
  - WhatsApp: #25d366 (Green)
- **Typography**: Segoe UI font family
- **Icons**: Font Awesome 6.0
- **Framework**: Bootstrap 5.3

## Fitur Khusus

1. **Auto-detect Platform**: Sistem otomatis mendeteksi jenis link pembelian dan menampilkan ikon yang sesuai
2. **Responsive Images**: Gambar produk otomatis menyesuaikan ukuran layar
3. **Hover Effects**: Animasi smooth saat hover pada card produk
4. **Default Image**: SVG placeholder untuk produk tanpa foto
5. **SEO Friendly**: Meta tags dan struktur HTML yang baik

## Customization

- **Warna**: Edit CSS variables di bagian `:root`
- **Layout**: Ubah grid classes Bootstrap untuk mengatur jumlah kolom
- **WhatsApp Number**: Ganti nomor di link WhatsApp default
- **Styling**: Semua style ada di dalam file blade, mudah untuk dikustomisasi