@component('mail::message')
# Hello {{$name}},

Your profile on Gulf Lab EXPO has been successfully deleted. 

Sincerely,<br>
{{ config('app.name') }}
@endcomponent