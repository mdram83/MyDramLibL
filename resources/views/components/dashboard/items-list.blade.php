@props(['items', 'noItemsMessage'])

@if(count($items) > 0)
    <ul>
        @foreach($items as $item)
            <li class="py-0.5 truncate">
                <a class="hover:underline"
                   href="{{ $navigator->getItemableShowLink($item) }}"
                >
                    <div class="flex items-center">
                        <img class="w-6" alt="Thumbnail"
                             src="{{ $item->thumbnail ?? $navigator->getItemableDefaultThumbnail($item) }}"
                        >
                        <span class="pl-2">{{ $item->title }}</span>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
@else
    <p>{{ $noItemsMessage }}</p>
@endif


