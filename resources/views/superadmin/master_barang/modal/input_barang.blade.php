<div class="modal fade" id="modalTambahBarang" tabindex="-1" role="dialog" aria-labelledby="modalTambahBarangLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahBarangLabel">Tambah Data Barang</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/superadmin/crud" method="POST" id="form-tambah-stasiun">
                    @csrf
                    <input hidden id="jenis_input" name="jenis_input" value="data_barang">
                    <input hidden class="form-control" id="kode_barang_table" name="kode_barang_table">
                    <input hidden class="form-control" id="input_status_barang" name="input_status_barang">

                    <div id="detail_barang">
                        <h5>Spesifikasi barang</h5>
                        <div class="form-group">
                            <label for="kode_barang">No. Aset / Inventaris / Serial Number</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang">
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <span class="text-danger">*</span>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Laptop/PC, atau hardware lainnya...">
                        </div>
                        <div class="form-group">
                            <label for="prosesor">Prosesor</label>
                            <input type="text" class="form-control" id="prosesor" name="prosesor"
                                placeholder="Intel... / AMD...">
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="ram">RAM</label>
                                <input type="text" class="form-control" id="ram" name="ram"
                                    placeholder="...GB">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="penyimpanan">Penyimpanan</label>
                                <input type="text" class="form-control" id="penyimpanan" name="penyimpanan"
                                    placeholder="...GB">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status_barang">Status Barang</label>
                            <select class="form-control" id="status_barang" name="status_barang">
                                <option value="belum diterima" selected>Belum Diterima</option>
                                <option value="diterima">Diterima</option>
                                <option value="siap diambil">Siap Diambil</option>
                                <option value="dikembalikan">Dikembalikan</option>
                            </select>
                        </div>

                    </div>

                    <div hidden id="peringatan_barang" class="alert alert-warning fade show small" role="alert">
                        <i class="fas fa-exclamation-triangle"> </i> Barang tersebut sudah ada. Lakukan update apabila
                        ingin mengubah.
                    </div>

                    <div class="modal-footer py-2">
                        <button type="reset" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary" id="btn-simpan">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        // disable tombol lanjut pada awalnya
        $('#btn-simpan').prop('disabled', true);

        var timeoutId;

        $('#detail_barang input').on('input', function() {
            clearTimeout(timeoutId);

            timeoutId = setTimeout(function() {
                // cek apakah semua input diisi
                var isFilled = true;
                var status_barang = $('#input_status_barang').val();

                $('#detail_barang input').each(function() {
                    if ($('#kode_barang').val() === '' || $('#nama_barang').val() ===
                        '' || (status_barang !== 'dikembalikan' &&
                            status_barang !== '')) {
                        isFilled = false;
                        return false; // keluar dari loop
                    }
                });

                // aktifkan tombol lanjut jika semua input diisi
                if (isFilled) {
                    $('#btn-simpan').prop('disabled', false);

                } else {
                    $('#btn-simpan').prop('disabled', true);
                }

                var tidak_ada_barang = true;
                $('#detail_barang input').each(function() {
                    if (status_barang !== '' && status_barang !== 'dikembalikan') {
                        tidak_ada_barang = false;
                        return false; // keluar dari loop
                    }
                });

                // aktifkan peringatan jika ada data barang di table barang
                if (tidak_ada_barang) {
                    $('#peringatan_barang').prop('hidden', true);
                } else {
                    $('#peringatan_barang').prop('hidden', false);
                }

            }, 500);
        });

    });
</script>



{{-- Perulangan untuk cek error --}}
<?php $listError = ['id_stasiun', 'nama_stasiun']; ?>
@foreach ($listError as $err)
    @error($err)
        <script type="text/javascript">
            window.onload = function() {
                OpenBootstrapPopup();
            };

            function OpenBootstrapPopup() {
                $("#modalTambahBarang").modal('show');
            }
        </script>
    @break
@enderror
@endforeach
