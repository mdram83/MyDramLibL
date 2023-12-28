@props(['filterName', 'inputPlaceholder'])

<div class="sm:min-h-[120px]">

    <div class="mb-4">
        <x-itemable.form.input type="text"
                               id="filter-{{ $filterName }}-input"
                               name="filter-{{ $filterName }}-input"
                               list="filter-{{ $filterName }}-datalist"
                               autocomplete="off"
                               placeholder="{{ $inputPlaceholder }}"
                               class="rounded-xl"
        />
        <datalist id="filter-{{ $filterName }}-datalist"></datalist>
    </div>

    <div id="filter-{{ $filterName }}-selected" class="col-span-2 text-sm text-white leading-6 flex flex-wrap"></div>

</div>

<div class="mt-2">
    <x-filters.clear-filter-button name="filter-{{ $filterName }}-clear" />
</div>
