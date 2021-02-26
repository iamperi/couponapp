<x-app-layout>
    <div class="w-full text-center">
        @if(isset($coupon))
            <div class="m-0 sm:m-8">
                <div class="flex flex-col">
                    <label class="text-2xl text-green-400 font-medium mb-4">@lang('Congratulations!')</label>
                    <label class="mb-1">@lang('Here is your coupon')</label>
                    <label class="mb-4 font-bold">@lang('Dont forget to download it!')</label>
                </div>
                @include('coupon', ['coupon' => $coupon])
                <div class="flex items-center justify-center mt-8">
                    <a href="{{ route('coupons.pdf', $coupon) }}" class="flex items-center mr-4">
                        <img src="{{ asset('img/icons/save.svg') }}" alt="PDF" class="w-8">
                        <label class="ml-2 text-sm cursor-pointer">@lang('Download PDF')</label>
                    </a>
                </div>
            </div>
            <hr class="mt-8 mb-4 mx-auto w-1/2">
        @endif

        <h1 class="text-5xl mb-8">¡Hola Ciudadano!</h1>

        @if($campaign)
            <h3 class="text-xl mb-8">Nuestra campaña actual de cupones es:</h3>

            <div class="">
                <h2 class="text-8xl text-green-500">{{ $campaign->coupon_amount }}€</h2>
                <h4 class="text-2xl text-green-400 mt-6">{{ $campaign->name }}</h4>

                <div class="mt-8">
                    <h6 class="text-red-500">Recuerda las reglas:</h6>
                    <ul class="Coupon__rules_list">
                        <li class="text-sm">
                            - Utiliza tu cupón antes de {{ $campaign->coupon_validity }} horas en cualquier
                            <a href="#">tienda asociada</a>
                        </li>
                        <li class="text-sm">- Puedes conseguir {{ $campaign->limit_per_person }} cupones para esta campaña</li>
                    </ul>
                </div>
            </div>

            <form method="POST" action="{{ route('coupons.assign') }}" class="max-w-2xl grid grid-cols-1 sm:grid-cols-2 gap-4 text-left mx-auto my-8">
                @csrf
                <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
                <div class="flex flex-col">
                    <label for="name" class="text-sm">@lang('Name') *</label>
                    <input type="text" name="name" class="rounded-lg py-1 px-2" value="{{ old('name') }}">
                    @error('name')
                    <span class="text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col">
                    <label for="last_name" class="text-sm">@lang('Last name') *</label>
                    <input type="text" name="last_name" class="rounded-lg py-1 px-2" value="{{ old('last_name') }}">
                    @error('last_name')
                    <span class="text-xs text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex flex-col" x-data="{}">
                    <label for="dni" class="text-sm">@lang('D.N.I.') *</label>
                    <input type="text"
                           name="dni"
                           class="rounded-lg py-1 px-2 uppercase"
                           value="{{ old('dni') }}"
                           maxlength="9"
                           @keyup="$event.target.value = $event.target.value.toUpperCase()"
                    >
                    @error('dni')
                    <span class="text-xs text-red-400">{{ $message }}</span>
                    @else
                    <span class="text-xs text-gray-400">@lang('Without spaces nor dashes')</span>
                    @enderror
                </div>

                <div class="flex flex-col">
                    <label for="phone" class="text-sm">@lang('Phone') *</label>
                    <input type="text"
                           name="phone"
                           class="rounded-lg py-1 px-2"
                           value="{{ old('phone') }}"
                           maxlength="9"
                    >
                    @error('phone')
                    <span class="text-xs text-red-400">{{ $message }}</span>
                    @else
                    <span class="text-xs text-gray-400">@lang('Without spaces')</span>
                    @enderror
                </div>

                <div class="flex flex-col">
                    <label for="email" class="text-sm">@lang('Email') *</label>
                    <input type="text" name="email" class="rounded-lg py-1 px-2" value="{{ old('email') }}">
                    @error('email')
                    <span class="text-xs text-red-400">{{ $message }}</span>
                    @else
                    <span class="text-xs text-gray-400">@lang('We will send your code to this email')</span>
                    @enderror
                </div>

                <div class="flex flex-col justify-end">
                    <button class="bg-red-700 rounded-lg text-white w-full px-2 py-1.5 mb-4">@lang('Get coupon')</button>
                </div>

                <div>
                    <label class="text-xs text-gray-500">@lang('Fields marked with * are required')</label>
                </div>
            </form>
        @else
            <div class="max-w-2xl m-auto text-center">
                <img src="{{ asset('img/icons/ticket.svg') }}" alt="Ticket" class="w-48 mx-auto opacity-20 rotate-12">
                <label class="text-xl">@lang('Sorry, no campaign active')</label>
            </div>
        @endif
    </div>
</x-app-layout>
