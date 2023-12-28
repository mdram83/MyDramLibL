<div id="filters-container" class="sm:pt-8 pt-4 hidden">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="block items-center px-6 py-3 bg-white border-b border-gray-200">

                <div class="flex justify-center mb-1 sm:hidden">
                    <x-filters.apply-filters-button />
                </div>

                <div class="mx-1 grid grid-cols-1 gap-0 sm:gap-6 sm:grid-cols-3 flex justify-center sm:divide-y-0 divide-y">

                    <x-filters.filter-container filterName="Published At">
                        <x-filters.containers.published-at-filter-container />
                    </x-filters.filter-container>

                    <x-filters.filter-container filterName="Tags">
                        <x-filters.containers.tags-filter-container />
                    </x-filters.filter-container>

                    <x-filters.filter-container filterName="Friends & You">
                        <x-filters.containers.users-filter-container />
                    </x-filters.filter-container>

                    @if(request()->path() === 'books')
                        <x-filters.filter-container filterName="Authors">
                            <x-filters.containers.authors-filter-container />
                        </x-filters.filter-container>
                    @endif

                </div>

                <div class="flex justify-center mt-1">
                    <x-filters.apply-filters-button />
                </div>

            </div>
        </div>
    </div>
</div>

@push('custom-scripts')
    @vite('resources/js/library/filters/FilterView.js')
@endpush
