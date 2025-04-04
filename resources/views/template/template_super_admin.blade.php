@extends('template.head')

{{-- Menambah "resource" atau "file external"  --}}
@section('resource')
    resources/css/super-admin.css
@endsection

{{-- Menambahkan nama page di title  --}}
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
                <div class="justify-content-between d-flex align-items-center gap-2">
                    <div class="justify-content-between d-flex align-items-center gap-2 position-relative">
                        <p class="fw-semibold m-0"
                            style="font-size: 25px; font-family: 'Plus Jakarta Sans', sans-serif !important;">
                            {{ Auth::user()->nama ?? 'Super Admin' }}
                        </p>
                        <i class="bi bi-chevron-down fs-4" id="dropdownMenuButton" data-bs-toggle="dropdown"
                            aria-expanded="false" style="cursor: pointer;"></i>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger"
                                        id="logoutButton">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <main class="px-md-4" style="margin-top: 95px;">
                    <div class="bg-white p-4 rounded border shadow-sm">
                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </body>
    <footer>
        @yield('footer')
    </footer>
@endsection
