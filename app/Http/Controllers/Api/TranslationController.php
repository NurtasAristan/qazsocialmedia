<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Services\OpenAITranslationService;

class TranslationController extends Controller
{
    public function translate(Request $request): string
    {
        $request->validate([
            'text' => 'required|string|max:1000',
            'target_language' => 'required|string',
        ]);

        // Қызмет данасын жасайды
        $translator = new OpenAITranslationService();

        // Аударма әдісін шақырады
        $translatedText = $translator->translate(
            $request->input('text'),
            $request->input('target_language')
        );

        return $translatedText;
    }
}
