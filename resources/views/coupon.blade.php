<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Oxygen+Mono&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
<style>
    @font-face {
        font-family: 'Oxygen Mono';
        src: url({{ storage_path('fonts\OxygenMono-Regular.ttf') }}) format("truetype");
        font-weight: 400;
        font-style: normal;
    }
    @font-face {
        font-family: 'Nunito';
        src: url({{ storage_path('fonts\Nunito-Regular.ttf') }}) format("truetype");
        font-weight: 400;
        font-style: normal;
    }
    .coupon {
        max-width: 28rem;
        border-radius: .25rem;
        --tw-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        padding: 1rem;
        background: #B91C1C;
        margin: auto;
        color: white;
    }
    .coupon-top {
    }
    .coupon-top > div {
        display: inline-block;
        width: 50%;
        float: left;
        text-align: center;
    }
    .campaign-data {
        color: rgba(255, 255, 255, 1);
    }
    .data-title {
        text-transform: uppercase;
        color: rgba(255, 255, 255, .6);
        font-size: .6rem;
    }
    .coupon-amount {
        font-size: 2rem;
    }
    .text-lg {
        font-size: 1.125rem;
    }
    .text-sm {
        font-size: 0.875rem;
    }
    .text-xs {
        font-size: 0.75rem;
    }
    .coupon-bottom {
        text-align: center;
        margin-top: 7rem;
        clear: both;
    }
    .code-label-wrapper {
        border: 1px dashed rgba(255, 255, 255, .8);
        padding: 0 25px;
        margin: 10px auto;
    }
    .code-label {
        font-family: 'Oxygen Mono', monospace;
        font-size: 2rem;
        border: 1px dashed rgba(255, 255, 255, .8);
        width: 60%;
        margin: auto;
    }
    .dimmed-text {
        color: rgba(255, 255, 255, .6);
    }
    span,
    label {
        display: block;
        font-family: 'Nunito', sans-serif;
    }
    .coupon-logo {
        margin-top:30px;
        text-align: center;
    }
    .coupon-logo img {
        display: inline-block;
        width: 170px;
    }
</style>

<div class="coupon">
    <div class="coupon-top">
        <div class="campaign-data">
            <span class="data-title">@lang('Campaign')</span>
            <label class="coupon-amount">{{ $coupon->amount }}&euro;</label>
            <label class="text-sm">{{ $coupon->campaign->name }}</label>
        </div>
        <div class="">
            <span class="data-title">@lang('Client')</span>
            <label class="" style="color: rgba(255, 255, 255, .8);">{{ $coupon->user->full_name }}</label>
            <label class="text-xs" style="color: rgba(255, 255, 255, .8);">DNI: {{ $coupon->user->dni }}</label>
        </div>
    </div>

    <div class="coupon-bottom">
        <span class="data-title text-xs">@lang('Your code')</span>
        <label class="code-label">{{ $coupon->code }}</label>
        <label class="text-xs dimmed-text">@lang('Valid until') {{ $coupon->expires_at->format('d/m/Y H:i') }}</label>
        @if($coupon->campaign->coupon_extra_text != '')
        <label class="text-xs dimmed-text">{!! str_replace('€', '&euro;', $coupon->campaign->coupon_extra_text) !!}</label>
        @endif
    </div>

    <div class="coupon-logo">
        <img src="{{ asset('img/logo-blanco.png') }}">
    </div>
</div>
