@push('custom-scripts')
    @vite('resources/js/library/ajax/generic-datalist.js')
@endpush

<div>

    <div id="filter-tags-selected" class="col-span-2 text-sm text-white leading-6 flex flex-wrap">

        <span class="my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl">
            Rock
            <a href="#" class="ml-2 font-bold cursor-pointer">&#10005;</a>
        </span>

        <span class="my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl">
            Crime
            <a href="#" class="ml-2 font-bold cursor-pointer">&#10005;</a>
        </span>

        <span class="my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl">
            Blues
            <a href="#" class="ml-2 font-bold cursor-pointer">&#10005;</a>
        </span>

        <span class="my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl">
            Drum'n'base
            <a href="#" class="ml-2 font-bold cursor-pointer">&#10005;</a>
        </span>

        <span class="my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl">
            Something long that probably won't fit into single line in the filter view. Js symbol for multiplication is \u2715.html is & + #10005;.
            <a href="#" class="ml-2 font-bold cursor-pointer">&#10005;</a>
        </span>

    </div>

    <div class="my-4">
        <x-itemable.form.input type="text"
                               id="filter-tags-input"
                               name="filter-tags-input"
                               list="filter-tags-datalist"
                               autocomplete="off"
                               onfocus="window.ajaxPopulateGenericDatalist('filter-tags-datalist', 'name', '/ajax/tags');"
                               placeholder="Select tag"
                               class="rounded-xl"
        />
        <datalist id="filter-tags-datalist"></datalist>
    </div>

</div>

<div class="mt-2">
    <x-filters.clear-filter-button name="filter-tags-clear" />
</div>
