@foreach ($data_pegawai as $pegawai)
    <div class="modal fade" id="modal_update_pegawai{{ $pegawai->nip }}" tabindex="-1" role="dialog"
        aria-labelledby="modal_update_pegawaiLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_update_pegawaiLabel">Update Data Pegawai</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/superadmin/crud/{{ $pegawai->nip }}" method="POST" id="form-tambah-pegawai">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nip_pegawai_update">NIP</label>
                            <input maxlength="5" type="text" class="form-control" id="nip_pegawai_update"
                                name="nip_pegawai_update" required value="{{ $pegawai->nip }}">
                            @error('nip_pegawai_update')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_pegawai_update">Nama Pegawai</label>
                            <input required type="text" class="form-control" id="nama_pegawai_update"
                                name="nama_pegawai_update" value="{{ $pegawai->nama }}">
                            @error('nama_pegawai_update')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bagian_pegawai_update">Unit/Bagian</label>
                            <input required type="text" class="form-control" id="bagian_pegawai_update"
                                name="bagian_pegawai_update" value="{{ $pegawai->bagian }}">
                            @error('bagian_pegawai_update')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="jabatan_pegawai_update">Jabatan</label>
                            <input required type="text" class="form-control" id="jabatan_pegawai_update"
                                name="jabatan_pegawai_update" value="{{ $pegawai->jabatan }}">
                            @error('jabatan_pegawai_update')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- lokasi --}}


                        {{-- OPSI LOKASI DENGAN DATALIST --}}
                        <div class="form-group">
                            <label for="lokasi_pegawai">Lokasi</label>
                            <input list="stasiun_list" class="form-control" placeholder="-Pilih Lokasi-" required
                                id="lokasi_pegawai_update" name="lokasi_pegawai_update"
                                value="{{ $pegawai->nama_stasiun }}">
                            <datalist id="stasiun_list">
                                @foreach ($data_stasiun as $stasiun)
                                    <option value="{{ $stasiun->nama_stasiun }}">
                                    </option>
                                @endforeach
                            </datalist>
                        </div>

                        <div class="modal-footer py-2">
                            <button type="reset" class="btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn-sm btn-primary" id="form-tambah-pegawai">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Perulangan untuk cek error --}}
<?php $listError = ['nip_pegawai_update', 'nama_pegawai_update', 'bagian_pegawai_update', 'jabatan_pegawai_update', 'lokasi_pegawai_update']; ?>
@foreach ($listError as $err)
    @error($err)
        <script type="text/javascript">
            Swal.fire({
                toast: true,
                icon: 'error',
                title: 'Update Gagal!',
                text: '{{ $message }}',

                animation: true,
                position: 'top-right',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 6000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
    @break
@enderror
@endforeach
