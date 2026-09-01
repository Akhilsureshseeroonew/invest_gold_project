@props(['cards' => []])

@if (filled($cards))
    <div class="glance">
        @foreach ($cards as $card)
            @php $card = (array) $card; @endphp
            <div data-reveal="zoom">
                <svg width="24" height="24"><use href="#i-{{ $card['icon'] ?? 'check' }}"/></svg>
                <b>{{ $card['title'] ?? '' }}</b>
                <span>{{ $card['text'] ?? '' }}</span>
            </div>
        @endforeach
    </div>
@endif
