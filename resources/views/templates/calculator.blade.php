@extends('layouts.site')

@section('title', $page->seo_title ?: $page->title.' · '.config('site.short_name'))
@section('meta_description', $page->seo_description)

@section('content')
    <x-site.hero
        :heading="$page->hero_heading ?: $page->title"
        :eyebrow="$page->hero_eyebrow"
        :lead="$page->hero_lead"
        :ctas="$page->hero_ctas ?? []"
        :breadcrumb="[['Home', url('/')], ['Products', url('/products')], [$page->title, null]]"
    />

    <section class="section">
        <div class="container">
            <x-site.calculator-panel />
        </div>
    </section>

    @if (filled($page->highlights))
        <section class="section section--alt">
            <div class="container">
                <x-site.section-head eyebrow="How It Is Calculated"
                    :title="'What Goes Into <span class=\'gold-text\'>Your Estimate</span>'" />
                <div class="grid grid--{{ min(count($page->highlights), 3) }}">
                    @foreach ($page->highlights as $card)
                        @php $card = (array) $card; @endphp
                        <div data-reveal="zoom">
                            <h3 style="font-size:1.1rem">{{ $card['title'] ?? '' }}</h3>
                            <p style="font-size:.9rem;margin:0">{{ $card['text'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-site.cta-band
        :title="$page->cta_heading ?: 'Ready to get started?'"
        :text="$page->cta_text ?: 'Visit your nearest branch or send an enquiry — our team will walk you through eligibility and documentation.'"
    />
@endsection
