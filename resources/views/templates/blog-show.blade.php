@extends('layouts.site')

@section('title', ($post->seo_title ?: $post->title).' · '.config('site.short_name'))
@section('meta_description', $post->seo_description ?: $post->excerpt)

@php
    use Illuminate\Support\Str;

    $catIcons = [
        'gold loans' => 'coin', 'investing' => 'chart', 'women & business' => 'female',
        'personal finance' => 'wallet', 'digital' => 'phone', 'borrowing' => 'wallet',
    ];
    $cat = Str::lower(trim((string) $post->category));
    $icon = $catIcons[$cat] ?? 'doc';
    $banner = $post->banner_image ?: $post->cover_image;

    // Bottom CTA: send the reader to the section the article is about
    // (per-post cta_url / cta_label override this when set).
    [$ctaLabel, $ctaUrl] = match (true) {
        str_contains($cat, 'gold')   => ['Estimate Your Gold Loan', url('/products/gold-loan')],
        str_contains($cat, 'invest') => ['Explore Investments',      url('/investment')],
        default                      => ['Explore Our Products',     url('/products')],
    };
    $ctaLabel = $post->cta_label ?: $ctaLabel;
    $ctaUrl   = $post->cta_url   ?: $ctaUrl;
@endphp

@section('content')
    <section class="section">
        <div class="container article">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a> <i>/</i>
                <a href="{{ url('/blog') }}">Blog</a> <i>/</i>
                <em>{{ Str::limit($post->title, 40) }}</em>
            </nav>

            <div class="banner" style="margin:1.4rem 0 2rem" data-reveal="zoom">
                @if ($post->category)<span class="banner__tag">{{ $post->category }}</span>@endif
                @if ($banner)
                    <img class="news__img" src="{{ \App\Support\Assets::url($banner) }}" alt="{{ $post->title }}" loading="lazy">
                @else
                    <svg width="78" height="78"><use href="#i-{{ $icon }}"/></svg>
                @endif
            </div>

            <h1 style="font-size:clamp(1.9rem,4vw,3rem)">{{ $post->title }}</h1>

            <div class="metarow">
                @if ($post->author)
                    <div><svg width="18" height="18"><use href="#i-user"/></svg><span><b>Author</b>{{ $post->author }}</span></div>
                @endif
                @if ($post->published_at)
                    <div><svg width="18" height="18"><use href="#i-calendar"/></svg><span><b>Published</b>{{ $post->published_at->format('d F Y') }}</span></div>
                @endif
                @if ($post->read_time)
                    <div><svg width="18" height="18"><use href="#i-clock"/></svg><span><b>Read time</b>{{ $post->read_time }}</span></div>
                @endif
            </div>

            @if (filled($post->body))
                {!! $post->body !!}
            @else
                <p>{{ $post->excerpt }}</p>
                <p class="disclaimer">The full article is being written — check back soon.</p>
            @endif

            <div style="display:flex;gap:.8rem;flex-wrap:wrap;margin-top:2.4rem">
                <a class="btn btn--ghost" href="{{ url('/blog') }}">
                    <svg width="15" height="15"><use href="#i-chev-left"/></svg> Back to Blog
                </a>
                <a class="btn btn--gold" href="{{ $ctaUrl }}">
                    {{ $ctaLabel }} <svg width="16" height="16"><use href="#i-arrow-right"/></svg>
                </a>
            </div>
        </div>
    </section>

    @if ($related->isNotEmpty())
        <section class="section section--alt">
            <div class="container">
                <x-site.section-head eyebrow="Keep Reading"
                    :title="'More From the <span class=\'gold-text\'>Blog</span>'" />
                <div class="grid grid--3">
                    @foreach ($related as $post)
                        <x-site.post-card :post="$post" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
