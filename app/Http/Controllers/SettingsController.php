<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        $settings = Setting::current();

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'organization_name_en' => 'nullable|string|max:255',
            'primary_color' => 'required|string|max:20',
            'website_url' => 'nullable|url|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:30',
            'welcome_message' => 'nullable|string|max:1000',
            'welcome_message_en' => 'nullable|string|max:1000',
            'footer_text' => 'nullable|string|max:500',
            'footer_text_en' => 'nullable|string|max:500',
            'tracking_enabled' => 'nullable|boolean',
            'logo' => 'nullable|image|max:2048',
            'header_image' => 'nullable|image|max:4096',
        ]);

        $settings = Setting::current();

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('branding', 'files');
        }

        if ($request->hasFile('header_image')) {
            $validated['header_image_path'] = $request->file('header_image')->store('branding', 'files');
        }

        $validated['tracking_enabled'] = $request->boolean('tracking_enabled');

        unset($validated['logo'], $validated['header_image']);

        $settings->update($validated);

        return redirect()->route('admin.settings')->with('success', __('messages.settings_saved'));
    }
}
