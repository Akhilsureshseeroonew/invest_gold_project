@extends('layouts.site')

@section('title', $page->seo_title ?: $page->title.' · '.config('site.short_name'))
@section('meta_description', $page->seo_description)

@section('content')
    <x-site.hero
        :heading="$page->hero_heading ?: $page->title"
        :eyebrow="$page->hero_eyebrow"
        :lead="$page->hero_lead"
        :ctas="$page->hero_ctas ?? []"
        :breadcrumb="[['Home', url('/')], ['Investment', url('/investment')], [$page->title, null]]"
    />

    <section class="section">
        <div class="container">
            <div class="faq" style="max-width:960px">
                @forelse ($schemes as $scheme)
                    <div class="card rate" data-reveal>
                        <div class="rate__head">
                            <div style="display:flex;align-items:center;gap:1rem">
                                <div class="card-icon" style="margin:0;width:48px;height:48px">
                                    <svg width="22" height="22"><use href="#i-{{ $scheme->icon ?: 'chart' }}"/></svg>
                                </div>
                                <h3>{{ $scheme->title }}</h3>
                            </div>
                            <span class="acc__icon"><svg width="14" height="14"><use href="#i-plus"/></svg></span>
                        </div>
                        <div class="rate__panel"><div>
                            <div class="table-wrap">
                                <table class="rates">
                                    @if (filled($scheme->columns))
                                        <thead>
                                            <tr>@foreach ($scheme->columns as $col)<th>{{ $col }}</th>@endforeach</tr>
                                        </thead>
                                    @endif
                                    <tbody>
                                        @foreach ($scheme->rows ?? [] as $row)
                                            <tr>@foreach ((array) $row as $cell)<td>{{ $cell }}</td>@endforeach</tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($scheme->note)
                                <p class="disclaimer">{{ $scheme->note }}</p>
                            @endif
                        </div></div>
                    </div>
                @empty
                    <p>Rate information will be published here shortly.</p>
                @endforelse
            </div>

            @if (filled($page->body))
                <div class="disclaimer" style="text-align:center;max-width:820px;margin:2.4rem auto 0">
                    {!! $page->body !!}
                </div>
            @endif
        </div>
    </section>

    <x-site.cta-band
        :title="$page->cta_heading ?: 'Want an exact figure?'"
        :text="$page->cta_text ?: 'Our branch team will confirm today\'s applicable rate for your scheme, tenure and amount.'"
        :ctas="[
            ['label' => 'Enquire Now', 'url' => url('/contact'), 'style' => 'btn--gold', 'icon' => 'arrow-right'],
            ['label' => 'Find a Branch', 'url' => url('/branches'), 'style' => 'btn--ghost'],
        ]"
    />
@endsection
