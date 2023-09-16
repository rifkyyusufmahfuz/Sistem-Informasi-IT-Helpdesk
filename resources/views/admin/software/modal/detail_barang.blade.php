@foreach ($barang as $data)
    <!-- Modal permintaan instalasi software -->
    <div class="modal fade" id="detail_barang_{{ $data->kode_barang }}" tabindex="-1" role="dialog"
        aria-labelledby="detail_barang_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detail_barang_label">Permintaan Instalasi Software</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="detail_barang">
                        <h6>Spesifikasi PC / Laptop</h6>
                        <div class="form-group">
                            <label for="kode_barang">No. Aset / Inventaris / Serial Number</label>
                            <input disabled type="text" class="form-control" id="kode_barang" name="kode_barang"
                                value="{{ $data->kode_barang }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input disabled type="text" class="form-control" id="nama_barang" name="nama_barang"
                                value="{{ $data->nama_barang }}">
                        </div>
                        <div class="form-group">
                            <label for="prosesor">Prosesor</label>
                            <input disabled type="text" class="form-control" id="prosesor" name="prosesor"
                                value="{{ $data->prosesor }}">
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="ram">RAM</label>
                                <input disabled type="text" class="form-control" id="ram" name="ram"
                                    value="{{ $data->ram }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="penyimpanan">Penyimpanan</label>
                                <input disabled type="text" class="form-control" id="penyimpanan" name="penyimpanan"
                                    value="{{ $data->penyimpanan }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
