<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiChatService
{
    public function chat($prompt)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . config('services.gemini.api_key'),
            [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]
        );

        return $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'No response';
    }
}
