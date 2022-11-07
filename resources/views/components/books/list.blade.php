@props(['books'])

@foreach ($books as $book)

<div class="first:pt-8 last:pb-8 py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex items-center p-6 bg-white border-b border-gray-200">

                <!-- Thumbnail -->
                <div class="pr-2 sm:basis-24 basis-16 flex-none">
                    <img
                        class="max-h-24"
                        alt="Thumbnail"
                        src="{{ $book->item->thumbnail ?? '/images/thumbnail.png' }}">
                </div>

                <!-- Main data -->
                <div class="flex-auto">
                    <p class="font-semibold text-lg leading-tight">
                        <a href="/books/{{ $book->id }}" class="hover:underline">
                            {{ $book->item->title }}
                        </a>
                    </p>
                    <p class="text-sm pt-1 italic">
{{--                        TODO authors in model and dinamically displayed --}}
                        Kozłowski, Paweł <strong>|</strong> Mróz, Remigiusz
                    </p>

                    @if ($book->series)
                        <p class="hidden sm:block text-sm pt-1 leading-tight">
                            {{ $book->series }}
                            @if ($book->volume)
                                <br> Volume {{ $book->volume }}
                            @endif
                        </p>
                    @endif
                </div>

                <!-- Details -->
                <div class="hidden sm:block">
                    <p class="text-sm pb-2">
                        Published: {{ $book->item->published_at }}
                    </p>

                    @if ($book->item->tags)
                        <p class="text-xs">
                        @foreach ($book->item->tags as $tag)
                            <span class="my-1 mx-1 px-1.5 bg-gray-400 text-white rounded-xl">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                        </p>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@endforeach
