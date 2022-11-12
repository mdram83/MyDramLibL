@if ($itemable->getPublishedAt())
    <p class="text-xs">{{ __('Published') }}: {{ $itemable->getPublishedAt() }}</p>
@endif

@if ($itemable->getPublisherName())
    <p class="text-xs pb-1">{{ $itemable->getPublisherName() }}</p>
@endif
