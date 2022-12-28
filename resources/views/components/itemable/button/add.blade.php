<x-library-button
    onclick="location.href = '{{ request()->route()->compiled->getStaticPrefix() . '/create' }}'"
    class="
        bg-blue-500
        hover:bg-blue-400
        active:bg-blue-600
        focus:border-blue-600
        focus:ring ring-blue-300
    "
>Add</x-library-button>
