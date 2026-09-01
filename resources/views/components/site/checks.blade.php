@props(['items' => []])

@if (filled($items))
    <ul class="checks">
        @foreach ($items as $item)
            <li>
                <svg width="19" height="19"><use href="#i-check"/></svg>
                <span>{!! $item !!}</span>
            </li>
        @endforeach
    </ul>
@endif
