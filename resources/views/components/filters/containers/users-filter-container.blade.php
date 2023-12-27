@push('custom-scripts')
    @vite('resources/js/library/ajax/generic-datalist.js')
@endpush

<div>

    <div class="mb-4">
        <x-itemable.form.input type="text"
                               id="filter-users-input"
                               name="filter-users-input"
                               list="filter-users-datalist"
                               autocomplete="off"
                               onfocus="window.ajaxPopulateGenericDatalist('filter-users-datalist', 'name', '/ajax/tags');"
                               placeholder="Select Friend"
                               class="rounded-xl"
        />
        <datalist id="filter-users-datalist"></datalist>
    </div>

    <div id="filter-users-selected" class="col-span-2 text-sm text-white leading-6 flex flex-wrap"></div>

</div>

<div class="mt-2">
    <x-filters.clear-filter-button name="filter-users-clear" />
</div>
