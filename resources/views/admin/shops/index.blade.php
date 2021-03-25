<x-admin-layout>
    <div class="card">
        <div class="card-header flex justify-between">
            <div class="card-title">
                <h1>@lang('Shop list')</h1>
            </div>
            <div>
                <input type="text" class="textbox textbox-sm table-search" placeholder="@lang('Search...')">
            </div>
        </div>

        <div class="card-body">
            <div class="responsive-table-wrapper">
                @include('admin.shops.table')
            </div>
        </div>
    </div>
    <div class="card mt-8">
        <div class="card-header">
            <label class="card-title">@lang('New shop')</label>
        </div>

        <form method="POST" action="{{ route('admin.shops.store') }}">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6">
                <div class="input-group">
                    <label>@lang('Name')</label>
                    <input type="text"
                           id="shop_name"
                           name="name"
                           class="textbox @error('name') invalid @enderror"
                           value="{{ old('name') }}"
                    >
                    @error('name')
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

                <div class="flex items-center mt-2">
                    <label class="text-xs text-gray-600">* @lang('An email will be sent to the store')</label>
                </div>
            </div>

            <div class="my-4 w-full text-center">
                <button class="btn">@lang('Create shop')</button>
            </div>
        </form>
    </div>

    @push('js')
    <script>
        let filters = {
            search: '',
            order_by: 'username',
            order_asc: true,
            page: 1,
            per_page: 25
        };
        const columns = [
            {
                field: 'full_name',
                label: 'Nombre'
            },
            {
                field: 'username',
                label: 'Usuario'
            },
            {
                field: 'email',
                label: 'Email'
            },
            {
                field: 'phone',
                label: 'Teléfono'
            },
            {
                field: 'password',
                label: 'Contraseña'
            }
        ];
        const table = document.querySelector('#shops_table');
        const searchBox = document.querySelector('.table-search');
        refreshTable();
        searchBox.addEventListener('keyup', () => {
            const value = searchBox.value;
            if(value.length == 0 || value.length >= 3) {
                filters.search = value;
                refreshTable();
            }
        });

        function updateHeaderListeners() {
            document.querySelectorAll('table thead tr td').forEach((el) => {
                el.addEventListener('click', () => {
                    console.log('ordena')
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
                url: '/admin/shops',
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
