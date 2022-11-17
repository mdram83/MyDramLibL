<p class="pb-2 flex flex-wrap">{{ __('by') }}&nbsp;
    @foreach ($authors as $author)
        <span class="font-semibold">
            {{ $author->getName() }}
            <x-itemable.itemable-link :link="'#'">{{ __('info') }}</x-itemable.itemable-link>
            <x-itemable.itemable-link :link="'#'">{{ __('items') }}</x-itemable.itemable-link>
            @if (!$loop->last) &&nbsp;@endif
        </span>
    @endforeach
</p>
