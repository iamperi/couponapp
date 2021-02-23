@foreach($shopUsers as $shopUser)
<tr>
    <td>{{ $shopUser->full_name }}</td>
    <td>{{ $shopUser->username }}</td>
    <td>{{ $shopUser->email }}</td>
    <td>{{ $shopUser->phone ?? '-' }}</td>
    <td>{{ $shopUser->shop->due_amount }} €</td>
</tr>
@endforeach
