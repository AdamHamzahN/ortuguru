@extends('template.template_admin')
@section('page_name', 'Dashboard')
@section('content')
    <div class="row">
        <h3>Dashboard</h3>
        <hr>
    </div>
    <div class="row justify-content-between gap-2">
        <div class="col h-100 border rounded round-2">
            <div class="row d-flex justify-content-between align-items-center"
                style="color: #ffffff; background-color: blue;">
                <span class="col d-flex justify-content-start align-items-start p-2">
                    <i class="bi bi-person-fill" style="font-size: 70px;"></i>
                </span>
                <span class="col d-flex flex-column align-items-end">
                    <h4 class="mb-0">{{ $total_siswa }}</h4>
                    <h3 class="mt-0">Siswa</h3>
                </span>
            </div>

            <div class="row d-flex justify-content-between mt-2 p-2 background-color:red;">
                <span class="col d-flex align-items-center">
                    <p class="mb-0">Lihat detail</p>
                </span>
                <span class="col d-flex align-items-center justify-content-end">
                    <a href="/admin/siswa/" class="text-decoration-none text-dark">
                        <i class="bi bi-arrow-right-circle-fill fs-4"></i>
                    </a>
                </span>
            </div>

        </div>
        <div class="col h-100 border rounded round-2">
            <div class="row d-flex justify-content-between align-items-center"
                style="color: #ffffff; background-color: blue;">
                <span class="col d-flex justify-content-start align-items-start p-2">
                    <i class="bi bi-mortarboard-fill" style="font-size: 70px;"></i>
                </span>
                <span class="col d-flex flex-column align-items-end">
                    <h4 class="mb-0">{{ $total_guru }}</h4>
                    <h3 class="mt-0">Guru</h3>
                </span>
            </div>

            <div class="row d-flex justify-content-between mt-2 p-2 background-color:red;">
                <span class="col d-flex align-items-center">
                    <p class="mb-0">Lihat detail</p>
                </span>
                <span class="col d-flex align-items-center justify-content-end">
                    <a href="/admin/guru/" class="text-decoration-none text-dark">
                        <i class="bi bi-arrow-right-circle-fill fs-4"></i>
                    </a>
                </span>
            </div>

        </div>
        <div class="col h-100 border rounded round-2">
            <div class="row d-flex justify-content-between align-items-center"
                style="color: #ffffff; background-color: blue;">
                <span class="col d-flex justify-content-start align-items-start p-2">
                    <i class="bi bi-easel" style="font-size: 70px;"></i>
                </span>
                <span class="col d-flex flex-column align-items-end">
                    <h4 class="mb-0">{{ $total_jurusan }}</h4>
                    <h3 class="mt-0">Jurusan</h3>
                </span>
            </div>

            <div class="row d-flex justify-content-between mt-2 p-2 background-color:red;">
                <span class="col d-flex align-items-center">
                    <p class="mb-0">Lihat detail</p>
                </span>
                <span class="col d-flex align-items-center justify-content-end">
                    <a href="/admin/jurusan/" class="text-decoration-none text-dark">
                        <i class="bi bi-arrow-right-circle-fill fs-4"></i>
                    </a>
                </span>
            </div>

        </div>
        <div class="col h-100 border rounded round-2">
            <div class="row d-flex justify-content-between align-items-center"
                style="color: #ffffff; background-color: blue;">
                <span class="col d-flex justify-content-start align-items-start p-2">
                    <i class="bi bi-building-fill" style="font-size: 70px;"></i>
                </span>
                <span class="col d-flex flex-column align-items-end">
                    <h4 class="mb-0">{{ $total_kelas }}</h4>
                    <h3 class="mt-0">Kelas</h3>
                </span>
            </div>

            <div class="row d-flex justify-content-between mt-2 p-2 background-color:red;">
                <span class="col d-flex align-items-center">
                    <p class="mb-0">Lihat detail</p>
                </span>
                <span class="col d-flex align-items-center justify-content-end">
                    <a href="/admin/siswa" class="text-decoration-none text-dark">
                        <i class="bi bi-arrow-right-circle-fill fs-4"></i>
                    </a>
                </span>
            </div>

        </div>
    </div>
    <div class="row mt-4">
        <table class="table table-hover table-bordered rounded-2 table-striped " style="overflow: hidden; ">
            <tr style="background-color: blue">
                <th style="background-color: blue" class="text-white fw-semibold">Nama Jurusan</th>
                <th style="background-color: blue" class=" text-white fw-semibold">Jumlah Kelas</th>
                <th style="background-color: blue" class=" text-white fw-semibold">Jumlah Siswa</th>
            </tr>
            @if ($detail_jurusan == null || $detail_jurusan == 'undifined')
                <tr>Tidak ada data</tr>
            @else
                @foreach ($detail_jurusan as $jurusan)
                    <tr>
                        <td>{{ $jurusan->nama_jurusan }}</td>
                        <td>{{ $jurusan->total_kelas }}</td>
                        <td>{{ $jurusan->total_siswa }}</td>
                    </tr>
                @endforeach
            @endif
            </tr>
        </table>
    </div>

@endsection
@section('footer')

@endsection
