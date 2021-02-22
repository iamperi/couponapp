<x-admin-layout>
    <div class="card">
        <div class="card-header">
            <label class="card-title">@lang('Shop list')</label>
        </div>

        <div class="card-body">
            <div class="responsive-table-wrapper">
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
                        @foreach($shopUsers as $shopUser)
                        <tr>
                            <td>{{ $shopUser->full_name }}</td>
                            <td>{{ $shopUser->username }}</td>
                            <td>{{ $shopUser->email }}</td>
                            <td>{{ $shopUser->phone ?? '-' }}</td>
                            <td>{{ $shopUser->password }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card mt-8">
        <div class="card-header">
            <label class="card-title">@lang('New shop')</label>
        </div>

        <form method="POST" action="{{ route('admin.shops.store') }}" x-data="{ name: '{{ old('name') }}', usernameChanged: false}">
            @csrf
            <div class="grid grid-cols-2 gap-x-6">
                <div class="input-group">
                    <label>@lang('Name')</label>
                    <input type="text"
                           id="shop_name"
                           name="name"
                           class="textbox @error('name') invalid @enderror"
                           x-model="name"
                           @keyup="if(!usernameChanged){ $refs.shop_username.value = name.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replaceAll(' ', '.').toLowerCase(); }"
                    >
                    @error('name')
                    <span class="form-feedback error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group">
                    <label>@lang('Username')</label>
                    <input type="text"
                           id="shop_username"
                           x-ref="shop_username"
                           name="username"
                           class="textbox @error('username') invalid @enderror"
                           value="{{ old('username') }}"
                           @keyup="usernameChanged = true"
                    >
                    @error('username')
                    <span class="form-feedback error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group">
                    <label>@lang('Email')</label>
                    <input type="email" name="email" class="textbox @error('email') invalid @enderror" value="{{ old('email') }}">
                    @error('email')
                    <span class="form-feedback error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group">
                    <label>@lang('Phone')</label>
                    <input type="text" name="phone" class="textbox @error('phone') invalid @enderror" value="{{ old('phone') }}">
                    @error('phone')
                    <span class="form-feedback error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group">
                    <label>@lang('Password')</label>
                    <input type="password" name="password" class="textbox @error('password') invalid @enderror">
                    @error('password')
                    <span class="form-feedback error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group">
                    <label>@lang('Password confirmation')</label>
                    <input type="password" name="password_confirmation" class="textbox">
                </div>
            </div>

            <div class="my-4 w-full text-center">
                <button class="btn">@lang('Create shop')</button>
            </div>
        </form>
    </div>
</x-admin-layout>
