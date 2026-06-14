<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, string $locale): RedirectResponse
    {
        if (!in_array($locale, ['ar', 'en'], true)) {
            $locale = config('app.locale');
        }

        session(['locale' => $locale]);

        return redirect()->back();
    }
}
