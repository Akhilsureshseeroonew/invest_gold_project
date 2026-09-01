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

    @if (filled($page->body))
        <section class="section">
            <div class="container">
                <x-site.section-head eyebrow="Governance" title='Built on Fair, Transparent <span class="gold-text">Practice</span>' />
                <div class="article" data-reveal>{!! $page->body !!}</div>
            </div>
        </section>
    @endif

    <section class="section section--alt" id="downloads">
        <div class="container">
            <div class="section-head" data-reveal>
                <span class="eyebrow">Documents</span>
                <h2>Policy <span class="gold-text">Documents</span></h2>
                <p>Board-approved policies, codes and certificates. Rows tagged <b>Download</b> save as a PDF;
                   rows tagged <b>View</b> open in a viewer on this page and are not offered as downloads.</p>
            </div>

            <div class="dl">
                @forelse ($policies as $policy)
                    @php $url = \App\Support\Assets::policyUrl($policy->file_path); @endphp
                    @if (! $policy->file_path)
                        @continue
                    @endif
                    @php
                        $isView = $policy->access === 'view_only';
                        $rowIcon = $policy->icon ?: ($isView ? 'doc' : 'download');
                    @endphp

                    <div class="dl__item" data-reveal>
                        <button type="button" class="dl__main"
                                data-modal-open="docModal"
                                data-doc-title="{{ strip_tags(html_entity_decode($policy->title)) }}"
                                data-doc-src="{{ $url }}">
                            <svg width="22" height="22"><use href="#i-{{ $rowIcon }}"/></svg>
                            <span>
                                <b>{!! $policy->title !!}</b>
                                <small>{{ $isView ? 'View only · not downloadable' : ($policy->file_size_label ?: 'PDF') }}</small>
                            </span>
                        </button>
                        <div class="dl__actions">
                            <button type="button" class="dl__tag"
                                    data-modal-open="docModal"
                                    data-doc-title="{{ strip_tags(html_entity_decode($policy->title)) }}"
                                    data-doc-src="{{ $url }}">View</button>
                            @unless ($isView)
                                <a class="dl__tag dl__tag--dl" href="{{ $url }}" download>Download</a>
                            @endunless
                        </div>
                    </div>
                @empty
                    <p>Documents will be published here shortly.</p>
                @endforelse
            </div>

            @if (filled($page->extra_html))
                <div class="disclaimer" style="text-align:center;margin-top:1.4rem">{!! $page->extra_html !!}</div>
            @endif
        </div>
    </section>

    <x-site.cta-band
        :title="$page->cta_heading ?: 'Need a document that is not listed?'"
        :text="$page->cta_text ?: 'Write to us and our compliance team will share the relevant policy or certificate.'"
        :ctas="[
            ['label' => 'Contact Us', 'url' => url('/contact'), 'style' => 'btn--gold', 'icon' => 'arrow-right'],
            ['label' => 'Find a Branch', 'url' => url('/contact#branches'), 'style' => 'btn--ghost'],
        ]" />

    {{-- ================= IN-PAGE DOCUMENT VIEWER ================= --}}
    <div class="modal" id="docModal" role="dialog" aria-modal="true" aria-labelledby="docModalTitle">
        <div class="modal__box modal__box--wide">
            <button class="modal__close" type="button" data-modal-close aria-label="Close viewer">
                <svg width="16" height="16"><use href="#i-close"/></svg>
            </button>
            <h3 id="docModalTitle" style="font-size:1.15rem;margin-bottom:1rem;padding-right:2.4rem">Document</h3>
            <iframe class="docview" id="docFrame" title="Document viewer" src="about:blank"></iframe>
            <p class="disclaimer" style="margin-top:1rem;margin-bottom:0">
                For on-screen reference only. Contact us if you need a certified copy.
            </p>
        </div>
    </div>
@endsection

@push('scripts')
<script>
/* Feeds the shared modal a PDF before main.js opens it, and empties the iframe
   on close so a closed viewer holds nothing. */
(function () {
    var modal = document.getElementById('docModal'),
        frame = document.getElementById('docFrame'),
        title = document.getElementById('docModalTitle');
    if (!modal || !frame) return;

    document.querySelectorAll('[data-doc-src]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            frame.src = btn.getAttribute('data-doc-src') + '#toolbar=0&navpanes=0';
            title.textContent = btn.getAttribute('data-doc-title') || 'Document';
        });
    });

    new MutationObserver(function () {
        if (!modal.classList.contains('is-open')) frame.src = 'about:blank';
    }).observe(modal, { attributes: true, attributeFilter: ['class'] });
})();
</script>
@endpush
