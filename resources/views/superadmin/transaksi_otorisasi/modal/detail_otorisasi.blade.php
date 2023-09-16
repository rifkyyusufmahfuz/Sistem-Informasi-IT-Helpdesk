@foreach ($data_tindaklanjut as $data)
    @if ($list_software->where('id_permintaan', $data->id_permintaan)->isNotEmpty())
        <!-- Modal permintaan instalasi software -->
        <div class="modal fade" id="detail_otorisasi{{ $data->id_otorisasi }}" tabindex="-1" role="dialog"
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
                        <div id="detail_permintaan">
                            <h5>Detail Software</h5>
                            <h6>List software yang telah diinstal:</h6>
                            <?php $no = 1; ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Software</th>
                                        <th>Versi</th>
                                        <th>Catatan</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list_software->where('id_permintaan', $data->id_permintaan) as $data2)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data2->nama_software }}</td>
                                            <td>{{ $data2->versi_software }}</td>
                                            <td class="text-center">{{ $data2->notes }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>


                        <div id="detail_pegawai">
                            <h6>Disetujui oleh Manajer</h6>
                            <div class="row">
                                <div class="form-group col-sm-5">
                                    <label for="nip">NIP</label>
                                    <input type="text" class="form-control" value="{{ $data->nip_manager }}"
                                        disabled>
                                </div>

                                <div class="form-group col-sm-7">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" value="{{ $data->nama_manager }}"
                                        disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-5">
                                    <label for="bagian">Bagian</label>
                                    <input type="text" class="form-control" value="{{ $data->bagian_manager }}"
                                        disabled>
                                </div>

                                <div class="form-group col-sm-7">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" class="form-control" value="{{ $data->jabatan_manager }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" class="form-control" value="{{ $data->lokasi_manager }}" disabled>
                            </div>
                            <hr>

                            <div class="form-group text-center">
                                <figcaption class="mb-2">Tanda Tangan Manajer</figcaption>
                                <div class="border rounded p-2">
                                    <img class="gambar_ttd"
                                        src="{{ asset('tandatangan/instalasi_software/manager/' . $data->ttd_manager) }}"
                                        title="Tanda tangan {{ $data->nama_manager }}" oncontextmenu="return false;"
                                        ondragstart="return false;">
                                    <figcaption>{{ $data->nama_manager }}</figcaption>
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
    @elseif ($list_hardware->where('id_permintaan', $data->id_permintaan)->isNotEmpty())
        <!-- Modal permintaan instalasi software -->
        <div class="modal fade" id="detail_otorisasi{{ $data->id_otorisasi }}" tabindex="-1" role="dialog"
            aria-labelledby="detail_permintaan_software_label" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detail_permintaan_software_label">Permintaan Pengecekan Hardware
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="signature-pad">
                        <div id="detail_permintaan">
                            <h5>Detail Hardware</h5>
                            <h6>List hardware yang telah dilakukan pengecekan:</h6>
                            <?php $no = 1; ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Komponen</th>
                                        <th>Status</th>
                                        <th>Problem</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list_hardware->where('id_permintaan', $data->id_permintaan) as $data2)
                                        <tr>
                                            <td>{{ $no++ }}</td>
                                            <td>{{ $data2->komponen }}</td>
                                            <td>{{ $data2->status_hardware }}</td>
                                            <td>{{ $data2->problem }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <div id="detail_pegawai">
                            <h6>Divalidasi oleh Manajer:</h6>
                            <div class="row">
                                <div class="form-group col-sm-5">
                                    <label for="nip">NIP</label>
                                    <input type="text" class="form-control" value="{{ $data->nip_manager }}"
                                        disabled>
                                </div>

                                <div class="form-group col-sm-7">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" value="{{ $data->nama_manager }}"
                                        disabled>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-5">
                                    <label for="bagian">Bagian</label>
                                    <input type="text" class="form-control" value="{{ $data->bagian_manager }}"
                                        disabled>
                                </div>

                                <div class="form-group col-sm-7">
                                    <label for="jabatan">Jabatan</label>
                                    <input type="text" class="form-control" value="{{ $data->jabatan_manager }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lokasi">Lokasi</label>
                                <input type="text" class="form-control" value="{{ $data->lokasi_manager }}"
                                    disabled>
                            </div>
                            <hr>

                            <div class="form-group text-center">
                                <figcaption class="mb-2">Tanda Tangan Manajer</figcaption>
                                <div class="border rounded p-2">
                                    <img class="gambar_ttd"
                                        src="{{ asset('tandatangan/pengecekan_hardware/manager/' . $data->ttd_manager) }}"
                                        title="Tanda tangan {{ $data->nama_manager }}" oncontextmenu="return false;"
                                        ondragstart="return false;">
                                    <figcaption>{{ $data->nama_manager }}</figcaption>
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
    @endif
@endforeach
