@component('mail::message')
# @lang('Hello!')

@lang('You are receiving this email because we received a password reset request for your account.')

@component('mail::button', ['url' => $url])
@lang('Reset password')
@endcomponent

@lang('If you did not request a password reset, no further action is required.')

<br>

@lang('Thanks'),<br>
{{ config('app.name') }}

@slot('subcopy')
    @lang('Trouble clicking reset password button') <a href="{{ $url }}" class="display: inline;">{{ $url }}</a>
@endslot
@endcomponent
