<x-admin-layout>
    <div x-data="{ tab: window.location.hash.replace('#', '') || localStorage.getItem('tab') }">

        <div class="tabs flex items-center">
            @admin
            <a href="#tab1" class="tab" :class="{'active': tab == 'tab1'}" @click="tab = 'tab1'; localStorage.setItem('tab', 'tab1')">
                <label>@lang('Shops')</label>
            </a>
            @endadmin
            @shop
            <a href="#tab1" class="tab" :class="{'active': tab == 'tab1'}" @click="tab = 'tab1'; localStorage.setItem('tab', 'tab1')">
                <label>@lang('Validate coupon')</label>
            </a>
            @endshop
            <a href="#tab2" class="tab" :class="{'active': tab == 'tab2'}" @click="tab = 'tab2'; localStorage.setItem('tab', 'tab2')">
                <label>@lang('Historic')</label>
            </a>
            @admin
            <a href="#tab3" class="tab" :class="{'active': tab == 'tab3'}" @click="tab = 'tab3'; localStorage.setItem('tab', 'tab3')">
                <label>@lang('Campaigns')</label>
            </a>
            @endadmin
        </div>

        <div x-show="tab == 'tab1'">
            @admin
                @include('admin.includes.shops-tab')
            @else
                @include('admin.includes.validate-coupon-tab')
            @endadmin
        </div>

        <div x-show="tab == 'tab2'">
            @include('admin.includes.historic-tab')
        </div>

        <div x-show="tab == 'tab3'">
            @include('admin.includes.campaigns-tab')
        </div>
    </div>
</x-admin-layout>
