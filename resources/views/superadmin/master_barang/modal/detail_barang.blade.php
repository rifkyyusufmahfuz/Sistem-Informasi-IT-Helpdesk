@foreach ($data_barang as $data)
    <div class="modal fade" id="modal_detail_barang{{ $data->kode_barang }}" tabindex="-1" role="dialog"
        aria-labelledby="modal_detail_barangLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_detail_barangLabel">Detail Barang</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Detail Spesifikasi Barang</h5>
                    <div class="form-group">
                        <label>No. Aset / Inventaris / Serial Number</label>
                        <span class="text-danger">*</span>
                        <input disabled class="form-control" value="{{ $data->kode_barang }}">
                    </div>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <span class="text-danger">*</span>
                        <input disabled class="form-control" value="{{ $data->nama_barang }}">
                    </div>
                    <div class="form-group">
                        <label>Prosesor</label>
                        <input disabled class="form-control" value="{{ $data->prosesor }}">
                    </div>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>RAM</label>
                            <input disabled class="form-control" value="{{ $data->ram }}">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Penyimpanan</label>
                            <input disabled class="form-control" value="{{ $data->penyimpanan }}">

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Status Barang</label>
                        <select disabled class="form-control">
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
                        <button type="reset" class="btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endforeach
