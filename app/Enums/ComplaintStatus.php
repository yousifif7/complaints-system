<?php

namespace App\Enums;

class ComplaintStatus
{
    public const ACTIVE = '1';
    public const COMPLETED = '2';
    public const PENDING = '3';

    public static function labels(): array
    {
        return [
            self::ACTIVE => __('messages.status_active'),
            self::COMPLETED => __('messages.status_completed'),
            self::PENDING => __('messages.status_pending'),
        ];
    }

    public static function normalize(?string $status): string
    {
        $status = (string) ($status ?? self::ACTIVE);

        return array_key_exists($status, self::labels()) ? $status : self::ACTIVE;
    }

    public static function label(?string $status): string
    {
        return self::labels()[self::normalize($status)];
    }

    public static function cssClass(?string $status): string
    {
        return match (self::normalize($status)) {
            self::ACTIVE => 'text-danger',
            self::COMPLETED => 'text-success',
            self::PENDING => 'text-warning',
            default => '',
        };
    }
}
