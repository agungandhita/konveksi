# Dokumentasi Teknis Fitur Portofolio / Galeri

## 1. Nama Menu
**Kelola Portofolio**

## 2. Deskripsi Tujuan
Fitur ini memungkinkan admin untuk mengelola dan menampilkan hasil produksi berupa foto, testimoni, dan video di halaman depan website sebagai bukti profesionalitas dan kualitas pekerjaan konveksi. Galeri portofolio berfungsi sebagai showcase untuk menarik calon pelanggan dengan menampilkan hasil kerja terbaik.

## 3. Fitur Utama

### 3.1 Manajemen Portofolio
- ✅ **Tambah Portofolio Baru** - Menambahkan hasil pekerjaan baru ke galeri
- ✅ **Edit Portofolio** - Mengubah informasi portofolio yang sudah ada
- ✅ **Hapus Portofolio** - Menghapus portofolio beserta file terkait
- ✅ **Unggah Foto / Video** - Upload gambar dan video (file atau YouTube)
- ✅ **Kelola Testimoni Klien** - Menambah dan mengelola testimoni pelanggan
- ✅ **Status Tampilkan / Sembunyikan** - Mengatur visibilitas portofolio

### 3.2 Fitur Tambahan
- ✅ **Filter berdasarkan tanggal / status** - Pencarian dan filter lanjutan
- ✅ **Pencarian berdasarkan judul** - Pencarian berdasarkan judul dan deskripsi
- ✅ **Preview galeri sebelum publish** - Melihat tampilan galeri seperti pengunjung
- ✅ **Bulk Actions** - Aksi massal untuk mengaktifkan, menonaktifkan, atau menghapus

## 4. Field/Form Input

### 4.1 Field Wajib
| Field | Tipe | Deskripsi | Validasi |
|-------|------|-----------|----------|
| **Judul Portofolio** | Text | Nama/judul hasil pekerjaan | Required, max 255 karakter |
| **Tanggal Proyek** | Date | Tanggal penyelesaian proyek | Required, format Y-m-d |
| **Status Tampilkan** | Select | Aktif/Non-aktif | Required, enum: aktif/non-aktif |

### 4.2 Field Opsional
| Field | Tipe | Deskripsi | Validasi |
|-------|------|-----------|----------|
| **Deskripsi Singkat** | Textarea | Penjelasan hasil pekerjaan | Max 1000 karakter |
| **Gambar Utama** | File Upload | Foto utama portofolio | JPG/PNG, max 2MB |
| **Video URL** | URL | Link YouTube | Format URL valid |
| **Video File** | File Upload | Upload video langsung | MP4/AVI/MOV/WMV, max 10MB |
| **Nama Pelanggan** | Text | Nama pemberi testimoni | Max 255 karakter |
| **Komentar Testimoni** | Textarea | Review/komentar pelanggan | Max 1000 karakter |

## 5. Validasi & Batasan

### 5.1 Validasi File
- **Gambar**: Format JPG, PNG, JPEG maksimal 2MB
- **Video**: Format MP4, AVI, MOV, WMV maksimal 10MB
- **Video URL**: Harus berupa URL YouTube yang valid

### 5.2 Validasi Testimoni
- Jika mengisi testimoni, nama dan komentar harus diisi keduanya
- Tidak boleh hanya mengisi salah satu field testimoni

### 5.3 Validasi Umum
- Judul portofolio wajib diisi
- Tanggal proyek wajib diisi
- Status wajib dipilih
- Deskripsi maksimal 1000 karakter

## 6. Tampilan Daftar di Admin

### 6.1 Format Tampilan
**Grid/Card View** dengan informasi:
- Thumbnail gambar/video dengan indikator media
- Judul portofolio
- Tanggal proyek (format: d M Y)
- Status (badge aktif/non-aktif)
- Preview testimoni (jika ada)
- Aksi: Lihat, Edit, Hapus

### 6.2 Fitur Daftar
- **Pencarian**: Berdasarkan judul, deskripsi, dan testimoni
- **Filter Status**: Aktif, Non-aktif, Semua
- **Filter Tanggal**: Rentang tanggal proyek
- **Bulk Actions**: Aktifkan, Non-aktifkan, Hapus
- **Pagination**: 12 item per halaman
- **Sorting**: Berdasarkan tanggal terbaru

## 7. Struktur Database

### 7.1 Tabel: `portofolio`
```sql
CREATE TABLE portofolio (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    deskripsi_singkat TEXT NULL,
    gambar_utama VARCHAR(255) NULL,
    video_url VARCHAR(255) NULL,
    video_file VARCHAR(255) NULL,
    testimoni_nama VARCHAR(255) NULL,
    testimoni_komentar TEXT NULL,
    tanggal_proyek DATE NOT NULL,
    status ENUM('aktif', 'non-aktif') DEFAULT 'aktif',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    
    INDEX idx_status (status),
    INDEX idx_tanggal_proyek (tanggal_proyek),
    INDEX idx_status_tanggal (status, tanggal_proyek)
);
```

## 8. Struktur File

### 8.1 Model
- `app/Models/Portofolio.php` - Eloquent model dengan accessor dan scope

### 8.2 Controller
- `app/Http/Controllers/admin/PortoflioController.php` - CRUD dan bulk actions

### 8.3 Views
- `resources/views/admin/portofolio/index.blade.php` - Daftar portofolio
- `resources/views/admin/portofolio/create.blade.php` - Form tambah
- `resources/views/admin/portofolio/edit.blade.php` - Form edit
- `resources/views/admin/portofolio/show.blade.php` - Detail portofolio
- `resources/views/admin/portofolio/preview.blade.php` - Preview galeri

### 8.4 Migration
- `database/migrations/2024_01_01_000000_create_portofolio_table.php`

### 8.5 Routes
```php
// Resource routes
Route::resource('admin/portofolio', PortoflioController::class);

// Additional routes
Route::post('admin/portofolio/bulk-action', [PortoflioController::class, 'bulkAction']);
Route::get('admin/portofolio-preview', [PortoflioController::class, 'preview']);
```

## 9. Fitur Keamanan

### 9.1 File Upload Security
- Validasi tipe file yang diizinkan
- Pembatasan ukuran file
- Penyimpanan file di storage yang aman
- Penghapusan file lama saat update/delete

### 9.2 Input Validation
- CSRF protection pada semua form
- Server-side validation untuk semua input
- XSS protection dengan escape output
- SQL injection protection dengan Eloquent ORM

## 10. Performa & Optimasi

### 10.1 Database
- Index pada kolom yang sering dicari (status, tanggal_proyek)
- Pagination untuk menghindari load data berlebihan
- Eager loading untuk relasi (jika ada)

### 10.2 File Storage
- Kompresi gambar otomatis (opsional)
- Lazy loading untuk gambar di grid view
- CDN ready untuk file static

## 11. User Experience

### 11.1 Interface
- Responsive design untuk semua device
- Drag & drop file upload
- Preview gambar sebelum upload
- Loading states untuk aksi yang membutuhkan waktu
- Konfirmasi untuk aksi destructive (hapus)

### 11.2 Feedback
- Toast notifications untuk sukses/error
- Progress indicator untuk upload file
- Validation errors yang jelas
- Empty states yang informatif

## 12. Testing Checklist

### 12.1 Functional Testing
- [ ] Create portofolio dengan semua field
- [ ] Create portofolio dengan field minimal
- [ ] Update portofolio existing
- [ ] Delete portofolio dan file terkait
- [ ] Upload gambar berbagai format
- [ ] Upload video file
- [ ] Input YouTube URL
- [ ] Bulk actions (activate, deactivate, delete)
- [ ] Search dan filter functionality
- [ ] Pagination

### 12.2 Validation Testing
- [ ] Required field validation
- [ ] File size validation
- [ ] File type validation
- [ ] URL format validation
- [ ] Testimoni paired validation
- [ ] XSS prevention
- [ ] CSRF protection

### 12.3 UI/UX Testing
- [ ] Responsive di berbagai device
- [ ] File upload drag & drop
- [ ] Image preview functionality
- [ ] Loading states
- [ ] Error handling
- [ ] Success notifications

## 13. Deployment Notes

### 13.1 Requirements
- PHP 8.1+
- Laravel 10+
- MySQL 8.0+
- Storage writable permissions
- GD/Imagick extension untuk image processing

### 13.2 Installation Steps
1. Run migration: `php artisan migrate`
2. Create storage symlink: `php artisan storage:link`
3. Set proper file permissions untuk storage
4. Configure file upload limits di php.ini
5. Test file upload functionality

### 13.3 Configuration
```env
# File upload limits
UPLOAD_MAX_FILESIZE=10M
POST_MAX_SIZE=12M
MAX_FILE_UPLOADS=20

# Storage configuration
FILESYSTEM_DISK=local
```

## 14. Maintenance

### 14.1 Regular Tasks
- Monitor storage usage
- Cleanup orphaned files
- Backup database regularly
- Monitor error logs

### 14.2 Performance Monitoring
- Track page load times
- Monitor file upload success rates
- Database query performance
- Storage I/O performance

---

**Dokumentasi ini dibuat pada:** {{ date('d M Y') }}  
**Versi:** 1.0  
**Status:** ✅ Implementasi Lengkap