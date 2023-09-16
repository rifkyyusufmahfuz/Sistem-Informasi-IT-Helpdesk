@foreach ($permintaan as $data)
    <!-- Modal permintaan instalasi software -->
    <div class="modal fade" id="detail_permintaan_pegawai_{{ $data->id_permintaan }}" tabindex="-1" role="dialog"
        aria-labelledby="detail_permintaan_software_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detail_permintaan_software_label">Permintaan Instalasi Software</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="signature-pad">
                    <div id="detail_barang">
                        <h5>Detail Permintaan</h5>
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
                    <hr>
                    <div id="detail_permintaan">
                        <h6>Kebutuhan Permintaan</h6>
                        <div class="form-group">
                            <label>Kategori Software</label>
                            <div class="form-control">
                                @if ($data->operating_system == 1)
                                    <span class="badge badge-primary mr-1 p-1">Sistem Operasi</span>
                                @endif
                                @if ($data->microsoft_office == 1)
                                    <span class="badge badge-primary mr-1 p-1">Microsoft Office</span>
                                @endif
                                @if ($data->software_design == 1)
                                    <span class="badge badge-primary mr-1 p-1">Software Design</span>
                                @endif
                                @if ($data->software_lainnya == 1)
                                    <span class="badge badge-primary p-1">Lainnya</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="uraian_kebutuhan">Uraian Kebutuhan</label>
                            <textarea disabled class="form-control" id="uraian_kebutuhan" name="uraian_kebutuhan" rows="3">{{ $data->keluhan_kebutuhan }}</textarea>
                        </div>
                    </div>
                    <hr>
                    <div id="detail_pegawai">
                        <h6>Pengajuan Permintaan Oleh:</h6>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="nip">NIP</label>
                                <input type="text" class="form-control" value="{{ $data->nip }}" disabled>
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" value="{{ $data->nama }}" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="bagian">Bagian</label>
                                <input type="text" class="form-control" value="{{ $data->bagian }}" disabled>
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" value="{{ $data->jabatan }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" value="{{ $data->nama_stasiun }}" disabled>
                        </div>
                        <hr>

                        <div class="form-group text-center">

                            <figcaption class="mb-2">Tanda Tangan Requestor</figcaption>
                            <div class="border rounded p-2">
                                <img class="gambar_ttd"
                                    src="{{ asset('tandatangan/instalasi_software/requestor/' . $data->ttd_requestor) }}"
                                    title="Tanda tangan {{ $data->nama }}" oncontextmenu="return false;"
                                    ondragstart="return false;">
                                <figcaption>{{ $data->nama }}</figcaption>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
