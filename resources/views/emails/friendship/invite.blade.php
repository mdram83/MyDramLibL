<x-mail::message>
# <b>{{ $friendName }}</b> invited you to connect.

Click on below button to accept or reject this invitation.

<x-mail::button :url="$link">
Manage Friends List
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
