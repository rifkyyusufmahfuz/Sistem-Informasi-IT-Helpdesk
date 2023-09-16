@extends('auth.layout')
@section('content')
    <main class="login-form">
        <div class="container">
            <div class="row justify-content-center">
                <div class="card o-hidden border-0 shadow-lg my-5">

                    <div class="card">
                        <div class="card-header">Reset Password</div>
                        <div class="card-body">
                            {{-- @if (Session::has('message'))
                                <div class="alert alert-success" role="alert">
                                    {{ Session::get('message') }}
                                </div>
                            @endif --}}
                            <form action="/reset_password/kirim_email_reset" method="POST">
                                @csrf
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label for="email_address" class="col-form-label">Masukkan email Anda
                                            untuk membantu kami mengidentifikasi.<span class="text-danger">*</span></label>
                                        <input type="email" id="email_address" class="form-control" name="email"
                                            required autofocus placeholder="name@example.com">

                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-user btn-block">Reset</button>
                                </div>
                                <div class="col-md-12 my-3">
                                    <label class="form-label"> Sudah memiliki akun ?</label>
                                    <a href="/" class="link">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
