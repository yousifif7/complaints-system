<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'organization_name',
        'organization_name_en',
        'logo_path',
        'header_image_path',
        'primary_color',
        'website_url',
        'contact_email',
        'contact_phone',
        'welcome_message',
        'welcome_message_en',
        'footer_text',
        'footer_text_en',
        'tracking_enabled',
    ];

    protected $casts = [
        'tracking_enabled' => 'boolean',
    ];

    public static function current(): self
    {
        return static::firstOrCreate([], [
            'organization_name' => config('complaints.organization_name'),
            'primary_color' => config('complaints.primary_color'),
            'welcome_message' => config('complaints.welcome_message'),
            'footer_text' => config('complaints.footer_text'),
            'tracking_enabled' => true,
        ]);
    }

    public function getLocalizedNameAttribute(): string
    {
        if (app()->getLocale() === 'en' && filled($this->organization_name_en)) {
            return $this->organization_name_en;
        }

        return $this->organization_name ?? __('messages.app_name');
    }

    public function getLocalizedWelcomeMessageAttribute(): string
    {
        if (app()->getLocale() === 'en' && filled($this->welcome_message_en)) {
            return $this->welcome_message_en;
        }

        return $this->welcome_message ?? __('messages.choose_department');
    }

    public function getLocalizedFooterTextAttribute(): string
    {
        if (app()->getLocale() === 'en' && filled($this->footer_text_en)) {
            return $this->footer_text_en;
        }

        return $this->footer_text ?? __('messages.all_rights_reserved');
    }
}
