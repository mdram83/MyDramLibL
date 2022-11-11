@props(['itemable'])
@php($book = $itemable)

<!-- Thumbnail -->
<x-itemables.itemable-thumbnail :src="$book->item->thumbnail" :type="'Book'"/>

<!-- Main -->
<x-itemables.itemable-main>

    <!-- Title -->
    <x-itemables.itemable-main-title :href="'/books/' . $book->id" :title="$book->item->title"/>

    <!-- Authors -->
    @if ($book->item->authors)
        <p class="text-sm pt-1 italic">
            @foreach ($book->item->authors as $author){{($loop->index > 0 ? ', ' : '') . $author->getName()}}@endforeach
        </p>
    @endif

    <!-- Series -->
    @if ($book->series)
        <x-itemables.itemable-main-paragraph>
            {{ $book->series }}
        </x-itemables.itemable-main-paragraph>
    @endif

    <!-- Volume -->
    @if ($book->volume)
        <x-itemables.itemable-main-paragraph>
            Volume: {{ $book->volume }}
        </x-itemables.itemable-main-paragraph>
    @endif

</x-itemables.itemable-main>

<!-- Details -->
<x-itemables.itemable-details>

    <!-- Publishing -->
    <x-itemables.itemable-details-publishing :item="$book->item"/>

    <!-- Tags -->
    <x-itemables.itemable-details-tags :tags="$book->item->tags"/>

</x-itemables.itemable-details>
