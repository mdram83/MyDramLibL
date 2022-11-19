@props(['name'])

@if ($errors->any())
    @foreach($errors->messages() as $key => $error)
        @php if (str_contains($key, $name)) $message = str_replace($key, $name, $error[0]); @endphp
    @endforeach
@endif

@isset($message)
    <p {!! $attributes->merge(['class' => 'text-red-500 text-xs mt-2']) !!}>{{ $message }}</p>
@endisset
