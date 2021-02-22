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
                            <td>{{ $coupon->used_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
