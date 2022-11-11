@props(['itemable'])
@php($musicAlbum = $itemable)

{{--TODO design this view for big and small screen, feel free not to reuse below components--}}

<!-- Thumbnail -->
<x-itemables.itemable-thumbnail :src="$musicAlbum->item->thumbnail" :type="'MusicAlbum'"/>

<!-- Main -->
<x-itemables.itemable-main>

    <!-- Title -->
    <x-itemables.itemable-main-title :href="'/music/' . $musicAlbum->id" :title="$musicAlbum->item->title"/>

    <!-- Main Bands and Artists -->
    @if ($musicAlbum->item->mainBands || $musicAlbum->item->mainArtists)
        <p class="text-sm pt-1">

            <!-- Main Bands -->
            @if ($musicAlbum->item->mainBands)
                <span class="font-semibold">
                        @foreach ($musicAlbum->item->mainBands as $mainBand){{($loop->index > 0 ? ', ' : '') . strtoupper($mainBand->name)}}@endforeach
                    </span>
            @endif

            @if ($musicAlbum->item->mainBands || $musicAlbum->item->mainArtists)
                <span>with</span>
            @endif

            <!-- Main Artists -->
            @if ($musicAlbum->item->mainArtists)
                <span class="italic">
                        @foreach ($musicAlbum->item->mainArtists as $mainArtist){{($loop->index > 0 ? ', ' : '') . $mainArtist->getName()}}@endforeach
                    </span>
            @endif

        </p>
    @endif

    <!-- Volumes -->
    @if ($musicAlbum->volumes)
        <x-itemables.itemable-main-paragraph>
            Volumes: {{ $musicAlbum->volumes }}
        </x-itemables.itemable-main-paragraph>
    @endif

    <!-- Duration -->
    @if ($musicAlbum->duration)
        <x-itemables.itemable-main-paragraph>
            Duration: {{ $musicAlbum->duration }}
        </x-itemables.itemable-main-paragraph>
    @endif

</x-itemables.itemable-main>

<!-- Details -->
<x-itemables.itemable-details>

    <!-- Publishing -->
    <x-itemables.itemable-details-publishing :item="$musicAlbum->item"/>

    <!-- Tags -->
    <x-itemables.itemable-details-tags :tags="$musicAlbum->item->tags"/>

</x-itemables.itemable-details>
