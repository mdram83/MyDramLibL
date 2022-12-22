@props(['value' => null])

@push('custom-scripts')
    @vite('resources/js/library/ajax/isbn-details.js')
@endpush

<x-itemable.form.label for="isbn" value="ISBN" class="mt-0"/>
<div class="grid grid-cols-2 gap-2">
    <div>
        <x-itemable.form.input type="text"
                               id="isbn"
                               name="isbn"
                               oninput="window.changeIsbnButtonStyle('enabled');"
                               value="{{ old('isbn') ?? $value }}"
                               placeholder="Start here..."
        />
    </div>
    <div>
        <x-primary-button type="button"
                          id="isbn-button"
                          class="w-full justify-center"
                          onclick="window.ajaxGetDetailsWithISBN('itemable');"
        >Get Details</x-primary-button>
    </div>
</div>
<x-itemable.form.error name="isbn"/>
