@props(['name'])

<x-library-button
    name="{{ $name }}"
    class="
            bg-[#ff6200]
            hover:bg-[#ff8220]
            active:bg-[#ffa240]
            focus:border-[#ffa240]
            focus:ring ring-[#ff7210]
            text-xs
        "
    disabled="disabled"
>Clear</x-library-button>
