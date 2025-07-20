<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\ManualChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatbotController extends Controller
{
    protected $chatbotService;

    public function __construct(ManualChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    public function chat(Request $request)
    {
        try {
            $message = $request->input('message');
            
            if (empty($message)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesan tidak boleh kosong'
                ], 400);
            }

            // Gunakan chatbot manual
            $response = $this->chatbotService->getResponse($message);
            
            return response()->json([
                'success' => true,
                'message' => $response
            ]);
            
        } catch (\Exception $e) {
            Log::error('Chatbot Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan sistem. Silakan coba lagi.'
            ], 500);
        }
    }

    public function getChatHistory(Request $request)
    {
        // Untuk sementara return empty array karena tidak ada sistem session/database untuk history
        return response()->json([
            'success' => true,
            'history' => []
        ]);
    }

    public function clearChatHistory(Request $request)
    {
        // Untuk sementara return success karena tidak ada sistem session/database untuk history
        return response()->json([
            'success' => true,
            'message' => 'History berhasil dihapus'
        ]);
    }
}
