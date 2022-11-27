@props(['prefix', 'divId', 'formId', 'hiddenInputName', 'values'])

@if(session()->getOldInput() === [] && $values !== [])
    @foreach ($values as $value)
        <script>
            window.addEventListener('load', () => {
                window.addToSelection(
                    "{{ $value }}",
                    "{{ $prefix }}",
                    "{{ $divId }}",
                    "{{ $formId }}",
                    "{{ $hiddenInputName }}"
                )
            });
        </script>
    @endforeach
@endif
