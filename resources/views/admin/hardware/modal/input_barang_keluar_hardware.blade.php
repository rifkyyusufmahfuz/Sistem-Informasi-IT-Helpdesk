<!-- Modal -->
<div class="modal fade" id="modal_input_bast_keluar_{{ $data_barang->id_bast }}" tabindex="-1" role="dialog"
    aria-labelledby="modal_input_bast_keluar_label" aria-hidden="true">
    <div class="modal-dialog" role="document" id="signature-pad">
        <div class="modal-content" id="signature-pad2">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_input_bast_keluar_label">Form BAST</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/admin/crud" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <input hidden name="jenis_bast" id="jenis_bast" value="barang_keluar">
                    <input hidden name="keperluan" value="pengecekan_hardware">

                    <div id="yang_menyerahkan-2">
                        <h6>Pihak Pertama - Yang Mengembalikan Barang</h6>
                        <div class="row">
                            @foreach ($permintaan as $data2)
                                <input type="hidden" value="{{ $data2->id_permintaan }}" name="id_permintaan">
                                <input type="hidden" value="{{ $data2->kode_barang }}" name="kode_barang">
                                <div class="form-group col-sm-5">
                                    <label for="nip_p1">NIP</label>
                                    <input readonly type="text" class="form-control" id="nip_pegawai_p1"
                                        name="nip_p1" placeholder="Masukkan NIP" maxlength="5" required
                                        value="{{ Auth::user()->pegawai->nip }}">
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
                                <input class="form-check-input" type="checkbox" id="konfirmasi_data-2">
                                <label class="form-check-label text-justify" for="konfirmasi_data-2">
                                    Saya sebagai Pihak Pertama menyatakan bahwa telah melaksanakan pengembalian barang
                                    kepada Pihak Kedua sesuai dengan keadaan saat diterima dan telah memastikan bahwa
                                    semua persyaratan pengambilan barang telah terpenuhi.
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-primary" id="next-btn-2">Lanjut</button>
                        </div>
                    </div>

                    <div id="yang_menerima-2">
                        <h6>Pihak Kedua - Yang Menerima Barang</h6>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="nip">NIP</label>
                                <input readonly type="text" class="form-control" id="nip_pegawai"
                                    name="nip_pegawai" placeholder="Masukkan NIP" maxlength="5" required
                                    value="{{ $data2->nip }}">
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
                                <input class="form-check-input" type="checkbox" id="konfirmasi_penerima-2">
                                <label class="form-check-label text-justify" for="konfirmasi_penerima-2">
                                    Saya sebagai Pihak Kedua telah menerima pengembalian barang sesuai dengan kondisi
                                    saat diserahkan dan telah memenuhi persyaratan yang berlaku. Barang yang telah
                                    dikembalikan akan menjadi tanggung jawab Pihak Kedua dan di luar tanggung jawab
                                    pihak IT Support.
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-primary" id="back-btn-2">Kembali</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan-2" disabled>Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function() {
        // Disable tombol lanjut pada awalnya
        $('#next-btn-2').prop('disabled', true);

        // Cek checkbox saat nilai berubah
        $('#konfirmasi_data-2').on('change', function() {
            // Cek apakah checkbox konfirmasi_data-2 dicentang
            var isDataChecked = $(this).prop('checked');

            // Aktifkan tombol lanjut jika checkbox konfirmasi_data-2 dicentang dan semua kolom input teks terisi, nonaktifkan jika tidak
            $('#next-btn-2').prop('disabled', !(isDataChecked));
        });

        // Disable tombol Simpan pada awalnya
        $('#btn-simpan-2').prop('disabled', true);

        // cek checkbox saat nilai berubah
        $('#konfirmasi_data-2, #konfirmasi_penerima-2').on('change', function() {
            // cek apakah checkbox konfirmasi_data-2 dicentang
            var isDataChecked = $('#konfirmasi_data-2').prop('checked');
            // cek apakah checkbox konfirmasi_penerima-2 dicentang
            var isPenerimaChecked = $('#konfirmasi_penerima-2').prop('checked');
            // aktifkan tombol lanjut jika checkbox konfirmasi_data-2 dicentang, nonaktifkan jika tidak
            $('#next-btn-2').prop('disabled', !isDataChecked);
            // aktifkan tombol simpan jika kedua checkbox dicentang, nonaktifkan jika tidak
            $('#btn-simpan-2').prop('disabled', !(isDataChecked && isPenerimaChecked));
        });

        // Hide the "Bagian Yang Menerima" section initially
        $('#yang_menerima-2').hide();

        // Handler untuk tombol Lanjut
        $('#next-btn-2').click(function() {
            // Hide the "Bagian Yang Menyerahkan" section
            $('#yang_menyerahkan-2').hide();
            // Show the "Bagian Yang Menerima" section
            $('#yang_menerima-2').show();
        });

        // Handler untuk tombol Kembali
        $('#back-btn-2').click(function() {
            // Show the "Bagian Yang Menyerahkan" section
            $('#yang_menyerahkan-2').show();
            // Hide the "Bagian Yang Menerima" section
            $('#yang_menerima-2').hide();
        });

        // Handler untuk tombol Close
        $('#modal_input_bast_keluar_{{ $data_barang->id_permintaan }}').on('hidden.bs.modal', function() {
            // $(this).find('input[type=text]').val('');
            $(this).find('button[type=submit]').prop('disabled', true);
            // Show the "Bagian Yang Menyerahkan" section
            $('#yang_menyerahkan-2').show();
            // Hide the "Bagian Yang Menerima" section
            $('#yang_menerima-2').hide();
        });
    });
</script>
