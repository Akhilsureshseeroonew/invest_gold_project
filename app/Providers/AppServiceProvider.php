<?php

namespace App\Providers;

use App\Models\MenuItem;
use App\Support\Settings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->overrideSiteConfig();
        $this->shareNavigation();
    }

    /**
     * Replay saved settings over config('site.*') so the header, footer and
     * SEO tags reflect the admin "Site Settings" panel. Falls back silently to
     * config/site.php when the table is missing or empty (fresh install, CI).
     */
    protected function overrideSiteConfig(): void
    {
        try {
            $settings = Settings::all();
        } catch (\Throwable $e) {
            return;
        }

        foreach ($settings as $path => $value) {
            if ($value !== null && str_starts_with($path, 'site.')) {
                config([$path => $value]);
            }
        }

        if ($addr = config('site.address_full')) {
            config(['site.address_lines' => preg_split('/\r\n|\r|\n/', trim($addr))]);
        }
    }

    /**
     * Share the DB-managed navigation trees with the layout partials:
     *   partials.header -> $menu        (config/navigation.php fallback)
     *   partials.footer -> $footerMenu  (footer partial has its own fallback)
     * Each is null when the menu_items table has no rows for that menu.
     */
    protected function shareNavigation(): void
    {
        View::composer('partials.header', function ($view) {
            $view->with('menu', $this->menuTree('header'));
        });

        View::composer('partials.footer', function ($view) {
            $view->with('footerMenu', $this->menuTree('footer'));
        });
    }

    /** @return array<int, array<string, mixed>>|null */
    protected function menuTree(string $menu): ?array
    {
        try {
            $items = MenuItem::query()->menu($menu)->active()->roots()
                ->with(['children' => fn ($q) => $q->active(), 'children.page', 'page'])
                ->orderBy('sort_order')
                ->get();

            if ($items->isEmpty()) {
                return null;
            }

            return $items->map(fn (MenuItem $item) => [
                'label'    => $item->label,
                'url'      => $item->resolvedUrl(),
                'target'   => $item->target,
                'children' => $item->children->map(fn (MenuItem $c) => [
                    'label'  => $c->label,
                    'url'    => $c->resolvedUrl(),
                    'target' => $c->target,
                ])->all(),
            ])->all();
        } catch (\Throwable $e) {
            return null;
        }
    }
}
