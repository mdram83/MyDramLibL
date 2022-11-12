@if ($itemable->getPublishedAt())
    <p class="text-sm text-gray-600">{{ __('Published') }}: {{ $itemable->getPublishedAt() }}</p>
@endif

@if ($itemable->getPublisherName())
    <p class="text-sm text-gray-600">{{ __('Publisher') }}: {{ $itemable->getPublisherName() }}</p>
@endif
