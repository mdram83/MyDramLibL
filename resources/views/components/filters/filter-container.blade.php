@props([
    'filterTitle',
    'filterName',
    'controlButtons',
    '$additionalControls',
    'mainFilterControl',
    'selectedFilterItems'
])

<div class="grid grid-cols-3 first:pt-0 pt-6">

    <div class="col-span-full sm:col-span-1">
        <div class="flex justify-between pb-4 sm:pb-1">

            <div><h2 class="font-semibold text-lg sm:mb-2 mb-0">{{ $filterTitle }}</h2></div>

            @isset($controlButtons)
                {{ $controlButtons }}
            @endisset

            <div><x-filters.clear-filter-button name="filter-{{ $filterName }}-clear" /></div>

        </div>

        <div class="">
            @isset($mainFilterControl)
                {{ $mainFilterControl }}
            @endisset
        </div>

        <div class="">
            @isset($additionalControls)
                {{ $additionalControls }}
            @endisset
        </div>

    </div>

    <div class="col-span-full sm:col-span-2 pt-2 sm:pt-0 px-0 sm:pl-4 sm:mt-0 mt-2">
        @isset($selectedFilterItems)
            {{ $selectedFilterItems }}
        @endisset
    </div>

    <div class="col-span-full">
        {{ $slot }}
    </div>

</div>
