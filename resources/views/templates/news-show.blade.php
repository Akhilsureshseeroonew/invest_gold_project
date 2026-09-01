@extends('layouts.site')

@section('title', $item->title.' · '.config('site.short_name'))
@section('meta_description', $item->summary)

@php
    $kindIcon = ['news' => 'building', 'event' => 'female', 'media' => 'award'][$item->kind] ?? 'building';
    $kindLabel = ['news' => 'News', 'event' => 'Event', 'media' => 'Media'][$item->kind] ?? ucfirst($item->kind);
    $date = $item->event_date ?: $item->published_at;
@endphp

@section('content')
    <section class="section" style="padding-bottom:0">
        <div class="container article">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a> <i>/</i>
                <a href="{{ url('/news') }}">News &amp; Media</a> <i>/</i>
                <em>{{ Str::limit($item->title, 40) }}</em>
            </nav>

            @php $banner = $item->banner_image ?: $item->cover_image; @endphp
            <div class="banner" style="margin:1.4rem 0 2rem" data-reveal="zoom">
                <span class="banner__tag">{{ $kindLabel }}</span>
                @if ($banner)
                    <img class="news__img" src="{{ \App\Support\Assets::url($banner) }}" alt="{{ $item->title }}" loading="lazy">
                @else
                    {{-- design default: themed icon placeholder --}}
                    <svg width="78" height="78"><use href="#i-{{ $kindIcon }}"/></svg>
                @endif
            </div>

            <h1 style="font-size:clamp(1.9rem,4vw,3rem)">{{ $item->title }}</h1>

            @php
                $meta = array_filter([
                    'calendar' => ['Date', $date?->format('d F Y')],
                    'clock'    => ['Time', $item->event_time],
                    'pin'      => ['Venue', $item->location],
                    'users'    => ['Organizer', $item->organizer],
                    'award'    => ['Source', $item->source],
                ], fn ($v) => filled($v[1]));
            @endphp
            @if (filled($meta))
                <div class="metarow">
                    @foreach ($meta as $icon => [$label, $value])
                        <div>
                            <svg width="18" height="18"><use href="#i-{{ $icon }}"/></svg>
                            <span><b>{{ $label }}</b>{{ $value }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            @if (filled($item->body))
                {!! $item->body !!}
            @else
                <p>{{ $item->summary }}</p>
            @endif
        </div>
    </section>

    @if (filled($item->gallery))
        @php $gallery = collect($item->gallery)->map(fn ($g) => (array) $g)->values(); @endphp
        <section class="section" style="padding-top:1.4rem">
            <div class="container" style="max-width:900px">
                @if ($gallery->count() === 1)
                    {{-- single image → plain framed figure, no slideshow chrome --}}
                    @php $g = $gallery->first(); @endphp
                    <figure class="card" style="padding:0;overflow:hidden;margin:0" data-reveal="zoom">
                        @if (! empty($g['image']))
                            <img src="{{ \App\Support\Assets::url($g['image']) }}" alt="{{ $g['caption'] ?? '' }}"
                                 style="display:block;width:100%" loading="lazy">
                        @else
                            <div class="banner" style="border:0;border-radius:0"><svg width="66" height="66"><use href="#i-image"/></svg></div>
                        @endif
                        @if (! empty($g['caption']))
                            <figcaption class="disclaimer" style="text-align:center;padding:.9rem 1rem;margin:0">{{ $g['caption'] }}</figcaption>
                        @endif
                    </figure>
                @else
                    {{-- 2+ images → slideshow (arrows, dots, autoplay via main.js) --}}
                    <div class="gallery" id="gallery" data-reveal>
                        <div class="gallery__viewport">
                            @foreach ($gallery as $g)
                                <div @class(['gallery__item', 'is-active' => $loop->first])>
                                    @if (! empty($g['image']))
                                        <img src="{{ \App\Support\Assets::url($g['image']) }}" alt="{{ $g['caption'] ?? '' }}" loading="lazy">
                                    @else
                                        <div><svg width="66" height="66"><use href="#i-image"/></svg><span>{{ $g['caption'] ?? '' }}</span></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <button class="gallery__nav gallery__nav--prev" type="button" aria-label="Previous image"><svg width="18" height="18"><use href="#i-chev-left"/></svg></button>
                        <button class="gallery__nav gallery__nav--next" type="button" aria-label="Next image"><svg width="18" height="18"><use href="#i-chev-right"/></svg></button>
                        <div class="gallery__dots"></div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <section class="section" style="padding-top:1.4rem">
        <div class="container" style="max-width:900px">
            <div style="display:flex;gap:.8rem;flex-wrap:wrap;justify-content:center;margin-top:1rem">
                <a class="btn btn--ghost" href="{{ url('/news') }}">
                    <svg width="15" height="15"><use href="#i-chev-left"/></svg> Back to News &amp; Media
                </a>
                @if ($item->cta_label)
                    <a class="btn btn--gold" href="{{ $item->cta_url ?: url('/contact') }}">
                        {{ $item->cta_label }} <svg width="16" height="16"><use href="#i-arrow-right"/></svg>
                    </a>
                @elseif ($item->source_url)
                    <a class="btn btn--gold" href="{{ $item->source_url }}" target="_blank" rel="noopener">
                        Read the coverage <svg width="16" height="16"><use href="#i-arrow-right"/></svg>
                    </a>
                @endif
            </div>
        </div>
    </section>
@endsection
