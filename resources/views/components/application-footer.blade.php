<!-- Footer -->
<div class="flex justify-center mt-2 sm:items-center sm:justify-between">
    <div class="text-center text-sm text-gray-500 sm:text-left">
        <div class="flex items-center">

            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
            <a href="{{ route('about') }}" class="ml-1 underline">
                About
            </a>


            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text ml-2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <a href="{{ route('terms') }}" class="ml-1 underline">
                Terms & Privacy
            </a>

        </div>
    </div>

    <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
        My Library v.{{ config('app.app_version') }}
    </div>
</div>
