<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\GeminiChatService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    protected $gemini;

    public function __construct(GeminiChatService $gemini)
    {
        $this->gemini = $gemini;
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $reply = $this->gemini->chat($request->message);

        return response()->json([
            'reply' => $reply,
        ]);
    }

    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            $message = $request->input('message');
            
            // Add context about the business
            $contextualMessage = "Anda adalah asisten virtual untuk Konveksi Surabaya, sebuah jasa konveksi terpercaya yang melayani pembuatan seragam berkualitas tinggi untuk instansi, perusahaan, sekolah, dan mahasiswa dengan pengalaman puluhan tahun. Layanan kami meliputi: Seragam Instansi, Seragam Perusahaan, Seragam Sekolah, Seragam Mahasiswa, Kaos Custom, dan Konsultasi Gratis. Kami memiliki 15+ tahun pengalaman, 500+ klien puas, dan layanan 24 jam. Jawab pertanyaan berikut dengan ramah dan informatif: " . $message;
            
            $reply = $this->gemini->chat($contextualMessage);

            return response()->json([
                'success' => true,
                'message' => $reply,
            ]);
        } catch (\Exception $e) {
            Log::error('Chatbot error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'error' => 'Maaf, terjadi kesalahan. Silakan coba lagi.',
            ], 500);
        }
    }

    public function getChatHistory(Request $request)
    {
        // For now, return empty history as we're not storing chat history
        return response()->json([
            'success' => true,
            'history' => [],
        ]);
    }

    public function clearChatHistory(Request $request)
    {
        // For now, just return success as we're not storing chat history
        return response()->json([
            'success' => true,
            'message' => 'Riwayat chat berhasil dihapus.',
        ]);
    }
}
