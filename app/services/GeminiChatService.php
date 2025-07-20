<?php

namespace App\Services;

use App\Models\Layanan;
use App\Models\Portofolio;
use App\Models\Produk;
use App\Models\LayananHargaUkuran;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiChatService
{
    public function chat($prompt)
    {
        try {
            // Ambil data dari database untuk konteks
            $layananData = $this->getLayananData();
            $portofolioData = $this->getPortofolioData();
            $produkData = $this->getProdukData();
            
            // Buat konteks lengkap untuk Gemini
            $contextualPrompt = $this->buildContextualPrompt($prompt, $layananData, $portofolioData, $produkData);
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . config('services.gemini.api_key'),
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $contextualPrompt]
                            ]
                        ]
                    ]
                ]
            );

            $result = $response->json();
            $aiResponse = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
            
            // Fallback response jika AI tidak memberikan jawaban yang sesuai
            if (!$aiResponse || strlen(trim($aiResponse)) < 10) {
                return 'Maaf, saya tidak dapat memberikan jawaban saat ini. Silakan hubungi WhatsApp kami di 081234567890 untuk bantuan langsung dari tim customer service.';
            }
            
            return $aiResponse;
            
        } catch (\Exception $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            Log::error('Gemini API Response: ' . ($response->body() ?? 'No response'));
            
            // Fallback response yang lebih informatif
            return 'Halo! Saya asisten virtual Konveksi Surabaya. Maaf, sistem sedang mengalami gangguan. Silakan hubungi WhatsApp kami di 081234567890 untuk bantuan langsung dari tim customer service kami.';
        }
    }
    
    private function getLayananData()
    {
        return Layanan::where('status', 'aktif')
            ->with('hargaUkuran')
            ->get()
            ->map(function ($layanan) {
                return [
                    'nama' => $layanan->nama_layanan,
                    'deskripsi' => $layanan->deskripsi_singkat,
                    'estimasi_waktu' => $layanan->estimasi_waktu . ' hari',
                    'minimal_order' => $layanan->minimal_order . ' ' . $layanan->satuan_order,
                    'perkiraan_harga' => 'Rp ' . number_format($layanan->perkiraan_harga, 0, ',', '.'),
                    'harga_per_ukuran' => $layanan->hargaUkuran->map(function ($harga) {
                        return $harga->ukuran . ': Rp ' . number_format($harga->harga, 0, ',', '.');
                    })->implode(', ')
                ];
            })->toArray();
    }
    
    private function getPortofolioData()
    {
        return Portofolio::where('status', 'aktif')
            ->orderBy('tanggal_proyek', 'desc')
            ->take(10)
            ->get(['judul', 'deskripsi_singkat', 'tanggal_proyek'])
            ->map(function ($portfolio) {
                return [
                    'judul' => $portfolio->judul,
                    'deskripsi' => $portfolio->deskripsi_singkat,
                    'tanggal' => $portfolio->tanggal_proyek->format('Y')
                ];
            })->toArray();
    }
    
    private function getProdukData()
    {
        return Produk::where('status', 'aktif')
            ->get(['nama_produk', 'deskripsi_singkat', 'harga'])
            ->map(function ($produk) {
                return [
                    'nama' => $produk->nama_produk,
                    'deskripsi' => $produk->deskripsi_singkat,
                    'harga' => 'Rp ' . number_format($produk->harga, 0, ',', '.')
                ];
            })->toArray();
    }
    
    private function buildContextualPrompt($userPrompt, $layananData, $portofolioData, $produkData)
    {
        $context = "IDENTITAS: Anda adalah asisten virtual resmi Konveksi Surabaya, jasa konveksi terpercaya dengan 15+ tahun pengalaman, 500+ klien puas, melayani pembuatan seragam berkualitas tinggi untuk instansi, perusahaan, sekolah, dan mahasiswa dengan layanan 24 jam.\n\n";
        
        $context .= "INFORMASI LAYANAN KAMI:\n";
        foreach ($layananData as $layanan) {
            $context .= "- {$layanan['nama']}: {$layanan['deskripsi']}\n";
            $context .= "  Estimasi: {$layanan['estimasi_waktu']}, Minimal order: {$layanan['minimal_order']}\n";
            $context .= "  Harga: {$layanan['perkiraan_harga']}";
            if (!empty($layanan['harga_per_ukuran'])) {
                $context .= " (Per ukuran: {$layanan['harga_per_ukuran']})";
            }
            $context .= "\n\n";
        }
        
        if (!empty($produkData)) {
            $context .= "PRODUK KAMI:\n";
            foreach ($produkData as $produk) {
                $context .= "- {$produk['nama']}: {$produk['deskripsi']} - {$produk['harga']}\n";
            }
            $context .= "\n";
        }
        
        if (!empty($portofolioData)) {
            $context .= "PORTOFOLIO TERBARU:\n";
            foreach (array_slice($portofolioData, 0, 5) as $portfolio) {
                $context .= "- {$portfolio['judul']} ({$portfolio['tanggal']}): {$portfolio['deskripsi']}\n";
            }
            $context .= "\n";
        }
        
        $context .= "KONTAK:\n";
        $context .= "- WhatsApp: 081234567890\n";
        $context .= "- Lokasi: Surabaya\n";
        $context .= "- Website: Tersedia form pemesanan online\n\n";
        
        $context .= "INSTRUKSI WAJIB:\n";
        $context .= "1. SELALU menjawab sebagai asisten virtual resmi Konveksi Surabaya\n";
        $context .= "2. Gunakan bahasa Indonesia yang ramah, sopan, dan profesional\n";
        $context .= "3. WAJIB gunakan data layanan, harga, dan portofolio yang disediakan di atas\n";
        $context .= "4. Untuk pertanyaan harga: sebutkan harga spesifik dari data yang ada\n";
        $context .= "5. Untuk pertanyaan layanan: jelaskan detail berdasarkan data layanan\n";
        $context .= "6. Untuk pertanyaan portofolio: berikan contoh konkret dari data proyek\n";
        $context .= "7. SELALU akhiri dengan ajakan menghubungi WhatsApp 081234567890\n";
        $context .= "8. Jika pertanyaan di luar konveksi: tetap sopan, jawab singkat, lalu arahkan ke layanan kami\n";
        $context .= "9. Batasi jawaban maksimal 4 kalimat agar mudah dibaca\n";
        $context .= "10. JANGAN memberikan informasi yang tidak ada dalam data\n\n";
        
        $context .= "PERTANYAAN PELANGGAN: " . $userPrompt;
        
        return $context;
    }
}
