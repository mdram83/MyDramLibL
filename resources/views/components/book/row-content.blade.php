@props(['itemable'])

<!-- Thumbnail -->
<x-itemables.itemable-thumbnail :src="$itemable->getThumbnail()" :type="'Book'"/>

<!-- Main -->
<x-itemables.itemable-main>

    <!-- Title -->
    <x-itemables.itemable-main-title :href="'/books/' . $itemable->id" :title="$itemable->getTitle()"/>

    <!-- Authors -->
    @if ($itemable->getAuthors())
        <p class="text-sm pt-1 italic">
            @foreach ($itemable->getAuthors() as $author){{($loop->index > 0 ? ' & ' : '') . $author->getName()}}@endforeach
        </p>
    @endif

    <!-- Series -->
    @if ($itemable->series)
        <x-itemables.itemable-main-paragraph>
            {{ $itemable->series }}
        </x-itemables.itemable-main-paragraph>
    @endif

    <!-- Volume -->
    @if ($itemable->volume)
        <x-itemables.itemable-main-paragraph>
            {{ __('Volume') }}: {{ $itemable->volume }}
        </x-itemables.itemable-main-paragraph>
    @endif

</x-itemables.itemable-main>

<!-- Details -->
<x-itemables.itemable-details :itemable="$itemable"/>
