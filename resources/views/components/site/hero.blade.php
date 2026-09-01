@props([
    'heading' => '',
    'eyebrow' => null,
    'lead' => null,
    'ctas' => [],
    'breadcrumb' => null,   // array of [label, url]; last item rendered plain
])

<section class="pagehero">
    <div class="container pagehero__inner">
        <div data-reveal>
            @if (filled($breadcrumb))
                <nav class="breadcrumb" aria-label="Breadcrumb">
                    @foreach ($breadcrumb as $crumb)
                        @php [$label, $url] = array_pad((array) $crumb, 2, null); @endphp
                        @if (! $loop->last && $url)
                            <a href="{{ $url }}">{{ $label }}</a> <i>/</i>
                        @else
                            <em>{{ $label }}</em>
                        @endif
                    @endforeach
                </nav>
            @endif

            <h1>{!! $heading !!}</h1>

            @if ($eyebrow)
                <p class="eyebrow" style="margin-bottom:1.1rem">{{ $eyebrow }}</p>
            @endif

            @if ($lead)
                <p class="pagehero__lead">{!! $lead !!}</p>
            @endif

            @if (filled($ctas))
                <div class="pagehero__cta">
                    @foreach ($ctas as $cta)
                        @php
                            $cta = (array) $cta;
                            $style = $cta['style'] ?? 'btn--gold';
                            // match the design: gold buttons carry a trailing icon by default
                            $icon = $cta['icon'] ?? ($style === 'btn--gold' ? 'arrow-right' : null);
                        @endphp
                        <a class="btn {{ $style }}" href="{{ $cta['url'] ?? '#' }}"
                           @if (str_starts_with($cta['url'] ?? '', 'http')) target="_blank" rel="noopener" @endif>
                            {{ $cta['label'] ?? 'Learn more' }}@if ($icon) <svg width="16" height="16"><use href="#i-{{ $icon }}"/></svg>@endif
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="pagehero__art" data-reveal="zoom">
            <div class="medallion">
                <div class="medallion__frame">
                    <img class="medallion__img" src="{{ asset('assets/img/mascot.png') }}" alt="" width="1355" height="1160" decoding="async">
                </div>
                <span class="medallion__shine" aria-hidden="true"></span>
                <span class="crown-orbit" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></span>
            </div>
        </div>
    </div>
</section>
