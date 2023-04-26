<div class="relative inline-flex items-center justify-end cursor-pointer"
     x-data="{ open: false }"
     @click="open = true"
     @click.outside="open = false"
>
    @php($userName = auth()->user()->full_name)
    <label class="mr-2 cursor-pointer">{{ $userName }}</label>
    <div class="flex items-center justify-center w-8 h-8 border border-gray-400 bg-gray-200 rounded-full font-bold text-gray-600">
        {{ strtoupper(substr($userName, 0, 1)) }}
    </div>
    <ul class="absolute w-60 mt-24 bg-white shadow-lg rounded py-2" x-show="open">
        <li class="text-left hover:bg-indigo-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full outline-none pl-4 py-2">
                    <img src="{{ asset('img/icons/logout.svg') }}" alt="@lang('Logout')" class="mr-2">
                    @lang('Logout')
                </button>
            </form>
        </li>
    </ul>
</div>
