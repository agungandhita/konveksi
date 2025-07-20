# Setup Chatbot Konveksi Surabaya

## Konfigurasi API Key Gemini

Untuk mengaktifkan chatbot, Anda perlu mengonfigurasi API key Google Gemini:

### 1. Dapatkan API Key Gemini
- Kunjungi [Google AI Studio](https://makersuite.google.com/app/apikey)
- Login dengan akun Google Anda
- Buat API key baru
- Copy API key yang dihasilkan

### 2. Konfigurasi di Laravel
- Copy file `.env.example` menjadi `.env`
- Buka file `.env`
- Ganti `your_gemini_api_key_here` dengan API key yang sudah Anda dapatkan:
  ```
  GOOGLE_GEMINI_API_KEY=AIzaSyC...
  ```

### 3. Restart Server
- Stop server Laravel (Ctrl+C)
- Jalankan kembali: `php artisan serve`

## Troubleshooting

### Respons Chatbot Tidak Sesuai
- Pastikan API key sudah benar
- Cek log di `storage/logs/laravel.log`
- Pastikan koneksi internet stabil

### Error "API key not found"
- Pastikan file `.env` sudah ada
- Pastikan `GOOGLE_GEMINI_API_KEY` sudah diisi
- Restart server setelah mengubah `.env`

## Fitur Chatbot
- Informasi layanan konveksi
- Harga dan estimasi waktu
- Portofolio proyek
- Arahan ke WhatsApp untuk pemesanan
- Respons dalam bahasa Indonesia