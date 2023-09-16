@foreach ($data_barang as $data)
    <div class="modal fade" id="modal_update_barang{{ $data->kode_barang }}" tabindex="-1" role="dialog"
        aria-labelledby="modal_update_barangLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_update_barangLabel">Update Data Barang</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/superadmin/crud/{{ $data->kode_barang }}" method="POST" id="form-tambah-barang">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="jenis_input" name="jenis_input" value="data_barang">

                        <h5>Update spesifikasi PC / Laptop</h5>
                        <div class="form-group">
                            <label for="kode_barang_update">No. Aset / Inventaris / Serial Number</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="kode_barang_update" name="kode_barang_update"
                                value="{{ $data->kode_barang }}">
                            @error('kode_barang_update')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Laptop/PC, merk, dan tipe" value="{{ $data->nama_barang }}">
                            @error('nama_barang')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="prosesor">Prosesor</label>
                            <input type="text" class="form-control" id="prosesor" name="prosesor"
                                placeholder="Intel... / AMD..." value="{{ $data->prosesor }}">
                            @error('prosesor')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="ram">RAM</label>
                                <input type="text" class="form-control" id="ram" name="ram"
                                    placeholder="...GB" value="{{ $data->ram }}">
                                @error('ram')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="penyimpanan">Penyimpanan</label>
                                <input type="text" class="form-control" id="penyimpanan" name="penyimpanan"
                                    placeholder="...GB" value="{{ $data->penyimpanan }}">
                                @error('penyimpanan')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status_barang">Status Barang</label>
                            <select class="form-control" name="status_barang">
                                <option value="belum diterima" @if ($data->status_barang == 'belum diterima') selected @endif>
                                    Belum
                                    Diterima</option>
                                <option value="diterima" @if ($data->status_barang == 'diterima') selected @endif>Diterima
                                </option>
                                <option value="siap diambil" @if ($data->status_barang == 'siap diambil') selected @endif>Siap
                                    Diambil</option>
                                <option value="dikembalikan" @if ($data->status_barang == 'dikembalikan') selected @endif>
                                    Dikembalikan</option>
                            </select>
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
<?php $listError = ['kode_barang_update', 'nama_barang', 'prosesor', 'ram', 'penyimpanan']; ?>
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
