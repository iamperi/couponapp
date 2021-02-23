<table id="shops_table">
    <thead>
        <tr>
            <td data-field="name">@lang('Name')</td>
            <td data-field="username">@lang('Username')</td>
            <td data-field="email">@lang('Email')</td>
            <td data-field="phone">@lang('Phone')</td>
            <td>@lang('Pending payments')</td>
        </tr>
    </thead>
    <tbody>
        @include('admin.shops.table-body')
    </tbody>
</table>

<div class="mx-4 mt-4">
    {{ $shopUsers->links() }}
</div>

