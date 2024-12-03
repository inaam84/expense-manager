@component('mail::message')
Hi {{ $user->firstname }},

@lang('The password for your ' . config('app.name') . ' Account ' . $user->email . ' was recently changed.')
<br><br>
@lang('If this was you, you can ignore this alert. If you suspect any suspicious activity on your account, please contact System Administrator.')
<br><br>
Regards,<br>

<br>
{{ config('app.name') }}

@endcomponent
