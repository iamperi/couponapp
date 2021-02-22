<div class="tabs flex items-center">
    @admin
    <a href="{{ route('admin.shops.index') }}" class="tab @if(request()->is('*shops*')) active @endif">
        <label>@lang('Shops')</label>
    </a>
    @endadmin
    @shop
    <a href="{{ route('admin.coupons.validation.index') }}" class="tab @if(request()->is('*validate*')) active @endif">
        <label>@lang('Validate coupon')</label>
    </a>
    @endshop
    <a href="{{ route('admin.historic.index') }}" class="tab @if(request()->is('*historic*')) active @endif">
        <label>@lang('Historic')</label>
    </a>
    @admin
    <a href="{{ route('admin.campaigns.index') }}" class="tab @if(request()->is('*campaigns*')) active @endif">
        <label>@lang('Campaigns')</label>
    </a>
    @endadmin
</div>
