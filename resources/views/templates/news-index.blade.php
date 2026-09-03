@extends('layouts.site')

@section('title', $page->seo_title ?: $page->title.' · '.config('site.short_name'))
@section('meta_description', $page->seo_description)

@section('content')
    <x-site.hero
        :heading="$page->hero_heading ?: $page->title"
        :eyebrow="$page->hero_eyebrow"
        :lead="$page->hero_lead"
        :ctas="$page->hero_ctas ?? []"
        :breadcrumb="[['Home', url('/')], [$page->title, null]]"
    />

    <section class="section">
        <div class="container grid grid--3">
            @forelse ($items as $item)
                @php
                    $icon = ['news' => 'building', 'event' => 'calendar', 'media' => 'award'][$item->kind] ?? 'building';
                    $date = $item->event_date ?: $item->published_at;
                    $thumb = $item->cover_image ?: $item->banner_image;
                @endphp
                <article class="card news" data-reveal="zoom">
                    <div class="news__media">
                        @if ($thumb)
                            <img class="news__img" src="{{ \App\Support\Assets::url($thumb) }}" alt="" loading="lazy">
                        @endif
                        <span class="news__date">{{ $date?->format('d M Y') ?: ucfirst($item->kind) }}</span>
                        @unless ($thumb)
                            <svg width="62" height="62"><use href="#i-{{ $icon }}"/></svg>
                        @endunless
                    </div>
                    <h3>{{ $item->title }}</h3>
                    <p>{{ $item->summary }}</p>
                    <a class="link-arrow" href="{{ route('news.show', $item) }}">
                        Learn More <svg width="15" height="15"><use href="#i-arrow-right"/></svg>
                    </a>
                </article>
            @empty
                <p>No news published yet.</p>
            @endforelse
        </div>

        @if ($items->hasPages())
            <div class="container" style="margin-top:2rem">{{ $items->links() }}</div>
        @endif
    </section>

    <x-site.cta-band
        :title="$page->cta_heading ?: 'Covering Invest Gold?'"
        :text="$page->cta_text ?: 'For press kits, spokesperson availability or event photography, get in touch with our communications desk.'"
        :ctas="[['label' => 'Contact the Comms Desk', 'url' => url('/contact'), 'style' => 'btn--gold', 'icon' => 'arrow-right']]" />
@endsection
