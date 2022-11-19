@props(['httpName', 'prefix', 'divId', 'formId', 'hiddenInputName'])

@if(session()->getOldInput($httpName))
    @foreach (session()->getOldInput($httpName) as $value)
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
