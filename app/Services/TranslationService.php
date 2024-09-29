<?php

namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationService
{
    protected $translator;

    public function __construct()
    {
        // Initialize the Google Translate service with English as the source language and Arabic as the target language
        $this->translator = new GoogleTranslate('ar', 'en');
    }

    public function translate($text)
    {
        // Use the translate method of GoogleTranslate to translate text
        return $this->translator->translate($text);
    }
}
