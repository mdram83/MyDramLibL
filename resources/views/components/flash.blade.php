<div class="fixed bottom-3 right-3 ml-3 ">

    @if (session()->has('success'))
        <div id="flashSuccess" onclick="this.classList.add('hidden');"
             class="
                transition-all duration-1000 ease-in-out
                py-2 px-4
                bg-blue-200 border border-blue-600 text-blue-900 opacity-90
                text-sm font-semibold
                rounded-md hover:cursor-pointer
             "
        >
            <p>{{ session('success') }}</p>
        </div>

        @push('custom-scripts')
            <script>
                setTimeout(function () {
                    document.getElementById("flashSuccess").classList.remove("opacity-90");
                    document.getElementById("flashSuccess").classList.add("opacity-0");
                    setTimeout(() => document.getElementById("flashSuccess").classList.add("hidden"), 1000);
                }, 4000);
            </script>
        @endpush
    @endif

    @error('general')
        <div id="flashError" onclick="this.classList.add('hidden');"
             class="
                transition-all duration-1000 ease-in-out
                py-2 px-4
                bg-red-200 border border-red-600 text-red-900 opacity-90
                text-sm font-semibold
                rounded-md hover:cursor-pointer
             "
        >
            <p>{{ $message }}</p>
        </div>

        @push('custom-scripts')
            <script>
                setTimeout(function () {
                    document.getElementById("flashError").classList.remove("opacity-90");
                    document.getElementById("flashError").classList.add("opacity-0");
                    setTimeout(() => document.getElementById("flashError").classList.add("hidden"), 1000);
                }, 9000);
            </script>
        @endpush
    @enderror

</div>
