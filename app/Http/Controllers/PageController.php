<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\InterestRateScheme;
use App\Models\JobOpening;
use App\Models\NewsItem;
use App\Models\Page;
use App\Models\Policy;
use App\Models\Post;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function home()
    {
        $page = Page::where('slug', 'home')->published()->first()
            ?? new Page(['slug' => 'home', 'template' => 'home', 'title' => config('site.short_name')]);

        return view('pages.home', ['page' => $page]);
    }

    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)->published()->firstOrFail();

        $view = match ($page->template) {
            'home'            => 'pages.home',
            'product'         => 'templates.product',
            'products-index'  => 'templates.products-index',
            'investment-index' => 'templates.investment-index',
            'investment-scheme' => 'templates.investment-scheme',
            'calculator'      => 'templates.calculator',
            'interest-rates'  => 'templates.interest-rates',
            'blog-index'      => 'templates.blog-index',
            'news-index'      => 'templates.news-index',
            'careers-index'   => 'templates.careers-index',
            'branch'          => 'templates.branch',
            'contact'         => 'templates.contact',
            'policies'        => 'templates.policies',
            default           => 'templates.standard',
        };

        $data = ['page' => $page, 'breadcrumb' => $this->breadcrumb($page)];

        $data += match ($page->template) {
            'products-index'   => ['children' => Page::query()->published()->childrenOf('products')->get()],
            'investment-index' => ['children' => Page::query()->published()->childrenOf('investment')
                ->where('template', '!=', 'interest-rates')->get()],
            'interest-rates'   => ['schemes' => InterestRateScheme::active()->orderBy('sort_order')->get()],
            'blog-index'       => ['posts' => Post::published()->orderByDesc('published_at')->paginate(9)],
            'news-index'       => ['items' => NewsItem::published()->orderByDesc('published_at')->paginate(9)],
            'careers-index'    => ['jobs' => JobOpening::open()->orderByDesc('posted_at')->get()],
            'branch'           => ['branches' => Branch::active()->orderBy('sort_order')->get()],
            'policies'         => ['policies' => Policy::active()->orderBy('sort_order')->get()],
            'contact'          => ['branches' => Branch::active()->orderBy('sort_order')->get()],
            default            => [],
        };

        return view($view, $data);
    }

    /** @return array<int, array{0:string,1:?string}> */
    protected function breadcrumb(Page $page): array
    {
        $trail = [['Home', url('/')]];

        if ($page->slug === 'home') {
            return [];
        }

        $segments = explode('/', $page->slug);
        $prefix = '';

        foreach ($segments as $i => $segment) {
            $prefix = $prefix === '' ? $segment : "$prefix/$segment";
            $isLast = $i === count($segments) - 1;

            $label = Page::where('slug', $prefix)->value('menu_label')
                ?? Page::where('slug', $prefix)->value('title')
                ?? Str::headline($segment);

            $trail[] = [$label, $isLast ? null : url("/$prefix")];
        }

        return $trail;
    }
}
