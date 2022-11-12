<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($header) }}
        </h2>
    </x-slot>

    @if ($itemables->count())

        @foreach ($itemables as $itemable)
            @php ( $componentName = lcfirst((new ReflectionClass($itemable::class))->getShortName()) . '.row-content' )
            <x-main-row>
                <x-dynamic-component
                    :component="$componentName"
                    :itemable="$itemable"/>
            </x-main-row>
        @endforeach

        <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{ $itemables->links() }}
        </div>

    @else
        <x-main-row>
            {{ __('No items found') }}.
        </x-main-row>
    @endif

</x-app-layout>
