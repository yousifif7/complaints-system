<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    public function translate(string $text, string $from, string $to): ?string
    {
        $text = trim($text);

        if ($text === '' || $from === $to) {
            return $text;
        }

        if (!config('complaints.auto_translate_enabled', true)) {
            return null;
        }

        try {
            $response = Http::timeout(8)->get('https://api.mymemory.translated.net/get', [
                'q' => $text,
                'langpair' => $from . '|' . $to,
            ]);

            if (!$response->successful()) {
                return null;
            }

            $translated = $response->json('responseData.translatedText');

            if (!is_string($translated) || trim($translated) === '') {
                return null;
            }

            // MyMemory returns the source text when it cannot translate.
            if (mb_strtolower(trim($translated)) === mb_strtolower($text)) {
                return null;
            }

            return trim($translated);
        } catch (\Throwable $exception) {
            Log::warning('Auto translation failed', [
                'from' => $from,
                'to' => $to,
                'message' => $exception->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * @return array{ar: string, en: string}
     */
    public function resolvePair(?string $arabic, ?string $english): array
    {
        $arabic = trim((string) $arabic);
        $english = trim((string) $english);

        if ($arabic !== '' && $english === '') {
            $english = $this->translate($arabic, 'ar', 'en') ?? '';
        } elseif ($english !== '' && $arabic === '') {
            $arabic = $this->translate($english, 'en', 'ar') ?? '';
        }

        return [
            'ar' => $arabic,
            'en' => $english,
        ];
    }
}
