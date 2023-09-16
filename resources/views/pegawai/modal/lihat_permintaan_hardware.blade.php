@foreach ($permintaan as $data)
    <script>
        $(function() {
            // disable berikut pada saat awal loa
            $('#detail_pegawai_{{ $data->id_permintaan }}').hide();
            $('#tombol_detail_pegawai_{{ $data->id_permintaan }}').hide();
        });
    </script>

    <!-- Modal permintaan instalasi software -->
    <div class="modal fade" id="detail_permintaan_hardware_{{ $data->id_permintaan }}" tabindex="-1" role="dialog"
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
                    <div id="detail_barang_{{ $data->id_permintaan }}">
                        <h5>Spesifikasi PC / Laptop</h5>
                        <div class="form-group">
                            <label for="kode_barang">No. Aset / Inventaris / Serial Number</label>
                            <input disabled class="form-control" value="{{ $data->kode_barang }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input disabled class="form-control" value="{{ $data->nama_barang }}">
                        </div>

                        <div class="form-group">
                            <label for="uraian_kebutuhan">Uraian Kebutuhan</label>
                            <textarea disabled class="form-control" rows="3">{{ $data->keluhan_kebutuhan }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end my-2"
                            id="tombol_detail_barang_{{ $data->id_permintaan }}">
                            <button type="button" class="btn btn-sm btn-primary"
                                id="btn_lanjut_{{ $data->id_permintaan }}">Lanjut <i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <div id="detail_pegawai_{{ $data->id_permintaan }}">
                        <h5>Pengajuan Permintaan Pegawai</h5>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="nip">NIP</label>
                                <input disabled class="form-control" value="{{ $data->nip }}">
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="nama">Nama</label>
                                <input class="form-control" value="{{ $data->nama }}" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="bagian">Bagian</label>
                                <input class="form-control" value="{{ $data->bagian }}" disabled>
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="jabatan">Jabatan</label>
                                <input class="form-control" value="{{ $data->jabatan }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input class="form-control" value="{{ $data->nama_stasiun }}" disabled>
                        </div>
                        <hr>

                        <div class="form-group text-center">

                            <figcaption class="mb-2">Tanda Tangan</figcaption>
                            <div class="border rounded p-2">
                                <img class="gambar_ttd"
                                    src="{{ asset('tandatangan/pengecekan_hardware/requestor/' . $data->ttd_requestor) }}"
                                    title="Tanda tangan {{ $data->nama }}" oncontextmenu="return false;"
                                    ondragstart="return false;">
                                <figcaption>{{ $data->nama }}</figcaption>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end my-2"
                            id="tombol_detail_pegawai_{{ $data->id_permintaan }}">
                            <button type="button" class="btn btn-sm btn-danger mr-1"
                                id="tombol_kembali{{ $data->id_permintaan }}"><i class="fas fa-arrow-left"></i>
                                Kembali</button>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-sm bg-secondary text-white rounded">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {

            // handler untuk tombol kembali 1
            $('#tombol_kembali{{ $data->id_permintaan }}').click(function() {
                $('#detail_barang_{{ $data->id_permintaan }}').show();
                $('#detail_pegawai_{{ $data->id_permintaan }}').hide();

                $('#tombol_detail_barang_{{ $data->id_permintaan }}').show();
            });

            // handler untuk tombol lanjut 2
            $('#btn_lanjut_{{ $data->id_permintaan }}').click(function() {
                $('#detail_barang_{{ $data->id_permintaan }}').hide();
                $('#detail_pegawai_{{ $data->id_permintaan }}').show();


                $('#tombol_detail_pegawai_{{ $data->id_permintaan }}').show();
            });
        });

        $(document).ready(function() {
            // Handler tombol Tutup
            $('#detail_permintaan_hardware_{{ $data->id_permintaan }}').on('hidden.bs.modal', function() {
                $(this).find('input[type=text]').not(
                    '#detail_pegawai_{{ $data->id_permintaan }} input[type=text]').val('');
                // $(this).find('button[type=submit]').prop('disabled', true);
                $('#detail_barang_{{ $data->id_permintaan }}').show();
                $('#detail_pegawai_{{ $data->id_permintaan }}').hide();

                // hapus centang pada setiap checkbox
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
                // kosongkan textarea
                uraianKebutuhanTextarea.value = '';

                $('#btn_lanjut_{{ $data->id_permintaan }}').prop('disabled', true);
            });
        });
    </script>
@endforeach
