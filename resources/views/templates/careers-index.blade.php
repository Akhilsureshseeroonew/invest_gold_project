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

    <section class="section" id="openings">
        <div class="container">
            <x-site.section-head eyebrow="Open Positions"
                :title="'Current <span class=\'gold-text\'>Openings</span>'"
                sub="Click any role to see the full description and apply." />
            <div class="grid grid--3">
                @forelse ($jobs as $job)
                    <article class="card jobcard" data-reveal="zoom">
                        <div class="card-icon"><svg width="28" height="28"><use href="#i-briefcase"/></svg></div>
                        <h3 style="font-size:1.15rem">{{ $job->title }}</h3>
                        <p style="font-size:.86rem;display:flex;align-items:center;gap:.4rem">
                            <svg width="14" height="14"><use href="#i-pin"/></svg>
                            {{ collect([$job->location, $job->department, $job->employment_type])->filter()->implode(' · ') }}
                        </p>
                        <a class="btn btn--ghost btn--sm" href="{{ route('careers.show', $job) }}">Apply Now</a>
                    </article>
                @empty
                    <p>No open roles right now — check back soon.</p>
                @endforelse
            </div>
        </div>
    </section>

    @if (filled($page->highlights))
        <section class="section section--alt">
            <div class="container">
                <x-site.section-head eyebrow="Why Join"
                    :title="'What You Get <span class=\'gold-text\'>Working Here</span>'" />
                <div class="grid grid--4">
                    @foreach ($page->highlights as $card)
                        @php $card = (array) $card; @endphp
                        <div class="card" data-reveal="zoom">
                            <div class="card-icon"><svg width="28" height="28"><use href="#i-{{ $card['icon'] ?? 'award' }}"/></svg></div>
                            <h3 style="font-size:1.08rem">{{ $card['title'] ?? '' }}</h3>
                            <p style="font-size:.88rem;margin:0">{{ $card['text'] ?? '' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-site.cta-band
        :title="$page->cta_heading ?: \"Don't see your role?\""
        :text="$page->cta_text ?: 'Send us your CV anyway — we keep strong applications on file and reach out when a matching position opens.'"
        :ctas="[['label' => 'Send Your CV', 'url' => url('/contact?service=Careers'), 'style' => 'btn--gold', 'icon' => 'arrow-right']]" />
@endsection
