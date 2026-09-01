<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

/**
 * Resolves a stored path to a public URL. Seeded content points at files
 * bundled under public/assets/…; admin uploads land on the "public" disk
 * (storage/app/public, served via /storage). This handles both.
 */
class Assets
{
    public static function url(?string $path, ?string $fallback = null): ?string
    {
        if (blank($path)) {
            return $fallback;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'assets/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }

    public static function policyUrl(?string $path): ?string
    {
        return self::url($path);
    }
}
