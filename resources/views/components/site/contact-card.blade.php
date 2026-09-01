<div class="contact-card" data-reveal="left">
    <div class="contact-row">
        <svg width="20" height="20"><use href="#i-building"/></svg>
        <div>
            <b>Corporate &amp; Head Office</b>
            <span>{{ config('site.company') }}<br>
                @foreach (config('site.address_lines') as $line){{ $line }}<br>@endforeach
            </span>
        </div>
    </div>
    <div class="contact-row">
        <svg width="20" height="20"><use href="#i-phone"/></svg>
        <div>
            <b>Phone</b>
            <span>
                <a href="tel:{{ config('site.phone_primary_tel') }}">{{ config('site.phone_primary') }}</a>
                @if (config('site.phone_secondary'))
                    &nbsp;·&nbsp; <a href="tel:{{ config('site.phone_secondary_tel') }}">{{ config('site.phone_secondary') }}</a>
                @endif
            </span>
        </div>
    </div>
    <div class="contact-row">
        <svg width="20" height="20"><use href="#i-mail"/></svg>
        <div><b>Email</b><span><a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a></span></div>
    </div>
    <div class="contact-row">
        <svg width="20" height="20"><use href="#i-whatsapp"/></svg>
        <div><b>WhatsApp</b><span><a href="https://wa.me/{{ config('site.whatsapp') }}" target="_blank" rel="noopener">Chat with our team →</a></span></div>
    </div>
    <div class="contact-row">
        <svg width="20" height="20"><use href="#i-clock"/></svg>
        <div><b>Working Hours</b><span>{{ config('site.hours') }}</span></div>
    </div>
</div>
