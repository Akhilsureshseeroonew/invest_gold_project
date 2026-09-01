@extends('layouts.site')

@section('title', $page->seo_title ?: $page->title.' · '.config('site.short_name'))
@section('meta_description', $page->seo_description)

@php
    // Reuse this scheme's own enquiry link (with its ?service= prefill) for the closing band.
    $enquiryUrl = collect($page->hero_ctas ?? [])
        ->first(fn ($c) => str_contains((string) (((array) $c)['url'] ?? ''), '/contact'))['url']
        ?? '/contact?service='.rawurlencode($page->title);
@endphp

@section('content')
    <x-site.hero
        :heading="$page->hero_heading ?: $page->title"
        :eyebrow="$page->hero_eyebrow"
        :lead="$page->hero_lead"
        :ctas="$page->hero_ctas ?? []"
        :breadcrumb="[['Home', url('/')], ['Investment', url('/investment')], [$page->title, null]]"
    />

    @if (filled($page->highlights))
        <section class="section">
            <div class="container">
                <x-site.section-head eyebrow="At a Glance"
                    :title="'The Scheme in <span class=\'gold-text\'>Four Lines</span>'" />
                <x-site.glance :cards="$page->highlights" />
            </div>
        </section>
    @endif

    @php $hasLeft = filled($page->body) || filled($page->features); @endphp

    @if ($hasLeft && filled($page->steps))
        <section class="section section--alt">
            <div class="container grid grid--2" style="gap:clamp(1.8rem,4vw,3.4rem);align-items:start">
                <div data-reveal="left">
                    @if (filled($page->body))
                        <div class="article">{!! $page->body !!}</div>
                    @else
                        <span class="eyebrow">Comparison</span>
                        <h2 style="margin:1.1rem 0 1.4rem">How It Differs</h2>
                        <x-site.checks :items="$page->features" />
                    @endif
                </div>
                <div data-reveal="right">
                    <span class="eyebrow">How It Works</span>
                    <h2 style="margin:1.1rem 0 1.4rem">From Application to Maturity</h2>
                    <x-site.steps :items="$page->steps" />
                </div>
            </div>
        </section>
    @elseif (filled($page->steps))
        <section class="section section--alt">
            <div class="container">
                <x-site.section-head eyebrow="How the Scheme Works"
                    :title="'Every Step, <span class=\'gold-text\'>Start to Maturity</span>'" />
                <x-site.steps :items="$page->steps" />
            </div>
        </section>
    @endif

    @if (filled($page->extra_html))
        <section class="section">
            <div class="container"><div class="article" data-reveal>{!! $page->extra_html !!}</div></div>
        </section>
    @endif

    <x-site.cta-band
        :title="$page->cta_heading ?: 'Talk to our investment desk'"
        :text="$page->cta_text ?: 'We will explain payout modes, documentation and the certificate you receive.'"
        :ctas="[['label' => 'Enquire Now', 'url' => url($enquiryUrl), 'style' => 'btn--gold', 'icon' => 'arrow-right']]"
    />
@endsection
