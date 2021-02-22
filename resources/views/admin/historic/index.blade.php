<x-admin-layout>
    <div class="card">
        <div class="card-header">
            <label class="card-title">@lang('Used coupon list')</label>
        </div>

        <div class="card-body">
            <div class="responsive-table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <td>@lang('Name')</td>
                            <td>@lang('DNI')</td>
                            <td>@lang('Phone')</td>
                            <td>@lang('Coupon')</td>
                            <td>@lang('Campaign')</td>
                            <td>@lang('Amount')</td>
                            <td>@lang('Used at')</td>
                            <td>
                                <div class="flex items-center relative" x-data="{ show: false }">
                                    <label>@lang('Status')</label>
                                    <img src="{{ asset('img/icons/help.svg') }}"
                                         class="w-5 ml-2 cursor-pointer"
                                         @click="show = !show"
                                         @click.away="show = false">
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
                            <td>{{ $coupon->user->username }}</td>
                            <td>{{ $coupon->user->dni }}</td>
                            <td>{{ $coupon->user->phone }}</td>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->campaign->name }}</td>
                            <td>{{ $coupon->amount }}</td>
                            <td class="flex flex-col items-start">
                                {{ $coupon->used_at->format('d/m/Y H:i:s') }}
                                <x-badge class="badge-indigo">{{ $coupon->shop->name }}</x-badge>
                            </td>
                            <td x-data="{}">
                                <form method="POST" action="{{ route('admin.coupons.payment.update', $coupon) }}">
                                    @csrf
                                    <a href="javascript:void(0);" @click="$event.target.closest('form').submit()">
                                        <x-badge class="{{ $coupon->payed_at ? 'badge-green' : 'badge-red' }} cursor-pointer">
                                            {!! $coupon->payedStatus() !!}
                                        </x-badge>
                                    </a>
                                </form>
                                @if($coupon->payed_at)<span class="text-xs">{{ $coupon->payed_at->format('d/m/Y H:i:s') }}</span> @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
