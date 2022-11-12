@if ($tags)
    <p class="text-sm leading-6 pt-2">
        @foreach ($tags as $tag)
            <span class="my-1 mr-2 px-2 bg-gray-400 text-white rounded-xl">
                {{ $tag->name }}
            </span>
        @endforeach
    </p>
@endif
