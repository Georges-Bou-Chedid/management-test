@component('mail::message')

# Hello {{$notifiable}}

@component('mail::button', ['url' => $url])
Confirm
@endcomponent

Thank you,<br>
*The FleetRuunr Team*

@endcomponent
