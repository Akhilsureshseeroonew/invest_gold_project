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
            @forelse ($posts as $post)
                <x-site.post-card :post="$post" />
            @empty
                <p>No articles published yet.</p>
            @endforelse
        </div>

        @if ($posts->hasPages())
            <div class="container" style="margin-top:2rem">{{ $posts->links() }}</div>
        @endif
    </section>

    <x-site.cta-band
        :title="$page->cta_heading ?: 'Have a question we should answer?'"
        :text="$page->cta_text ?: 'Tell us what you would like explained and we will cover it in an upcoming article.'"
        :ctas="[['label' => 'Suggest a Topic', 'url' => url('/contact'), 'style' => 'btn--gold', 'icon' => 'arrow-right']]" />
@endsection
