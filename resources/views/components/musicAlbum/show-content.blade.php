@props(['itemable'])

<!-- Thumbnail -->
<x-itemable.itemable-thumbnail :src="$itemable->getThumbnail()" :type="'MusicAlbum'"/>

<!-- Main -->
<x-itemable.itemable-main>

    <!-- Title -->
    <x-itemable.itemable-main-title :title="$itemable->getTitle()"/>

    <!-- More About Item From Openlibrary.org -->
    <p class="text-xs leading-none pt-0 pb-2 mt-0">
        <x-itemable.itemable-link :link="'#'">{{ __('info') }}</x-itemable.itemable-link>
    </p>

    <!-- Main Bands and Artists -->
    @if ($itemable->getMainBands() || $itemable->getMainArtists())

        <div class="pb-2">

        <!-- Main Bands -->
        @if ($itemable->getMainBands())
            <p class="flex flex-wrap">
            @foreach ($itemable->getMainBands() as $mainBand)
                <span class="font-semibold">
                    {{ strtoupper($mainBand->name) }}
                    <x-itemable.itemable-link :link="'#'">{{ __('info') }}</x-itemable.itemable-link>
                    <x-itemable.itemable-link :link="'#'">{{ __('items') }}</x-itemable.itemable-link>
                    @if (!$loop->last),&nbsp;@endif
                </span>
            </p>
           @endforeach
        @endif

        <!-- Main Artists -->
        @if ($itemable->getMainArtists())
            <p class="flex flex-wrap">
                @foreach ($itemable->getMainArtists() as $mainArtist)
                    <span class="font-semibold">
                        {{ $mainArtist->getName() }}
                        <x-itemable.itemable-link :link="'#'">{{ __('info') }}</x-itemable.itemable-link>
                        <x-itemable.itemable-link :link="'#'">{{ __('items') }}</x-itemable.itemable-link>
                        @if (!$loop->last),&nbsp;@endif
                    </span>
                @endforeach
            </p>
        @endif

        </div>
    @endif

    <!-- Publishing -->
    <x-itemable.itemable-main-publishing :itemable="$itemable"/>

    <!-- Tags -->
    <x-itemable.itemable-main-tags :tags="$itemable->getTags()"/>

</x-itemable.itemable-main>

<!-- Music Album Details -->
<x-itemable.details>

    <!-- Volumes -->
    <x-itemable.details-element :label="__('Volumes')" :value="$itemable->volumes"/>

    <!-- Duration -->
    <x-itemable.details-element :label="__('Duration')" :value="$itemable->duration"/>

    <!-- EAN -->
    <x-itemable.details-element :label="__('EAN')" :value="$itemable->ean"/>

</x-itemable.details>

<!-- Comment -->
@if ($itemable->getComment())
    <x-itemable.itemable-comment :itemableType="__($itemable->getItemableType())" :comment="$itemable->getComment()"/>
@endif
