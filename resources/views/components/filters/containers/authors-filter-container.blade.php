@push('custom-scripts')
    @vite('resources/js/library/ajax/generic-datalist.js')
@endpush

<div class="sm:min-h-[120px]">

    <div class="mb-4">
        <x-itemable.form.input type="text"
                               id="filter-authors-input"
                               name="filter-authors-input"
                               list="filter-authors-datalist"
                               autocomplete="off"
                               onfocus="window.ajaxPopulateGenericDatalist('filter-authors-datalist', 'name', '/ajax/tags');"
                               placeholder="Select Author"
                               class="rounded-xl"
        />
        <datalist id="filter-authors-datalist"></datalist>
    </div>

    <div id="filter-authors-selected" class="col-span-2 text-sm text-white leading-6 flex flex-wrap"></div>

</div>

<div class="mt-2">
    <x-filters.clear-filter-button name="filter-authors-clear" />
</div>
