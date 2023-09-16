@extends('auth.layout')
@section('content')
    <div class="container register mt-2 mb-1 col-md-8">
        <div class="row justify-content-center">
            <div class="card col-md-12 px-4 pt-1 pb-2">
                <div class="pb-2">

                    <div class="card-header bg-white">
                        <div class="row d-flex flex-column m-0">
                            <div class="d-flex">
                                <img class=" text-right" src="{{ asset('custom_script/img/logo_it_helpdesk.png') }}"
                                    alt="" width="200px" height="auto">
                            </div>
                            <div class="d-flex">
                                <h6 class="register-heading">Form Registrasi Akun Pegawai</h6>
                            </div>
                        </div>
                    </div>
                    <form action="/registrasi/registrasi_akun" method="POST">
                        @csrf
                        <div class="row card-body">
                            <div class="col-md-7">
                                <span>Data Pegawai</span>
                                <hr>
                                <div class="row">
                                    <div class="form-group col-sm-5">
                                        <label for="nip">NIPP<span class="text-danger">*</span></label>
                                        <input onkeypress="return event.charCode >= 48 && event.charCode <=57"
                                            name="nip" id="nip" type="text" class="form-control"
                                            value="{{ old('nip') }}" maxlength="5" />
                                        @error('nip')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-sm-7">
                                        <label for="nama">Nama</label>
                                        <input name="nama" id="nama" type="text" class="form-control"
                                            value="{{ old('nama') }}"
                                            onkeypress="return event.charCode < 48 || event.charCode > 57" />
                                        @error('nama')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-sm-5">
                                        <label for="bagian">Unit/Bagian</label>
                                        <input name="bagian" id="bagian" type="text" class="form-control"
                                            value="{{ old('bagian') }}" />
                                        @error('bagian')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-sm-7">
                                        <label for="jabatan">Jabatan</label>
                                        <input name="jabatan" id="jabatan" type="text" class="form-control"
                                            value="{{ old('jabatan') }}" />
                                        @error('jabatan')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label" for="lokasi">Lokasi</label>
                                    <input list="stasiun_list" class="form-control" id="lokasi" name="lokasi"
                                        placeholder="Pilih lokasi" value="{{ old('lokasi') }}">
                                    <datalist id="stasiun_list">
                                        @foreach ($data_stasiun as $stasiun)
                                            <option value="{{ $stasiun->nama_stasiun }}"></option>
                                        @endforeach
                                    </datalist>
                                    @error('lokasi')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <span class=" text-danger small">*NIPP harus terdaftar sebagai pegawai PT KCI</span>
                            </div>

                            <div class="col-md-5">
                                <span>Data Akun</span>
                                <hr>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ old('email') }}" />
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input name="password" id="password" type="password" class="form-control" />
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="confirm_password">Konfirmasi Password</label>
                                    <input name="confirm_password" id="confirm_password" type="password"
                                        class="form-control" />
                                    @error('confirm_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white">
                            <input type="submit" class="btn btn-block btn-primary" value="Registrasi" />
                        </div>

                        <div class="text-center">
                            <span class="text-center">Sudah punya akun? <a href="/">Login</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
