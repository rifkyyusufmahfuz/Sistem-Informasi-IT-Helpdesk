@foreach ($data_stasiun as $data)
    <div class="modal fade" id="modal_update_stasiun{{ $data->id_stasiun }}" tabindex="-1" role="dialog"
        aria-labelledby="modal_update_stasiunLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_update_stasiunLabel">Update Data Stasiun</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/superadmin/crud/{{ $data->id_stasiun }}" method="POST" id="form-tambah-pegawai">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="jenis_input" name="jenis_input" value="data_stasiun">
                        <div class="form-group">
                            <label for="id_stasiun_update">ID Stasiun</label>
                            <input
                                onkeypress="return event.charCode >= 65 && event.charCode <= 90 || event.charCode >= 97 && event.charCode <= 122"
                                maxlength="3" type="text" class="form-control" id="id_stasiun_update" name="id_stasiun_update"
                                required value="{{ $data->id_stasiun }}" autofocus
                                onkeyup="this.value = this.value.toUpperCase();">
                            @error('id_stasiun_update')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_stasiun_update">Nama Stasiun</label>
                            <input required type="text" class="form-control" id="nama_stasiun_update" name="nama_stasiun_update"
                                value="{{ $data->nama_stasiun }}" onkeypress="return /^[a-zA-Z\s]*$/.test(event.key);">
                            @error('nama_stasiun_update')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer py-2">
                            <button type="reset" class="btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn-sm btn-primary" id="form-tambah-stasiun">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- Perulangan untuk cek error --}}
<?php $listError = ['id_stasiun_update', 'nama_stasiun_update']; ?>
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
