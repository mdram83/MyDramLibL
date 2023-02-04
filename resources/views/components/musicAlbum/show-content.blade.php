@props(['itemable'])

<!-- Thumbnail -->
<x-itemable.itemable-thumbnail :src="$itemable->getThumbnail()" :type="'MusicAlbum'"/>

<!-- Main -->
<x-itemable.itemable-main>

    <!-- Title -->
    <x-itemable.itemable-main-title :title="$itemable->getTitle()">
        @push('custom-scripts')
            @vite('resources/js/library/ajax/play-music-links.js')
        @endpush
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
             onclick="window.ajaxGetPlayMusicLinks({{ $itemable->id }}, this);"
        >
            <path d="M3 18v-6a9 9 0 0 1 18 0v6"></path>
            <path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"></path>
        </svg>

        <!-- Spotify Link -->
        <svg id="spotify_link"
             xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 2931 2931"
             width="24"
             height="24"
             fill="#2ebd59"
             stroke="#2ebd59"
             class="inline-block align-middle pb-1 hover:cursor-pointer hidden"
        >
            <path class="st0" d="M1465.5 0C656.1 0 0 656.1 0 1465.5S656.1 2931 1465.5 2931 2931 2274.9 2931 1465.5C2931 656.2 2274.9.1 1465.5 0zm672.1 2113.6c-26.3 43.2-82.6 56.7-125.6 30.4-344.1-210.3-777.3-257.8-1287.4-141.3-49.2 11.3-98.2-19.5-109.4-68.7-11.3-49.2 19.4-98.2 68.7-109.4C1242.1 1697.1 1721 1752 2107.3 1988c43 26.5 56.7 82.6 30.3 125.6zm179.3-398.9c-33.1 53.8-103.5 70.6-157.2 37.6-393.8-242.1-994.4-312.2-1460.3-170.8-60.4 18.3-124.2-15.8-142.6-76.1-18.2-60.4 15.9-124.1 76.2-142.5 532.2-161.5 1193.9-83.3 1646.2 194.7 53.8 33.1 70.8 103.4 37.7 157.1zm15.4-415.6c-472.4-280.5-1251.6-306.3-1702.6-169.5-72.4 22-149-18.9-170.9-91.3-21.9-72.4 18.9-149 91.4-171 517.7-157.1 1378.2-126.8 1922 196 65.1 38.7 86.5 122.8 47.9 187.8-38.5 65.2-122.8 86.7-187.8 48z"/>
        </svg>

        <!-- YouTube Link -->
        <svg id="youtube_link"
             xmlns="http://www.w3.org/2000/svg"
             viewBox="0 0 159 110"
             width="24"
             height="24"
             class="inline-block align-middle pb-1 hover:cursor-pointer hidden"
        >
            <path d="m154 17.5c-1.82-6.73-7.07-12-13.8-13.8-9.04-3.49-96.6-5.2-122 0.1-6.73 1.82-12 7.07-13.8 13.8-4.08 17.9-4.39 56.6 0.1 74.9 1.82 6.73 7.07 12 13.8 13.8 17.9 4.12 103 4.7 122 0 6.73-1.82 12-7.07 13.8-13.8 4.35-19.5 4.66-55.8-0.1-75z" fill="#f00"/>
            <path d="m105 55-40.8-23.4v46.8z" fill="#fff"/>
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
