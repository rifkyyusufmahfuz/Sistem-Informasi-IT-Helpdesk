@extends('auth.layout')
@section('content')
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card o-hidden border-0 shadow-lg my-5">

                        <div class="card">
                            <div class="card-header">Reset Password</div>
                            <div class="card-body">
                                <form action="/halaman_reset_password" method="POST">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group row">
                                        <label for="email_address"
                                            class="col-md-4 col-form-label text-md-right">E-mail</label>
                                        <div class="col-md-6">
                                            <input type="text" id="email_address" class="form-control" name="email"
                                                required value="{{ old('email') }}">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                        <div class="col-md-6">
                                            <input type="password" id="password" class="form-control" name="password"
                                                required>
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password-confirm"
                                            class="col-md-4 col-form-label text-md-right">Konfirmasi Password</label>
                                        <div class="col-md-6">
                                            <input type="password" id="password-confirm" class="form-control"
                                                name="password_confirmation" required>
                                            @if ($errors->has('password_confirmation'))
                                                <span
                                                    class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Reset Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
