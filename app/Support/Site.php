<?php

namespace App\Support;

class Site
{
    /**
     * Normalise a user-entered URL:
     *  - trims whitespace
     *  - returns null for empty / "#" placeholder values
     *  - leaves absolute URLs, mailto:, tel: and #anchors untouched
     *  - prepends https:// to a bare domain ("facebook.com/x" -> "https://facebook.com/x")
     */
    public static function normalizeUrl(?string $value): ?string
    {
        $value = trim((string) $value);

        if ($value === '' || $value === '#') {
            return null;
        }

        if (preg_match('#^(https?:)?//#i', $value)
            || str_starts_with($value, 'mailto:')
            || str_starts_with($value, 'tel:')
            || str_starts_with($value, '/')
            || str_starts_with($value, '#')) {
            return $value;
        }

        return 'https://'.ltrim($value, '/');
    }

    /**
     * Only the social platforms that have a link set in admin (Site Settings →
     * Social). Platforms with no link are omitted entirely so their icon is not
     * shown anywhere. Used by the header, footer and side-mascot icon rows.
     *
     * @return array<int, array{key:string, label:string, url:string}>
     */
    public static function socialLinks(): array
    {
        $platforms = [
            'facebook'  => 'Facebook',
            'instagram' => 'Instagram',
            'youtube'   => 'YouTube',
            'linkedin'  => 'LinkedIn',
            'x'         => 'X',
        ];

        $links = [];

        foreach ($platforms as $key => $label) {
            $url = self::normalizeUrl(config("site.social.$key"));

            if ($url !== null) {
                $links[] = ['key' => $key, 'label' => $label, 'url' => $url];
            }
        }

        return $links;
    }
}
