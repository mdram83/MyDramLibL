@props(['musicAlbums'])

@foreach ($musicAlbums as $musicAlbum)

<div class="first:pt-8 last:pb-8 py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="flex items-center p-6 bg-white border-b border-gray-200">

                <!-- Thumbnail -->
                <div class="pr-2 sm:basis-24 basis-16 flex-none">
                    <img class="max-h-24" alt="Thumbnail"
                        src="{{ $musicAlbum->item->thumbnail ?? '/images/thumbnails\music.png' }}"
                    >
                </div>

                <!-- Main data -->
                <div class="flex-auto">
                    <p class="font-semibold text-lg leading-tight">
                        <a href="/books/{{ $musicAlbum->id }}" class="hover:underline">{{ $musicAlbum->item->title }}</a>
                    </p>
                    @if ($musicAlbum->item->artists)
                        <p class="text-sm pt-1 italic">
                            @foreach ($musicAlbum->item->artists as $artist){{($loop->index > 0 ? ', ' : '') . $artist->getName()}}@endforeach
                        </p>
                    @endif

                    @if ($musicAlbum->volumes)
                        <p class="hidden sm:block text-sm pt-1 leading-tight">
                            Volumes: {{ $musicAlbum->volumes }}
                        </p>
                    @endif

                    @if ($musicAlbum->duration)
                        <p class="hidden sm:block text-sm pt-1 leading-tight">
                            Duration: {{ $musicAlbum->duration }}
                        </p>
                    @endif

                </div>

                <!-- Details -->
                <div class="hidden sm:block pl-2 sm:basis-64 flex-none text-right">

                    @if ($musicAlbum->item->published_at)
                        <p class="text-xs">
                            Published: {{ $musicAlbum->item->published_at }}
                        </p>
                    @endif

                    @if ($musicAlbum->item->publisher)
                        <p class="text-xs pb-1">
                            {{ $musicAlbum->item->publisher->name }}
                        </p>
                    @endif

                    @if ($musicAlbum->item->tags)
                        <p class="text-xs leading-6">
                        @foreach ($musicAlbum->item->tags as $tag)
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
