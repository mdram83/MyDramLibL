<div class="hidden sm:block pl-2 sm:basis-64 flex-none text-right">

    <!-- Publishing -->
    <x-itemables.itemable-details-publishing :itemable="$itemable"/>

    <!-- Tags -->
    <x-itemables.itemable-details-tags :tags="$itemable->getTags()"/>

</div>
