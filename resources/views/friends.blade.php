<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Friends') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="p-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="ml-2">

                    <div class="text-lg leading-7 font-semibold">Friends and Invites</div>

                    @if (!$friends->count())
                        <div class="flex justify-center mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            Your list is empty. Invite friends using below window.
                        </div>
                    @endif

                    <div class="flex justify-center mt-2 text-gray-600 dark:text-gray-400 text-sm">

                        <table class="table-fixed w-full sm:max-w-2xl w-full">
                            <thead class="border-b font-medium dark:border-neutral-500">
                                <tr>
                                    <th class="h-10 w-1/6 sm:w-1/12"></th>
                                    <th class="h-10 flex justify-start items-center">Name</th>
                                    <th class="h-10 w-2/6 sm:w-1/6"></th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- List Friends -->

                                @foreach ($friends as $friend)
                                    <tr class="border-b font-medium dark:border-neutral-500">
                                        <td class="h-10 flex justify-center items-center">
                                            <x-svg icon="{{ $friendshipTranslator->getStatusIconName($friend) }}"
                                                   stroke="{{ $friendshipTranslator->getStatusIconColor($friend) }}"
                                                   width="20"
                                                   height="20"
                                                   class="m-2"
                                            />
                                        </td>
                                        <td>
                                            {{ $friendshipTranslator->getFriendNameOfLoggedUser($friend) }}
                                        </td>
                                        <td class="flex justify-end items-center">
                                            @foreach ($friendshipTranslator->getPossibleActions($friend) as $action)
                                                <x-svg icon="{{ $action['icon'] }}"
                                                       stroke="{{ $action['color'] }}"
                                                       width="20"
                                                       height="20"
                                                       class="m-2"
                                                />
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- Add Friend -->
                                <tr>
                                    <td class="h-16 flex justify-center items-center">
                                        <x-svg icon="search"
                                               width="20"
                                               height="20"
                                               class="m-2"
                                        />
                                    </td>
                                    <td>
                                        <label for="friend"></label>
                                        <input id="friend"
                                               type="text"
                                               class="
                                                w-full
                                                py-1.5
                                                text-sm
                                                rounded-sm
                                                shadow-sm
                                                border-gray-300
                                                focus:border-indigo-300
                                                focus:ring
                                                focus:ring-indigo-200
                                                focus:ring-opacity-50
                                        ">
                                    </td>
                                    <td class="flex justify-end items-center">
                                        <x-svg icon="user-plus"
                                               stroke="rgb(34 197 94)"
                                               width="20"
                                               height="20"
                                               class="m-2"
                                        />
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>
