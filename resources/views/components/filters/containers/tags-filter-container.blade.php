@push('custom-scripts')
    @vite('resources/js/library/ajax/generic-datalist.js')
@endpush

<x-slot name="controlButtons">
</x-slot>

<x-slot name="additionalControls">
</x-slot>

<x-slot name="mainFilterControl">
    <div>

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
</x-slot>

<x-slot name="selectedFilterItems">
    <div>

        <div id="filter-tags-selected" class="col-span-2 text-sm text-white leading-6 flex flex-wrap"></div>

    </div>
</x-slot>
