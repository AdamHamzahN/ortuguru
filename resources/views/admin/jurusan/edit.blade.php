<div class="row">
    <div class="col-lg-12">
        <input class="form-control" type="hidden" name="id" id="id" value={{ $jurusan->id }}>
        <div class="form-group mb-3">
            <label for="nama_jurusan">Nama Jurusan :</label>
            <input type="text" class="form-control" name="nama_jurusan" id="nama_jurusan"
                value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}">

        </div>
        <div class="form-group mb-3">
            <label for="kepala_program_id">Kepala Program :</label>
            <select class="form-control" id="kepala_program_id" name="kepala_program_id">
                <option value={{ $jurusan->kepala_program_id }}>{{ $jurusan->nama_kepala_program }}</option>
            </select>
        </div>
        @csrf
    </div>
</div>
