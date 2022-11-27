@props(['labelFor', 'labelValue', 'elementsPrefix', 'hiddenInputName', 'buttonText', 'artists' => null])

@push('custom-scripts')
    @vite('resources/js/library/ajax/artists-index.js')
    @vite('resources/js/library/artists-operations.js')
@endpush

<datalist id="artistFirstnames"></datalist>
<datalist id="artistLastnames"></datalist>

<x-itemable.form.label for="{{ $labelFor }}" value="{{ $labelValue }}"/>

<div class="grid sm:grid-cols-8 grid-cols-2 gap-2">

    <div class="sm:col-span-3 order-first">

        <x-itemable.form.input
            type="text"
            id="artistFirstname"
            name="artistFirstname"
            list="artistFirstnames"
            autocomplete="off"
            onfocus="window.ajaxPopulateArtistsDatalist();"
            placeholder="Select/add first name"
        />

    </div>

    <div class="sm:col-span-3 sm:order-none order-3">

        <x-itemable.form.input
            type="text"
            id="artistLastname"
            name="artistLastname"
            list="artistLastnames"
            autocomplete="off"
            onfocus="window.ajaxPopulateArtistsDatalist();"
            placeholder="Select/add last name"
        />

    </div>

    <div class="sm:col-span-2 sm:order-none order-2 row-span-2">

        <x-primary-button
            type="button"
            class="w-full justify-center sm:h-auto h-full"
            onclick="window.addToSelection(
                window.getArtistFromInputs('artistFirstname', 'artistLastname'),
                '{{ $elementsPrefix }}',
                'selectedArtists',
                'itemable',
                '{{ $hiddenInputName }}[]',
                'artistFirstname',
                ['artistFirstname', 'artistLastname']
            );"
        >{{ $buttonText }}</x-primary-button>

    </div>

    <div id="selectedArtists" class="col-span-full order-last text-sm text-white leading-6 flex flex-wrap"></div>

</div>

<x-itemable.form.error-array name="{{ $hiddenInputName }}"/>

<x-itemable.form.restore-hidden
    httpName="{{ $hiddenInputName }}"
    prefix="{{ $elementsPrefix }}"
    divId="selectedArtists"
    formId="itemable"
    hiddenInputName="{{ $hiddenInputName }}[]"
/>

@if(isset($artists) && $artists->count() > 0)
    <x-itemable.form.provide-hidden
        prefix="{{ $elementsPrefix }}"
        divId="selectedArtists"
        formId="itemable"
        hiddenInputName="{{ $hiddenInputName }}[]"
        :values="$artists"
    />
@endif
