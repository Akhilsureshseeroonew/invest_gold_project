@props(['post'])

@php
    $catIcons = [
        'gold loans' => 'coin', 'gold loan' => 'coin',
        'investing' => 'chart', 'investment' => 'chart', 'investments' => 'chart',
        'women & business' => 'female', 'women and business' => 'female', 'mahila' => 'female',
        'personal finance' => 'wallet', 'borrowing' => 'wallet',
        'digital' => 'phone', 'app' => 'phone',
        'security' => 'shield', 'safety' => 'shield',
    ];
    $icon = $catIcons[\Illuminate\Support\Str::lower(trim((string) $post->category))] ?? 'doc';
    $thumb = $post->cover_image ?: $post->banner_image;
@endphp

<article class="card news" data-reveal="zoom">
    <div class="news__media">
        @if ($thumb)
            <img class="news__img" src="{{ \App\Support\Assets::url($thumb) }}" alt="" loading="lazy">
        @endif
        <span class="news__date">{{ $post->category ?: 'Article' }}</span>
        @unless ($thumb)
            <svg width="62" height="62"><use href="#i-{{ $icon }}"/></svg>
        @endunless
    </div>
    <h3>{{ $post->title }}</h3>
    <p>{{ $post->excerpt }}</p>
    <a class="link-arrow" href="{{ route('blog.show', $post) }}">
        Read Article <svg width="15" height="15"><use href="#i-arrow-right"/></svg>
    </a>
</article>
