@extends('template.head')
@section('page-name')
    @yield('page_name', 'Default Page')
@endsection
@section('body')

    <body style="background-color: #F8F9FA">
        <!-- Navbar -->
        <nav class="navbar fixed-top px-3" style="background-color: #FA9420">
            <div class="container-fluid d-flex align-items-center justify-content-between p-1">
                <a href="/super-admin/dashboard"><img src="{{ asset('images/logo.png') }}" alt="logo" class="img-fluid" style="height: 60px;width:auto; filter: brightness(0);" ></a>
                <p class="fw-semibold m-0" style="font-size: 30px">Samuel Oscar Silaen</p>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar position-fixed vh-100 p-3"
                    style="
                    position: fixed;
                    top: 80px; 
                    left: 0;
                    height: calc(100vh - 80px); 
                    overflow-y: auto;
                    background-color:#002B55;
                    ">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Dashborad</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Settings</a>
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
        @yield('footer')
    </footer>
@endsection
