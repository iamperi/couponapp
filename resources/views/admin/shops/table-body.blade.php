@foreach($shopUsers as $shopUser)
<tr>
    <td>{{ $shopUser->full_name }}</td>
    <td>{{ $shopUser->username }}</td>
    <td>{{ $shopUser->email }}</td>
    <td>{{ $shopUser->phone ?? '-' }}</td>
    <td>{{ $shopUser->shop->due_amount ?? 0 }} €</td>
    @if($shopUser->shop && !is_null($shopUser->shop->registration_token))
    <td>
        <a href="{{ route('admin.shops.send_registration_email', $shopUser->shop) }}" class="btn btn-xs">@lang('Resend email')</a>
    </td>
    @else
    <td></td>
    @endif
</tr>
@endforeach
