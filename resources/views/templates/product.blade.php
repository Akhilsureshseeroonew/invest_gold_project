@extends('layouts.site')

@section('title', $page->seo_title ?: $page->title.' · '.config('site.short_name'))
@section('meta_description', $page->seo_description)

@section('content')
    <x-site.hero
        :heading="$page->hero_heading ?: $page->title"
        :eyebrow="$page->hero_eyebrow"
        :lead="$page->hero_lead"
        :ctas="$page->hero_ctas ?? []"
        :breadcrumb="$breadcrumb ?? [['Home', url('/')], ['Products', url('/products')], [$page->title, null]]"
    />

    @if (filled($page->body))
        <section class="section">
            <div class="container"><div class="article" data-reveal>{!! $page->body !!}</div></div>
        </section>
    @endif

    @if (filled($page->features) || filled($page->steps))
        <section class="section">
            <div class="container grid grid--2" style="gap:clamp(1.8rem,4vw,3.4rem);align-items:start">
                <div data-reveal="left">
                    <span class="eyebrow">Why Choose {{ config('site.short_name') }}</span>
                    <h2 style="margin:1.1rem 0 1.4rem">Built for Speed, Security &amp; Clear Terms</h2>
                    <x-site.checks :items="$page->features ?? []" />
                    <div class="pagehero__cta">
                        <a class="btn btn--gold" href="{{ url('/contact?service='.rawurlencode($page->title)) }}">
                            Enquire Now <svg width="16" height="16"><use href="#i-arrow-right"/></svg>
                        </a>
                    </div>
                </div>
                <div data-reveal="right">
                    <span class="eyebrow">How It Works</span>
                    <h2 style="margin:1.1rem 0 1.4rem">How Our {{ $page->title }} Process Works</h2>
                    <x-site.steps :items="$page->steps ?? []" />
                </div>
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
        :ctas="[
            ['label' => 'Enquire Now', 'url' => url('/contact?service='.rawurlencode($page->title)), 'style' => 'btn--gold'],
            ['label' => 'Find a Branch', 'url' => url('/branches'), 'style' => 'btn--ghost'],
        ]"
    />

    @if (filled(config('site.loan_disclaimer')))
        <section class="section">
            <div class="container" style="max-width:900px">
                <h3 style="font-size:1.15rem;margin-bottom:1rem">Disclaimer</h3>
                @foreach (preg_split('/\R\s*\R/', trim(config('site.loan_disclaimer'))) as $para)
                    <p class="disclaimer">{{ $para }}</p>
                @endforeach
            </div>
        </section>
    @endif
@endsection
