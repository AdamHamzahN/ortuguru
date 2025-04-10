@extends('template.template_admin')
@section('page_name', 'Guru')
@section('content')
    <div class="row">
        <span class="col">
            <h3>Daftar Mata Pelajaran</h3>
        </span>
    </div>
    <div class="row">
        <table class="table DataTable table-hover table-bordered rounded-2 table-striped text-white"
            style="overflow: hidden; ">
            <thead>
                <tr class="text-white">
                    <th style="background-color: blue" class=" text-white fw-semibold">Mata Pelajaran</th>
                    <th style="background-color: blue" class=" text-white fw-semibold">Jumlah Guru</th>
                    <th style="background-color: blue" class=" text-white fw-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    {{-- Modal --}}
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
        let table = $('.DataTable').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            ajax: {
                url: "/admin/mata-pelajaran/data",
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
                    data: 'mata_pelajaran',
                    name: 'mata_pelajaran'
                },
                {
                    data: 'jumlah_guru',
                    name: 'jumlah_guru',
                    className: 'text-start'
                },
                {
                    render: function(data, type, row) {
                        return `
                                <div class="d-flex gap-2">
                                    <button 
                                        class="btn btn-sm btn-primary editBtn" 
                                        data-id="${row.id}" 
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </div>
                            `;
                    },
                    orderable: false,
                    searchable: false
                }

            ],
            layout: {
                topStart: 'search',
                topEnd: 'buttons'
            },
            buttons: [{
                text: 'Tambah',
                className: 'btn btn-primary px-5 btnTambah',
                action: function(e, dt, node, config) {
                    changeHTML('#modalForm', '.modal-title', 'Tambah Mata Pelajaran');
                    let modalForm = document.getElementById('modalForm');

                    let bsModal = new bootstrap.Modal(modalForm);
                    bsModal.show();

                    modalForm.addEventListener('shown.bs.modal', function(eventTambah) {
                        const link = "{{ route('mata-pelajaran.tambah') }}";

                        axios.get(link).then(response => {
                            $("#modalForm .modal-body").html(response.data);
                        });

                        // Event listener untuk tombol Simpan
                        $('.btnSimpan').off('click').on('click', function(submitEvent) {
                            submitEvent.stopImmediatePropagation();

                            var data = {
                                'nama_pelajaran': $('#nama_pelajaran').val(),
                                '_token': "{{ csrf_token() }}"
                            };

                            if (data.nama_pelajaran !== '') {
                                // alert(data.nama)
                                axios.post('{{ url('/admin/mata-pelajaran/simpan') }}',
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

        $('.DataTable tbody').on('click', '.editBtn', function() {
            const id = $(this).data('id');

            changeHTML('#modalForm', '.modal-title', 'Edit Mata Pelajaran');
            let modalForm = document.getElementById('modalForm');
            let bsModal = new bootstrap.Modal(modalForm);
            bsModal.show();

            modalForm.addEventListener('shown.bs.modal', function(eventEdit) {
                const link = `/admin/mata-pelajaran/edit/${id}`;
                axios.get(link).then(response => {
                    $("#modalForm .modal-body").html(response.data);
                });

                // Event Simpan
                $('.btnSimpan').off('click').on('click', function(submitEvent) {
                    submitEvent.stopImmediatePropagation();

                    const data = {
                        'nama_pelajaran': $('#nama_pelajaran').val(),
                        '_token': "{{ csrf_token() }}"
                    };

                    if (data.nama_pelajaran !== '') {
                        axios.post(`/admin/mata-pelajaran/update/${id}`, data)
                            .then(resp => {
                                if (resp.data.status === 'success') {
                                    Swal.fire({
                                        title: "Berhasil!",
                                        text: resp.data.pesan,
                                        icon: "success"
                                    }).then(() => {
                                        bsModal.hide();
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
            }, {
                once: true
            });
        });

        function changeHTML(element, find, text) {
            $(element).find(find).html();
            return $(element).find(find).html(text).promise().done();
        }
    </script>
@endsection
