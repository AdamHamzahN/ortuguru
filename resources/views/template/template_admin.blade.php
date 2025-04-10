@extends('template.head')

{{-- Menambah "resource" atau "file external" --}}
@section('resource')
    resources/css/admin.css
@endsection

{{-- Menambahkan nama page di title --}}
@section('page-name')
    @yield('page_name', 'Default Page')
@endsection

{{-- Menambahkan body --}}
@section('body')

    <body style="background-color: #F8F9FA">
        <!-- Navbar -->
        <nav class="navbar fixed-top px-3" style="background-color: #FA9420">
            <div class="container-fluid d-flex align-items-center justify-content-between px-2">
                <span><img src="{{ asset('images/logo.png') }}" alt="logo" class="img-fluid"
                        style="height: 60px;width:auto; filter: brightness(0);"></span>
                <div class="d-flex align-items-center gap-2">
                    <div class="d-flex align-items-center gap-2 position-relative">
                        <p class="fw-semibold m-0"
                            style="font-size: 25px; font-family: 'Plus Jakarta Sans', sans-serif !important;">
                            {{ Auth::user()->nama ?? 'Super Admin' }}
                        </p>
                        <i class="bi bi-chevron-down fs-4" id="dropdownMenuButton" data-bs-toggle="dropdown"
                            aria-expanded="false" style="cursor: pointer;"></i>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <button class="btn">Ubah Password</button>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                {{-- Sidebar --}}
                <nav id="sidebar" class="col-md-2 col-lg-2 d-md-block sidebar position-fixed vh-100"
                    style="
                        position: fixed;
                        top: 70px; 
                        left: 0;
                        height: calc(100vh - 10px); 
                        overflow-y: auto;
                        background-color:#002B55;
                        padding: 10px;
                    ">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white-50 {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                                href="/admin/dashboard">
                                Dashboard
                            </a>
                        </li>

                        {{-- Dropdown Guru --}}
                        <li class="nav-item">
                            <a class="nav-link text-white-50 {{ request()->is('admin/guru*') ? 'active' : '' }}"
                                href="/admin/guru/" onclick="handleMenuClick(event, '/admin/guru/', 'guruMenu')">
                                Guru
                            </a>
                            <div class="collapse {{ request()->is('admin/guru*') ? 'show' : '' }}" id="guruMenu">
                                {{-- <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link text-white-50 {{ request()->is('admin/guru/daftar') ? 'active-submenu' : '' }}"
                                            href="/admin/guru/daftar">Daftar Guru</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white-50 {{ request()->is('admin/guru/tambah') ? 'active-submenu' : '' }}"
                                            href="/admin/guru/tambah">Tambah Guru</a>
                                    </li>
                                </ul> --}}
                            </div>
                        </li>

                        {{-- Dropdown Siswa --}}
                        <li class="nav-item">
                            <a class="nav-link text-white-50 {{ request()->is('admin/siswa*') ? 'active' : '' }}"
                                href="/admin/kelas/" onclick="handleMenuClick(event, '/admin/kelas/', 'siswaMenu')">
                                Siswa
                            </a>
                            <div class="collapse {{ request()->is('admin/siswa*') ? 'show' : '' }}" id="siswaMenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link text-white-50 {{ request()->is('admin/siswa') ? 'active-submenu' : '' }}"
                                            href="/admin/kelas/">Daftar Kelas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white-50 {{ request()->is('admin/siswa/tambah') ? 'active-submenu' : '' }}"
                                            href="/admin/kelas/tambah-siswa">Tambah Siswa</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white-50 {{ request()->is('admin/siswa/tambah') ? 'active-submenu' : '' }}"
                                            href="/admin/kelas/tambah-kelas">Tambah Kelas</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        {{-- Dropdown Jurusan --}}
                        <li class="nav-item">
                            <a class="nav-link text-white-50 {{ request()->is('admin/jurusan*') ? 'active' : '' }}"
                                href="/admin/jurusan/">
                                Jurusan
                            </a>
                            {{-- <div class="collapse {{ request()->is('admin/jurusan*') ? 'show' : '' }}" id="jurusanMenu">
                                <ul class="nav flex-column ms-3">
                                    <li class="nav-item">
                                        <a class="nav-link text-white-50 {{ request()->is('admin/jurusan') ? 'active-submenu' : '' }}"
                                            href="/admin/jurusan/">Daftar Jurusan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link text-white-50 {{ request()->is('admin/jurusan/tambah') ? 'active-submenu' : '' }}"
                                            href="/admin/jurusan/tambah">Tambah Jurusan</a>
                                    </li>
                                </ul>
                            </div> --}}
                        </li>

                        {{-- Mata Pelajaran --}}
                        <li class="nav-item">
                            <a class="nav-link text-white-50 {{ request()->is('admin/mata-pelajaran*') ? 'active' : '' }}"
                                href="/admin/mata-pelajaran/">
                                Mata    Pelajaran
                            </a>
                        </li>
                    </ul>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4" style="margin-top: 95px;">
                    <div class="bg-white p-4 rounded border shadow-sm">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </body>

    <footer>
        <script>
            function handleMenuClick(event, url, menuId) {
                var menu = document.getElementById(menuId);
                if (!menu.classList.contains('show')) {
                    event.preventDefault(); // Mencegah collapse langsung terbuka
                    window.location.href = url; // Redirect ke halaman utama submenu
                }
            }
        </script>
        @yield('footer')
    </footer>
@endsection
