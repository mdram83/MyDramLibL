<div id="filters-container" class="sm:pt-8 pt-4 hidden">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="block items-center px-6 py-3 bg-white border-b border-gray-200">

                <div class="flex justify-center">
                    <x-filters.apply-filters-button />
                </div>

                <div class="grid grid-cols-1 gap-4 sm:gap-6 divide-y my-8">

                    @if(request()->path() === 'books')
                        <x-filters.filter-container filterTitle="Authors" filterName="authors">
                            <x-filters.containers.artists-filter-container
                                filterName="authors"
                                inputPlaceholder="Select Author"
                            />
                        </x-filters.filter-container>
                    @endif

                    @if(request()->path() === 'music')
                        <x-filters.filter-container filterTitle="Main Artists" filterName="mainArtists">
                            <x-filters.containers.artists-filter-container
                                filterName="mainArtists"
                                inputPlaceholder="Select Main Artist"
                            />
                        </x-filters.filter-container>

                        <x-filters.filter-container filterTitle="Main Bands" filterName="mainBands">
                            <x-filters.containers.guilds-filter-container
                                filterName="mainBands"
                                inputPlaceholder="Select Main Band"
                            />
                        </x-filters.filter-container>
                    @endif

                    <x-filters.filter-container filterTitle="Tags" filterName="tags">
                        <x-filters.containers.tags-filter-container />
                    </x-filters.filter-container>

                    <x-filters.filter-container filterTitle="Friends" filterName="users">
                        <x-filters.containers.users-filter-container />
                    </x-filters.filter-container>

                    <x-filters.filter-container filterTitle="Published At" filterName="publishedAt">
                        <x-filters.containers.published-at-filter-container />
                    </x-filters.filter-container>

                </div>

                <div class="flex justify-center">
                    <x-filters.apply-filters-button />
                </div>

            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
    @vite('resources/js/library/filters/FilterView.js')
@endpush
