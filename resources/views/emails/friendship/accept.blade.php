<x-mail::message>
# <b>{{ $friendName }}</b> accepted your invitation to connect.

Click on below button to manage your friends list.

<x-mail::button :url="$link">
    Manage Friends List
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
