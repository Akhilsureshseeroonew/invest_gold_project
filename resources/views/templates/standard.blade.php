@extends('layouts.site')

@section('title', $page->seo_title ?: $page->title.' · '.config('site.short_name'))
@section('meta_description', $page->seo_description)

@section('content')
    <x-site.hero
        :heading="$page->hero_heading ?: $page->title"
        :eyebrow="$page->hero_eyebrow"
        :lead="$page->hero_lead"
        :ctas="$page->hero_ctas ?? []"
        :breadcrumb="$breadcrumb ?? null"
    />

    @if (filled($page->body))
        <section class="section">
            <div class="container">
                <div class="article" data-reveal>{!! $page->body !!}</div>
            </div>
        </section>
    @endif

    @if (filled($page->highlights))
        <section class="section section--alt">
            <div class="container">
                <div class="grid grid--{{ min(count($page->highlights), 3) }}" style="gap:1.1rem">
                    @foreach ($page->highlights as $card)
                        @php $card = (array) $card; @endphp
                        <div class="card" style="padding:1.5rem 1.35rem" data-reveal="zoom">
                            <div class="card-icon"><svg width="28" height="28"><use href="#i-{{ $card['icon'] ?? 'trend' }}"/></svg></div>
                            <h3 style="font-size:1.1rem">{{ $card['title'] ?? '' }}</h3>
                            <p style="font-size:.88rem;margin:0">{{ $card['text'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (filled($page->stats))
        <section class="section">
            <div class="container">
                <div class="stats">
                    @foreach ($page->stats as $stat)
                        @php $stat = (array) $stat; @endphp
                        <div class="stat" data-reveal="zoom">
                            <b class="gold-text">{{ $stat['value'] ?? '' }}</b>
                            <span>{{ $stat['label'] ?? '' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if (filled($page->features) || filled($page->steps))
        <section class="section {{ filled($page->stats) ? 'section--alt' : '' }}">
            <div class="container grid grid--2" style="gap:clamp(1.8rem,4vw,3.4rem);align-items:start">
                @if (filled($page->features))
                    <div data-reveal="left">
                        <span class="eyebrow">Highlights</span>
                        <h2 style="margin:1.1rem 0 1.4rem">What You Get</h2>
                        <x-site.checks :items="$page->features" />
                    </div>
                @endif
                @if (filled($page->steps))
                    <div data-reveal="right">
                        <span class="eyebrow">How It Works</span>
                        <h2 style="margin:1.1rem 0 1.4rem">Step by Step</h2>
                        <x-site.steps :items="$page->steps" />
                    </div>
                @endif
            </div>
        </section>
    @endif

    @if (filled($page->extra_html))
        <section class="section section--alt">
            <div class="container"><div class="article" data-reveal>{!! $page->extra_html !!}</div></div>
        </section>
    @endif

    <x-site.cta-band
        :title="$page->cta_heading ?: 'Ready to get started?'"
        :text="$page->cta_text ?: 'Visit your nearest branch or send an enquiry — our team will walk you through eligibility and documentation.'"
    />
@endsection
