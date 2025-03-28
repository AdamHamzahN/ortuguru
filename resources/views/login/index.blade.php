@extends('template.head')
@section('page-name', 'Login')
@section('app')

    <body class="bg-primary d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-sm-8 col-10">
                    <div class="card fw-semibold px-4 py-5 px-lg-9 py-lg-44"
                        style="background-color: rgba(255, 255, 255, 0.5);">
                        <div class="card-body">
                            <div class="logo mb-3 text-center">
                                <img src="{{ asset('images/logo.png') }}" alt="logo" class="img-fluid"
                                    style="max-width: 180px;">
                            </div>
                            <form action="/login/check" method="post">
                                @csrf
                                <div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-warning w-100 fw-semibold mt-4"
                                    style="background-color: #FA9420;">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    @if (session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Gagal!',
                        text: @json(session('error')),
                    });
                }, 500);
            });
        </script>
    @endif

@endsection
