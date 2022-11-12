@if ($itemable->getPublishedAt())
    <p class="text-sm text-gray-600">Published: {{ $itemable->getPublishedAt() }}</p>
@endif

@if ($itemable->getPublisherName())
    <p class="text-sm text-gray-600">Publisher: {{ $itemable->getPublisherName() }}</p>
@endif
