<div x-data="{
        prefix: '{{ old("prefix") }}',
        couponCount: '',
        couponValidity: '',
        limitPerPerson: '',
        redirectUrl: '{{ url()->full() }}#tab3'
     }"
     class="card mt-8"
>
    <div class="card-header">
        <label class="card-title">@lang('New campaign')</label>
    </div>

    <form method="POST" action="{{ route('admin.campaigns.store') }}">
        @csrf
        <input type="hidden" name="redirect" :value="redirectUrl">
        <div class="grid grid-cols-2 gap-x-6">
            <div class="input-group">
                <label>@lang('Campaign name')</label>
                <input type="text" name="name" class="textbox @error('name') invalid @enderror" value="{{ old('name') }}" maxlength="64">
                @error('name')
                <span class="form-feedback error">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group">
                <label>@lang('Campaign prefix')</label>
                <div class="textbox-with-span">
                    <input type="text"
                           name="prefix"
                           class="textbox uppercase @error('prefix') invalid @enderror"
                           value="{{ old('prefix') }}"
                           maxlength="3"
                           x-model="prefix"
                    >
                    <span class="text-xs">Ej. cupón:&nbsp;<label x-text="prefix" class="uppercase"></label>X9RD4M</span>
                </div>
                @error('prefix')
                <span class="form-feedback error">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group">
                <label>@lang('Starts at')</label>
                <div class="textbox-with-span">
                    <input type="text"
                           id="starts_at"
                           x-ref="starts_at"
                           name="starts_at"
                           class="textbox date-input @error('starts_at') invalid @enderror"
                           value="{{ old('starts_at') }}"
                    >
                    <span class="text-xs cursor-pointer" @click="$refs.starts_at.click()">
                        <img src="{{ asset('img/icons/calendar-ok.svg') }}">
                    </span>
                </div>
                @error('starts_at')
                <span class="form-feedback error">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group">
                <label>@lang('Ends at')</label>
                <div class="textbox-with-span">
                    <input type="text"
                           id="ends_at"
                           x-ref="ends_at"
                           name="ends_at"
                           class="textbox date-input @error('ends_at') invalid @enderror"
                           value="{{ old('ends_at') }}"
                    >
                    <span class="text-xs cursor-pointer" @click="$refs.ends_at.click()">
                        <img src="{{ asset('img/icons/calendar-x.svg') }}">
                    </span>
                </div>
                @error('ends_at')
                <span class="form-feedback error">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group">
                <label>@lang('Price per coupon')</label>
                <div class="textbox-with-span">
                    <input type="text"
                           name="coupon_amount"
                           class="textbox @error('coupon_amount') invalid @enderror"
                           value="{{ old('coupon_amount') }}"
                    >
                    <span>
                        <img src="{{ asset('img/icons/euro.svg') }}">
                    </span>
                </div>
                @error('coupon_amount')
                <span class="form-feedback error">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group">
                <label>@lang('Coupon max per person')</label>
                <div class="textbox-with-span">
                    <input type="text"
                           name="limit_per_person"
                           class="textbox @error('limit_per_person') invalid @enderror"
                           value="{{ old('limit_per_person') }}"
                           x-model="limitPerPerson"
                    >
                    <span>
                        <label class="lowercase" x-text="limitPerPerson == '1' ? '{{ __('Coupon') }}' : '{{ __('Coupons') }}'"></label>
                    </span>
                </div>
                @error('limit_per_person')
                <span class="form-feedback error">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group">
                <label>@lang('Coupon total')</label>
                <div class="textbox-with-span">
                    <input type="text"
                           name="coupon_count"
                           class="textbox @error('coupon_count') invalid @enderror"
                           value="{{ old('coupon_count') }}"
                           x-model="couponCount"
                    >
                    <span>
                        <label class="lowercase" x-text="couponCount == '1' ? '{{ __('Coupon') }}' : '{{ __('Coupons') }}'"></label>
                    </span>
                </div>
                @error('coupon_count')
                <span class="form-feedback error">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group">
                <label>@lang('Coupon valid for')</label>
                <div class="textbox-with-span">
                    <input type="text"
                           name="coupon_validity"
                           class="textbox @error('coupon_validity') invalid @enderror"
                           value="{{ old('coupon_validity') }}"
                           x-model="couponValidity"
                    >
                    <span>
                        <label class="lowercase"
                               x-text="couponValidity == '1' ? '{{ __('Hour') }}' : '{{ __('Hours') }}'"></label>
                    </span>
                </div>
                @error('coupon_validity')
                <span class="form-feedback error">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="my-4 w-full text-center">
            <button class="btn">@lang('Create campaign')</button>
        </div>
    </form>
</div>

<div class="card mt-8">
    <div class="card-header">
        <div class="card-title">
            <h1>@lang('Active campaigns')</h1>
            <h2>@lang('Citizens will only receive coupons from the active campaign')</h2>
        </div>
        <div class="card-body">
            <div class="active-campaigns mt-8">
            @foreach($activeCampaigns as $campaign)
                <div class="flex inline-flex flex-col bg-indigo-50 border border-indigo-200 p-6 rounded shadow">
                    <label class="font-medium">{{ $campaign->name }}</label>
                    <label>
                        {{ $campaign->coupon_count }} <span class="lowercase">@lang('Coupons')</span>
                        ({{ $campaign->usedCouponCount() }} <span class="lowercase">@lang('Used')</span>)
                    </label>
                    <label>@lang('Amount'): {{ $campaign->coupon_amount }} €</label>
                    <label>@lang('Valid for') {{ $campaign->coupon_validity }} <span class="lowercase">@lang('Hours')</span></label>
                    <form method="POST" action="{{ route('admin.campaigns.deactivate', $campaign) }}">
                        @csrf
                        <button class="btn btn-xs btn-red">@lang('Desactivar')</button>
                    </form>
                </div>
            @endforeach
            </div>
        </div>

    </div>

    <div class="card-body">

    </div>
</div>
