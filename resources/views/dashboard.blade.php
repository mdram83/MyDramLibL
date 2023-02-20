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
                <!-- TODO below div could be a dashboard blade component aka widget-->

                <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="ml-2">

                        <div class="text-lg leading-7 font-semibold">Your new items</div>

                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">

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

                        </div>

                    </div>
                </div>

                <!-- Recently played items -->
                <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="ml-2">

                        <div class="text-lg leading-7 font-semibold">Recently played music</div>

                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
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

                        </div>

                    </div>
                </div>

                <!-- Recently added friends items -->
                <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="ml-2">

                        <div class="text-lg leading-7 font-semibold">Your friends' new items</div>

                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            <p><i>Under construction</i></p>
                        </div>

                    </div>
                </div>

                <!-- Recently added friends -->
                <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="ml-2">

                        <div class="text-lg leading-7 font-semibold">Recent contacts</div>

                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            <p><i>Under construction</i></p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
