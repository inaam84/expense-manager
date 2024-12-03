@component('mail::message')

@component('mail::panel')
>>>> Welcome Email
@endcomponent

Hi {{ $user->firstname }},

Your **{{ config('app.name') }}** account has been created, your username is as follows:

> **Username:** {{ $user->username }}<br>

*you will receive another email containing your password. If you don't receive password email, please contact **{{ config('app.name') }}** system administrator.*

@component('mail::button', ['url' => env('APP_URL').'/login'])
    Login to **{{ config('app.name') }}**
@endcomponent

Regards,<br>

<br>
{{ config('app.name') }}
@endcomponent


