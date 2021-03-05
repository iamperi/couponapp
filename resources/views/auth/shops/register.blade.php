<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('shops.register.store') }}">
            @csrf

            <input type="hidden" name="token" value="{{ request('token') }}">

            <div>
                <x-label for="shop_name" :value="__('Shop name')" />

                <x-input id="shop_name" class="block mt-1 w-full" type="text" name="shop_name" :value="old('shop_name') ?? $shop->name" autofocus />

                @error('shop_name')
                <x-form-error>{{ $message }}</x-form-error>
                @enderror
            </div>

            <!-- Name -->
            <div class="mt-4">
                <x-label for="username" :value="__('Username')" />

                <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" autofocus />

                @error('username')
                <x-form-error>{{ $message }}</x-form-error>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email') ?? $shop->user->email" disabled />

                @error('email')
                <x-form-error>{{ $message }}</x-form-error>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mt-4">
                <x-label for="phone" :value="__('Phone')" />

                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" />

                @error('phone')
                <x-form-error>{{ $message }}</x-form-error>
                @enderror
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                autocomplete="new-password" />

                @error('password')
                <x-form-error>{{ $message }}</x-form-error>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" />
            </div>

            <div class="flex items-center justify-center mt-4">
                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>

        <x-slot name="bottom">
            <a href="{{ asset('pdf/condiciones.pdf') }}" class="text-xs text-gray-500" target="_blank">@lang('Terms and legal conditions')</a>
        </x-slot>
    </x-auth-card>
</x-guest-layout>
