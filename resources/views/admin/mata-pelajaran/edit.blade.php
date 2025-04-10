<div class="row">
    <div class="col-lg-12">
        <input type="hidden" name="id" id="id" value={{$mata_pelajaran->id}}>
        <div class="form-group">
            <label for="nama_pelajaran">Mata Pelajaran :</label>
            <input class="form-control"type="text" name="nama_pelajaran" id="nama_pelajaran" value="{{$mata_pelajaran->nama_pelajaran}}">
        </div>
        @csrf
    </div>
</div>