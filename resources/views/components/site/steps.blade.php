@props(['items' => []])

@if (filled($items))
    <ol class="steps">
        @foreach ($items as $item)
            <li>{!! $item !!}</li>
        @endforeach
    </ol>
@endif
