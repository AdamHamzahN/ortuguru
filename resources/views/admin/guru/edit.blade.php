@extends('template.template_admin')
@section('page_name', 'Guru')
@section('content')
    <div class="d-flex justify-content-between align-items-center mt-3 mb-4">
        <a href="/admin/guru/daftar" class="btn btn-primary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h3 class="mb-0 fw-semibold">Tambah Guru</h3>
    </div>
    <hr>

    <form id="formGuru">
        @csrf
        <div class="row">
            <div class="col">
                <div class="form-group mb-3">
                    <label for="nip">NIP :</label>
                    <input class="form-control" type="text" name="nip" id="nip" required
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="18">
                </div>
                <div class="form-group mb-3">
                    <label for="nama">Nama :</label>
                    <input class="form-control" type="text" name="nama" id="nama" required>
                </div>
                <div class="form-group mb-3">
                    <label for="jenis_kelamin">Jenis Kelamin :</label>
                    <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="agama">Agama :</label>
                    <select class="form-control" name="agama" id="agama" required>
                        <option value="">-- Pilih --</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="tempat_lahir">Tempat Lahir :</label>
                    <input class="form-control" type="text" name="tempat_lahir" id="tempat_lahir" required>
                </div>
                <div class="form-group mb-3">
                    <label for="tanggal_lahir">Tanggal Lahir :</label>
                    <input class="form-control" type="date" name="tanggal_lahir" id="tanggal_lahir" required>
                </div>
            </div>
            <div class="col">
                <div class="form-group mb-3">
                    <label for="email">Email :</label>
                    <input class="form-control" type="email" name="email" id="email" required>
                </div>
                <div class="form-group mb-3">
                    <label for="nomor_telepon">Nomor Telepon :</label>
                    <div class="input-group">
                        <span class="input-group-text">+62</span>
                        <input class="form-control" type="text" name="nomor_telepon" id="nomor_telepon" required
                            oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="18">
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="alamat">Alamat :</label>
                    <textarea class="form-control" name="alamat" id="alamat" rows="4" required style="resize: none;"></textarea>
                </div>
                <!-- Pastikan Select2 CSS sudah di-link -->
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

                <div class="form-group mb-3">
                    <label for="mata_pelajaran">Mata Pelajaran :</label>
                    <select class="form-control" id="multiSelect" name="mata_pelajaran[]" multiple>
                        <option value="Matematika">Matematika</option>
                        <option value="Fisika">Fisika</option>
                        <option value="Kimia">Kimia</option>
                        <option value="Biologi">Biologi</option>
                        <option value="Bahasa Indonesia">Bahasa Indonesia</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="form-group mb-3 align-center">
                    <label for="foto">Foto (4x6) :</label>
                    <input class="form-control" type="file" name="foto" id="foto" accept="image/*"
                        onchange="previewImage()">
                </div>
                <div class="mb-3 text-center">
                    <img class="img-preview img-fluid mb-3" id="foto-preview"
                        style="display: none; width: 160px; height:240px; object-fit: cover; border:1px solid #ccc; border-radius:6px;">
                </div>

            </div>
        </div>
        <hr>
        <div class="row mt-4 justify-content-end">
            <button class="btn btn-primary btnSimpan" type="submit" style="width: 15%">Tambah</button>
        </div>
    </form>
@endsection

@section('footer')
    <script type="module">
        // --- Preview Image ---
        function previewImage(e) {
            const input = e.target;
            const preview = document.getElementById('foto-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.style.display = 'inline';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // --- DOM Ready ---
        $(document).ready(function() {
            // Preview Image
            $('#foto').on('change', previewImage);

            // Init Select2
            $('#multiSelect').select2({
                placeholder: "Pilih mata pelajaran",
                allowClear: true,
                multiple: true,
                closeOnSelect: false,
                width: '100%',
                height: '100%',
                ajax: {
                    url: '/admin/mata-pelajaran/list',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.results ?? []
                        };
                    },
                    cache: true
                }
            });

            // Submit form dengan Axios
            $('.btnSimpan').on('click', function(e) {
                e.preventDefault();

                const form = $('#formGuru')[0];
                const formData = new FormData(form);
                for (let [key, value] of formData.entries()) {
                    console.log(`${key}:`, value);
                };
                axios.post("{{ route('guru.simpan') }}", formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                }).then(response => {
                    if (response.data.status === 'success') {
                        Swal.fire({
                            title: "Berhasil!",
                            text: response.data.pesan,
                            icon: "success"
                        }).then(() => location.reload());
                    } else {
                        Swal.fire("Gagal", response.data.pesan || "Terjadi kesalahan", "error");
                    }
                }).catch(err => {
                    console.error(err);
                    Swal.fire("Error", "Terjadi kesalahan sistem", "error");
                });
            });
        });
    </script>
@endsection
