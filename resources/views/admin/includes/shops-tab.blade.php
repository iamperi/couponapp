<div>
    <div class="w-full text-center py-4">
        <label>@lang('Shop list')</label>
    </div>

    <div class="overflow-x-auto">
        <table>
            <thead>
                <tr>
                    <td>@lang('Name')</td>
                    <td>@lang('Username')</td>
                    <td>@lang('Email')</td>
                    <td>@lang('Phone')</td>
                    <td>@lang('Password')</td>
                </tr>
            </thead>
            <tbody>
                @foreach($shops as $shop)
                <tr>
                    <td>{{ $shop->name }}</td>
                    <td>{{ $shop->username }}</td>
                    <td>{{ $shop->email }}</td>
                    <td>{{ $shop->phone }}</td>
                    <td>{{ $shop->password }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div>
    <div class="w-full text-center py-4">
        <label>@lang('New shop')</label>
    </div>

    <form method="POST" action="{{ route('admin.shops.store') }}">
        @csrf
        <div class="input-group">
            <label>@lang('Name'):</label>
            <input type="text" name="name" class="textbox">
        </div>
        <div class="input-group">
            <label>@lang('Username'):</label>
            <input type="text" name="username" class="textbox">
        </div>
        <div class="input-group">
            <label>@lang('Email'):</label>
            <input type="email" name="email" class="textbox">
        </div>
        <div class="input-group">
            <label>@lang('Phone'):</label>
            <input type="text" name="phone" class="textbox">
        </div>
        <div class="input-group">
            <label>@lang('Password'):</label>
            <input type="password" name="password" class="textbox">
        </div>
        <div class="input-group">
            <label>@lang('Password confirmation'):</label>
            <input type="password" name="password_confirmation" class="textbox">
        </div>
        <div class="my-4 w-full text-center">
            <button class="btn">@lang('Create shop')</button>
        </div>
    </form>
</div>
