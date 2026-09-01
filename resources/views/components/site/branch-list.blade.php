@props(['branches' => collect(), 'filter' => true])

@if ($filter)
    <div style="max-width:560px;margin:0 auto 2.6rem;position:relative" data-reveal>
        <svg width="18" height="18" style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:var(--gold-ink);pointer-events:none"><use href="#i-search"/></svg>
        <input class="input" type="search" id="branchSearch" placeholder="Type a branch name or city…"
               style="padding-left:3rem" aria-label="Search branches">
    </div>
@endif

<div class="grid grid--3" id="branchList">
    @forelse ($branches as $branch)
        @php
            $addr = collect([$branch->address, $branch->city, $branch->pincode])->filter()->implode(', ');
            $mapSrc = $branch->maps_url
                ?: 'https://www.google.com/maps?q='.urlencode($addr ?: $branch->name).'&output=embed';
        @endphp
        <article class="card branch-near" data-reveal="zoom"
                 data-branch="{{ \Illuminate\Support\Str::lower(trim($branch->name.' '.$branch->city.' '.$branch->district)) }}">
            @if ($loop->first)
                <span class="invest__tag" style="position:absolute;top:1.1rem;right:1.2rem">Head office</span>
            @endif
            <div class="card-icon"><svg width="28" height="28"><use href="#i-pin"/></svg></div>
            <h3 style="font-size:1.15rem">{{ $branch->name }}</h3>
            <p style="font-size:.88rem">{{ $addr }}</p>
            <p style="font-size:.88rem;margin-bottom:1rem">
                @if ($branch->phone)
                    <a href="tel:{{ preg_replace('/\s+/', '', $branch->phone) }}" style="color:var(--gold-ink)">{{ $branch->phone }}</a><br>
                @endif
                @if ($branch->email)
                    <a href="mailto:{{ $branch->email }}" style="color:var(--gold-ink)">{{ $branch->email }}</a>
                @endif
            </p>
            @if ($branch->hours)
                <p class="disclaimer" style="margin-bottom:.8rem">{{ $branch->hours }}</p>
            @endif
            <iframe class="branch-map" loading="lazy" title="Map of {{ $branch->name }} branch"
                    src="{{ $mapSrc }}" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </article>
    @empty
        <p>Branch list coming soon.</p>
    @endforelse
</div>

@if ($filter)
    <p class="disclaimer" id="branchNoMatch" style="display:none;margin-top:1rem">
        No branch matches that search. Try another city, or
        <a href="#enquiry" style="color:var(--gold-ink)">send us an enquiry</a>.
    </p>
    @once
    @push('scripts')
    <script>
        (function () {
            var input = document.getElementById('branchSearch');
            if (!input) return;
            var cards = Array.prototype.slice.call(document.querySelectorAll('#branchList [data-branch]'));
            var empty = document.getElementById('branchNoMatch');
            input.addEventListener('input', function () {
                var q = this.value.trim().toLowerCase(), shown = 0;
                cards.forEach(function (c) {
                    var hit = !q || c.getAttribute('data-branch').indexOf(q) !== -1;
                    c.style.display = hit ? '' : 'none';
                    if (hit) shown++;
                });
                if (empty) empty.style.display = shown ? 'none' : '';
            });
        })();
    </script>
    @endpush
    @endonce
@endif
