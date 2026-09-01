@extends('layouts.site')

@section('title', 'Coming soon · '.config('site.short_name'))

@section('content')
    <section class="section">
        <div class="container" style="text-align:center;padding-block:4rem">
            <span class="eyebrow">Under construction</span>
            <h1 style="margin:1rem 0">This page is being built</h1>
            <p style="max-width:52ch;margin-inline:auto">
                The layout, navigation and styling are wired up. This page will be
                rendered from its content record once the admin panel and page
                models are in place.
            </p>
            <p style="margin-top:1.6rem">
                <a class="btn btn--gold" href="{{ url('/') }}">Back to home</a>
            </p>
        </div>
    </section>
@endsection
