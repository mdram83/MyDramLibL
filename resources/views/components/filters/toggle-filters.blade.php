<div class="text-gray-400 px-1">

    @php

        $color = count(Arr::except(Request::query(), ['page'])) > 0 ? '#ff6200' : 'currentColor';

    @endphp

    <a href="#">
        <x-svg icon="filter"
               stroke="{{ $color }}"
               width="20"
               height="20"
        />
    </a>

</div>
