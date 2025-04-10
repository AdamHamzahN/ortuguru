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

    {{-- Modal tambah admin --}}
    <div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btnSimpan">Simpan</button>
                    <button class="btn btn-primary " data-bs-dismiss="modal">Batal</button>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('footer')
    <script type="module">
        const barangModal = document.querySelector('#modalForm');
        const modal = bootstrap.Modal.getOrCreateInstance(barangModal);
        let table = $('.DataTable').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            ajax: {
                url: "/super-admin/admin/data",
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
                className: 'btn btn-primary px-5 btnTambah',
                action: function(e, dt, node, config) {
                    changeHTML('#modalForm', '.modal-title', 'Tambah Data Admin');
                    let modalForm = document.getElementById('modalForm');

                    let bsModal = new bootstrap.Modal(modalForm);
                    bsModal.show();

                    modalForm.addEventListener('shown.bs.modal', function(eventTambah) {
                        const link = "{{ route('admin.tambah') }}";

                        axios.get(link).then(response => {
                            $("#modalForm .modal-body").html(response.data);
                        });

                        // Event listener untuk tombol Simpan
                        $('.btnSimpan').off('click').on('click', function(submitEvent) {
                            submitEvent.stopImmediatePropagation();

                            var data = {
                                'nama': $('#nama').val(),
                                'email': $('#email').val(),
                                '_token': "{{ csrf_token() }}"
                            };

                            if (data.nama !== '' && data.email !== '') {
                                // alert(data.nama)
                                axios.post('{{ url('/super-admin/admin/simpan') }}',
                                    data).then(resp => {
                                    if (resp.data.status == 'success') {
                                        Swal.fire({
                                            title: "Berhasil!",
                                            text: resp.data.pesan,
                                            icon: "success"
                                        }).then(() => {
                                            bsModal
                                                .hide(); // Tutup modal
                                            table.ajax.reload(); 
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Gagal!",
                                            text: resp.data.pesan,
                                            icon: "error"
                                        });
                                    }
                                });
                            } else {
                                alert('Data tidak boleh kosong!');
                            }
                        });
                    });
                }
            }]

        });

        function changeHTML(element, find, text) {
            $(element).find(find).html();
            return $(element).find(find).html(text).promise().done();
        }

        $(document).on('change', '.toggleSwitch', function() {
            let userId = $(this).data('id'); // Ambil ID user dari data-id
            let newStatus = $(this).is(':checked') ? 'aktif' : 'tidak aktif'; // Tentukan status baru
            let switchLabel = $(this).siblings('.switchStatus'); // Ambil elemen teks status

            let data = { 'id': userId, 'status': newStatus }; 
            console.log(data);


            // Kirim permintaan AJAX ke server
            axios.post(`/super-admin/admin/${userId}/update-status`, data).then(resp => {
                console.log(resp.data.status == 'success');
                if (resp.data.status == 'success') {
                    Swal.fire({
                        title: "Berhasil!",
                        text: resp.data.pesan,
                        icon: "success"
                    }).then(()=>{
                        table.ajax.reload();
                    });
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: resp.data.pesan,
                        icon: "error"
                    });
                }
            });
        });
    </script>
@endsection
