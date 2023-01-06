@props(['itemable'])

<!-- Thumbnail -->
<x-itemable.itemable-thumbnail :src="$itemable->getThumbnail()" :type="'MusicAlbum'"/>

<!-- Main -->
<x-itemable.itemable-main>

    <!-- Title -->
    <x-itemable.itemable-main-title :title="$itemable->getTitle()">
        <svg xmlns="http://www.w3.org/2000/svg"
             width="24"
             height="24"
             viewBox="0 0 24 24"
             fill="none"
             stroke="#ff6200"
             stroke-width="2"
             stroke-linecap="round"
             stroke-linejoin="round"
             class="inline-block align-middle pb-1 hover:cursor-pointer"
             onclick="alert('no playlist found for the album.');"
        >
            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
            <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
        </svg>
    </x-itemable.itemable-main-title>

    <!-- More About Item From Somewhere... -->
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
                    @if (!$loop->last) & @endif
                </span>
            @endforeach
            </p>
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
