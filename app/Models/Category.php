<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['catName', 'catName_en'];

    public function formTypes(): HasMany
    {
        return $this->hasMany(FormType::class, 'category_id');
    }

    public function requestTypes(): HasMany
    {
        return $this->hasMany(RequestType::class, 'category_id');
    }

    public function getLocalizedNameAttribute(): string
    {
        if (app()->getLocale() === 'en' && filled($this->catName_en)) {
            return $this->catName_en;
        }

        return $this->catName;
    }
}
