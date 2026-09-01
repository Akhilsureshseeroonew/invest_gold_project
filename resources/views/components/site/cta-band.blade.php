@props([
    'title' => 'Ready to get started?',
    'text' => 'Visit your nearest branch or send an enquiry — our team will walk you through eligibility and documentation.',
    'ctas' => [
        ['label' => 'Enquire Now', 'url' => '/contact', 'style' => 'btn--gold'],
        ['label' => 'Find a Branch', 'url' => '/branches', 'style' => 'btn--ghost'],
    ],
])

<section class="ctaband">
    <div class="container ctaband__inner">
        <div data-reveal="left">
            <h2>{!! $title !!}</h2>
            <p>{!! $text !!}</p>
        </div>
        <div class="pagehero__cta" data-reveal="right" style="margin:0">
            @foreach ($ctas as $cta)
                @php
                    $cta = (array) $cta;
                    $style = $cta['style'] ?? 'btn--gold';
                    $icon = $cta['icon'] ?? ($style === 'btn--gold' ? 'arrow-right' : null);
                @endphp
                <a class="btn {{ $style }}" href="{{ $cta['url'] ?? '#' }}"
                   @if (str_starts_with($cta['url'] ?? '', 'http')) target="_blank" rel="noopener" @endif>
                    {{ $cta['label'] ?? 'Enquire Now' }}@if ($icon) <svg width="16" height="16"><use href="#i-{{ $icon }}"/></svg>@endif
                </a>
            @endforeach
        </div>
    </div>
</section>
