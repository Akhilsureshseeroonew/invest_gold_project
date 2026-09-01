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
        <div class="container">
            <div class="grid grid--2">
                @foreach ($children as $child)
                    <article class="card product" data-reveal="zoom">
                        @if ($child->card_tag)
                            <span class="ribbon">{{ $child->card_tag }}</span>
                        @endif
                        <div class="card-icon"><svg width="28" height="28"><use href="#i-{{ $child->icon ?: 'coin' }}"/></svg></div>
                        <h3>{{ $child->title }}</h3>
                        @if ($child->hero_eyebrow)
                            <div class="product__sub">{{ $child->hero_eyebrow }}</div>
                        @endif
                        <p>{{ $child->seo_description ?: strip_tags($child->hero_lead) }}</p>
                        <a class="link-arrow" href="{{ $child->url() }}">
                            {{ $child->card_cta ?: 'Explore '.$child->title }} <svg width="15" height="15"><use href="#i-arrow-right"/></svg>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @if (filled($page->body))
        <section class="section section--alt">
            <div class="container"><div class="article" data-reveal>{!! $page->body !!}</div></div>
        </section>
    @endif

    <x-site.cta-band
        :title="$page->cta_heading ?: 'Not sure which product fits?'"
        :text="$page->cta_text ?: 'Send us a note describing what you need — we will recommend the right option and the documents to bring.'"
        :ctas="[
            ['label' => 'Enquire Now', 'url' => url('/contact'), 'style' => 'btn--gold', 'icon' => 'arrow-right'],
            ['label' => 'See Investments', 'url' => url('/investment'), 'style' => 'btn--ghost'],
        ]"
    />
@endsection
