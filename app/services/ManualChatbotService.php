<?php

namespace App\Services;

use App\Models\Layanan;
use App\Models\Portofolio;
use App\Models\Produk;
use App\Models\LayananHargaUkuran;

class ManualChatbotService
{
    private $responses = [
        'greeting' => [
            'keywords' => ['halo', 'hai', 'hello', 'hi', 'selamat', 'pagi', 'siang', 'sore', 'malam', 'assalamualaikum'],
            'responses' => [
                'Halo! 👋 Selamat datang di Konveksi Surabaya! Saya siap membantu Anda dengan informasi layanan konveksi kami.',
                'Hai! 😊 Terima kasih sudah menghubungi Konveksi Surabaya. Ada yang bisa saya bantu?',
                'Selamat datang! 🎉 Konveksi Surabaya siap melayani kebutuhan seragam berkualitas Anda.',
                'Halo! Saya asisten virtual Konveksi Surabaya. Silakan tanya tentang layanan, harga, atau portofolio kami! 💼'
            ]
        ],
        'layanan' => [
            'keywords' => ['layanan', 'service', 'jasa', 'produk', 'seragam', 'baju', 'kaos', 'kemeja', 'celana', 'jaket'],
            'responses' => [
                'Konveksi Surabaya menyediakan berbagai layanan:\n\n🔹 Seragam Sekolah\n🔹 Seragam Kantor\n🔹 Kaos Custom\n🔹 Kemeja Seragam\n🔹 Jaket & Hoodie\n🔹 Celana Seragam\n\nSemua dengan kualitas terbaik dan harga terjangkau! 💯'
            ]
        ],
        'harga' => [
            'keywords' => ['harga', 'biaya', 'tarif', 'cost', 'price', 'berapa', 'murah', 'mahal'],
            'responses' => [
                'Harga layanan kami sangat kompetitif! 💰\n\n📋 Harga bervariasi tergantung:\n• Jenis produk\n• Jumlah pesanan\n• Bahan yang dipilih\n• Kompleksitas desain\n\nUntuk penawaran terbaik, hubungi WhatsApp kami di 081234567890! 📱'
            ]
        ],
        'portofolio' => [
            'keywords' => ['portofolio', 'portfolio', 'contoh', 'hasil', 'karya', 'project', 'proyek', 'galeri'],
            'responses' => [
                'Kami bangga dengan portofolio yang telah dikerjakan! 🏆\n\n✨ 500+ klien puas\n✨ 15+ tahun pengalaman\n✨ Berbagai instansi & perusahaan\n\nLihat galeri lengkap di website kami atau hubungi WhatsApp 081234567890 untuk melihat contoh hasil kerja! 📸'
            ]
        ],
        'kontak' => [
            'keywords' => ['kontak', 'contact', 'hubungi', 'whatsapp', 'wa', 'telepon', 'phone', 'alamat', 'lokasi'],
            'responses' => [
                'Hubungi kami sekarang! 📞\n\n📱 WhatsApp: 081234567890\n📍 Lokasi: Surabaya\n🌐 Website: Tersedia form pemesanan online\n⏰ Layanan 24 jam\n\nTim customer service kami siap membantu Anda! 🤝'
            ]
        ],
        'waktu' => [
            'keywords' => ['waktu', 'lama', 'estimasi', 'berapa lama', 'kapan selesai', 'durasi', 'pengerjaan'],
            'responses' => [
                'Estimasi waktu pengerjaan: ⏱️\n\n🔸 Seragam Sekolah: 7-14 hari\n🔸 Seragam Kantor: 10-21 hari\n🔸 Kaos Custom: 5-10 hari\n🔸 Jaket & Hoodie: 14-21 hari\n\n*Waktu dapat bervariasi tergantung jumlah dan kompleksitas pesanan\n\nHubungi WhatsApp 081234567890 untuk konsultasi! 📱'
            ]
        ],
        'pemesanan' => [
            'keywords' => ['pesan', 'order', 'beli', 'booking', 'pemesanan', 'cara pesan', 'bagaimana'],
            'responses' => [
                'Cara pemesanan mudah! 📝\n\n1️⃣ Hubungi WhatsApp: 081234567890\n2️⃣ Konsultasi kebutuhan & desain\n3️⃣ Dapatkan penawaran harga\n4️⃣ Konfirmasi pesanan\n5️⃣ Proses produksi dimulai\n6️⃣ Pengiriman/pickup\n\nTim kami siap membantu dari konsultasi hingga selesai! 🎯'
            ]
        ],
        'complaint' => [
            'keywords' => ['goblok', 'gila', 'jelek', 'buruk', 'tidak bisa', 'error', 'rusak', 'masalah', 'trouble', 'problem'],
            'responses' => [
                'Maaf jika ada ketidaknyamanan! 😔\n\nSaya akan berusaha membantu Anda lebih baik. Silakan sampaikan keluhan atau masalah yang Anda alami:\n\n🔹 Masalah teknis website\n🔹 Pertanyaan tentang layanan\n🔹 Keluhan kualitas produk\n🔹 Masalah pemesanan\n\nAtau hubungi langsung WhatsApp 081234567890 untuk bantuan personal! 📱',
                'Terima kasih atas feedback Anda! 🙏\n\nKami selalu berusaha memberikan pelayanan terbaik. Jika ada yang kurang memuaskan, mohon beri tahu kami:\n\n• Apa yang bisa kami perbaiki?\n• Bagaimana kami bisa membantu lebih baik?\n\nHubungi WhatsApp 081234567890 untuk berbicara langsung dengan tim kami! 💬'
            ]
        ]
    ];

    public function getResponse($message)
    {
        $message = strtolower(trim($message));
        
        // Cek setiap kategori respons
        foreach ($this->responses as $category => $data) {
            foreach ($data['keywords'] as $keyword) {
                if (strpos($message, $keyword) !== false) {
                    return $this->getRandomResponse($data['responses']);
                }
            }
        }
        
        // Jika tidak ada keyword yang cocok, berikan respons default
        return $this->getDefaultResponse();
    }
    
    private function getRandomResponse($responses)
    {
        return $responses[array_rand($responses)];
    }
    
    private function getDefaultResponse()
    {
        $defaultResponses = [
            'Terima kasih sudah menghubungi Konveksi Surabaya! 😊\n\nSaya dapat membantu dengan informasi tentang:\n🔹 Layanan konveksi (ketik: "layanan")\n🔹 Harga & penawaran (ketik: "harga")\n🔹 Portofolio hasil kerja (ketik: "portofolio")\n🔹 Cara pemesanan (ketik: "pemesanan")\n🔹 Kontak & lokasi (ketik: "kontak")\n\nAtau hubungi WhatsApp 081234567890! 📱',
            'Halo! Saya asisten virtual Konveksi Surabaya 🤖\n\nCoba ketik salah satu kata kunci ini:\n• "halo" - untuk sapaan\n• "layanan" - info produk kami\n• "harga" - informasi harga\n• "kontak" - hubungi kami\n\nAtau langsung chat WhatsApp 081234567890! 💬',
            'Selamat datang di Konveksi Surabaya! 🎯\n\nSilakan ketik kata kunci seperti:\n✨ "layanan" untuk melihat produk\n✨ "harga" untuk info harga\n✨ "pemesanan" untuk cara order\n✨ "portofolio" untuk hasil kerja\n\nUntuk bantuan langsung: WhatsApp 081234567890! 📞'
        ];
        
        return $defaultResponses[array_rand($defaultResponses)];
    }
    
    public function getDetailedServiceInfo()
    {
        try {
            $layanan = Layanan::where('status', 'aktif')->with('hargaUkuran')->get();
            
            if ($layanan->isEmpty()) {
                return 'Informasi layanan sedang diperbarui. Hubungi WhatsApp 081234567890 untuk info terkini! 📱';
            }
            
            $response = "📋 **LAYANAN KONVEKSI SURABAYA** 📋\n\n";
            
            foreach ($layanan as $item) {
                $response .= "🔸 **{$item->nama_layanan}**\n";
                $response .= "   📝 {$item->deskripsi_singkat}\n";
                $response .= "   ⏱️ Estimasi: {$item->estimasi_waktu} hari\n";
                $response .= "   📦 Min. order: {$item->minimal_order} {$item->satuan_order}\n";
                $response .= "   💰 Mulai: Rp " . number_format($item->perkiraan_harga, 0, ',', '.') . "\n\n";
            }
            
            $response .= "📱 Hubungi WhatsApp 081234567890 untuk penawaran khusus!";
            
            return $response;
            
        } catch (\Exception $e) {
            return 'Informasi layanan sedang diperbarui. Hubungi WhatsApp 081234567890 untuk info lengkap! 📱';
        }
    }
}