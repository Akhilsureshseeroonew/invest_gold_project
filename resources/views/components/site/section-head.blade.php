@props(['eyebrow' => null, 'title' => '', 'sub' => null])

<div class="section-head" data-reveal>
    @if ($eyebrow)
        <span class="eyebrow">{{ $eyebrow }}</span>
    @endif
    <h2>{!! $title !!}</h2>
    @if ($sub)
        <p>{!! $sub !!}</p>
    @endif
</div>
