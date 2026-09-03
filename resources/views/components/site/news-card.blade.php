@props(['item'])

@php
    $icon  = ['news' => 'building', 'event' => 'calendar', 'media' => 'award'][$item->kind] ?? 'building';
    $date  = $item->event_date ?: $item->published_at;
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
