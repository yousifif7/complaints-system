<?php

namespace App\Http\Controllers;

use App\Services\TranslationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function translate(Request $request, TranslationService $translator): JsonResponse
    {
        $validated = $request->validate([
            'text' => 'required|string|max:500',
            'from' => 'required|in:ar,en',
            'to' => 'required|in:ar,en|different:from',
        ]);

        if (!config('complaints.auto_translate_enabled', true)) {
            return response()->json(['translation' => '']);
        }

        $translation = $translator->translate(
            $validated['text'],
            $validated['from'],
            $validated['to']
        );

        return response()->json([
            'translation' => $translation ?? '',
        ]);
    }
}
