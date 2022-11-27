@props(['action', 'patch' => null])

<form id="itemable" method="POST" action="{{ $action }}">
@csrf

@isset($patch)
    @method('PATCH')
@endisset

@push('custom-scripts')
    @vite('resources/js/library/ajax/generic-datalist.js')
    @vite('resources/js/library/form-hidden-operations.js')
@endpush

    {{ $slot }}

</form>
