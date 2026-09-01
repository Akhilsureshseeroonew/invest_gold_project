@extends('layouts.site')

@section('title', $job->title.' · Careers · '.config('site.short_name'))
@section('meta_description', $job->summary)

@php
    $badges = collect([$job->location, $job->department, $job->employment_type, $job->experience])->filter();
    $meta = collect([
        ['calendar', 'Posted', optional($job->posted_at)->format('d F Y')],
        ['rupee', 'Salary range', $job->salary_range],
        ['pin', 'Location', $job->location],
    ])->filter(fn ($m) => filled($m[2]));
    $applied = session('application_sent');
@endphp

@section('content')
    <section class="section">
        <div class="container">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ url('/') }}">Home</a> <i>/</i>
                <a href="{{ url('/careers') }}">Careers</a> <i>/</i>
                <em>{{ $job->title }}</em>
            </nav>

            <div class="grid" style="grid-template-columns:1.55fr .45fr;gap:clamp(1.6rem,4vw,3rem);align-items:start;margin-top:1.4rem">
                <div data-reveal="left">
                    <h1 style="font-size:clamp(1.9rem,4vw,3rem)">{{ $job->title }}</h1>

                    @if ($badges->isNotEmpty())
                        <div class="job__badges">
                            @foreach ($badges as $b)
                                <span class="tagpill">{{ $b }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if ($meta->isNotEmpty())
                        <div class="metarow" style="margin-top:0">
                            @foreach ($meta as [$icon, $label, $value])
                                <div>
                                    <svg width="18" height="18"><use href="#i-{{ $icon }}"/></svg>
                                    <span><b>{{ $label }}</b>{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="article" style="max-width:none">
                        @if (filled($job->description))
                            <h2>About the role</h2>
                            {!! $job->description !!}
                        @elseif ($job->summary)
                            <h2>About the role</h2>
                            <p>{{ $job->summary }}</p>
                        @endif

                        @if (filled($job->responsibilities))
                            <h2>What you will do</h2>
                            <ul>@foreach ($job->responsibilities as $r)<li>{!! $r !!}</li>@endforeach</ul>
                        @endif

                        @if (filled($job->requirements))
                            <h2>What we are looking for</h2>
                            <ul>@foreach ($job->requirements as $r)<li>{!! $r !!}</li>@endforeach</ul>
                        @endif

                        @if (filled($job->benefits))
                            <h2>What we offer</h2>
                            <ul>@foreach ($job->benefits as $r)<li>{!! $r !!}</li>@endforeach</ul>
                        @endif
                    </div>

                    <a class="btn btn--ghost" href="{{ url('/careers') }}" style="margin-top:2rem">
                        <svg width="15" height="15"><use href="#i-chev-left"/></svg> Back to all openings
                    </a>
                </div>

                <aside class="card sticky-apply" data-reveal="right">
                    <div class="card-icon"><svg width="28" height="28"><use href="#i-briefcase"/></svg></div>
                    <h3 style="font-size:1.15rem">Apply for this role</h3>
                    <p style="font-size:.88rem">Send your details and CV — our HR team responds to every shortlisted application within 7 working days.</p>
                    <button class="btn btn--gold btn--block" type="button" data-modal-open="applyModal" style="margin-top:1rem">
                        Apply Now <svg width="16" height="16"><use href="#i-arrow-right"/></svg>
                    </button>
                    <p class="disclaimer" style="margin-top:1rem">
                        Or email your CV to
                        <a href="mailto:{{ config('site.email') }}" style="color:var(--gold-ink)">{{ config('site.email') }}</a>
                    </p>
                    @if ($job->closing_at)
                        <p class="disclaimer">Applications close {{ $job->closing_at->format('d M Y') }}</p>
                    @endif
                </aside>
            </div>
        </div>
    </section>

    {{-- application modal --}}
    <div class="modal" id="applyModal" role="dialog" aria-modal="true" aria-labelledby="applyTitle">
        <div class="modal__box">
            <button class="modal__close" type="button" data-modal-close aria-label="Close">
                <svg width="16" height="16"><use href="#i-close"/></svg>
            </button>
            <span class="eyebrow">Application</span>
            <h3 id="applyTitle" style="margin:.9rem 0 1.3rem">
                {{ $job->title }}@if ($job->location) — {{ $job->location }}@endif
            </h3>

            <form id="applyForm" method="post" action="{{ route('careers.apply', $job) }}"
                  enctype="multipart/form-data" novalidate>
                @csrf
                <input type="hidden" name="source_url" value="{{ url()->current() }}">

                <div @class(['field', 'is-invalid' => $errors->has('name')])>
                    <label for="aName">Full name</label>
                    <input class="input" type="text" id="aName" name="name" value="{{ old('name') }}"
                           placeholder="Your full name" autocomplete="name" required>
                    <span class="err">{{ $errors->first('name') ?: 'Please enter your name.' }}</span>
                </div>
                <div @class(['field', 'is-invalid' => $errors->has('email')])>
                    <label for="aEmail">Email</label>
                    <input class="input" type="email" id="aEmail" name="email" value="{{ old('email') }}"
                           placeholder="you@example.com" autocomplete="email" required>
                    <span class="err">{{ $errors->first('email') ?: 'Please enter a valid email address.' }}</span>
                </div>
                <div @class(['field', 'is-invalid' => $errors->has('phone_normalised')])>
                    <label for="aPhone">Phone number</label>
                    <input class="input" type="tel" id="aPhone" name="phone" value="{{ old('phone') }}"
                           placeholder="10-digit mobile number" autocomplete="tel" inputmode="numeric" required>
                    <span class="err">{{ $errors->first('phone_normalised') ?: 'Please enter a valid 10-digit number.' }}</span>
                </div>
                <div @class(['field', 'is-invalid' => $errors->has('cv')])>
                    <label for="aCv">Upload CV</label>
                    <label class="filedrop" for="aCv">
                        <svg width="22" height="22"><use href="#i-upload"/></svg>
                        <span id="aCvName">PDF or DOC, up to 5 MB</span>
                        <input type="file" id="aCv" name="cv" accept=".pdf,.doc,.docx" required>
                    </label>
                    <span class="err">{{ $errors->first('cv') ?: 'Please attach your CV.' }}</span>
                </div>
                <button class="btn btn--gold btn--block" type="submit" style="margin-top:.6rem">
                    Submit Application <svg width="16" height="16"><use href="#i-arrow-right"/></svg>
                </button>
                <div @class(['form-ok', 'is-shown' => $applied]) id="applyOk" role="status">
                    <b>Application received!</b> Our HR team will be in touch if your profile matches.
                </div>
            </form>
        </div>
    </div>
@endsection
