<x-admin-layout>
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
            <div class="card-title">
                <h1>@lang('New campaign')</h1>
                <h2>@lang('Fields marked with * are required')</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.campaigns.store') }}">
            @csrf
            <input type="hidden" name="redirect" :value="redirectUrl">
            <div class="grid grid-col-1 sm:grid-cols-2 gap-x-6">
                <div class="input-group">
                    <label>@lang('Campaign name') *</label>
                    <input type="text" name="name" class="textbox @error('name') invalid @enderror" value="{{ old('name') }}" maxlength="64">
                    @error('name')
                    <span class="form-feedback error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group">
                    <label>@lang('Campaign prefix') *</label>
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
                    <label>@lang('Starts at') *</label>
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
                    <label>@lang('Price per coupon') *</label>
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
                    <label>@lang('Coupon max per person') *</label>
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
                    <label>@lang('Coupon total') *</label>
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
                    <label>@lang('Coupon valid for') *</label>
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
                <div class="input-group">
                    <label>@lang('Campaign description')</label>
                    <textarea name="description" rows="3" class="textarea @error('coupon_validity') invalid @enderror">
                        {{ old('description') ?? '' }}
                    </textarea>
                    @error('description')
                    <span class="form-feedback error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="flex flex-col">
                    <div class="input-group" x-data="{maxChars: 30, charsLeft: 30, prevLength: {{ strlen(old('coupon_extra_text')) }}, statusClass: ''}">
                        <label>@lang('Coupon extra text')</label>
                        <div class="textbox-with-span" :class="{'success': charsLeft > 10 && charsLeft < 30, 'warning': charsLeft <= 10, 'danger': charsLeft < 0}">
                            <input type="text"
                                   name="coupon_extra_text"
                                   class="textbox @error('coupon_extra_text') invalid @enderror"
                                   :class="statusClass"
                                   value="{{ old('coupon_extra_text') }}"
                                   @keyup="charsLeft = $event.target.value.length == 0 ? maxChars : maxChars - $event.target.value.length"
                            >
                            <span>
                                <label class="lowercase"
                                       x-text="charsLeft == '1' ? charsLeft + ' {{ __('Character') }}' : charsLeft + ' {{ __('Characters') }}'"></label>
                            </span>
                        </div>
                        @error('coupon_extra_text')
                        <span class="form-feedback error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div
                        x-data="{
                            checked: false,
                            url: '',
                        }"
                        x-init="
                            checked = $refs.checkbox.checked
                            url = `{{ config('app.url') }}/vip/${$refs.codeInput.value}`
                        "
                        class="flex flex-col"
                    >
                        <div class="input-group col-span-2 mb-4">
                            <label>
                                <input
                                    type="checkbox"
                                    x-ref="checkbox"
                                    name="is_vip"
                                    @input="checked = $refs.checkbox.checked"
                                    class="@error('is_vip') invalid @enderror" value="1" {{ old('is_vip') ? 'checked' : '' }}
                                >
                                @lang('Create VIP campaign')
                            </label>
                            @error('is_vip')
                            <span class="form-feedback error">{{ $message }}</span>
                            @enderror
                        </div>

                        <input type="hidden" x-ref="codeInput" name="vip_code" value="{{ $vipCode }}" />
                        <label x-show="checked" class="text-xs">Visible en: <span x-text="url" class="bg-gray-100 rounded px-2 py-1"></span></label>
                    </div>
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
                <h1>@lang('Campaign list')</h1>
                <h2>@lang('Citizens will only receive coupons from the active campaign')</h2>
            </div>
        </div>
        <div class="card-body">
            @if($activeCampaigns->count() > 0 || $oldCampaigns->count() > 0)
            <div class="active-campaigns grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 mt-2">
                @foreach($activeCampaigns as $campaign)
                    <div class="inline-flex flex-col min-w-full border p-6 rounded shadow m-2 {{ $campaign->active ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                        <div class="relative flex justify-between items-start">
                            <div class="flex flex-col">
                                <div>
                                    <span class="uppercase text-gray-400" style="font-size: .6rem;">@lang('Campaign')</span>
                                </div>
                                <label class="font-medium">{{ $campaign->name }}</label>
                                @if($campaign->is_vip)
                                <div
                                    x-data="{
                                        notifying: false,
                                        copyToClipboard() {
                                            label = this.$refs.url;

                                            navigator.clipboard.writeText(label.innerText);

                                            this.notifying = true
                                            setTimeout(() => {
                                                this.notifying = false
                                            }, 2000)
                                        }
                                    }"
                                    class="relative flex items-center mb-2"
                                >
                                    <label x-ref="url" @click="copyToClipboard" class="text-xs cursor-pointer">{{ $campaign->getVipUrl() }}</label>
                                    <label x-show="notifying" x-transition class="absolute top-full left-0 text-xs p-1 bg-green-100">Enlace copiado</label>
                                </div>
                                @endif
                                <span class="text-xs text-gray-500">
                                    @lang('From'):
                                    {{ $campaign->starts_at->format('d/m/Y H:i') }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    @lang('Until'):
                                    @if($campaign->ends_at)
                                    {{ $campaign->ends_at->format('d/m/Y H:i') }}
                                    @else
                                    @lang('No date')
                                    @endif
                                </span>
                            </div>
                            <div class="absolute top-1 right-1 flex items-center space-x-2">
                                @if($campaign->is_vip)
                                <span class="rounded text-xs bg-yellow-200 px-2">VIP</span>
                                @endif
                                <x-badge class="{{ $campaign->active ? 'badge-green' : 'badge-red' }}">
                                     {{ $campaign->status() }}
                                </x-badge>
                            </div>
                        </div>
                        <div class="flex flex-col mt-2">
                            <label class="text-sm">
                                {{ $campaign->coupon_count }} <span class="lowercase">@lang('Coupons')</span>
                                ({{ $campaign->usedCouponCount() }} <span class="lowercase">@lang('Used')</span>)
                            </label>
                            <label class="text-sm">@lang('Amount'): {{ $campaign->coupon_amount }} €</label>
                            <label class="text-sm">@lang('Valid for') {{ $campaign->coupon_validity }} <span class="lowercase">@lang('Hours')</span></label>
                            <form method="POST" action="{{ route('admin.campaigns.toggle', $campaign) }}" class="mt-4">
                                @csrf
                                @if($campaign->active)
                                    <button class="btn btn-xs btn-red">@lang('Deactivate')</button>
                                @else
                                    <button class="btn btn-xs btn-green">@lang('Activate')</button>
                                @endif
                            </form>
                        </div>
                    </div>
                @endforeach

                @foreach($oldCampaigns as $campaign)
                    <div class="inline-flex flex-col min-w-full border p-6 rounded shadow m-2 {{ $campaign->active ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                        <div class="relative flex justify-between items-start">
                            <div class="flex flex-col">
                                <div>
                                    <span class="uppercase text-gray-400" style="font-size: .6rem;">@lang('Campaign')</span>
                                </div>
                                <label class="font-medium">{{ $campaign->name }}</label>
                                @if($campaign->is_vip)
                                <div
                                    x-data="{
                                        notifying: false,
                                        copyToClipboard() {
                                            label = this.$refs.url;

                                            navigator.clipboard.writeText(label.innerText);

                                            this.notifying = true
                                            setTimeout(() => {
                                                this.notifying = false
                                            }, 2000)
                                        }
                                    }"
                                    class="relative flex items-center mb-2"
                                >
                                    <label x-ref="url" @click="copyToClipboard" class="text-xs cursor-pointer">{{ $campaign->getVipUrl() }}</label>
                                    <label x-show="notifying" x-transition class="absolute top-full left-0 text-xs p-1 bg-green-100">Enlace copiado</label>
                                </div>
                                @endif
                                <span class="text-xs text-gray-500">
                                    @lang('From'):
                                    {{ $campaign->starts_at->format('d/m/Y H:i') }}
                                </span>
                                <span class="text-xs text-gray-500">
                                    @lang('Until'):
                                    @if($campaign->ends_at)
                                    {{ $campaign->ends_at->format('d/m/Y H:i') }}
                                    @else
                                    @lang('No date')
                                    @endif
                                </span>
                            </div>
                            <div class="absolute top-1 right-1 flex items-center space-x-2">
                                @if($campaign->is_vip)
                                <span class="rounded text-xs bg-yellow-200 px-2">VIP</span>
                                @endif
                                <x-badge class="bg-gray-200 text-black">
                                     Cerrada
                                </x-badge>
                            </div>
                        </div>
                        <div class="flex flex-col mt-2">
                            <label class="text-sm">
                                {{ $campaign->coupon_count }} <span class="lowercase">@lang('Coupons')</span>
                                ({{ $campaign->usedCouponCount() }} <span class="lowercase">@lang('Used')</span>)
                            </label>
                            <label class="text-sm">@lang('Amount'): {{ $campaign->coupon_amount }} €</label>
                            <label class="text-sm">@lang('Valid for') {{ $campaign->coupon_validity }} <span class="lowercase">@lang('Hours')</span></label>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
            <div class="flex flex-col justify-center items-center">
                <img src="{{ asset('img/icons/ticket.svg') }}" class="w-40 rotate-12 opacity-20">
                <label>@lang('There are no campaigns that can be activated')</label>
                <label>@lang('Create a new one')</label>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
