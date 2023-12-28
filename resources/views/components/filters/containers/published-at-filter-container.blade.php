<style>
    .filter-publishedAt-range-input input::-webkit-slider-thumb {
        height: 20px;
        width: 20px;
        border-radius: 50%;
        border: 3px solid #ff6200;
        background-color: #fff;
        pointer-events: auto;
        -webkit-appearance: none;
    }
    .filter-publishedAt-range-input input::-moz-range-thumb {
        height: 16px;
        width: 16px;
        border-radius: 50%;
        border: 3px solid #ff6200;
        background-color: #fff;
        pointer-events: auto;
        -moz-appearance: none;
    }
</style>

<x-slot name="controlButtons">
</x-slot>

<x-slot name="additionalControls">
    <div>

        <input type="checkbox" id="filter-publishedAt-required" name="filter-publishedAt-required">
        <label for="filter-publishedAt-required" class="text-sm px-1.5">
            Exclude items without date
        </label>

    </div>
</x-slot>

<x-slot name="mainFilterControl">
</x-slot>

<x-slot name="selectedFilterItems">
    <div class="mt-4 sm:mt-2 sm:px-6 px-0">

        <div class="h-2 relative bg-gray-200 rounded-sm">
            <span class="filter-publishedAt-range-selected h-full right-px left-px absolute rounded bg-[#ff6200]"></span>
        </div>

        <div class="filter-publishedAt-range-input relative">
            <input class="min absolute w-full h-2 -top-2 bg-transparent pointer-events-none appearance-none"
                   type="range" min="1900" max="2024" value="1900" step="1">
            <input class="min absolute w-full h-2 -top-2 bg-transparent pointer-events-none appearance-none"
                   type="range" min="1900" max="2024" value="2024" step="1">
        </div>

        <div class="filter-publishedAt-range-value pt-2 w-full flex justify-between items-center">
            <p class="text-base text-gray-500">1900</p>
            <p class="text-base text-gray-500">2024</p>
        </div>

    </div>
</x-slot>

