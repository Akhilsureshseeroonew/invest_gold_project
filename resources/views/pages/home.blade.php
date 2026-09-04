@extends('layouts.site')

@section('title', ($page->seo_title ?? null) ?: "Invest Gold General Finance | Kerala's Trusted NBFC Since 1996")
@section('meta_description', ($page->seo_description ?? null) ?: "Kerala's trusted, RBI-registered NBFC since 1996. Instant gold, personal, Mahila & consumer loans - trusted by 10,000+ customers.")
@section('meta_keywords', 'gold loan Kerala, personal loan Thrissur, Mahila loan, consumer loan, NCD investment, subordinated debt, NBFC Kerala')



@section('content')
      <!-- ================= 03. HERO ================= -->
      <section class="hero" id="home">
        <video
          class="hero__video"
          autoplay
          muted
          loop
          playsinline
          preload="auto"
          poster="{{ asset('assets/img/mascot.png') }}"
          aria-hidden="true"
        >
          <source src="{{ asset('assets/video/ig-hero.mp4') }}" type="video/mp4" />
        </video>
        <div class="hero__video-overlay" aria-hidden="true"></div>
        <div class="container hero__inner">
          <div class="hero__copy">
            @if ($home['hero']['eyebrow'])
              <span class="eyebrow" data-reveal>{{ $home['hero']['eyebrow'] }}</span>
            @endif
            <h1 data-reveal>{!! $home['hero']['heading'] !!}</h1>
            <p class="hero__lead" data-reveal>{!! $home['hero']['lead'] !!}</p>

            <div class="hero__cta" data-reveal>
              @if ($home['hero']['cta1_label'])
                <a class="btn btn--gold" href="{{ $home['hero']['cta1_url'] ?: '#' }}">
                  {{ $home['hero']['cta1_label'] }}
                  <svg width="16" height="16"><use href="#i-arrow-right" /></svg>
                </a>
              @endif
              @if ($home['hero']['cta2_label'])
                <a class="btn btn--ghost" href="{{ $home['hero']['cta2_url'] ?: '#' }}">{{ $home['hero']['cta2_label'] }}</a>
              @endif
            </div>
          </div>

          <!-- Mascot medallion + orbiting product badges (hosts the supplied 1.3s loop artwork) -->
          <div class="hero__visual" data-reveal="zoom">
            <div class="orbit">
              <svg class="orbit__web" viewBox="0 0 400 400" aria-hidden="true">
                <defs>
                  <linearGradient id="orbitLine" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#D4AF37" stop-opacity="0" />
                    <stop
                      offset="35%"
                      stop-color="#F2DFA0"
                      stop-opacity=".85"
                    />
                    <stop
                      offset="65%"
                      stop-color="#D4AF37"
                      stop-opacity=".55"
                    />
                    <stop offset="100%" stop-color="#A87F16" stop-opacity="0" />
                  </linearGradient>
                </defs>
                <circle
                  class="orbit__ring-solid"
                  cx="200"
                  cy="200"
                  r="168"
                  fill="none"
                  stroke="url(#orbitLine)"
                  stroke-width="1.4"
                />
                <circle
                  class="orbit__ring-dash"
                  cx="200"
                  cy="200"
                  r="168"
                  fill="none"
                  stroke="url(#orbitLine)"
                  stroke-width="2.6"
                  stroke-dasharray="3 16"
                  stroke-linecap="round"
                />
              </svg>

              <div class="medallion">
                <div class="medallion__frame">
                  <img
                    class="medallion__img"
                    src="{{ asset('assets/img/mascot.png') }}"
                    width="1355"
                    height="1160"
                    alt="Invest Gold royal elephant mascot holding a gold IG coin"
                    fetchpriority="high"
                    decoding="async"
                  />
                </div>
                <span class="medallion__shine" aria-hidden="true"></span>
                
              </div>

              <div class="orbit__items">
                <a
                  class="orbit__item"
                  style="--x: 11.9%; --y: 32.2%"
                  href="/products/gold-loan"
                >
                  <span class="orbit__disc"
                    ><svg><use href="#i-coin" /></svg
                  ></span>
                  <span class="orbit__label"
                    >Gold
                    Loan</span
                  >
                </a>
                <a
                  class="orbit__item"
                  style="--x: 88.1%; --y: 32.2%"
                  href="/products/personal-loan"
                >
                  <span class="orbit__disc"
                    ><svg><use href="#i-wallet" /></svg
                  ></span>
                  <span class="orbit__label"
                    >Personal Loan</span
                  >
                </a>
                <a
                  class="orbit__item"
                  style="--x: 15.6%; --y: 74.1%"
                  href="/products/consumer-loan"
                >
                  <span class="orbit__disc"
                    ><svg><use href="#i-tv" /></svg
                  ></span>
                  <span class="orbit__label"
                    >Consumer Loan</span
                  >
                </a>
                <a
                  class="orbit__item"
                  style="--x: 84.4%; --y: 74.1%"
                  href="/products/mahila-loan"
                >
                  <span class="orbit__disc"
                    ><svg><use href="#i-female" /></svg
                  ></span>
                  <span class="orbit__label"
                    >Mahila Loan</span
                  >
                </a>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- trust marquee -->
      <div class="marquee" aria-hidden="true">
        <div class="marquee__track">
          <span>Gold Loan</span><span>Personal Loan</span
          ><span>Mahila Loan</span><span>Consumer Loan</span>
          <span>NCD Investment</span><span>Subordinated Debt</span
          ><span>Doubling Scheme</span><span>Live Passbook</span>
          <span>Gold Loan</span><span>Personal Loan</span
          ><span>Mahila Loan</span><span>Consumer Loan</span>
          <span>NCD Investment</span><span>Subordinated Debt</span
          ><span>Doubling Scheme</span><span>Live Passbook</span>
        </div>
      </div>

      <!-- ================= 04. ABOUT ================= -->
      <section class="section" id="about">
        <div class="container">
          <div class="section-head" data-reveal>
            <h2>{!! $home['about']['heading'] !!}</h2>
            <div class="divider" aria-hidden="true">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="132"
                height="14"
                viewBox="0 0 132 14"
                fill="none"
              >
                <path
                  d="M2 7H46M86 7H130"
                  stroke="#D4AF37"
                  stroke-width="1.3"
                />
                <path d="M66 2L72 7L66 12L60 7L66 2Z" fill="#D4AF37" />
                <path
                  d="M52 9C53.1046 9 54 8.10457 54 7C54 5.89543 53.1046 5 52 5C50.8954 5 50 5.89543 50 7C50 8.10457 50.8954 9 52 9Z"
                  stroke="#D4AF37"
                  stroke-width="1.3"
                />
                <path
                  d="M80 9C81.1046 9 82 8.10457 82 7C82 5.89543 81.1046 5 80 5C78.8954 5 78 5.89543 78 7C78 8.10457 78.8954 9 80 9Z"
                  stroke="#D4AF37"
                  stroke-width="1.3"
                />
              </svg>
            </div>
          </div>

          <div class="about__intro" data-reveal>
            {!! $home['about']['body'] !!}
            @if ($home['about']['cta_label'])
              <a class="btn btn--gold" href="https://wa.me/{{ preg_replace('/\D+/', '', (string) config('site.whatsapp')) }}"
                 target="_blank" rel="noopener">{{ $home['about']['cta_label'] }}</a>
            @endif
          </div>

          @if (! empty($home['about']['cards']))
            <div class="about__cards" data-reveal>
              @foreach ($home['about']['cards'] as $card)
                @php $card = (array) $card; @endphp
                <div class="card">
                  <div class="card-icon"><svg><use href="#i-{{ $card['icon'] ?? 'award' }}" /></svg></div>
                  <h3>{{ $card['title'] ?? '' }}</h3>
                  <p>{{ $card['text'] ?? '' }}</p>
                </div>
              @endforeach
            </div>
          @endif

          @if (! empty($home['about']['stats']))
            <!-- Invest Gold by the numbers -->
            <div class="stats-band" data-reveal>
              <div class="stats">
                @foreach ($home['about']['stats'] as $stat)
                  @php $stat = (array) $stat; @endphp
                  <div class="stat" data-reveal="zoom">
                    <b class="gold-text"><span data-count="{{ (int) ($stat['value'] ?? 0) }}">0</span>{{ $stat['suffix'] ?? '' }}</b><span>{{ $stat['label'] ?? '' }}</span>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
        </div>
      </section>

      <!-- ================= 05. PRODUCTS ================= -->
      <section class="section section--alt" id="products">
        <div class="container">
          <div class="section-head" data-reveal>
            @if ($home['products']['eyebrow'])<span class="eyebrow">{{ $home['products']['eyebrow'] }}</span>@endif
            <h2>{!! $home['products']['heading'] !!}</h2>
            @if ($home['products']['sub'])<p>{{ $home['products']['sub'] }}</p>@endif
          </div>

          <div class="grid grid--{{ min(max($productChildren->count(), 1), 4) }}">
            @foreach ($productChildren as $child)
              <article class="card product" data-reveal="zoom" data-tilt>
                @if ($child->card_tag)<span class="ribbon">{{ $child->card_tag }}</span>@endif
                <div class="card-icon"><svg><use href="#i-{{ $child->icon ?: 'coin' }}" /></svg></div>
                <h3>{{ $child->title }}</h3>
                @if ($child->hero_eyebrow)<div class="product__sub">{{ $child->hero_eyebrow }}</div>@endif
                <p>{{ $child->seo_description ?: strip_tags($child->hero_lead) }}</p>
                <a class="link-arrow" href="{{ $child->url() }}">
                  {{ $child->card_cta ?: 'Explore '.$child->title }}
                  <svg width="15" height="15"><use href="#i-arrow-right" /></svg>
                </a>
              </article>
            @endforeach
          </div>
        </div>
      </section>

      <!-- ================= 06. INVESTMENTS ================= -->
      <section class="section section--gold" id="investment">
        <div class="container">
          <div class="section-head" data-reveal>
            @if ($home['investments']['eyebrow'])<span class="eyebrow">{{ $home['investments']['eyebrow'] }}</span>@endif
            <h2>{!! $home['investments']['heading'] !!}</h2>
            @if ($home['investments']['sub'])<p>{{ $home['investments']['sub'] }}</p>@endif
          </div>

          @if ($investmentChildren->isNotEmpty())
          <div class="invtl" data-reveal>
            <div class="invtl__rail" role="tablist" aria-label="Investment options">
              @foreach ($investmentChildren as $i => $child)
                <button @class(['invtl__step', 'is-active' => $i === 0]) type="button" role="tab"
                        aria-selected="{{ $i === 0 ? 'true' : 'false' }}" @if ($i !== 0) tabindex="-1" @endif>
                  <span class="invtl__pill">{{ $child->card_tag ?: $child->title }}</span>
                  <span class="invtl__dot" aria-hidden="true"></span>
                </button>
              @endforeach
            </div>

            @foreach ($investmentChildren as $i => $child)
              @php
                $points = collect($child->highlights ?? [])
                    ->map(fn ($h) => ((array) $h)['text'] ?? ((array) $h)['title'] ?? null)
                    ->filter()->take(4)->values()->all();
              @endphp
              <article class="invtl__panel" role="tabpanel" tabindex="0" @if ($i !== 0) hidden @endif>
                @if ($child->card_tag)<span class="invtl__tag">{{ $child->card_tag }}</span>@endif
                <div class="invtl__cols">
                  <h3>{{ $child->title }}</h3>
                  <div class="invtl__body">
                    <p>{{ $child->seo_description ?: strip_tags($child->hero_lead) }}</p>
                    @if (filled($points))
                      <ul class="invest__list">
                        @foreach ($points as $p)
                          <li><svg><use href="#i-check" /></svg> {{ $p }}</li>
                        @endforeach
                      </ul>
                    @endif
                    <a class="link-arrow invtl__cta" href="{{ $child->url() }}">
                      {{ $child->card_cta ?: 'Explore '.$child->title }}
                      <svg width="15" height="15"><use href="#i-arrow-right" /></svg>
                    </a>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
          @endif
        </div>
      </section>

      <!-- ================= 07. CALCULATOR ================= -->
      <!-- ================= 07. LOAN CALCULATOR ================= -->
      <section class="section section--alt" id="calculator">
        <div class="container">
          <div class="section-head" data-reveal>
            @if ($home['calculator']['eyebrow'])<span class="eyebrow">{{ $home['calculator']['eyebrow'] }}</span>@endif
            <h2>{!! $home['calculator']['heading'] !!}</h2>
            @if ($home['calculator']['sub'])<p>{{ $home['calculator']['sub'] }}</p>@endif
          </div>

          <x-site.calculator-hub />
        </div>
      </section>

      <!-- ================= 08. WHY CHOOSE US ================= -->
      <section class="section" id="why">
        <div class="container">
          <div class="section-head" data-reveal>
            @if ($home['why']['eyebrow'])<span class="eyebrow">{{ $home['why']['eyebrow'] }}</span>@endif
            <h2>{!! $home['why']['heading'] !!}</h2>
            @if ($home['why']['sub'])<p>{{ $home['why']['sub'] }}</p>@endif
          </div>

          @if (! empty($home['why']['cards']))
            <div class="why">
              @foreach ($home['why']['cards'] as $card)
                @php $card = (array) $card; @endphp
                <article class="card" data-reveal="zoom">
                  <span class="why__num">{{ $card['num'] ?? '' }}</span>
                  <div class="card-icon"><svg><use href="#i-{{ $card['icon'] ?? 'shield' }}" /></svg></div>
                  <h3>{{ $card['title'] ?? '' }}</h3>
                  <p>{{ $card['text'] ?? '' }}</p>
                </article>
              @endforeach
            </div>
          @endif

          @if (! empty($home['why']['badges']))
            <div class="hero__badges" style="margin-top: clamp(1.8rem, 4vw, 2.8rem)">
              @foreach ($home['why']['badges'] as $badge)
                @php $badge = (array) $badge; @endphp
                <div class="badge" data-reveal="zoom">
                  <svg><use href="#i-{{ $badge['icon'] ?? 'shield' }}" /></svg>
                  <b>{{ $badge['value'] ?? '' }}</b><span>{{ $badge['label'] ?? '' }}</span>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </section>

      <!-- ================= 09. TESTIMONIALS ================= -->
      <section class="section section--deep" id="testimonials">
        <div class="container">
          <div class="section-head" data-reveal>
            @if ($home['testimonials']['eyebrow'])<span class="eyebrow">{{ $home['testimonials']['eyebrow'] }}</span>@endif
            <h2>{!! $home['testimonials']['heading'] !!}</h2>
            @if (! empty($home['testimonials']['sub']))<p>{{ $home['testimonials']['sub'] }}</p>@endif
          </div>

          @if ($testimonials->isNotEmpty())
          <div class="tcar" id="tcar" data-reveal>
            <button class="tcar__nav tcar__nav--prev" type="button" aria-label="Previous story">
              <svg width="20" height="20"><use href="#i-chev-left" /></svg>
            </button>
            <div class="tcar__viewport">
              <div class="tcar__track" id="tcarTrack">
                @foreach ($testimonials as $t)
                  <div class="tslide">
                    <div class="tslide__card">
                      <span class="tslide__avatar">{{ $t->initial() }}</span>
                      <div class="stars">
                        @for ($s = 0; $s < $t->stars(); $s++)<svg><use href="#i-star" /></svg>@endfor
                      </div>
                      <q>{{ $t->quote }}</q>
                      <div class="tslide__name">{{ $t->name }}</div>
                      @if ($t->location)<div class="tslide__loc">{{ $t->location }}</div>@endif
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <button class="tcar__nav tcar__nav--next" type="button" aria-label="Next story">
              <svg width="20" height="20"><use href="#i-chev-right" /></svg>
            </button>
            <div class="tcar__dots" id="tcarDots"></div>
          </div>
          @endif
        </div>
      </section>

      <!-- ================= 10. MOBILE APP ================= -->
      <section class="section" id="app">
        <div class="container app">
          <div data-reveal="left">
            @if ($home['app']['eyebrow'])<span class="eyebrow">{{ $home['app']['eyebrow'] }}</span>@endif
            <h2 style="margin: 1.1rem 0 1rem">{!! $home['app']['heading'] !!}</h2>
            @if ($home['app']['lead'])<p>{!! $home['app']['lead'] !!}</p>@endif
            @if (! empty($home['app']['features']))
              <ul class="app__list">
                @foreach ($home['app']['features'] as $feature)
                  <li><svg><use href="#i-check" /></svg> {!! $feature !!}</li>
                @endforeach
              </ul>
            @endif
            @php
              $playUrl  = \App\Support\Site::normalizeUrl(config('site.app.play_store'));
              $appleUrl = \App\Support\Site::normalizeUrl(config('site.app.apple_store'));
            @endphp
            @if ($playUrl || $appleUrl)
              <h3 style="font-size: 1.05rem; margin-bottom: 0.9rem">
                {{ $home['app']['download_heading'] ?: 'Download Now' }}
              </h3>
              <div class="store">
                @if ($playUrl)
                  <a href="{{ $playUrl }}" target="_blank" rel="noopener" aria-label="Get it on Google Play">
                    <svg><use href="#i-play" /></svg>
                    <span><small>Get it on</small><b>Google Play</b></span>
                  </a>
                @endif
                @if ($appleUrl)
                  <a href="{{ $appleUrl }}" target="_blank" rel="noopener" aria-label="Download on the App Store">
                    <svg><use href="#i-apple" /></svg>
                    <span><small>Download on the</small><b>App Store</b></span>
                  </a>
                @endif
              </div>
            @endif
          </div>

          <!-- App screen carousel (pure CSS/SVG mock screens) -->
          <div class="phones" data-reveal="right">
            <div class="phones__stage" id="phones">
              <!-- 1 · Dashboard -->
              <div class="phone">
                <svg
                  viewBox="0 0 216 440"
                  role="img"
                  aria-label="App dashboard screen"
                >
                  <rect width="216" height="440" fill="#0B1B3F" />
                  <rect width="216" height="96" fill="#12275A" />
                  <circle cx="30" cy="46" r="12" fill="#D4AF37" />
                  <rect
                    x="50"
                    y="38"
                    width="70"
                    height="7"
                    rx="3.5"
                    fill="#E7C766"
                  />
                  <rect
                    x="50"
                    y="52"
                    width="46"
                    height="6"
                    rx="3"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="16"
                    y="72"
                    width="184"
                    height="52"
                    rx="12"
                    fill="#0A0F2C"
                    stroke="#D4AF37"
                    stroke-opacity=".5"
                  />
                  <rect
                    x="28"
                    y="86"
                    width="60"
                    height="6"
                    rx="3"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="28"
                    y="100"
                    width="92"
                    height="11"
                    rx="4"
                    fill="#E7C766"
                  />
                  <g fill="#12275A">
                    <rect x="16" y="140" width="86" height="76" rx="14" />
                    <rect x="114" y="140" width="86" height="76" rx="14" />
                    <rect x="16" y="228" width="86" height="76" rx="14" />
                    <rect x="114" y="228" width="86" height="76" rx="14" />
                  </g>
                  <g fill="#D4AF37">
                    <circle cx="59" cy="168" r="11" />
                    <circle cx="157" cy="168" r="11" />
                    <circle cx="59" cy="256" r="11" />
                    <circle cx="157" cy="256" r="11" />
                  </g>
                  <g fill="#8494C4">
                    <rect x="35" y="190" width="48" height="6" rx="3" />
                    <rect x="133" y="190" width="48" height="6" rx="3" />
                    <rect x="35" y="278" width="48" height="6" rx="3" />
                    <rect x="133" y="278" width="48" height="6" rx="3" />
                  </g>
                  <rect
                    x="16"
                    y="320"
                    width="184"
                    height="42"
                    rx="12"
                    fill="#D4AF37"
                  />
                  <rect
                    x="70"
                    y="337"
                    width="76"
                    height="8"
                    rx="4"
                    fill="#0B1B3F"
                  />
                  <rect x="0" y="392" width="216" height="48" fill="#12275A" />
                  <g fill="#5B6C9E">
                    <circle cx="43" cy="416" r="7" />
                    <circle cx="108" cy="416" r="7" />
                    <circle cx="173" cy="416" r="7" />
                  </g>
                </svg>
              </div>
              <!-- 2 · My loans -->
              <div class="phone">
                <svg
                  viewBox="0 0 216 440"
                  role="img"
                  aria-label="My loans screen"
                >
                  <rect width="216" height="440" fill="#0A0F2C" />
                  <rect width="216" height="70" fill="#D4AF37" />
                  <rect
                    x="20"
                    y="32"
                    width="72"
                    height="9"
                    rx="4.5"
                    fill="#0B1B3F"
                  />
                  <g fill="#12275A">
                    <rect x="16" y="88" width="184" height="88" rx="14" />
                    <rect x="16" y="188" width="184" height="88" rx="14" />
                    <rect x="16" y="288" width="184" height="88" rx="14" />
                  </g>
                  <g fill="#E7C766">
                    <rect x="30" y="106" width="70" height="8" rx="4" />
                    <rect x="30" y="206" width="70" height="8" rx="4" />
                    <rect x="30" y="306" width="70" height="8" rx="4" />
                  </g>
                  <g fill="#5B6C9E">
                    <rect x="30" y="124" width="110" height="6" rx="3" />
                    <rect x="30" y="140" width="86" height="6" rx="3" />
                    <rect x="30" y="224" width="110" height="6" rx="3" />
                    <rect x="30" y="240" width="86" height="6" rx="3" />
                    <rect x="30" y="324" width="110" height="6" rx="3" />
                    <rect x="30" y="340" width="86" height="6" rx="3" />
                  </g>
                  <g fill="#D4AF37">
                    <rect x="140" y="150" width="46" height="16" rx="8" />
                    <rect x="140" y="250" width="46" height="16" rx="8" />
                    <rect x="140" y="350" width="46" height="16" rx="8" />
                  </g>
                </svg>
              </div>
              <!-- 3 · Biometrics -->
              <div class="phone">
                <svg
                  viewBox="0 0 216 440"
                  role="img"
                  aria-label="Secure login screen"
                >
                  <rect width="216" height="440" fill="#0B1B3F" />
                  <circle
                    cx="108"
                    cy="150"
                    r="58"
                    fill="#12275A"
                    stroke="#D4AF37"
                    stroke-width="2"
                  />
                  <path
                    d="M108 116c-16 0-29 13-29 29v22c0 16 13 29 29 29s29-13 29-29v-22c0-16-13-29-29-29z"
                    fill="none"
                    stroke="#E7C766"
                    stroke-width="3"
                  />
                  <path
                    d="M96 150c0-7 5-12 12-12s12 5 12 12v18"
                    fill="none"
                    stroke="#E7C766"
                    stroke-width="3"
                    stroke-linecap="round"
                  />
                  <rect
                    x="46"
                    y="238"
                    width="124"
                    height="10"
                    rx="5"
                    fill="#E7C766"
                  />
                  <g fill="#5B6C9E">
                    <rect x="34" y="266" width="148" height="6" rx="3" />
                    <rect x="52" y="282" width="112" height="6" rx="3" />
                  </g>
                  <rect
                    x="30"
                    y="326"
                    width="156"
                    height="44"
                    rx="12"
                    fill="#D4AF37"
                  />
                  <rect
                    x="78"
                    y="344"
                    width="60"
                    height="8"
                    rx="4"
                    fill="#0B1B3F"
                  />
                  <rect
                    x="30"
                    y="382"
                    width="156"
                    height="14"
                    rx="7"
                    fill="#12275A"
                  />
                </svg>
              </div>
              <!-- 4 · Pay interest -->
              <div class="phone">
                <svg
                  viewBox="0 0 216 440"
                  role="img"
                  aria-label="Pay interest screen"
                >
                  <rect width="216" height="440" fill="#0A0F2C" />
                  <rect width="216" height="180" rx="0" fill="#12275A" />
                  <circle
                    cx="108"
                    cy="86"
                    r="34"
                    fill="none"
                    stroke="#D4AF37"
                    stroke-width="3"
                  />
                  <path
                    d="M96 86l9 9 17-19"
                    fill="none"
                    stroke="#E7C766"
                    stroke-width="4"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                  />
                  <rect
                    x="58"
                    y="136"
                    width="100"
                    height="9"
                    rx="4.5"
                    fill="#E7C766"
                  />
                  <rect
                    x="16"
                    y="204"
                    width="184"
                    height="60"
                    rx="14"
                    fill="#12275A"
                  />
                  <rect
                    x="30"
                    y="220"
                    width="60"
                    height="6"
                    rx="3"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="30"
                    y="234"
                    width="96"
                    height="12"
                    rx="5"
                    fill="#D4AF37"
                  />
                  <g fill="#12275A">
                    <rect x="16" y="278" width="88" height="40" rx="10" />
                    <rect x="112" y="278" width="88" height="40" rx="10" />
                  </g>
                  <g fill="#5B6C9E">
                    <rect x="32" y="294" width="56" height="7" rx="3.5" />
                    <rect x="128" y="294" width="56" height="7" rx="3.5" />
                  </g>
                  <rect
                    x="16"
                    y="340"
                    width="184"
                    height="44"
                    rx="12"
                    fill="#D4AF37"
                  />
                  <rect
                    x="76"
                    y="358"
                    width="64"
                    height="8"
                    rx="4"
                    fill="#0B1B3F"
                  />
                </svg>
              </div>
              <!-- 5 · Gold calculator -->
              <div class="phone">
                <svg
                  viewBox="0 0 216 440"
                  role="img"
                  aria-label="Gold calculator screen"
                >
                  <rect width="216" height="440" fill="#0B1B3F" />
                  <rect width="216" height="62" fill="#12275A" />
                  <rect
                    x="20"
                    y="28"
                    width="88"
                    height="8"
                    rx="4"
                    fill="#E7C766"
                  />
                  <ellipse
                    cx="108"
                    cy="124"
                    rx="44"
                    ry="16"
                    fill="#D4AF37"
                    opacity=".9"
                  />
                  <path
                    d="M64 124v22c0 9 20 16 44 16s44-7 44-16v-22"
                    fill="#C9A227"
                  />
                  <rect
                    x="20"
                    y="188"
                    width="176"
                    height="8"
                    rx="4"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="20"
                    y="188"
                    width="112"
                    height="8"
                    rx="4"
                    fill="#D4AF37"
                  />
                  <circle cx="132" cy="192" r="11" fill="#F2DFA0" />
                  <rect
                    x="20"
                    y="224"
                    width="176"
                    height="8"
                    rx="4"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="20"
                    y="224"
                    width="66"
                    height="8"
                    rx="4"
                    fill="#D4AF37"
                  />
                  <circle cx="86" cy="228" r="11" fill="#F2DFA0" />
                  <rect
                    x="16"
                    y="264"
                    width="184"
                    height="74"
                    rx="14"
                    fill="#12275A"
                    stroke="#D4AF37"
                    stroke-opacity=".5"
                  />
                  <rect
                    x="32"
                    y="282"
                    width="70"
                    height="6"
                    rx="3"
                    fill="#5B6C9E"
                  />
                  <rect
                    x="32"
                    y="298"
                    width="118"
                    height="16"
                    rx="6"
                    fill="#E7C766"
                  />
                  <rect
                    x="16"
                    y="356"
                    width="184"
                    height="42"
                    rx="12"
                    fill="#D4AF37"
                  />
                  <rect
                    x="72"
                    y="373"
                    width="72"
                    height="8"
                    rx="4"
                    fill="#0B1B3F"
                  />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- ================= 11. NEWS & EVENTS ================= -->
      <section class="section section--alt" id="news">
        <div class="container">
          <div class="section-head" data-reveal>
            @if ($home['news']['eyebrow'])<span class="eyebrow">{!! $home['news']['eyebrow'] !!}</span>@endif
            <h2>{!! $home['news']['heading'] !!}</h2>
            @if ($home['news']['sub'])<p>{{ $home['news']['sub'] }}</p>@endif
          </div>

          <div class="grid grid--3">
            @forelse ($news ?? [] as $item)
              <x-site.news-card :item="$item" />
            @empty
              <p>News &amp; updates will appear here soon.</p>
            @endforelse
          </div>
        </div>
      </section>

      <!-- ================= 14. FAQ ================= -->
      <section class="section" id="faq">
        <div class="container">
          <div class="section-head" data-reveal>
            @if ($home['faq']['eyebrow'])<span class="eyebrow">{{ $home['faq']['eyebrow'] }}</span>@endif
            <h2>{!! $home['faq']['heading'] !!}</h2>
          </div>

          @if ($faqs->isNotEmpty())
          <div class="faq" id="faqList">
            @foreach ($faqs as $faq)
              <div class="acc" data-reveal>
                <button class="acc__btn" type="button" aria-expanded="false">
                  {{ $faq->question }}
                  <span class="acc__icon"><svg width="14" height="14"><use href="#i-plus" /></svg></span>
                </button>
                <div class="acc__panel">
                  <div>{!! $faq->answer !!}</div>
                </div>
              </div>
            @endforeach
          </div>
          @endif
        </div>
      </section>

      <!-- ================= 15. ENQUIRY / CONTACT ================= -->
      <section class="section section--alt" id="contact">
        <div class="container">
          <div class="section-head" data-reveal>
            @if ($home['contact']['eyebrow'])<span class="eyebrow">{{ $home['contact']['eyebrow'] }}</span>@endif
            <h2>{!! $home['contact']['heading'] !!}</h2>
            @if ($home['contact']['sub'])<p>{{ $home['contact']['sub'] }}</p>@endif
          </div>

          <div class="enquiry">
            <x-site.contact-card />
            <x-site.enquiry-form />
          </div>
        </div>
      </section>
@endsection
