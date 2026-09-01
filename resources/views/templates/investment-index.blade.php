@extends('layouts.site')

@section('title', $page->seo_title ?: $page->title.' · '.config('site.short_name'))
@section('meta_description', $page->seo_description)

@section('content')
    <x-site.hero
        :heading="$page->hero_heading ?: $page->title"
        :eyebrow="$page->hero_eyebrow"
        :lead="$page->hero_lead"
        :ctas="$page->hero_ctas ?? []"
        :breadcrumb="[['Home', url('/')], [$page->title, null]]"
    />

    <section class="section">
        <div class="container grid grid--{{ min(max($children->count(), 1), 3) }}">
            @foreach ($children as $child)
                @php
                    $points = collect($child->highlights ?? [])
                        ->map(fn ($h) => ((array) $h)['text'] ?? ((array) $h)['title'] ?? null)
                        ->filter()->values()->all();
                @endphp
                <article @class(['card', 'invest', 'invest--feature' => $child->featured]) data-reveal="zoom">
                    <div class="invest__top">
                        <div class="card-icon" style="margin:0"><svg width="28" height="28"><use href="#i-{{ $child->icon ?: 'lock' }}"/></svg></div>
                        @if ($child->card_tag)
                            <span class="invest__tag">{{ $child->card_tag }}</span>
                        @endif
                    </div>
                    <h3>{{ $child->title }}</h3>
                    <p>{{ $child->seo_description ?: strip_tags($child->hero_lead) }}</p>
                    @if (filled($points))
                        <x-site.checks :items="array_slice($points, 0, 4)" />
                    @endif
                    <a class="link-arrow" href="{{ $child->url() }}" style="margin-top:1.4rem">
                        {{ $child->card_cta ?: 'Explore '.$child->title }} <svg width="15" height="15"><use href="#i-arrow-right"/></svg>
                    </a>
                </article>
            @endforeach
        </div>
    </section>

    @if (filled($page->body))
        <section class="section section--alt">
            <div class="container"><div class="article" data-reveal>{!! $page->body !!}</div></div>
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
        :ctas="[['label' => 'Enquire Now', 'url' => url('/contact?service=NCD%20Investment'), 'style' => 'btn--gold', 'icon' => 'arrow-right']]"
    />
@endsection
