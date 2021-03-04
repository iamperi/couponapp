@component('mail::message')
# @lang('Hello!')

{{ __('Your shop :shop has received an invitation to participate in MostoleApp', ['shop' => $shop->name]) }}

<br>

@lang('Click on the button below to access the registration page')

@component('mail::button', ['url' => $url])
@lang('Go to registration')
@endcomponent

@lang('Thanks'),<br>
{{ config('app.name') }}

@slot('subcopy')
    @lang('Trouble clicking registration button') <a href="{{ $url }}" class="display: inline;">{{ $url }}</a>
@endslot

@endcomponent
