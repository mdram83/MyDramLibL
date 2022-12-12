<div class="js-cookie-consent cookie-consent fixed z-50 bottom-0 inset-x-0">
    <div class="w-full mx-auto">
        <div class="py-2 rounded-lg bg-yellow-100">

            <div class="block sm:flex max-w-6xl mx-auto sm:px-6 lg:px-8 items-center justify-between flex-wrap">

                <div class="w-full sm:w-auto flex-1 items-center">
                    <div class="flex justify-center sm:justify-start">
                        <p class="mx-3 sm:mx-1.5 sm:text-left text-center text-black w-fit text-sm cookie-consent__message">
                            {!! trans('cookie-consent::texts.message') !!}
                        </p>
                    </div>
                </div>

                <div class="m-2 flex-shrink-0 w-auto">
                    <div class="flex justify-center sm:justify-start">
                        <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer w-auto flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-yellow-800 bg-yellow-400 hover:bg-yellow-300">
                            {{ trans('cookie-consent::texts.agree') }}
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
