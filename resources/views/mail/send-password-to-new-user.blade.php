@component('mail::message')
Hi {{ $user->firstname }},

Following is your password for **{{ config('app.name') }}** account:

> {{ $password }}<br>

*you must have received welcome email containing your username. If you haven't received welcome email, please contact **{{ config('app.name') }}** system administrator.*

Regards,<br>

<br>
{{ config('app.name') }}
@endcomponent


