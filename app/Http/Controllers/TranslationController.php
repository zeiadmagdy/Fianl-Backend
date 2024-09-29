<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TranslationService;

class TranslationController extends Controller
{
    protected $translationService;

    public function __construct(TranslationService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Handle translation requests from the front-end.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function translate(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'text' => 'required|string',
        ]);

        // Get the text to translate
        $text = $request->input('text');

        // Translate the text using the TranslationService
        $translatedText = $this->translationService->translate($text);

        // Return the translated text as a JSON response
        return response()->json([
            'translatedText' => $translatedText,
        ]);
    }
}
