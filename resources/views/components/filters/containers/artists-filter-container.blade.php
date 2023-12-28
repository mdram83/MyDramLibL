@props(['filterName', 'inputPlaceholder'])

<x-slot name="controlButtons">
</x-slot>

<x-slot name="additionalControls">
</x-slot>

<x-slot name="mainFilterControl">
    <div>

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
</x-slot>

<x-slot name="selectedFilterItems">
    <div>

        <div id="filter-{{ $filterName }}-selected"
             class="{{--col-span-2 --}}text-sm text-white leading-6 flex flex-wrap"
        ></div>

    </div>
</x-slot>
