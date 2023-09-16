<div class="modal fade" id="modalTambahPegawai" tabindex="-1" role="dialog" aria-labelledby="modalTambahPegawaiLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPegawaiLabel">Tambah Data Pegawai</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/superadmin/crud" method="POST" id="form-tambah-pegawai">
                    @csrf
                    <input type="hidden" id="jenis_input" name="jenis_input" value="data_pegawai">
                    <div class="form-group">
                        <label for="nip_pegawai">NIP</label>
                        <input maxlength="5" type="text" class="form-control" id="nip_pegawai" name="nip_pegawai"
                            required value="{{ old('nip_pegawai') }}">
                        @error('nip_pegawai')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nama_pegawai">Nama Pegawai</label>
                        <input required type="text" class="form-control" id="nama_pegawai" name="nama_pegawai"
                            value="{{ old('nama_pegawai') }}">
                        @error('nama_pegawai')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bagian_pegawai">Unit/Bagian</label>
                        <input required type="text" class="form-control" id="bagian_pegawai" name="bagian_pegawai"
                            value="{{ old('bagian_pegawai') }}">
                        @error('bagian_pegawai')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="jabatan_pegawai">Jabatan</label>
                        <input required type="text" class="form-control" id="jabatan_pegawai" name="jabatan_pegawai"
                            value="{{ old('jabatan_pegawai') }}">
                        @error('jabatan_pegawai')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="lokasi_pegawai">Lokasi</label>
                        <input required placeholder="-Pilih Lokasi-" list="stasiun_list" class="form-control"
                            id="lokasi_pegawai" name="lokasi_pegawai" value="{{ old('lokasi_pegawai') }}">
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


{{-- Perulangan untuk cek error --}}
<?php $listError = ['nip_pegawai', 'nama_pegawai', 'bagian_pegawai', 'jabatan_pegawai', 'lokasi_pegawai']; ?>
@php
    $showModal = false;
@endphp

@foreach ($listError as $err)
    @error($err)
        @php
            $showModal = true;
            // Hentikan perulangan ketika ada error ditemukan
            break;
        @endphp
    @enderror
@endforeach

@if ($showModal)
    <script type="text/javascript">
        $(document).ready(function() {
            // Tampilkan modal secara otomatis ketika ada error
            $("#modalTambahPegawai").modal('show');
        });
    </script>
@endif
