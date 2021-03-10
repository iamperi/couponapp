<x-admin-layout>
    <div class="card">
        <div class="card-header">
            <label class="card-title">@lang('Validate coupon')</label>
        </div>

        <div class="card-body">
            <form method="POST"
                  @if(isset($coupon))
                  action="{{ route('admin.coupons.validate', $coupon) }}"
                  @else
                  action="{{ route('admin.coupons.verify') }}"
                  @endif
                  class="flex flex-col justify-center items-center mt-4"
            >
                @csrf
                <label class="text-4xl mb-8">@lang('Enter coupon code')</label>

                <input type="text"
                       name="code"
                       value="{{ old('code') }}"
                       id="validate_coupon"
                       class="textbox text-4xl px-8 py-4 text-center uppercase"
                       placeholder="XXXP34FT6"
                       @keyup="$event.target.value = $event.target.value.toUpperCase()"
                       autofocus
                       maxlength="9"
                >
                @error('code')
                <span class="text-xs text-red-400">{{ $message }}</span>
                @enderror
                <span></span>
                @if(session('valid'))
                    <div class="alert alert-success mt-8 mb-4">
                        {{ session('valid') }}
                    </div>
                    <h1 class="font-bold mb-8">@lang('Press enter to validate the coupon')</h1>
                    @if(isset($coupon))
                        <div style="min-width: 26rem;">
                            @include('coupon')
                        </div>
                    @endif
                @elseif(session('invalid'))
                    <div class="alert alert-error mt-8">
                        {{ session('invalid') }}
                    </div>
                @endif

                @if(isset($coupon))
                <button class="btn btn-green mt-8 px-8 py-4 text-4xl">@lang('Validate coupon')</button>
                @else
                <button class="btn mt-8 px-8 py-4 text-4xl">@lang('Verify')</button>
                @endif
            </form>
        </div>
    </div>
</x-admin-layout>
