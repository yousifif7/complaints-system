<?php

namespace App\Models;

use App\Enums\ComplaintStatus;
use App\Support\ComplaintFileStorage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormType extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'content',
        'file',
        'status',
        'ticket_number',
        'priority',
        'internal_notes',
        'category_id',
        'requesttype_id',
    ];

    protected static function booted(): void
    {
        static::creating(function (FormType $complaint) {
            if (empty($complaint->status)) {
                $complaint->status = ComplaintStatus::ACTIVE;
            }

            if (empty($complaint->ticket_number)) {
                $complaint->ticket_number = static::generateTicketNumber(
                    $complaint->category_id,
                    $complaint->requesttype_id
                );
            }
        });
    }

    public static function generateTicketNumber(?int $categoryId, ?int $requestTypeId): string
    {
        $prefix = sprintf('CMP-%s%s-', $categoryId ?? '0', $requestTypeId ?? '0');
        $latest = static::where('ticket_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('ticket_number');

        $sequence = 1;
        if ($latest && preg_match('/(\d+)$/', $latest, $matches)) {
            $sequence = (int) $matches[1] + 1;
        }

        return $prefix . str_pad((string) $sequence, 5, '0', STR_PAD_LEFT);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function requestType(): BelongsTo
    {
        return $this->belongsTo(RequestType::class, 'requesttype_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(ComplaintNote::class, 'form_type_id');
    }

    public function getLegacyReferenceAttribute(): string
    {
        return $this->category_id . '0' . $this->requesttype_id . '0' . $this->id;
    }

    public function getFileUrlAttribute(): ?string
    {
        return ComplaintFileStorage::publicUrl($this->file);
    }

    public function isPdfAttachment(): bool
    {
        return str_ends_with(strtolower($this->file ?? ''), '.pdf');
    }

    public function getStatusLabelAttribute(): string
    {
        return ComplaintStatus::label($this->status);
    }

    public function getStatusCssClassAttribute(): string
    {
        return ComplaintStatus::cssClass($this->status);
    }

    public function getPriorityLabelAttribute(): string
    {
        $priority = $this->priority ?? 'medium';

        return __('messages.priority_' . $priority);
    }
}
