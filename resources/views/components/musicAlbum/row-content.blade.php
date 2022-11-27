@props(['itemable'])

<!-- Thumbnail -->
<x-itemables.itemable-thumbnail :src="$itemable->getThumbnail()" :type="'MusicAlbum'"/>

<!-- Main -->
<x-itemables.itemable-main>

    <!-- Title -->
    <x-itemables.itemable-main-title :href="'/music/' . $itemable->id" :title="$itemable->getTitle()"/>

    <!-- Main Bands and Artists -->
    @if ($itemable->getMainBands() || $itemable->getMainArtists())
        <p class="text-sm pt-1">

            <!-- Main Bands -->
            @if ($itemable->getMainBands())
                <span class="font-semibold">
                    @foreach ($itemable->getMainBands() as $mainBand){{($loop->index > 0 ? ' & ' : '') . strtoupper($mainBand->name)}}@endforeach
                </span>
            @endif

            <!-- Band & Artist Connector -->
            @if ($itemable->getMainBands()->count() && $itemable->getMainArtists()->count())
                <span>with</span>
            @endif

            <!-- Main Artists -->
            @if ($itemable->getMainArtists())
                <span class="italic">
                    @foreach ($itemable->getMainArtists() as $mainArtist){{($loop->index > 0 ? ' & ' : '') . $mainArtist->getName()}}@endforeach
                </span>
            @endif

        </p>
    @endif

    <!-- Volumes -->
    @if ($itemable->volumes)
        <x-itemables.itemable-main-paragraph>
            {{ __('Volumes') }}: {{ $itemable->volumes }}
        </x-itemables.itemable-main-paragraph>
    @endif

    <!-- Duration -->
    @if ($itemable->duration)
        <x-itemables.itemable-main-paragraph>
            {{ __('Duration') }}: {{ $itemable->duration }}
        </x-itemables.itemable-main-paragraph>
    @endif

</x-itemables.itemable-main>

<!-- Details -->
<x-itemables.itemable-details :itemable="$itemable"/>
