@extends('template.template_super_admin')
@section('page_name', 'Dashboard')
@section('content')
    <div>
        <div class="row">
            <h3>Dashboard</h3>
        </div>
        <div class="row">
            <table class="table DataTable table-hover table-bordered rounded-2 table-striped text-white"
                style="overflow: hidden; ">
                <thead>
                    <tr class="text-white">
                        <th style="background-color: blue" class=" text-white fw-semibold">Nama</th>
                        <th style="background-color: blue" class=" text-white fw-semibold">Email</th>
                        <th style="background-color: blue" class=" text-white fw-semibold">Status</th>
                        <th style="background-color: blue" class=" text-white fw-semibold">Waktu Dibuat</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    <script type="module">
        $('.DataTable').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            info: false,
            ajax: {
                url: "http://127.0.0.1:8000/super-admin/admin/data",
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
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
            ],
            layout: {
                topStart: 'search',
                topEnd: 'buttons'
            },
            buttons: [{
                text: 'Tambah',
                className: 'btn btn-primary px-5',
                action: function(e, dt, node, config) {
                    alert('Tombol Tambah Data diklik!');
                }
            }],
            
        });

    </script>
@endsection
