<x-library-button
    onclick="location.href = '{{ request()->url() . '/edit' }}'"
    class="
        bg-teal-500
        hover:bg-teal-400
        active:bg-teal-600
        focus:border-teal-600
        focus:ring ring-teal-300
    "
>Edit</x-library-button>
