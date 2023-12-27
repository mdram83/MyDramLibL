<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center">
            <div class="flex-auto items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __($header) }}
                </h2>
            </div>

            <div class="flex">
                <x-filters.toggle-filters/>
            </div>

            <div class="flex-auto items-center text-right">

                <div class="inline-flex">
                    <x-itemable.button.add/>
                </div>

            </div>
        </div>

    </x-slot>

    <x-filters.filters-container />

    @if ($itemables->count())

        <div>
        @foreach ($itemables as $itemable)
            <x-main-row>
                <x-dynamic-component
                    :component="$componentName"
                    :itemable="$itemable"/>
            </x-main-row>
        @endforeach
        </div>

        <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ $itemables->links() }}
        </div>

    @else
        <x-main-row>
            {{ __('No items found') }}.
        </x-main-row>
    @endif

</x-app-layout>
