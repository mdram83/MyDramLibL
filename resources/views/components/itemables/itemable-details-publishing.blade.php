@isset ($item->published_at)
    <p class="text-xs">Published: {{ $item->published_at }}</p>
@endisset

@isset ($item->publisher)
    <p class="text-xs pb-1">{{ $item->publisher->name }}</p>
@endisset

