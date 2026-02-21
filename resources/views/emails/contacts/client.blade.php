@component('mail::message')
# {{ __('messages.mail_greeting', ['name' => $contact->name]) }}

{!! __('messages.mail_received_subject', ['subject' => $contact->subject]) !!}

{{ __('messages.mail_expert_analysis') }}

**{{ __('messages.mail_summary_title') }}**
*"{{ $contact->message }}"*

{{ __('messages.mail_cta_waiting') }}

@component('mail::button', ['url' => url(app()->getLocale())])
{{ __('messages.mail_button_catalog') }}
@endcomponent

{{ __('messages.mail_closer') }}<br>
{{ __('messages.mail_team', ['app' => config('app.name')]) }}
@endcomponent