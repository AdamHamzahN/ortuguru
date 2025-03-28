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
            <div class="container-fluid d-flex align-items-center justify-content-between p-1">
                <a href="/super-admin/dashboard"><img src="{{ asset('images/logo.png') }}" alt="logo" class="img-fluid" style="height: 60px;width:auto; filter: brightness(0);" ></a>
                <p class="fw-semibold m-0" style="font-size: 30px" style="font-family: 'Plus Jakarta Sans', sans-serif !important;" >Samuel Oscar Silaen</p>
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
