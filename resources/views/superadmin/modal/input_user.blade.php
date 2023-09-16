<div class="modal fade" id="modalTambahUser" tabindex="-1" role="dialog" aria-labelledby="modalTambahUserLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title" id="modalTambahUserLabel">Tambah User</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body py-2">
                <div class="row">
                    <div class="col-md-6">

                        <form action="/superadmin/crud" method="POST" id="form-tambah-user">
                            @csrf
                            {{-- <input type="hidden" value="data_user" name="jenis_input" id="jenis_input"> --}}
                            <h6 class="text-center">Data user</h6>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control form-control-sm" id="email" name="email"
                                    required value="{{ old('email') }}" onkeypress="return event.charCode != 32">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control form-control-sm" id="password"
                                    name="password" required>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="confirm_password">Konfirmasi Password</label>
                                <input type="password" class="form-control form-control-sm" id="confirm_password"
                                    name="confirm_password" required>
                                @error('confirm_password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control form-control-sm" id="role" name="role" required>
                                    <option value="" disabled selected>-Pilih Role-</option>
                                    @foreach ($data_role as $role)
                                        <option value="{{ $role->id_role }}"
                                            {{ old('role') == $role->id_role ? 'selected' : '' }}>
                                            {{ ucwords($role->nama_role) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <p class="text-danger small">
                                *Masuk ke menu data pegawai untuk mengubah data pegawai
                            </p>
                            <p class="text-danger small">
                                *Pegawai harus sudah terdaftar dan belum memiliki akun user
                            </p>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-center">Data pegawai</h6>
                        <div class="form-group">
                            <label for="nip_pegawai">NIP</label>
                            <select class="form-control form-control-sm" id="nip_pegawai" name="nip_pegawai" required>
                                @if (count($nip_pegawai) == 0)
                                    <option value="" disabled selected>-Semua pegawai telah memiliki akun user-</option>
                                @else
                                    <option value="" disabled selected>-Pilih NIP Pegawai-</option>
                                    @foreach ($nip_pegawai as $nip)
                                        <option value="{{ $nip }}"
                                            {{ old('nip_pegawai') == $nip ? 'selected' : '' }}>
                                            {{ $nip }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('nip_pegawai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label for="nama_pegawai">Nama Pegawai</label>
                            <input type="text" class="form-control form-control-sm" id="nama_pegawai"
                                name="nama_pegawai" readonly value="{{ old('nama_pegawai') }}">
                            @error('nama_pegawai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bagian_pegawai">Bagian</label>
                            <input type="text" class="form-control form-control-sm" id="bagian_pegawai"
                                name="bagian_pegawai" readonly value="{{ old('bagian_pegawai') }}">
                            @error('bagian_pegawai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jabatan_pegawai">Jabatan</label>
                            <input type="text" class="form-control form-control-sm" id="jabatan_pegawai"
                                name="jabatan_pegawai" readonly value="{{ old('jabatan_pegawai') }}">
                            @error('jabatan_pegawai')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="lokasi_pegawai">Lokasi</label>
                            <input type="text" class="form-control form-control-sm" id="lokasi_pegawai"
                                name="lokasi_pegawai" readonly value="{{ old('lokasi_pegawai') }}">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="reset" class="btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-sm btn-primary" id="form-tambah-user">Simpan</button>
            </div>
            </form>

        </div>
    </div>
</div>

{{-- Perulangan untuk cek error --}}
<?php $listError = ['email', 'password', 'confirm_password', 'role', 'nip_pegawai', 'nama_pegawai', 'bagian_pegawai', 'jabatan_pegawai', 'lokasi_pegawai']; ?>
@foreach ($listError as $err)
    @error($err)
        <script type="text/javascript">
            window.onload = function() {
                OpenBootstrapPopup();
            };

            function OpenBootstrapPopup() {
                $("#modalTambahUser").modal('show');
            }
        </script>
    @break
@enderror
@endforeach
