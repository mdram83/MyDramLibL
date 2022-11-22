<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center">
            <div class="flex-auto items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit') . ' ' . __($itemable->getItemableType()) }}
                </h2>
            </div>

            <div class="flex-auto items-center text-right">

                <div class="inline-flex"><x-itemable.button.delete id="{{ $itemable->id }}"/></div>

            </div>

        </div>


    </x-slot>

        @php ( $componentName = lcfirst((new ReflectionClass($itemable::class))->getShortName()) . '.edit' )
        <x-itemable.main-edit>
            <x-dynamic-component
                :component="$componentName"
                :itemable="$itemable"/>
        </x-itemable.main-edit>

</x-app-layout>
