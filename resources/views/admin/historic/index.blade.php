<x-admin-layout>
    <div class="card">
        <div class="card-header">
            <label class="card-title">@lang('Used coupon list')</label>
        </div>

        <div class="card-body">
            <div class="responsive-table-wrapper">
                @include('admin.historic.table')
            </div>
        </div>
    </div>

    <button id="get">Dale</button>

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

