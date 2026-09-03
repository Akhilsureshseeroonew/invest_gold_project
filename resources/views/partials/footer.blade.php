{{-- ================= FOOTER ================= --}}
<footer class="footer">
    <div class="container footer__grid">
        <div>
            <a class="brand brand--footer" href="{{ url('/') }}" style="margin-bottom:1.1rem">
                <img class="brand__logo" src="{{ asset('assets/img/logo.png') }}" width="3080" height="683"
                     alt="{{ config('site.company') }}" loading="lazy">
            </a>
            <p style="max-width:40ch">{{ config('site.footer_about') }}</p>
            <nav class="social" style="margin-top:1.3rem" aria-label="Social media">
                @foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'youtube' => 'YouTube', 'linkedin' => 'LinkedIn'] as $key => $label)
                    @if ($url = config("site.social.$key"))
                        <a href="{{ $url }}" aria-label="{{ $label }}"
                           @if ($url !== '#') target="_blank" rel="noopener" @endif>
                            <svg><use href="#i-{{ $key }}"/></svg>
                        </a>
                    @endif
                @endforeach
            </nav>
        </div>

        @php
            // Admin-managed footer columns (Navigation → menu "Footer"); the
            // static list below is the fallback before anything is seeded.
            $footerColumns = $footerMenu ?? [
                ['label' => 'Products', 'children' => [
                    ['label' => 'Gold Loan',      'url' => '/products/gold-loan'],
                    ['label' => 'Personal Loan',  'url' => '/products/personal-loan'],
                    ['label' => 'Mahila Loan',    'url' => '/products/mahila-loan'],
                    ['label' => 'Consumer Loan',  'url' => '/products/consumer-loan'],
                    ['label' => 'Gold Calculator', 'url' => '/calculator'],
                ]],
                ['label' => 'Company', 'children' => [
                    ['label' => 'About Us',       'url' => '/about'],
                    ['label' => 'Investments',    'url' => '/investment'],
                    ['label' => 'News & Media',   'url' => '/news'],
                    ['label' => 'Blog',           'url' => '/blog'],
                    ['label' => 'Careers',        'url' => '/careers'],
                    ['label' => 'Branch Locator', 'url' => '/branches'],
                    ['label' => 'Downloads',      'url' => '/policies'],
                ]],
            ];
        @endphp
        @php
            $footerLink = function ($item) {
                $item = (array) $item;
                $url = $item['url'] ?? '#';
                $href = \Illuminate\Support\Str::startsWith($url, ['http://', 'https://', 'tel:', 'mailto:', '#'])
                    ? $url : url($url);
                $blank = ($item['target'] ?? '_self') === '_blank';
                return '<a href="'.e($href).'"'.($blank ? ' target="_blank" rel="noopener"' : '').'>'.e($item['label']).'</a>';
            };
        @endphp
        @foreach ($footerColumns as $column)
            @php
                $column = (array) $column;
                $links = collect($column['children'] ?? [])->map(fn ($l) => (array) $l);
                $columnHref = $column['url'] ?? '#';
            @endphp
            @if ($links->isNotEmpty())
                <div>
                    <h4>{{ $column['label'] }}</h4>
                    <ul>
                        @foreach ($links as $link)
                            <li>{!! $footerLink($link) !!}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif ($columnHref !== '#')
                {{-- top-level footer item with a link but no children: show it as a standalone link --}}
                <div>
                    <h4>{!! $footerLink($column) !!}</h4>
                </div>
            @endif
        @endforeach

        <div>
            <h4>{{ config('site.footer_address_heading', 'Head Office') }}</h4>
            <p style="margin-bottom:0.9rem">
                @foreach (config('site.address_lines') as $line)
                    {{ $line }}@if (! $loop->last)<br>@endif
                @endforeach
            </p>
            <ul>
                <li><a href="tel:{{ config('site.phone_primary_tel') }}">{{ config('site.phone_primary') }}</a></li>
                <li><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></li>
                <li><a href="{{ config('site.website') }}" target="_blank" rel="noopener">{{ preg_replace('#^https?://#', '', config('site.website')) }}</a></li>
            </ul>
        </div>
    </div>

    <div class="container footer__bottom">
        <span>© <span id="year">{{ date('Y') }}</span> {{ config('site.company') }}. All rights reserved.</span>
        @if ($legal = config('site.footer_legal_line'))
            <span>{{ $legal }}</span>
        @endif
    </div>
</footer>

{{-- ================= FLOATING MASCOT ASSISTANT ================= --}}
<div class="fab" id="fab">
    <button class="fab__btn" id="fabBtn" type="button" aria-expanded="false" aria-label="Open quick assistant">
        <span class="fab__pulse" aria-hidden="true"></span>
        <canvas id="scrollAnimCanvas" class="fab__canvas" width="120" height="250"></canvas>
        <img class="fab__fallback" src="{{ asset('assets/img/mascot.png') }}" alt="" loading="lazy" decoding="async">
    </button>
</div>

{{-- ================= SIDE MASCOT — SOCIAL LINKS ================= --}}

<div class="smascot" id="sideMascot">
    <div class="smascot__panel">
        @foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'youtube' => 'YouTube', 'linkedin' => 'LinkedIn', 'x' => 'X'] as $key => $label)
            @if ($url = config("site.social.$key"))
                <a class="smascot__item" href="{{ $url }}" aria-label="{{ $label }}"
                   @if ($url !== '#') target="_blank" rel="noopener" @endif><svg><use href="#i-{{ $key }}"/></svg></a>
            @endif
        @endforeach
    </div>
    <button class="smascot__btn" id="sideMascotBtn" type="button" aria-expanded="false"
            aria-label="Show social links">
        <img src="{{ asset('assets/img/mascot_.webp') }}" alt="" loading="lazy" decoding="async">
    </button>
</div>

<button class="totop" id="toTop" type="button" aria-label="Back to top">
    <svg width="18" height="18"><use href="#i-arrow-up"/></svg>
</button>
