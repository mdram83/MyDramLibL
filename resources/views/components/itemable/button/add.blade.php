<x-library-button
    onclick="location.href = '{{ request()->route()->compiled->getStaticPrefix() . '/create' }}'"
>Add</x-library-button>
