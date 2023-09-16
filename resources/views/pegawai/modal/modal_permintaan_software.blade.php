<!-- Modal permintaan instalasi software -->
<div class="modal fade" id="modal_instalasi_software" tabindex="-1" role="dialog"
    aria-labelledby="modal_instalasi_software-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_instalasi_software-label">Permintaan Instalasi Software</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="signature-pad">
                <form action="/pegawai/simpan_software" method="POST" id="form-instalasi-software"
                    enctype="multipart/form-data">
                    @csrf
                    <div hidden class="form-group">
                        <input class="form-control" id="kode_barang_table" name="kode_barang_table">
                        <input class="form-control" id="input_status_barang" name="input_status_barang">
                    </div>
                    <div id="detail_barang">
                        <h5>Spesifikasi PC / Laptop</h5>
                        <div class="form-group">
                            <label for="kode_barang">No. Aset / Inventaris / Serial Number</label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang">
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                placeholder="Laptop/PC, merk, dan tipe">
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

                        <div hidden id="peringatan_barang" class="alert alert-warning fade show small" role="alert">
                            <i class="fas fa-exclamation-triangle"> </i> Barang tersebut telah diinput dan sedang dalam
                            proses
                            pengajuan.
                        </div>

                        <div class="d-flex justify-content-end my-2" id="tombol_detail_barang">
                            <button type="button" class="btn btn-sm btn-primary" id="btn_lanjut_1">Lanjut <i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <div id="detail_permintaan">
                        <h5>Detail Permintaan</h5>
                        <h6>Pilih Software</h6>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label>Operating System</label>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox" id="os1"
                                            value="Microsoft Windows">
                                        <label class="form-check-label" for="os1">Microsoft Windows</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox" id="os2"
                                            value="Linux OS">
                                        <label class="form-check-label" for="os2">Linux OS</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="os3" value="Mac OS">
                                        <label class="form-check-label" for="os3">Mac OS</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <label>Microsoft Office</label>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="office1" value="Microsoft Office Standar">
                                        <label class="form-check-label" for="office1">Microsoft Office
                                            Standar</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="office2" value="Microsoft Office For Mac">
                                        <label class="form-check-label" for="office2">Microsoft Office For
                                            Mac</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group mb-2">
                            <label>Software Design</label>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="design5" value="Adobe After Effect">
                                        <label class="form-check-label" for="design5">Adobe After Effect</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="design1" value="Adobe Photoshop">
                                        <label class="form-check-label" for="design1">Adobe Photoshop</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="design2" value="Adobe Premiere">
                                        <label class="form-check-label" for="design2">Adobe Premiere</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="design3" value="Adobe Ilustrator">
                                        <label class="form-check-label" for="design3">Adobe Ilustrator</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="design4" value="Autocad">
                                        <label class="form-check-label" for="design4">Autocad</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="design6" value="Corel Draw">
                                        <label class="form-check-label" for="design6">Corel Draw</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="design7" value="Microsoft Project">
                                        <label class="form-check-label" for="design7">Microsoft Project</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="design8" value="Microsoft Visio">
                                        <label class="form-check-label" for="design8">Microsoft Visio</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="design9" value="Sketch Up Pro">
                                        <label class="form-check-label" for="design9">Sketch Up Pro</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="design10" value="Vray Fr Sketchup">
                                        <label class="form-check-label" for="design10">Vray fr Sketchup</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group mb-2">
                            <label>Software Lainnya</label>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="other1" value="Antivirus">
                                        <label class="form-check-label" for="other1">Antivirus</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="other5" value="Nitro PDF Pro">
                                        <label class="form-check-label" for="other5">Nitro PDF Pro</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="other2" value="Open Office">
                                        <label class="form-check-label" for="other2">Open Office</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="other3" value="SAP">
                                        <label class="form-check-label" for="other3">SAP</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" name="software[]" type="checkbox"
                                            id="other4" value="Software Lainnya">
                                        <label class="form-check-label" for="other4">Software Lainnya</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <hr>
                        <div class="form-group">
                            <label for="uraian_kebutuhan">Uraian Kebutuhan</label>
                            <textarea class="form-control" id="uraian_kebutuhan" name="uraian_kebutuhan" rows="2"></textarea>
                        </div>
                        <div class="d-flex justify-content-end my-2" id="tombol_detail_permintaan">
                            <button type="button" class="btn btn-sm btn-danger mr-1" id="tombol_kembali"><i
                                    class="fas fa-arrow-left"></i> Kembali</button>
                            <button type="button" class="btn btn-sm btn-primary" id="btn_lanjut_2">Lanjut <i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <div id="detail_pegawai">
                        <h6>Pengajuan Permintaan</h6>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="nip">NIP</label>
                                <input disabled type="text" class="form-control" id="nip_pegawai" name="nip"
                                    placeholder="Masukkan NIP" maxlength="5" required
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
                            <label for="">Tanda Tangan</label>
                            <div>
                                <div id="note">Silakan tanda tangan di area kolom ini</div>
                                <canvas onmouseover="my_function();" class="form-ttd" id="the_canvas"
                                    class="isi-ttd" height="150px"></canvas>
                            </div>
                            <div style="margin:10px;">
                                <input type="hidden" id="signature" name="signature">
                                <button type="button" id="clear_btn" class="btn btn-danger"
                                    data-action="clear">Clear</button>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end my-2" id="tombol_detail_pegawai">
                            <button type="button" class="btn btn-sm btn-danger mr-1" id="tombol_kembali_2"><i
                                    class="fas fa-arrow-left"></i> Kembali</button>
                        </div>
                    </div>

                    <div class="modal-footer p-0">
                        <button type="reset" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
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
        $('#btn_lanjut_1').prop('disabled', true);

        var timeoutId;

        $('#detail_barang input').on('input', function() {
            clearTimeout(timeoutId);

            timeoutId = setTimeout(function() {
                // cek apakah semua input diisi
                var isFilled = true;
                var status_barang = $('#input_status_barang').val();

                $('#detail_barang input').each(function() {
                    if ($(this).val() === '' || (status_barang !== 'dikembalikan' &&
                            status_barang !== '')) {
                        isFilled = false;
                        return false; // keluar dari loop
                    }
                });

                // aktifkan tombol lanjut jika semua input diisi
                if (isFilled) {
                    $('#btn_lanjut_1').prop('disabled', false);

                } else {
                    $('#btn_lanjut_1').prop('disabled', true);
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


        // tampilan modal awal, sembunyikan form detail_permintaan dan detail_pegawai
        $('#detail_permintaan').hide();
        $('#detail_pegawai').hide();
        $('#btn-simpan').hide();

        $('#tombol_detail_permintaan').hide();
        $('#tombol_detail_pegawai').hide();


        // handler untuk tombol lanjut 1
        $('#btn_lanjut_1').click(function() {
            $('#detail_barang').hide();
            $('#tombol_detail_barang').hide();

            $('#detail_permintaan').show();
            $('#tombol_detail_permintaan').show();
        });

        // handler untuk tombol kembali 1
        $('#tombol_kembali').click(function() {
            $('#detail_barang').show();
            $('#detail_permintaan').hide();
            $('#detail_pegawai').hide();

            $('#tombol_detail_barang').show();
            $('#tombol_detail_permintaan').hide();
        });

        // handler untuk tombol lanjut 2
        $('#btn_lanjut_2').click(function() {
            $('#detail_barang').hide();
            $('#detail_permintaan').hide();
            $('#detail_pegawai').show();
            $('#btn-simpan').show();

            $('#tombol_detail_pegawai').show();
        });

        // handler untuk tombol kembali 2
        $('#tombol_kembali_2').click(function() {
            $('#detail_barang').hide();
            $('#detail_permintaan').show();
            $('#detail_pegawai').hide();

            $('#btn-simpan').hide();

            $('#tombol_detail_permintaan').show();

            $('#tombol_detail_pegawai').hide();

        });
    });
</script>



<script>
    $(document).ready(function() {
        // nonaktifkan tombol lanjut pada awalnya
        $('#btn_lanjut_2').prop('disabled', true);

        // dapatkan elemen checkbox dan textarea
        const checkboxes = document.querySelectorAll('input[name="software[]"]');
        const uraianKebutuhanTextarea = document.getElementById('uraian_kebutuhan');

        // dapatkan elemen tombol lanjut 2
        const lanjutBtn = document.getElementById('btn_lanjut_2');

        // tambahkan listener untuk setiap perubahan pada checkbox dan textarea
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', validasiForm);
        });
        uraianKebutuhanTextarea.addEventListener('input', validasiForm);

        // fungsi untuk memvalidasi apakah form sudah terisi atau belum
        function validasiForm() {
            // cek apakah setidaknya satu checkbox sudah dicentang dan textarea diisi
            if (
                Array.from(checkboxes).some(function(checkbox) {
                    return checkbox.checked;
                }) &&
                uraianKebutuhanTextarea.value.trim().length > 0
            ) {
                // jika sudah terisi, maka aktifkan tombol lanjut 2
                lanjutBtn.disabled = false;
            } else {
                // jika belum terisi, maka nonaktifkan tombol lanjut 2
                lanjutBtn.disabled = true;
            }
        }

        // Handler tombol Tutup
        $('#modal_instalasi_software').on('hidden.bs.modal', function() {
            $(this).find('input[type=text]').not('#detail_pegawai input[type=text]').val('');
            // $(this).find('button[type=submit]').prop('disabled', true);
            $('#detail_barang').show();
            $('#detail_permintaan').hide();
            $('#detail_pegawai').hide();

            // hapus centang pada setiap checkbox
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            // kosongkan textarea
            uraianKebutuhanTextarea.value = '';

            $('#btn_lanjut_1').prop('disabled', true);
            $('#btn_lanjut_2').prop('disabled', true);
            $('#btn-simpan').hide();
        });
    });
</script>
