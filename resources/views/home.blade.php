<form method="POST" action="{{ route('coupons.assign') }}">
    @csrf
    <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
    <div>
        <label for="name">@lang('Name')</label>
        <input type="text" name="name">
    </div>

    <div>
        <label for="last_name">@lang('Last name')</label>
        <input type="text" name="last_name">
    </div>

    <div>
        <label for="dni">@lang('D.N.I.')</label>
        <input type="text" name="dni">
    </div>

    <div>
        <label for="phone">@lang('Phone')</label>
        <input type="text" name="phone">
    </div>

    <div>
        <label for="email">@lang('Email')</label>
        <input type="text" name="email">
    </div>

    <div>
        <button>@lang('Get coupon')</button>
    </div>
</form>
