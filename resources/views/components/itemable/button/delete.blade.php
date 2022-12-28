@props(['id'])

<form method="POST"
      action="{{ request()->route()->compiled->getStaticPrefix() . '/' . $id }}"
      onsubmit="return confirm('Do you want to delete this item?');"
>
    @csrf
    @method('DELETE')
    <x-library-button class="
        bg-rose-500
        hover:bg-rose-400
        active:bg-rose-600
        focus:border-rose-600
        focus:ring ring-rose-300
    ">Delete</x-library-button>
</form>
