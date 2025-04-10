{{-- @dd($guru, $mataPelajaran,$waliKelas) --}}
@extends('template.template_admin')

@section('page_name', 'Guru')

@section('content')
    <div class="mb-4">
        <a href="/admin/guru/daftar" class="btn btn-primary mb-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h2 class="fw-semibold">{{ $guru->nama }}</h2>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="{{ asset('storage/' . $guru->foto) }}" class="card-img-top rounded" alt="Foto Guru">
            </div>
            <div class="card shadow-sm p-3 mt-3">
                <p class="fs-5">
                    <strong>Status:</strong>
                    @if (strtolower($guru->status) === 'aktif')
                        <span class="badge bg-primary fs-6">{{ $guru->status }}</span>
                    @else
                        <span class="badge bg-danger fs-6">{{ $guru->status }}</span>
                    @endif
                </p>
                <p class="fs-5">
                    <strong>Wali Kelas:</strong>
                    @if ($waliKelas)
                        <span class="badge bg-primary fs-6">{{ $waliKelas->nama_kelas }}</span>
                    @else
                        <span class="badge bg-danger fs-6">Tidak sedang menjadi wali kelas saat ini</span>
                    @endif
                </p>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <h4 class="mb-4 fw-bold">Informasi Guru</h4>
                <ul class="list-unstyled fs-5" style="line-height: 1.8;">
                    <li class="mb-2"><strong>Nama:</strong> {{ $guru->nama }}</li>
                    <li class="mb-2"><strong>NIP:</strong> {{ $guru->nip }}</li>
                    <li class="mb-2"><strong>Tempat, Tanggal Lahir:</strong> {{ $guru->tempat_lahir }}, {{ $guru->tanggal_lahir }}</li>
                    <li class="mb-2"><strong>Jenis Kelamin:</strong> {{ $guru->jenis_kelamin }}</li>
                    <li class="mb-2"><strong>Agama:</strong> {{ $guru->agama }}</li>
                    <li class="mb-2"><strong>No. HP:</strong> {{ $guru->nomor_telepon }}</li>
                    <li class="mb-2"><strong>Email:</strong> {{ $guru->email }}</li>
                    <li class="mb-2"><strong>Alamat:</strong> {{ $guru->alamat }}</li>
                </ul>
                

                <h4 class="mt-2 mb-3 fw-bold">Mata Pelajaran Diajarkan</h4>
                <ul class="list-group fs-6">
                    @forelse ($mataPelajaran as $mapel)
                        <li class="list-group-item py-3">{{ $mapel->nama_pelajaran }}</li>
                    @empty
                        <li class="list-group-item text-muted py-3">Belum ada mata pelajaran</li>
                    @endforelse
                </ul>
            </div>

        </div>
    </div>
@endsection
