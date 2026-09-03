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
        <div class="container grid grid--3">
            @forelse ($items as $item)
                <x-site.news-card :item="$item" />
            @empty
                <p>No news published yet.</p>
            @endforelse
        </div>

        @if ($items->hasPages())
            <div class="container" style="margin-top:2rem">{{ $items->links() }}</div>
        @endif
    </section>

    <x-site.cta-band
        :title="$page->cta_heading ?: 'Covering Invest Gold?'"
        :text="$page->cta_text ?: 'For press kits, spokesperson availability or event photography, get in touch with our communications desk.'"
        :ctas="[['label' => 'Contact the Comms Desk', 'url' => url('/contact'), 'style' => 'btn--gold', 'icon' => 'arrow-right']]" />
@endsection
