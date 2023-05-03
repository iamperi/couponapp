<x-admin-layout>
    <div class="card">
        <div class="card-header flex justify-between">
            <div class="card-title">
                <h1>@lang('Used coupon list')</h1>
            </div>
            <div>
                <input type="text" class="textbox textbox-sm table-search" placeholder="@lang('Search...')">
            </div>
        </div>

        <div class="card-body">
            @admin
            <div class="flex flex-col">
                <label class="text-xs text-gray-300 uppercase tracking-widest">@lang('Filters')</label>
                <div class="mt-2 mb-6">
                    <div class="inline-flex flex-col">
                        <label class="text-xs text-gray-400">@lang('Shop')</label>
                        <select id="shop" class="pl-4 pr-8 py-2 text-xs rounded border border-gray-400">
                            <option value="">@lang('Select a shop')</option>
                            @foreach($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="inline-flex flex-col ml-4">
                        <label class="text-xs text-gray-400">@lang('Campaign')</label>
                        <select id="campaign" class="pl-4 pr-8 py-2 text-xs rounded border border-gray-400">
                            <option value="">@lang('Select a campaign')</option>
                            @foreach($notFinishedCampaigns as $campaign)
                            <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @endadmin
            <div class="responsive-table-wrapper">
                @include('admin.historic.table')
            </div>
        </div>
    </div>

    @push('js')
    <script>
        let filters = {
            search: '',
            shop: '',
            campaign: '',
            order_by: 'used_at',
            order_asc: false,
            page: 1,
            per_page: 25
        };
        const columns = [
            {
                field: 'user.full_name',
                label: 'Nombre'
            },
            {
                field: 'user.dni',
                label: 'DNI'
            },
            {
                field: 'user.phone',
                label: 'Teléfono'
            },
            {
                field: 'code',
                label: 'Cupón'
            },
            {
                field: 'campaign',
                label: 'Campaña'
            }
        ];
        const table = document.querySelector('#historic_table');
        const searchBox = document.querySelector('.table-search');
        const shopSelect = document.querySelector('#shop');
        const campaignSelect = document.querySelector('#campaign');

        refreshTable();

        searchBox.addEventListener('keyup', () => {
            const value = searchBox.value;
            if(value.length == 0 || value.length >= 3) {
                filters.search = value;
                refreshTable();
            }
        });

        shopSelect.addEventListener('change', function() {
            filters.shop = shopSelect.value;

            refreshTable();
        });

        campaignSelect.addEventListener('change', function() {
            filters.campaign = campaignSelect.value;

            refreshTable();
        });

        function updateHeaderListeners() {
            document.querySelectorAll('table thead tr td').forEach((el) => {
                el.addEventListener('click', () => {
                    const orderBy = el.dataset.field;
                    if(filters.order_by == orderBy) {
                        filters.order_asc = !filters.order_asc;
                    } else {
                        filters.order_by = orderBy;
                        filters.order_asc = true;
                    }

                    refreshTable();
                });
            });
        }

        function updatePaginationListeners() {
            document.querySelectorAll('.pagination a').forEach(el => {
                el.addEventListener('click', (e) => {
                    e.preventDefault();
                    const query = e.target.href.split('?')[1];
                    if(query.includes('page=')) {
                        const goToPage = query.split('page=')[1];
                        if(parseInt(goToPage) != filters.page) {
                            filters.page = goToPage;
                            refreshTable();
                        }
                    }
                    return false;
                });
            });
        }

        function refreshTable() {
            axios({
                method: 'GET',
                url: '/admin/historic',
                params: filters
            })
            .then(response => {
                document.querySelector('.responsive-table-wrapper').innerHTML = response.data;
                updateHeaderListeners();
                updatePaginationListeners();
            });
        }
    </script>
    @endpush
</x-admin-layout>
