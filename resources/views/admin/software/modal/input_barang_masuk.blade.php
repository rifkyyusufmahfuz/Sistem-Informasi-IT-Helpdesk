<!-- Modal -->
<div class="modal fade" id="modal_input_bast_masuk{{ $data_barang->id_bast }}" tabindex="-1" role="dialog"
    aria-labelledby="modal_input_bast_masuk_label" aria-hidden="true">
    <div class="modal-dialog" role="document" id="signature-pad">
        <div class="modal-content" id="signature-pad2">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_input_bast_masuk_label">Form BAST</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/crud" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input hidden name="jenis_bast" id="jenis_bast" value="barang_masuk">
                    <input hidden name="keperluan" value="instalasi_software">

                    <div id="yang_menyerahkan">
                        <h6>Pihak Pertama - Yang Menyerahkan Barang</h6>
                        <div class="row">
                            @foreach ($permintaan as $data2)
                                <input hidden value="{{ $data2->id_permintaan }}" name="id_permintaan">
                                <input hidden value="{{ $data2->kode_barang }}" name="kode_barang">
                                <div class="form-group col-sm-5">
                                    <label for="nip_p1">NIP</label>
                                    <input readonly type="text" class="form-control" id="nip_pegawai_p1"
                                        name="nip_p1" placeholder="Masukkan NIP" maxlength="5" required
                                        value="{{ $data2->nip }}">
                                </div>
                            @endforeach
                            
                            <div class="form-group col-sm-7">
                                <label for="nama_p1">Nama</label>
                                <input type="text" class="form-control" id="nama_pegawai_p1" name="nama_p1"
                                    placeholder="Nama" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="bagian_p1">Bagian</label>
                                <input type="text" class="form-control" id="bagian_pegawai_p1" name="bagian_p1"
                                    placeholder="Bagian" disabled>
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="jabatan_p1">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan_pegawai_p1" name="jabatan_p1"
                                    placeholder="Jabatan" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lokasi_p1">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi_pegawai_p1" name="lokasi_p1"
                                placeholder="Lokasi" disabled>
                        </div>
                        <hr>

                        <div class="form-group text-center">
                            <label for="">Tanda Tangan</label>
                            <div>
                                <div id="note">Silakan tanda tangan di area kolom ini</div>
                                <canvas onmouseover="my_function();" class="form-ttd" id="the_canvas" class="isi-ttd"
                                    height="150px"></canvas>
                            </div>
                            <div style="margin:10px;">
                                <input type="hidden" id="signature" name="signature">
                                <button type="button" id="clear_btn" class="btn btn-danger"
                                    data-action="clear">Clear</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="konfirmasi_data">
                                <label class="form-check-label text-justify" for="konfirmasi_data">
                                    Saya sebagai Pihak Pertama menyatakan bahwa barang telah diserahkan dengan lengkap
                                    kepada Pihak Kedua untuk keperluan instalasi software.
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-primary" id="next-btn">Lanjut</button>
                        </div>
                    </div>

                    <div id="yang_menerima">
                        <h6>Pihak Kedua - Yang Menerima Barang</h6>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="nip">NIP</label>
                                <input readonly type="text" class="form-control" id="nip_pegawai"
                                    name="nip_pegawai" placeholder="Masukkan NIP" maxlength="5" required
                                    value="{{ Auth::user()->pegawai->nip }}">
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama_pegawai" name="nama"
                                    placeholder="Nama" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="bagian">Bagian</label>
                                <input type="text" class="form-control" id="bagian_pegawai" name="bagian"
                                    placeholder="Bagian" disabled>
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="jabatan">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan_pegawai" name="jabatan"
                                    placeholder="Jabatan" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi_pegawai" name="lokasi"
                                placeholder="Lokasi" disabled>
                        </div>
                        <hr>

                        <div class="form-group text-center">
                            <label for="">Tanda tangan Penerima</label>
                            <div>
                                <div id="note2">Silakan tanda tangan di area kolom ini</div>
                                <canvas onmouseover="my_function2()" class="form-ttd" id="the_canvas2"
                                    class="isi-ttd" height="150px"></canvas>
                            </div>
                            <div style="margin:10px;">
                                <input type="hidden" id="ttd_bast" name="ttd_bast">
                                <button type="button" id="clear_btn2" class="btn btn-danger"
                                    data-action="hapus_ttd">Clear</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="konfirmasi_penerima">
                                <label class="form-check-label text-justify" for="konfirmasi_penerima">
                                    Saya, sebagai Pihak Kedua, menyatakan bahwa saya telah menerima barang
                                    dalam kondisi lengkap dan sesuai saat diserahkan oleh Pihak Pertama. Saya
                                    bertanggung jawab sepenuhnya atas barang tersebut dan akan menggunakan barang
                                    tersebut sesuai dengan keperluan yang telah disepakati.
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-primary" id="back-btn">Kembali</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan" disabled>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Disable tombol lanjut pada awalnya
        $('#next-btn').prop('disabled', true);

        // Cek checkbox saat nilai berubah
        $('#konfirmasi_data').on('change', function() {
            // Cek apakah checkbox konfirmasi_data dicentang
            var isDataChecked = $(this).prop('checked');

            // Aktifkan tombol lanjut jika checkbox konfirmasi_data dicentang dan semua kolom input teks terisi, nonaktifkan jika tidak
            $('#next-btn').prop('disabled', !(isDataChecked));
        });

        // Disable tombol Simpan pada awalnya
        $('#btn-simpan').prop('disabled', true);

        // cek checkbox saat nilai berubah
        $('#konfirmasi_data, #konfirmasi_penerima').on('change', function() {
            // cek apakah checkbox konfirmasi_data dicentang
            var isDataChecked = $('#konfirmasi_data').prop('checked');
            // cek apakah checkbox konfirmasi_penerima dicentang
            var isPenerimaChecked = $('#konfirmasi_penerima').prop('checked');
            // aktifkan tombol lanjut jika checkbox konfirmasi_data dicentang, nonaktifkan jika tidak
            $('#next-btn').prop('disabled', !isDataChecked);
            // aktifkan tombol simpan jika kedua checkbox dicentang, nonaktifkan jika tidak
            $('#btn-simpan').prop('disabled', !(isDataChecked && isPenerimaChecked));
        });

        // Hide the "Bagian Yang Menerima" section initially
        $('#yang_menerima').hide();

        // Handler untuk tombol Lanjut
        $('#next-btn').click(function() {
            // Hide the "Bagian Yang Menyerahkan" section
            $('#yang_menyerahkan').hide();
            // Show the "Bagian Yang Menerima" section
            $('#yang_menerima').show();
        });

        // Handler untuk tombol Kembali
        $('#back-btn').click(function() {
            // Show the "Bagian Yang Menyerahkan" section
            $('#yang_menyerahkan').show();
            // Hide the "Bagian Yang Menerima" section
            $('#yang_menerima').hide();
        });

        // Handler untuk tombol Close
        $('#modal_input_bast_masuk{{ $data_barang->id_permintaan }}').on('hidden.bs.modal', function() {
            // $(this).find('input[type=text]').val('');
            $(this).find('button[type=submit]').prop('disabled', true);
            // Show the "Bagian Yang Menyerahkan" section
            $('#yang_menyerahkan').show();
            // Hide the "Bagian Yang Menerima" section
            $('#yang_menerima').hide();
        });
    });
</script>
