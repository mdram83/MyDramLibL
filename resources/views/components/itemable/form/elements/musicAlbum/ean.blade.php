@props(['value' => null])

@push('custom-scripts')
    @vite('resources/js/library/ajax/ean-music-details.js')
@endpush

<x-itemable.form.label for="ean" value="EAN" class="mt-0"/>
<div class="grid grid-cols-2 gap-2">
    <div>
        <x-itemable.form.input type="text"
                               id="ean"
                               name="ean"
                               oninput="window.changeEanButtonStyle('enabled');"
                               value="{{ old('ean') ?? $value }}"
                               placeholder="Start here..."
        />
    </div>
    <div>
        <x-primary-button type="button"
                          id="ean-button"
                          class="w-full justify-center"
                          onclick="window.ajaxGetDetailsWithEAN('itemable');"
        >Get Details</x-primary-button>
    </div>
</div>
<x-itemable.form.error name="ean"/>
