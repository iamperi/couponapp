<x-admin-layout>
    <div x-data="{ tab: 'tab1' }">

        <label>@lang('Hello') {{ auth()->user()->username }}</label>

        <div class="tabs flex items-center">
            <div class="tab" :class="{'active': tab == 'tab1'}" @click="tab = 'tab1'">
                <label>@lang('Shops')</label>
            </div>
            <div class="tab" :class="{'active': tab == 'tab2'}" @click="tab = 'tab2'">
                <label>@lang('Historic')</label>
            </div>
            <div class="tab" :class="{'active': tab == 'tab3'}" @click="tab = 'tab3'">
                <label>@lang('Campaigns')</label>
            </div>
        </div>

        <div x-show="tab == 'tab1'">
            @include('admin.includes.shops-tab')
        </div>

        <div x-show="tab == 'tab2'">
            Historic content
        </div>

        <div x-show="tab == 'tab3'">
            Campaigns content
        </div>
    </div>
</x-admin-layout>
