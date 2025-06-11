<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenAITranslationService
{
    protected string $apiKey;
    protected string $endpoint = 'https://api.openai.com/v1/chat/completions';
    protected string $model = 'gpt-4.1';

    public function __construct()
    {
        $this->apiKey = config('services.openai.key');
    }

    public function translate(string $text, string $targetLanguage): string
    {
        $response = Http::withToken($this->apiKey)
            ->post($this->endpoint, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 
                        "You are a translator. Translate the following text to {$targetLanguage}."],
                    ['role' => 'user', 'content' => $text],
                ],
                'temperature' => 0.2,
            ]);
        return $response->json('choices.0.message.content');
    }
}