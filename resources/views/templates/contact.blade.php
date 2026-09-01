@extends('layouts.site')

@section('title', $page->seo_title ?: $page->title.' · '.config('site.short_name'))
@section('meta_description', $page->seo_description)

@php
    $headOffice = $branches->first(fn ($b) => str_contains(strtolower($b->name), 'head office')) ?? $branches->first();
@endphp

@section('content')
    <x-site.hero
        :heading="$page->hero_heading ?: $page->title"
        :eyebrow="$page->hero_eyebrow"
        :lead="$page->hero_lead"
        :ctas="$page->hero_ctas ?? [
            ['label' => config('site.phone_primary'), 'url' => 'tel:'.config('site.phone_primary_tel'), 'style' => 'btn--gold', 'icon' => 'phone'],
            ['label' => 'WhatsApp Us', 'url' => 'https://wa.me/'.config('site.whatsapp'), 'style' => 'btn--ghost'],
            ['label' => 'Find a Branch', 'url' => '#branches', 'style' => 'btn--ghost'],
        ]"
        :breadcrumb="[['Home', url('/')], [$page->title, null]]"
    />

    <section class="section" id="enquiry">
        <div class="container enquiry">
            <x-site.contact-card />
            <x-site.enquiry-form />
        </div>
    </section>

    @if ($headOffice)
        <section class="section section--alt">
            <div class="container">
                <x-site.section-head eyebrow="Find Us"
                    :title="'Corporate &amp; <span class=\'gold-text\'>Head Office</span>'"
                    :sub="config('site.address_full')" />
                <div class="card" style="padding:0;overflow:hidden" data-reveal>
                    <iframe title="Invest Gold head office location" loading="lazy"
                        style="width:100%;height:400px;border:0;display:block;filter:saturate(.9)"
                        src="{{ $headOffice->maps_url ?: 'https://www.google.com/maps?q='.urlencode(config('site.address_full')).'&output=embed' }}"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>
    @endif

    @if ($branches->isNotEmpty())
        <section class="section" id="branches">
            <div class="container">
                <x-site.section-head eyebrow="Branch Network"
                    :title="'Find a Branch <span class=\'gold-text\'>Near You</span>'"
                    sub="Invest Gold has a growing presence across Kerala. Search by branch name or city — the list filters as you type." />
                <x-site.branch-list :branches="$branches" />
            </div>
        </section>
    @endif

    <x-site.cta-band
        :title="$page->cta_heading ?: 'Prefer to speak to someone?'"
        :text="$page->cta_text ?: 'Our team is available Monday to Saturday, 9:30 AM to 5:30 PM.'"
        :ctas="[
            ['label' => config('site.phone_primary'), 'url' => 'tel:'.config('site.phone_primary_tel'), 'style' => 'btn--gold', 'icon' => 'phone'],
            ['label' => 'WhatsApp Us', 'url' => 'https://wa.me/'.config('site.whatsapp'), 'style' => 'btn--ghost'],
        ]"
    />
@endsection
