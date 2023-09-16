<div class="modal fade" id="modal_lihat_data" tabindex="-1" role="dialog" aria-labelledby="modal_lihat_dataLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header py-4">
                <h5 class="modal-title" id="modal_lihat_dataLabel">Data Pegawai</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body py-2">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="nip_pegawai">NIP</label>
                            <input disabled class="form-control form-control-sm" type="text" name="nip"
                                id="nip" value="">
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama Pegawai</label>
                            <input type="text" class="form-control form-control-sm" id="nama" name="nama"
                                readonly value="">
                        </div>
                        <div class="form-group">
                            <label for="bagian">Bagian</label>
                            <input type="text" class="form-control form-control-sm" id="bagian" name="bagian"
                                readonly value="">
                        </div>
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" class="form-control form-control-sm" id="jabatan" name="jabatan"
                                readonly value="">
                        </div>
                        <div class="form-group">
                            <label for="nama_stasiun">Lokasi</label>
                            <input type="text" class="form-control form-control-sm" id="nama_stasiun"
                                name="nama_stasiun" readonly value="">
                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="reset" class="btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
