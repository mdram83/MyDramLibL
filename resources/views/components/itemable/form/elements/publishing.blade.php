@props(['publisherName' => null, 'publishedAt' => null])

<div class="grid grid-cols-4 sm:gap-2 gap-1">

    <div class="sm:col-span-3 col-span-full">
        <!-- Publisher -->
        <x-itemable.form.label for="publisher" value="Publisher"/>
        <x-itemable.form.input type="text"
                               id="publisher"
                               name="publisher"
                               list="publishers"
                               autocomplete="off"
                               onfocus="window.ajaxPopulateGenericDatalist('publishers', 'name', '/ajax/publishers');"
                               value="{{ old('publisher') ?? $publisherName }}"
                               placeholder="Select/add publisher"
        />
        <x-itemable.form.error name="publisher"/>
        <datalist id="publishers"></datalist>
    </div>

    <div class="sm:col-span-1 col-span-full">
        <!-- Published At -->
        <x-itemable.form.label for="published_at" value="Published At"/>
        <x-itemable.form.input type="number"
                               id="published_at"
                               name="published_at"
                               value="{{ old('published_at') ?? $publishedAt }}"
                               placeholder="and published year"
                               min="1901"
                               max="2155"
        />
        <x-itemable.form.error name="published_at"/>
    </div>

</div>
