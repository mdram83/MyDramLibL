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
                               placeholder="Select Friend"
                               class="rounded-xl"
        />
        <datalist id="filter-users-datalist"></datalist>
    </div>

    <div id="filter-users-selected" class="col-span-2 text-sm text-white leading-6 flex flex-wrap"></div>

</div>

<div>
    <input type="checkbox" id="filter-users-excludeMyItems" name="filter-users-excludeMyItems">
    <label for="filter-users-excludeMyItems" class="text-sm px-1.5">
        Exclude your items
    </label>
</div>

<div class="mt-2">
    <x-library-button
        name="filter-users-addAllFriends"
        id="filter-users-addAllFriends"
        class="
            bg-[#ff6200]
            hover:bg-[#ff8220]
            active:bg-[#ffa240]
            focus:border-[#ffa240]
            focus:ring ring-[#ff7210]
            text-xs
        "
    >Add All Friends</x-library-button>
</div>

<div class="mt-2">
    <x-filters.clear-filter-button name="filter-users-clear" />
</div>
