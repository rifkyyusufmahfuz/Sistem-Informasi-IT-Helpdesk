<!-- Modal -->
<div class="modal fade" id="cetak_laporan_permintaan" tabindex="-1" role="dialog"
    aria-labelledby="cetak_laporan_permintaanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cetak_laporan_permintaanLabel">Laporan Periodik</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="signature-pad2">
                <form method="post" action="/create_laporan_permintaan">
                    <!-- Form untuk filter laporan -->
                    @csrf
                    <input hidden name="jenis_laporan" id="jenis_laporan" value="software">
                    <div class="form-group">
                        <label for="jenis_filter">Jenis Filter:</label>
                        <select class="form-control" name="jenis_filter" id="jenis_filter">
                            <option disabled value="" selected>--Pilih Filtering--</option>
                            <option value="harian">Harian</option>
                            <option value="mingguan">Mingguan</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                        </select>
                    </div>
                    <div id="filter_options">
                        <!-- Opsi untuk filtering harian -->
                        <div id="filter_harian" class="filter_option">
                            <div class="form-group">
                                <label for="tanggal">Tanggal:</label>
                                <input class="form-control" type="date" name="tanggal" id="tanggal"
                                    max="{{ $now }}">
                            </div>
                        </div>
                        <!-- Opsi untuk filtering mingguan -->
                        <div id="filter_mingguan" class="filter_option">
                            <div class="form-group">
                                <label for="tanggal_awal">Tanggal Awal:</label>
                                <input class="form-control" type="date" name="tanggal_awal" id="tanggal_awal"
                                    max="{{ $now }}">
                            </div>
                            <div class="form-group">
                                <label for="tanggal_akhir">Tanggal Akhir:</label>
                                <input class="form-control" type="date" name="tanggal_akhir" id="tanggal_akhir"
                                    max="{{ $now }}">
                            </div>
                        </div>
                        <!-- Opsi untuk filtering bulanan -->
                        <div id="filter_bulanan" class="filter_option">
                            <div class="form-group">
                                <label for="bulan">Bulan:</label>
                                <input class="form-control" type="month" name="bulan" id="bulan"
                                    max="{{ $now }}">
                            </div>
                        </div>

                        <!-- Opsi untuk filtering tahunan -->
                        <div id="filter_tahunan" class="filter_option">
                            <div class="form-group">
                                <label for="tahun">Tahun:</label>
                                <select class="form-control selectpicker" name="tahun" id="tahun"
                                    data-live-search="true">
                                    <option value="" selected disabled>--Pilih Tahun--</option>
                                    @for ($year = date('Y'); $year >= 2020; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <hr>
                        <!-- Signature Pad -->
                        <div class="form-group text-center">
                            <label for="">Tanda tangan Admin</label>
                            <div>
                                <div id="note2">Silakan tanda tangan di area kolom ini</div>
                                <canvas onmouseover="my_function2()" class="form-ttd" id="the_canvas2" class="isi-ttd"
                                    height="150px"></canvas>
                            </div>
                            <div style="margin:10px;">
                                <input type="hidden" id="ttd_bast" name="ttd_bast">
                                <button type="button" id="clear_btn2" class="btn btn-danger"
                                    data-action="hapus_ttd">Clear</button>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="reset" id="btn_close" class="btn btn-sm btn-secondary"
                            data-bs-dismiss="modal">Tutup</button>
                        <button id="submit_btn" type="submit" class="btn btn-sm btn-primary">Ajukan ke
                            Manajer</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    $("#submit_btn").prop("disabled", true);


    function toggleSubmitButton() {
        var jenisFilter = $("#jenis_filter").val();
        var tanggal = $("#tanggal").val();
        var tanggalAwal = $("#tanggal_awal").val();
        var tanggalAkhir = $("#tanggal_akhir").val();
        var bulan = $("#bulan").val();
        var tahun = $("#tahun").val();

        // Periksa kondisi dan atur status tombol "Submit"
        if (jenisFilter !== "" && (tanggal !== "" || tanggalAwal !== "" || tanggalAkhir !== "" || bulan !== "" ||
                tahun !== "")) {
            $("#submit_btn").prop("disabled", false);
        } else {
            $("#submit_btn").prop("disabled", true);
        }
    }



    // Tampilkan opsi filter yang sesuai berdasarkan jenis filter yang dipilih
    $(document).ready(function() {
        $(".filter_option").hide();

        $("#jenis_filter").change(function() {
            var selectedOption = $(this).val();
            $(".filter_option").hide();
            $("#filter_" + selectedOption).show();
        });

        // Validasi rentang tanggal pada opsi mingguan
        $("#tanggal_awal").change(function() {
            var startDate = new Date($(this).val());
            var endDate = new Date(startDate);
            endDate.setDate(endDate.getDate() + 6);
            var maxEndDate = new Date($("#tanggal_akhir").attr("max"));

            if (endDate > maxEndDate) {
                endDate = maxEndDate;
                startDate.setDate(endDate.getDate() - 6);
                $(this).val(startDate.toISOString().split("T")[0]);
            }

            $("#tanggal_akhir").val(endDate.toISOString().split("T")[0]);
            toggleSubmitButton(); // Panggil fungsi untuk memeriksa kondisi tombol "Submit"
        });

        $("#tanggal_akhir").change(function() {
            var endDate = new Date($(this).val());
            var startDate = new Date($("#tanggal_awal").val());
            startDate.setDate(endDate.getDate() - 6);

            if (startDate < new Date($("#tanggal_awal").attr("min"))) {
                startDate = new Date($("#tanggal_awal").attr("min"));
                endDate.setDate(startDate.getDate() + 6);
                $(this).val(endDate.toISOString().split("T")[0]);
            }

            $("#tanggal_awal").val(startDate.toISOString().split("T")[0]);
        });

        $("#tanggal").change(function() {
            toggleSubmitButton(); // Panggil fungsi untuk memeriksa kondisi tombol "Submit"

        });

        $("#bulan").change(function() {
            toggleSubmitButton(); // Panggil fungsi untuk memeriksa kondisi tombol "Submit"

        });

        $("#tahun").change(function() {
            toggleSubmitButton(); // Panggil fungsi untuk memeriksa kondisi tombol "Submit"

        });

        $("#btn_close").click(function() {
            $(".filter_option").hide();
            $("#submit_btn").prop("disabled", true);
        });
    });
</script>
