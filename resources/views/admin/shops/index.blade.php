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
                <table id="shops_table">
                    <thead>
                        <tr>
                            <td data-field="name">@lang('Name')</td>
                            <td data-field="username">@lang('Username')</td>
                            <td data-field="email">@lang('Email')</td>
                            <td data-field="phone">@lang('Phone')</td>
                            <td>@lang('Pending payments')</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shopUsers as $shopUser)
                        <tr>
                            <td>{{ $shopUser->full_name }}</td>
                            <td>{{ $shopUser->username }}</td>
                            <td>{{ $shopUser->email }}</td>
                            <td>{{ $shopUser->phone ?? '-' }}</td>
                            <td>{{ $shopUser->shop->due_amount }} €</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="shops_pagination"></div>
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

    @push('js')
    <script>
        let filters = {
            search: '',
            order_by: 'name',
            order_asc: true,
            page: 1
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
        const headerCells = table.querySelectorAll('thead tr td');
        const pagination = document.querySelector('#shops_pagination');
        // refreshTable();
        headerCells.forEach((el) => {
            el.addEventListener('click', () => {
                const orderBy = el.dataset.field;
                if(filters.order_by == orderBy) {
                    filters.order_asc = !filters.orderAsc;
                } else {
                    filters.order_by = orderBy;
                    filters.order_asc = true;
                }
                refreshTable();
            });
        });
        searchBox.addEventListener('keyup', () => {
            const value = searchBox.value;
            if(value.length == 0 || value.length >= 3) {
                filters.search = value;
                refreshTable();
            }
        });

        function refreshTable() {
            axios({
                method: 'GET',
                url: '/admin/shops',
                params: filters
            })
            .then(response => {
                const data = response.data;
                const shops = data.data;
                console.log(data)
                const tBody = table.querySelector('tbody');
                tBody.innerHTML = '';
                for(const row of shops) {
                    const tr = document.createElement('tr');
                    for(const column of columns) {
                        const td = document.createElement('td');
                        td.innerText = row[column.field];
                        tr.appendChild(td);
                    }
                    tBody.appendChild(tr);
                }
                pagination.innerHTML = '';
                for(const link of data.links) {
                    const a = document.createElement('a');
                    a.innerText = link.label;
                    a.classList.add('pagination-link');
                    a.addEventListener('click', (e) => {
                        e.preventDefault();
                        filters.page = link.label;
                        refreshTable();
                    });
                    pagination.appendChild(a);
                }
            });
        }
    </script>
    @endpush
</x-admin-layout>
