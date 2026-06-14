<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintNote extends Model
{
    protected $fillable = [
        'form_type_id',
        'user_id',
        'note',
        'type',
    ];

    public function complaint(): BelongsTo
    {
        return $this->belongsTo(FormType::class, 'form_type_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
