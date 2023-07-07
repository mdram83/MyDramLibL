<div class="text-gray-400">

    @php

        $filterName = 'friends';
        $isFilterOn = (Request::query($filterName) === '1');

        $queryString = http_build_query([
            Arr::except(Request::query(), ['page', $filterName]),
            $filterName => $isFilterOn ? '0' : '1',
        ]);

        $href = Request::path() . '?' . $queryString;
        $color = $isFilterOn ? '#ff6200' : 'currentColor';

    @endphp

    <a href="{{ $href }}">
        <x-svg icon="users"
               stroke="{{ $color }}"
               width="20"
               height="20"
        />
    </a>

</div>
