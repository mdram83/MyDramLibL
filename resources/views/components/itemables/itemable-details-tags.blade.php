@if ($tags)
    <p class="text-xs leading-4 flex flex-wrap">
        @foreach ($tags as $tag)
            <span class="my-1 mx-1 px-1.5 bg-gray-400 text-white rounded-xl">
                {{ $tag->name }}
            </span>
        @endforeach
    </p>
@endif
