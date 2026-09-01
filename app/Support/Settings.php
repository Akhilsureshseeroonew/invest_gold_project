<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Thin accessor over the `settings` table.
 *
 * Rows are keyed by the exact config path they map onto (e.g. "site.email",
 * "site.social.facebook", "site.calculator.gold_rate_per_gram"); `group` only
 * drives the tabs on the Filament "Site Settings" page. AppServiceProvider
 * replays every row into config() at boot, so views keep reading config('site.*').
 */
class Settings
{
    protected const CACHE_KEY = 'app.settings.v1';

    /** @return array<string,mixed> keyed by config path */
    public static function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return Setting::query()
                ->get()
                ->mapWithKeys(fn (Setting $s) => [$s->key => data_get($s->value, 'v')])
                ->all();
        });
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        return self::all()[$key] ?? $default;
    }

    public static function put(string $group, string $key, mixed $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['group' => $group, 'value' => ['v' => $value]],
        );

        self::flush();
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
