@component('mail::message')
# {{ __('messages.mail_inquiry_greeting', ['name' => $inquiry->name]) }}

{!! __('messages.mail_inquiry_received', ['title' => $property->title]) !!}

@if($inquiry->type_action === 'Vente')
{{-- CAS VENTE : LOGIQUE RELATIONNELLE --}}
### {{ __('messages.mail_sale_subtitle') }}
{{ __('messages.mail_sale_intro') }}

**1. {{ __('messages.mail_sale_step1_title') }}** {{ __('messages.mail_sale_step1_text') }}
**2. {{ __('messages.mail_sale_step2_title') }}** {{ __('messages.mail_sale_step2_text') }}
**3. {{ __('messages.mail_sale_step3_title') }}** {{ __('messages.mail_sale_step3_text') }}

@else
{{-- CAS LOCATION / RESERVATION : LOGIQUE FINANCIERE --}}
## {{ __('messages.mail_inquiry_finance_title') }}
* **{{ __('messages.mail_inquiry_op_type') }}** {{ $inquiry->type_action }}

@if($inquiry->type_action === 'Réservation')
* **{{ __('messages.mail_inquiry_stay') }}** {{ __('messages.mail_inquiry_stay_detail', [
    'date' => \Carbon\Carbon::parse($inquiry->arrival_date)->format('d/m/Y'),
    'nights' => $inquiry->nights
]) }}
@else
* **{{ __('messages.mail_inquiry_visit') }}** {{ __('messages.mail_inquiry_visit_detail', [
    'date' => \Carbon\Carbon::parse($inquiry->visit_date)->format('d/m/Y'),
    'time' => $inquiry->visit_time
]) }}
@endif

* **{{ __('messages.mail_inquiry_total_amount') }}** @if($inquiry->type_action === 'Location') 
{{ __('messages.mail_inquiry_amount_rent', ['amount' => number_format($property->price * 5, 0, ',', ' ')]) }} 
@else 
{{ __('messages.mail_inquiry_amount_book', ['amount' => number_format($property->price * $inquiry->nights, 0, ',', ' ')]) }} 
@endif

---

### {{ __('messages.mail_inquiry_proc_title') }}

1. {!! __('messages.mail_inquiry_proc_step1') !!}
2. {!! __('messages.mail_inquiry_proc_step2') !!}
3. **{{ __('messages.mail_inquiry_proc_step3') }}** @if($inquiry->type_action === 'Location')
> {{ __('messages.mail_inquiry_pass_rent') }}
@else
> {{ __('messages.mail_inquiry_pass_book') }}
@endif
@endif

@component('mail::button', ['url' => route('properties.show', ['locale' => app()->getLocale(), 'slug_uuid' => $property->url_identifier])])
{{ __('messages.mail_inquiry_btn_view') }}
@endcomponent

{{ __('messages.mail_inquiry_closer') }}<br>
{!! __('messages.mail_team_bold', ['app' => config('app.name')]) !!}
@endcomponent