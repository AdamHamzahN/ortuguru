@extends('template.template_admin')
@section('page_name', 'Guru')
@section('content')
    <div class="row">
        <span class="col">
            <h3>Daftar Guru SMKN 1 Kota Bekasi</h3>
        </span>
    </div>
    <div class="row">
        <table class="table DataTable table-hover table-bordered rounded-2 table-striped text-white"
            style="overflow: hidden; ">
            <thead>
                <tr class="text-white">
                    <th style="background-color: blue" class=" text-white fw-semibold">Nama</th>
                    <th style="background-color: blue" class=" text-white fw-semibold">NIP</th>
                    <th style="background-color: blue" class=" text-white fw-semibold">Status</th>
                    <th style="background-color: blue" class=" text-white fw-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection

@section('footer')
    <script type="module">
        let table = $('.DataTable').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            ajax: {
                url: "/admin/guru/data",
                type: "GET",
                dataType: "json",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                dataSrc: function(json) {
                    console.log("DataTables menerima data:", json);
                    return json.data;
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", xhr.status, xhr.responseText);
                }
            },
            columns: [{
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'nip',
                    name: 'nip',
                    className: 'text-start'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        console.log(row);
                        let checked = data === 'aktif' ? 'checked' : '';
                        return `
                            <label class="form-check form-switch">
                                <input class="form-check-input toggleSwitch" type="checkbox" data-id="${row.id}" ${checked}>
                                ${data}
                            </label>
                        `;
                    }
                },
                {
                    render: function(data, type, row) {
                        return `
                            <div class="d-flex gap-2">
                                <a href="/admin/guru/edit/${row.id}">  
                                    <button class="btn btn-sm btn-primary btn-edit" data-id="${row.id}" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </a>
                                 <a href="/admin/guru/detail/${row.id}">  
                                    <button class="btn btn-sm btn-primary btn-edit" data-id="${row.id}" title="Detail">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </a>
                            </div>
                        `;
                    }

                },
            ],
            layout: {
                topStart: 'search',
                topEnd: 'buttons'
            },
            buttons: [{
                text: '<i class="bi bi-list"></i>',
                className: 'btn btn-primary px-2 btnOptions',
                attr: {
                    'data-bs-toggle': 'dropdown',
                    'aria-expanded': 'false'
                }
            }],
            initComplete: function() {
                $('.btnOptions').after(`
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/admin/export/akun-guru" id="editButton">Ekspor Akun Ke Excel</a></li>
                        <li><a class="dropdown-item" href="/admin/export/data-guru" id="deleteButton">Ekspor Data Guru Ke Excel</a></li>
                    </ul>
                `);
            }


        });
    </script>
@endsection
