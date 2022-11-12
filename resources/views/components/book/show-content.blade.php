@props(['itemable'])

<!-- Thumbnail -->
<x-itemable.itemable-thumbnail :src="$itemable->getThumbnail()" :type="'Book'"/>

<!-- Main -->
<x-itemable.itemable-main>

    <!-- Title -->
    <x-itemable.itemable-main-title :title="$itemable->getTitle()"/>

    <!-- More About Item From Openlibrary.org -->
    <p class="text-xs leading-none pt-0 pb-2 mt-0">
        <x-itemable.itemable-link :link="'#'">{{ __('info') }}</x-itemable.itemable-link>
    </p>

    <!-- Authors -->
    @if ($itemable->getAuthors()?->count() > 0)
        <x-book.authors :authors="$itemable->getAuthors()"/>
    @endif

    <!-- Publishing -->
    <x-itemable.itemable-main-publishing :itemable="$itemable"/>

    <!-- Tags -->
    <x-itemable.itemable-main-tags :tags="$itemable->getTags()"/>

</x-itemable.itemable-main>

<!-- Book Details -->
<x-itemable.details>

    <!-- Series -->
    <x-itemable.details-element :label="__('Series')" :value="$itemable->series"/>

    <!-- Volume -->
    <x-itemable.details-element :label="__('Volume')" :value="$itemable->volume"/>

    <!-- Pages -->
    <x-itemable.details-element :label="__('Pages')" :value="$itemable->pages"/>

    <!-- ISBN -->
    <x-itemable.details-element :label="__('ISBN')" :value="$itemable->isbn"/>

</x-itemable.details>

<!-- Comment -->
@if ($itemable->getComment())
    <x-itemable.itemable-comment :itemableType="__($itemable->getItemableType())" :comment="$itemable->getComment()"/>
@endif
