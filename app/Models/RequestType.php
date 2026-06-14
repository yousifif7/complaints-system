<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestType extends Model
{
    protected $fillable = ['request_name', 'request_name_en', 'category_id'];

    public function formTypes(): HasMany
    {
        return $this->hasMany(FormType::class, 'requesttype_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getLocalizedNameAttribute(): string
    {
        if (app()->getLocale() === 'en' && filled($this->request_name_en)) {
            return $this->request_name_en;
        }

        return $this->request_name;
    }
}
