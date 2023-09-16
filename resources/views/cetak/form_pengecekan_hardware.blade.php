{{-- header --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Permintaan Instalasi Software</title>
    <link href="{{ asset('custom_script/css/form-permintaan_instalasi_software.css') }}" rel="stylesheet">
</head>

<body style="font-size: 12px;">
    <table class="tabel" border="1" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td rowspan="6">
                <img src="{{ asset('custom_script/img/logo_kci.png') }}" alt="logo_kci" width="100px" height="auto">
            </td>
            <td rowspan="2" id="judul_dokumen">PT. KERETA COMMUTER INDONESIA</td>
            <td id="informasi_dokumen">
                <div class="konten">
                    <div class="kolom1">No. Dokumen</div>
                    <div class="kolom2">: FR.KCI.0355</div>
                </div>
            </td>
        </tr>
        <tr>
            <td id="informasi_dokumen">
                <div class="konten">
                    <div class="kolom1">Tanggal Terbit</div>
                    <div class="kolom2">: 25-Jul-19</div>
                </div>
            </td>
        </tr>
        <tr>
            <td rowspan="4" id="judul_dokumen">FORMULIR PENGECEKAN PC/LAPTOP</td>
        </tr>
        <tr>
            <td id="informasi_dokumen">
                <div class="konten">
                    <div class="kolom1">Revisi</div>
                    <div class="kolom2">: -</div>
                </div>
            </td>
        </tr>
        <tr>
            <td id="informasi_dokumen">
                <div class="konten">
                    <div class="kolom1">Tanggal Revisi</div>
                    <div class="kolom2">: -</div>
                </div>
            </td>
        </tr>
        <tr>
            <td id="informasi_dokumen">
                <div class="konten">
                    <div class="kolom1">Halaman</div>
                    <div class="kolom2">: 1</div>
                </div>
            </td>
        </tr>
    </table>
    {{-- END HEADER --}}

    {{-- DATA REQUEST --}}
    <div>
        <table>
            <tr>
                <td class="jarak-kiri">Nomor Request</td>
                <td>:</td>
                <td>{{ $id_permintaan }}</td>
            </tr>
        </table>
        <table>

            <tr>
                <td class="jarak-kiri">Tanggal Request</td>
                <td>:</td>
                <td id="garis_bawah" style="width: 15px">
                    {{ date('d', strtotime($tanggal_permintaan)) }}
                </td>
                <td>/</td>
                <td id="garis_bawah" style="width: 15px">
                    {{ date('m', strtotime($tanggal_permintaan)) }}
                </td>
                <td>/</td>
                <td id="garis_bawah">
                    {{ date('Y', strtotime($tanggal_permintaan)) }}
                </td>
                <td>&nbsp; &nbsp; (dd/mm/yyyy)</td>

            </tr>
        </table>
    </div>

    <div class="container">
        <table width="100%" cellpadding="0" class="table-data-requestor">
            <thead>
                <tr>
                    <td class="jarak-kiri" colspan="3">HARAP DITULIS DENGAN HURUF CETAK </td>
                    <td colspan="4">*DIISI SETELAH PENGECEKAN SELESAI DILAKUKAN</td>
                </tr>
                <tr>
                    <td colspan="7" class="header">REQUESTOR</td>
                </tr>
            </thead>
            <tbody class="body-table-data-requestor">
                <tr>
                    <td class="kolom_nama jarak-kiri">Nama</td>
                    <td class="titikdua">:</td>
                    <td class="kolom_isi_nama" id="garis_bawah">
                        {{ $nama }}
                    </td>
                    <td></td>
                    <td class="kolom_kedua">Unit/Bagian</td>
                    <td>:</td>
                    <td id="garis_bawah">
                        {{ $bagian }}
                    </td>
                </tr>
                <tr>
                    <td class="jarak-kiri">NIK/NIPP</td>
                    <td>:</td>
                    <td id="garis_bawah">
                        {{ $nip }}
                    </td>
                    <td></td>
                    <td class="kolom_kedua">Jabatan</td>
                    <td>:</td>
                    <td id="garis_bawah">
                        {{ $jabatan }}
                    </td>
                </tr>

                <tr>
                    <td class="jarak-kiri">Uraian Keluhan</td>
                    <td>:</td>
                    <td id="garis_bawah" colspan="5">
                        {{ $keluhan }}
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td id="garis_bawah" colspan="5">&nbsp;</td>
                </tr>

                <tr>
                    <td colspan="7">
                        <table>
                            <tr>
                                <td class="kolom_aset jarak-kiri">
                                    No. Aset/Inventaris/Serial Number
                                </td>
                                <td class="titikdua">:</td>
                                <td class="no_aset" id="garis_bawah_noaset">
                                    {{ $kode_barang }}
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <table class="tabel_ttd_requestor" border="0" cellspacing="0">
            @if (file_exists(public_path('/tandatangan/pengecekan_hardware/requestor/' . $ttd_requestor)))
                <tr class="kolom_tanda_tangan">
                    <td class="nama_tanda_tangan">Nama/Tanda Tangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                    <td rowspan="8">
                        <div class="kotak-ttd">
                            {{-- <figure> --}}
                            <img class="gambar_ttd"
                                src="{{ asset('tandatangan/pengecekan_hardware/requestor/' . $ttd_requestor) }}"
                                title="Tanda tangan {{ $nama }}">
                            <figcaption>{{ $nama }}</figcaption>
                            {{-- </figure> --}}
                        </div>
                    </td>
                </tr>
            @else
                <tr>
                    <td class="nama_tanda_tangan">Nama/Tanda Tangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                    <td rowspan="7">
                        <div class="ttd" style="padding: 20px 90px 20px 90px;"></div>
                    </td>
                </tr>
            @endif
        </table>

        {{-- END OF DATA REQUESTOR  --}}

        {{-- BAGIAN ADMIN --}}

        <table border="0" width="100%" cellpadding="0">
            <thead>
                <tr>
                    <td colspan="7" class="header">EXECUTOR</td>
                </tr>
                <tr>
                    <th rowspan="2" class="header-kolom-admin kolom_komponen">Component</th>
                    <th class="header-kolom-admin kolom_check_hardware" id="status_hardware">Status</th>
                    <th rowspan="2" class="header-kolom-admin header_kolom_problem">Problem</th>
                </tr>
                <tr>
                    <td class="kolom_check_hardware">OK&nbsp;&nbsp;&nbsp;&nbsp;NOK</td>
                </tr>
            </thead>
            <tbody>
                <!-- hardware loop -->
                @foreach ($list_hardware as $hardware)
                    @php
                        $hardware_name = str_replace(' ', '_', strtolower($hardware));
                        $selected_hardware = $table_hardware->where('komponen', $hardware)->first();
                        $status_ok_checked = $selected_hardware && $selected_hardware->status_hardware == 'OK';
                        $status_nok_checked = $selected_hardware && $selected_hardware->status_hardware == 'NOK';
                    @endphp

                    <tr class="form-software">
                        {{-- Kolom Nama hardware --}}
                        <td class="kolom_hardware">
                            <label class="kolom_hardware" for="{{ $hardware_name }}">{{ $hardware }}</label>
                        </td>
                        <td class="kolom_check_hardware">
                            {{-- TAMBAHKAN HEADER CHECKBOX PERTAMA "OK" --}}
                            <input class="checkbox_hardware" type="checkbox" name="hardware[]"
                                id="{{ $hardware_name }}_ok" value="{{ $hardware }}"
                                @if ($status_ok_checked) checked @endif>
                            {{-- TAMBAHKAN HEADER CHECKBOX KEDUA "NOK" --}}
                            <input type="checkbox" name="hardware[]" id="{{ $hardware_name }}_nok"
                                value="{{ $hardware }}" @if ($status_nok_checked) checked @endif>
                        </td>

                        {{-- Kolom problem  --}}
                        <td class="kolom_problem" id="garis_bawah">
                            @if ($selected_hardware && $selected_hardware->problem != null)
                                {{ $selected_hardware->problem }}
                            @else
                                &nbsp;
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>

        {{-- <div class="pembungkus"> --}}
        <table class="tabel_ttd_requestor" border="0" cellspacing="0">
            @if (
                !empty($ttd_tindak_lanjut) &&
                    file_exists(public_path('/tandatangan/pengecekan_hardware/executor/' . $ttd_tindak_lanjut)))
                <tr class="kolom_tanda_tangan">
                    <td class="nama_tanda_tangan">Nama/Tanda Tangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                    <td rowspan="8">
                        <div class="kotak-ttd">
                            {{-- <figure> --}}
                            <img class="gambar_ttd"
                                src="{{ asset('tandatangan/pengecekan_hardware/executor/' . $ttd_tindak_lanjut) }}"
                                title="Tanda tangan {{ $nama_admin }}">
                            <figcaption>{{ $nama_admin }}</figcaption>
                            {{-- </figure> --}}
                        </div>
                    </td>
                </tr>
            @else
                <tr class="kolom_tanda_tangan">
                    <td class="nama_tanda_tangan">Nama/Tanda Tangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                    <td rowspan="8">
                        <div class="kotak-ttd">
                            {{-- <figure> --}}
                            <img class="gambar_ttd" src="" title="">
                            <figcaption></figcaption>
                            {{-- </figure> --}}
                        </div>
                    </td>
                </tr>
            @endif
        </table>

        {{-- </div> --}}

        <table border="0" width="100%" cellpadding="0">
            <thead>
                <tr>
                    <td colspan="7" class="header">RECOMMENDATIONS</td>
                </tr>
            </thead>

            <tr class="kotak-comment lebar-kotak-comment">
                <td colspan="7">
                    <div class="judul-comment">Comment : </div>
                <td class="isi-comment">
                    <div>{{ $rekomendasi }}</div>
                </td>
                </td>
            </tr>

            <tbody>
                <table class="tabel_ttd_requestor" border="0" cellspacing="0">
                    @if (
                        !empty($otorisasi->ttd_manager) &&
                            file_exists(public_path('/tandatangan/pengecekan_hardware/manager/' . $otorisasi->ttd_manager)))
                        <tr class="kolom_tanda_tangan">
                            <td class="nama_tanda_tangan">Nama/Tanda Tangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                            <td rowspan="8">
                                <div class="kotak-ttd">
                                    {{-- <figure> --}}
                                    <img class="gambar_ttd"
                                        src="{{ asset('tandatangan/pengecekan_hardware/manager/' . $otorisasi->ttd_manager) }}"
                                        title="Tanda tangan {{ $otorisasi->nama }}">
                                    <figcaption>{{ $otorisasi->nama }}</figcaption>
                                    {{-- </figure> --}}
                                </div>
                            </td>
                        </tr>
                    @else
                        <tr class="kolom_tanda_tangan">
                            <td class="nama_tanda_tangan">Nama/Tanda Tangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                            <td rowspan="8">
                                <div class="kotak-ttd">
                                    {{-- <figure> --}}
                                    <img class="gambar_ttd" src="" title="">
                                    <figcaption></figcaption>
                                    {{-- </figure> --}}
                                </div>
                            </td>
                        </tr>
                    @endif
                </table>
            </tbody>
        </table>

        <table border="0" width="100%" cellpadding="0">
            <thead>
                <tr>
                    <td colspan="7" class="header">DUAL CONTROL CHECKLIST</td>
                </tr>
            </thead>

            <tr>
                <td>
                    <div class="status-dual_control">
                        <span class="checkbox-status">
                            Status
                        </span>
                        <span class="checkbox-dual_control">
                            <input type="checkbox">
                            <label for="">OK</label>

                        </span>
                        <span class="checkbox-dual_control">
                            <input type="checkbox">
                            <label for="">NOT OK</label>
                        </span>
                    </div>
                </td>
            </tr>

            <tr class="kotak-comment">
                <td colspan="7">
                    <div class="judul-comment">Comment : </div>
                    <div class="isi-comment"></div>
                </td>
            </tr>


            <tr>
                <td>
                    <div class="kolom-dual_control">
                        <div class="status-dual_control control-executor">
                            <span class="checkbox-status">
                                <label for="">Control Executor</label>
                                <p class="control-signature">Signature</p>
                            </span>
                            <span class="label-titikdua">
                                <label for="">:</label>
                                <p class="control-signature">&nbsp;</p>
                            </span>
                            <span class="checkbox-status">
                                <label for="">&nbsp;</label>
                                <p class="control-name control-signature">Name & Employee ID</p>
                            </span>
                        </div>
                        <div class="kolom-date">
                            <span class="checkbox-status">
                                <label for="">Date</label>
                                <p class="control-signature">&nbsp;</p>
                            </span>
                            <span class="label-titikdua">
                                <label class="label-titikdua" for="">:</label>
                                <p class="control-signature">&nbsp;</p>
                            </span>
                            <span class="checkbox-status">
                                <label for="">&nbsp;</label>
                                <p class="control-name control-signature">&nbsp;</p>
                            </span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mendapatkan semua elemen input dengan tipe checkbox
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');

            // Mengatur fungsi onclick untuk mencegah perubahan pada checkbox
            checkboxes.forEach(function(checkbox) {
                checkbox.onclick = function() {
                    return false;
                };
            });
        });
    </script>
</body>

</html>
