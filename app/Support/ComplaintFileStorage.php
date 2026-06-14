<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ComplaintFileStorage
{
    public const PUBLIC_SUBDIRECTORY = 'userFiles/complaints';

    public static function store(UploadedFile $file): string
    {
        $directory = public_path(self::PUBLIC_SUBDIRECTORY);

        if (!File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'bin');
        $filename = Str::uuid()->toString() . '.' . $extension;

        $file->move($directory, $filename);

        return 'complaints/' . $filename;
    }

    public static function absolutePath(?string $relativePath): ?string
    {
        if (empty($relativePath)) {
            return null;
        }

        $relativePath = str_replace('\\', '/', ltrim($relativePath, '/'));

        // Legacy records may already include userFiles/ in the stored path.
        if (str_starts_with($relativePath, 'userFiles/')) {
            return public_path($relativePath);
        }

        return public_path('userFiles/' . $relativePath);
    }

    public static function publicUrl(?string $relativePath): ?string
    {
        if (empty($relativePath)) {
            return null;
        }

        $relativePath = str_replace('\\', '/', ltrim($relativePath, '/'));

        if (str_starts_with($relativePath, 'userFiles/')) {
            return asset($relativePath);
        }

        return asset('userFiles/' . $relativePath);
    }

    public static function delete(?string $relativePath): void
    {
        $absolutePath = self::absolutePath($relativePath);

        if ($absolutePath && File::exists($absolutePath)) {
            File::delete($absolutePath);
        }
    }
}
