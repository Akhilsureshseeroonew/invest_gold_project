<!doctype html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0A0F2C">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ===== SEO ===== --}}
    <title>@yield('title', config('site.short_name').' | '.config('site.tagline'))</title>
    <meta name="description" content="@yield('meta_description', 'Kerala\'s trusted, RBI-registered NBFC since 1996. Instant gold, personal, Mahila & consumer loans - trusted by 10,000+ customers.')">
    @hasSection('meta_keywords')
        <meta name="keywords" content="@yield('meta_keywords')">
    @endif
    <link rel="canonical" href="{{ $canonical ?? url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', config('site.short_name'))">
    <meta property="og:description" content="@yield('meta_description', 'Instant gold, personal & consumer loans with a trusted NBFC in Kerala. RBI-registered since 1996.')">
    <meta property="og:image" content="{{ asset('assets/img/mascot.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <link rel="icon" href="{{ asset('assets/img/logo.png') }}" sizes="any">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/logo.png') }}">

    {{-- ===== Fonts ===== --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- Prevent theme flash: applied before first paint.
         Defaults to the brand dark palette (matching the design); an explicit
         choice via the header toggle is remembered and wins. --}}
    <script>
        (function () {
            try {
                document.documentElement.setAttribute(
                    "data-theme",
                    localStorage.getItem("ig-theme") || "dark"
                );
            } catch (e) {}
        })();
    </script>

    {{-- ===== Structured data ===== --}}
    @hasSection('structured_data')
        @yield('structured_data')
    @else
        @php
            $ldJson = [
                '@context'      => 'https://schema.org',
                '@type'         => 'FinancialService',
                'name'          => config('site.company'),
                'description'   => 'RBI-registered NBFC in Kerala since 1996 offering gold loans, personal loans, Mahila loans, consumer loans, NCDs and subordinated debt investments.',
                'url'           => rtrim(config('site.website'), '/').'/',
                'email'         => config('site.email'),
                'telephone'     => config('site.phone_primary_tel'),
                'foundingDate'  => '1996',
                'address'       => [
                    '@type'           => 'PostalAddress',
                    'streetAddress'   => 'Invest Complex, Urakam PO',
                    'addressLocality' => 'Thrissur',
                    'addressRegion'   => 'Kerala',
                    'postalCode'      => '680562',
                    'addressCountry'  => 'IN',
                ],
                'areaServed'    => 'Kerala, India',
            ];
        @endphp
        <script type="application/ld+json">{!! json_encode($ldJson, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endif

    @stack('head')
</head>
<body class="preload-fade">

    @include('partials.icon-sprite')

    <div class="progress" id="progress"></div>

    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="{{ asset('assets/js/main.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
