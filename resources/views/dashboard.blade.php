<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- PLACEHOLDER FOR QUICK LINKS -->

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 grid-cols-1 gap-4">

                <!-- Recently added items -->
                <x-dashboard.widget title="Your new items">
                    @if($items)
                        <ul>
                            @foreach($items as $item)
                                <li class="py-0.5 truncate">
                                    <a class="hover:underline"
                                       href="{{ $navigator->getItemableShowLink($item) }}"
                                    >
                                        <div class="flex items-center">
                                            <img class="w-6" alt="Thumbnail"
                                                 src="{{ $item->thumbnail ?? $navigator->getItemableDefaultThumbnail($item) }}"
                                            >
                                            <span class="pl-2">{{ $item->title }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>You have no items yet</p>
                    @endif

                </x-dashboard.widget>

                <!-- Recently played items -->
                <x-dashboard.widget title="Recently played music">

                    @if($played)
                        <ul>
                            @foreach($played as $musicAlbum)
                                <li class="pb-1.5 truncate">
                                    <a class="hover:underline"
                                       href="{{ $navigator->getItemableShowLink($musicAlbum->item) }}"
                                    >
                                        <div class="flex items-center">
                                            <img class="w-6" alt="Thumbnail"
                                                 src="{{ $musicAlbum->item->thumbnail ?? $navigator->getItemableDefaultThumbnail($musicAlbum->item) }}"
                                            >
                                            <span class="pl-2">{{ $musicAlbum->item->title }}</span>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>You have no played music albums</p>
                    @endif

                </x-dashboard.widget>

                <!-- Recently added friends items -->
                <x-dashboard.widget title="Your friends' new items">
                    <p><i>Under construction</i></p>
                </x-dashboard.widget>

                <!-- Recently added friends -->
                <x-dashboard.widget title="Recent contacts">
                    <p><i>Under construction</i></p>
                </x-dashboard.widget>

            </div>
        </div>
    </div>

</x-app-layout>
