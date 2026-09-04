<?php

namespace App\Support;

class Homepage
{
    /**
     * The full home-page content tree: config/home.php defaults with any
     * "home.<dot.path>" settings rows merged over the top.
     *
     * @return array<string, mixed>
     */
    public static function all(): array
    {
        $data = config('home', []);

        try {
            $rows = Settings::all();
        } catch (\Throwable $e) {
            return $data;
        }

        foreach ($rows as $key => $value) {
            if ($value !== null && str_starts_with($key, 'home.')) {
                data_set($data, substr($key, 5), $value);
            }
        }

        return $data;
    }
}
