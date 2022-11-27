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

        <x-itemable.main-form>
            <x-dynamic-component
                :component="$componentName"
                :itemable="$itemable"/>
        </x-itemable.main-form>

</x-app-layout>
