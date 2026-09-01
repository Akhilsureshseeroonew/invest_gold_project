@php
    // $menu is supplied by a view composer once the menu_items table exists;
    // until then fall back to the config tree.
    $navItems = $menu ?? config('navigation');

    $isActive = function (?string $url) {
        if (! $url || $url === '#') {
            return false;
        }
        $path = trim(parse_url($url, PHP_URL_PATH) ?? $url, '/');
        return $path === '' ? request()->is('/') : request()->is($path, $path.'/*');
    };
@endphp

{{-- ================= 01. TOP BAR ================= --}}
<header class="topbar">
    <div class="container topbar__inner">
        <a class="brand" href="{{ url('/') }}" aria-label="{{ config('site.short_name') }} — home">
            <img class="brand__logo" src="{{ asset('assets/img/logo.png') }}" width="3080" height="683"
                 alt="{{ config('site.company') }}">
        </a>

        <div class="topbar__right">
            <a class="topbar__call" href="tel:{{ config('site.phone_primary_tel') }}">
                <svg><use href="#i-phone"/></svg> {{ config('site.phone_primary') }}
            </a>
            <span class="topbar__sep"></span>
            <nav class="social" aria-label="Social media">
                @foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'youtube' => 'YouTube', 'linkedin' => 'LinkedIn', 'x' => 'X'] as $key => $label)
                    @if ($url = config("site.social.$key"))
                        <a href="{{ $url }}" aria-label="{{ $label }}"
                           @if ($url !== '#') target="_blank" rel="noopener" @endif>
                            <svg><use href="#i-{{ $key }}"/></svg>
                        </a>
                    @endif
                @endforeach
            </nav>
            <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch colour theme">
                <svg class="i-sun"><use href="#i-sun"/></svg>
                <svg class="i-moon"><use href="#i-moon"/></svg>
            </button>
        </div>
    </div>
</header>

{{-- ================= 02. NAVIGATION ================= --}}
<nav class="nav" id="nav" aria-label="Primary">
    <div class="container nav__inner">
        <ul class="nav__links" id="navLinks">
            @foreach ($navItems as $item)
                @php
                    $item = (array) $item;
                    $children = $item['children'] ?? [];
                    $active = $isActive($item['url'] ?? null)
                        || collect($children)->contains(fn ($c) => $isActive(((array) $c)['url'] ?? null));
                @endphp
                <li @class(['has-sub' => filled($children)])>
                    <a href="{{ $item['url'] ?? '#' }}" @class(['is-active' => $active])>
                        {{ $item['label'] }}
                        @if (filled($children))
                            <svg class="caret" width="11" height="11" aria-hidden="true"><use href="#i-chev-down"/></svg>
                        @endif
                    </a>
                    @if (filled($children))
                        <ul class="subnav">
                            @foreach ($children as $child)
                                @php $child = (array) $child; @endphp
                                <li><a href="{{ $child['url'] ?? '#' }}">{{ $child['label'] }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
        <div class="nav__cta">
            <a class="btn btn--gold btn--sm" href="{{ url('/contact') }}">Enquire Now</a>
            <button class="nav__burger" id="burger" type="button" aria-label="Menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>
