@extends('auth.layout')
@section('content')
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-12">
                                <div class="p-5">
                                    <div class="text-center mb-4">
                                        <img src="{{ asset('custom_script/img/logo_it_helpdesk.png') }}" width="250px">
                                        <p style="letter-spacing: 1px" class="text-muted mt-4 font-italic">Sistem Informasi
                                            Layanan IT Helpdesk</p>
                                    </div>
                                    <form action="/" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                class="form-control @error('email') is-invalid @enderror"
                                                placeholder="Email">
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" value="{{ old('password') }}"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                        <div class="text-center my-2">
                                            <span class="small">Belum punya akun?</span>
                                        </div>
                                        <div>
                                            <a href="/registrasi" class="btn btn-success btn-user btn-block">
                                                Registrasi
                                            </a>
                                        </div>
                                        <div class="text-center mt-2">
                                            <span class="small">Lupa password? </span>
                                            <a class="small" href="/reset_password">Reset</a>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
