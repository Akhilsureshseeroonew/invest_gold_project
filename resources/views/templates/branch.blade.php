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

    <section class="section" id="branches">
        <div class="container">
            <x-site.branch-list :branches="$branches" />
        </div>
    </section>

    <section class="section section--alt" id="downloads">
        <div class="container">
            <x-site.section-head eyebrow="Downloads"
                :title="'Forms &amp; <span class=\'gold-text\'>Documents</span>'"
                sub="Application forms, the Fair Practice Code and other regulatory documents." />
            <p><a class="btn btn--ghost" href="{{ url('/policies') }}">Go to Downloads <svg width="15" height="15"><use href="#i-arrow-right"/></svg></a></p>
        </div>
    </section>

    <section class="section" id="enquiry">
        <div class="container">
            <x-site.section-head eyebrow="Get in Touch"
                :title="'Have a Question or <span class=\'gold-text\'>Need Assistance?</span>'" />
            <div class="enquiry">
                <x-site.contact-card />
                <x-site.enquiry-form />
            </div>
        </div>
    </section>

@endsection
