@props(['books'])

@foreach ($books as $book)

<div class="first:pt-8 last:pb-8 py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">

                <p class="font-semibold text-lg leading-tight">
                    <a href="/books/{{ $book->id }}" class="hover:underline">
                        {{ $book->title }}
                    </a>
                </p>
                <p class="text-sm pt-1">
{{--                    TODO authors--}}
                    <i>Kozłowski, Paweł</i> | <i>Mróz, Remigiusz</i>
                </p>

{{--                TODO consider series only on higher resolutions --}}
                @if ($book->series)
                    <p class="text-sm pt-1 leading-tight">
                        {{ $book->series }}
                        @if ($book->volume)
                            <br> Volume {{ $book->volume }}
                        @endif
                    </p>
                @endif

{{--                TODO tags, picture and published_at only for higher resolutions, on the right side, maybe picture first on left and also for mobiles --}}

            </div>
        </div>
    </div>
</div>

@endforeach
