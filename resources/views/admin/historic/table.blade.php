<table id="historic_table">
    <thead>
        <tr>
            <td data-field="users.name">@lang('Name')</td>
            <td data-field="users.dni">@lang('DNI')</td>
            <td data-field="users.phone">@lang('Phone')</td>
            <td data-field="code">@lang('Coupon')</td>
            <td data-field="campaign.name">@lang('Campaign')</td>
            <td data-field="amount">@lang('Amount')</td>
            <td data-field="used_at">@lang('Used at')</td>
            <td data-field="name">
                <div class="flex items-center relative" x-data="{ show: false }">
                    <label>@lang('Status')</label>
                    @admin
                    <img src="{{ asset('img/icons/help.svg') }}"
                         class="w-5 ml-2 cursor-pointer"
                         @click="show = !show"
                         @click.away="show = false">
                    @endadmin
                    <div class="absolute w-32 rounded bg-white shadow-lg mt-24 p-2" x-show="show">
                        <label class="text-xs normal-case">@lang('Inline mark as payed')</label>
                    </div>
                </div>
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach($usedCoupons as $coupon)
        <tr>
            <td>{{ $coupon->user->full_name }}</td>
            <td>{{ $coupon->user->dni }}</td>
            <td>{{ $coupon->user->phone }}</td>
            <td>{{ $coupon->code }}</td>
            <td>{{ $coupon->campaign->name }}</td>
            <td>{{ $coupon->amount }}€</td>
            <td class="flex flex-col items-start">
                <x-badge class="badge-indigo">{{ $coupon->shop->name }}</x-badge>
                {{ $coupon->used_at->format('d/m/Y H:i:s') }}
            </td>
            <td x-data="{}">
                @admin
                <form method="POST" action="{{ route('admin.coupons.payment.update', $coupon) }}">
                    @csrf
                    <a href="javascript:void(0);" @click="$event.target.closest('form').submit()">
                        <x-badge class="{{ $coupon->payed_at ? 'badge-green' : 'badge-red' }} cursor-pointer">
                            {!! $coupon->payedStatus() !!}
                        </x-badge>
                    </a>
                </form>
                @else
                <x-badge class="{{ $coupon->payed_at ? 'badge-green' : 'badge-red' }}">
                    {!! $coupon->payedStatus() !!}
                </x-badge>
                @endadmin
                @if($coupon->payed_at)<span class="text-xs block">{{ $coupon->payed_at->format('d/m/Y H:i:s') }}</span> @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
