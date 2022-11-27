@props(['labelFor', 'labelValue', 'elementsPrefix', 'hiddenInputName', 'buttonText', 'guilds' => null])

<x-itemable.form.label for="{{ $labelFor }}" value="{{ $labelValue }}"/>

<datalist id="guilds"></datalist>

<div class="grid grid-cols-2 gap-2">

    <div>

        <x-itemable.form.input
            type="text"
            id="guild"
            name="guild"
            list="guilds"
            autocomplete="off"
            onfocus="window.ajaxPopulateGenericDatalist('guilds', 'name', '/ajax/guilds');"
            placeholder="Select/add {{ $labelValue }}"
        />

    </div>

    <div>

        <x-primary-button
            type="button"
            class="w-full justify-center"
            onclick="window.addToSelection(
                          document.getElementById('guild').value,
                          '{{ $elementsPrefix }}',
                          'selectedGuilds',
                          'itemable',
                          '{{ $hiddenInputName }}[]',
                          'guild',
                          ['guild']
                      );"
        >{{ $buttonText }}</x-primary-button>

    </div>

    <div id="selectedGuilds" class="col-span-2 text-sm text-white leading-6 flex flex-wrap"></div>

</div>

<x-itemable.form.error-array name="{{ $hiddenInputName }}"/>

<x-itemable.form.restore-hidden
    httpName="{{ $hiddenInputName }}"
    prefix="{{ $elementsPrefix }}"
    divId="selectedGuilds"
    formId="itemable"
    hiddenInputName="{{ $hiddenInputName }}[]"
/>

@if(isset($guilds) && $guilds->count() > 0)
    <x-itemable.form.provide-hidden
        prefix="{{ $elementsPrefix }}"
        divId="selectedGuilds"
        formId="itemable"
        hiddenInputName="{{ $hiddenInputName }}[]"
        :values="$guilds"
    />
@endif
