@component('mail::message')
Hello {{ $userName }},

{{ $messageContent }}

@component('mail::button', ['url' => route('user.show', $profileId)])
View Your Profile
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
