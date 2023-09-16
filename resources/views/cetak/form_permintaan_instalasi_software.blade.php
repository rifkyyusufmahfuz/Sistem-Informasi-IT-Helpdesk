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
            <td rowspan="5">
                <img src="{{ asset('custom_script/img/logo_kci.png') }}" alt="logo_kci" width="100px" height="auto">
            </td>
            <td rowspan="2" id="judul_dokumen">PT. KERETA COMMUTER INDONESIA</td>
            <td id="informasi_dokumen">
                <div class="konten">
                    <div class="kolom1">No. Dokumen</div>
                    <div class="kolom2">: FR.KCI.0480</div>
                </div>
            </td>
        </tr>
        <tr>
            <td id="informasi_dokumen">
                <div class="konten">
                    <div class="kolom1">Tanggal Terbit</div>
                    <div class="kolom2">: 12-Mar-20</div>
                </div>
            </td>
        </tr>
        <tr>
            <td rowspan="3" id="judul_dokumen">FORMULIR PERMINTAAN INSTALASI SOFTWARE</td>
        </tr>
        <tr>
            <td id="informasi_dokumen">
                <div class="konten">
                    <div class="kolom1">Status Revisi</div>
                    <div class="kolom2">: -</div>
                </div>
            </td>
        </tr>
        <tr>
            <td id="informasi_dokumen">
                <div class="konten">
                    <div class="kolom1">Halaman</div>
                    <div class="kolom2">: 1 dari 1</div>
                </div>
            </td>
        </tr>
    </table>
    {{-- END HEADER --}}

    {{-- DATA REQUEST --}}
    <div>
        {{-- <table>
            <tr>
                <td class="jarak-kiri">Nomor Request</td>
                <td>:</td>
                <td>{{ $id_permintaan }}</td>
            </tr>
            <tr>
                <td class="jarak-kiri">Tanggal Request</td>
                <td>:</td>
                <td>{{ $tanggal_permintaan }}</td>
            </tr>
        </table> --}}
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
                    <td colspan="4">*DIINSTALASI SETELAH APPROVALS SELESAI DILAKUKAN</td>
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
                    <td class="jarak-kiri">Kategori Software</td>
                    <td>:</td>
                    <td colspan="5">
                        <input style="margin-left: 1px;" type="checkbox" name="category1" id="category1" value="1"
                            {{ $kategori->operating_system ? 'checked' : '' }}>
                        <label style="margin-right: 1px;" for="category1">Operating System</label>
                        <input type="checkbox" name="category2" id="category2" value="2"
                            {{ $kategori->microsoft_office ? 'checked' : '' }}>
                        <label style="margin-right: 1px;" for="category2">Microsoft Office</label>
                        <input type="checkbox" name="category3" id="category3" value="3"
                            {{ $kategori->software_design ? 'checked' : '' }}>
                        <label style="margin-right: 1px;" for="category3">Software Design</label>
                        <input type="checkbox" name="category4" id="category4" value="4"
                            {{ $kategori->software_lainnya ? 'checked' : '' }}>
                        <label for="category4">Software Lainnya</label>
                    </td>
                </tr>

                <tr>
                    <td class="jarak-kiri">Uraian Kebutuhan</td>
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
            @if (file_exists(public_path('/tandatangan/instalasi_software/requestor/' . $ttd_requestor)))
                <tr class="kolom_tanda_tangan">
                    <td class="nama_tanda_tangan">Nama/Tanda Tangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                    <td rowspan="8">
                        <div class="kotak-ttd">
                            {{-- <figure> --}}
                            <img class="gambar_ttd"
                                src="{{ asset('tandatangan/instalasi_software/requestor/' . $ttd_requestor) }}"
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
                    <td colspan="7" class="header">ADMIN</td>
                </tr>
                <tr>
                    <th class="header-kolom-admin kolom_check_software">Selection</th>
                    <th class="header-kolom-admin">Software</th>
                    <th class="header-kolom-admin">*Version</th>
                    <th class="header-kolom-admin kolom_notes">*Notes</th>

                    {{-- <td class="header-kolom-admin">Selection</td>
                    <td class="header-kolom-admin">Software</td>
                    <td class="header-kolom-admin">*Version</td>
                    <td class="header-kolom-admin">*Notes</td> --}}
                </tr>
            </thead>
            <tbody>
                <!-- software loop -->
                @foreach ($list_software as $software)
                    @php
                        $software_name = str_replace(' ', '_', strtolower($software));
                        $selected_software = $table_software->where('nama_software', $software)->first();
                    @endphp

                    <tr class="form-software">
                        <td class="kolom_check_software">
                            <input type="checkbox" name="software[]" id="{{ $software_name }}"
                                value="{{ $software }}" @if ($selected_software) checked @endif>
                        </td>
                        {{-- Kolom Nama software --}}
                        <td class="kolom_software">
                            <label class="kolom_software" for="{{ $software_name }}">{{ $software }}</label>
                        </td>
                        {{-- Kolom Version --}}
                        <td class="kolom_version" id="garis_bawah">
                            @if ($selected_software && $selected_software->versi_software == !null)
                                {{ $selected_software->versi_software }}
                            @else
                                &nbsp;
                            @endif
                        </td>
                        {{-- Kolom Notes  --}}
                        <td class="kolom_notes" id="garis_bawah">
                            @if ($selected_software && $selected_software->notes == !null)
                                {{ $selected_software->notes }}
                            @else
                                &nbsp;
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pembungkus">
            {{-- kolom ttd admin --}}
            <div class="tabel_ttd_request_owner" border="0" cellspacing="0">
                <div class="kolom_ttd_request_owner">
                    {{-- @if (file_exists(public_path('/tandatangan/instalasi_software/requestor/' . $ttd_requestor)))
                        <div>
                            <div class="kotak_ttd_request_owner">
                                <figcaption class="judul_ttd_request_owner">Request Owner</figcaption>
                                <img class="gambar_ttd_request_owner" title="Tanda tangan {{ $nama }}"
                                    src="{{ asset('tandatangan/instalasi_software/requestor/' . $ttd_requestor) }}">
                                <figcaption id="garis_bawah_request_owner">{{ $nama }}</figcaption>
                            </div>
                        </div>
                    @else --}}
                    <div>
                        <div class="kotak_ttd_request_owner">
                            <figcaption class="judul_ttd_request_owner">Request Owner</figcaption>
                            <img>
                            <figcaption id="garis_bawah_request_owner_kosong"></figcaption>
                        </div>
                    </div>
                    {{-- @endif --}}
                </div>
            </div>

            <div class="tabel_ttd_admin">
                {{-- ttd admin --}}
                <div class="kolom_ttd_admin">
                    @if (
                        !empty($ttd_tindak_lanjut) &&
                            file_exists(public_path('/tandatangan/instalasi_software/admin/' . $ttd_tindak_lanjut)))
                        <div class="nama_tanda_tangan">Nama/Tanda Tangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</div>
                        <div>
                            <div class="kotak-ttd">
                                <img class="gambar_ttd"
                                    src="{{ asset('tandatangan/instalasi_software/admin/' . $ttd_tindak_lanjut) }}"
                                    title="Tanda tangan {{ $nama_admin }}">
                                <figcaption>{{ $nama_admin }}</figcaption>
                            </div>
                        </div>
                    @else
                        <div class="nama_tanda_tangan">Nama/Tanda Tangan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</div>
                        <div rowspan="7">
                            <div class="kotak-ttd"></div>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <table border="0" width="100%" cellpadding="0">
            <thead>
                <tr>
                    <td colspan="7" class="header">APPROVALS</td>
                </tr>
            </thead>
            @php $status_otorisasi = '-'; @endphp

            @if ($otorisasi && $otorisasi->status_approval == 'approved')
                @php $status_otorisasi = 'A'; @endphp
            @elseif ($otorisasi && $otorisasi->status_approval == 'rejected')
                @php $status_otorisasi = 'R'; @endphp
            @elseif ($otorisasi && $otorisasi->status_approval == 'revision')
                @php $status_otorisasi = 'N'; @endphp
            @endif

            @php $tanggal = '__/__/____'; @endphp

            @if ($otorisasi && $otorisasi->tanggal_approval != '0000-00-00')
                @php
                    $tanggal = date('d/m/Y', strtotime($otorisasi->tanggal_approval));
                @endphp
            @endif
            <tbody>
                <tr>
                    <td class="table_otorisasi">
                        <table border="0">
                            <tr>
                                <td class="jarak-table-otorisasi">Otorisasi Persetujuan</td>
                                <td>:</td>
                                <td>
                                    <div class="kotak_otorisasi" style="padding:4px; font-weight:bold;"
                                        align="center">
                                        {{ $status_otorisasi }}</div>
                                </td>
                                <td>(A) Approved, (R) Rejected, (N) Revision Needed</td>
                            </tr>
                            <tr>
                                <td>Catatan</td>
                                <td>:</td>
                                <td colspan="2" id="garis_bawah">
                                    @if ($otorisasi && $otorisasi->catatan != '')
                                        {{ $otorisasi->catatan }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td colspan="2" id="garis_bawah">
                                    &nbsp;
                                </td>
                            </tr>

                            <tr>
                                <td colspan="4">Manager IT</td>
                            </tr>
                            <tr>
                                <td colspan="2">Nama/Tanda Tangan</td>
                                <td colspan="2" align="right">
                                    <div class="tanggal-otorisasi">
                                        <div class="jarak-kiri">Jakarta, </div>
                                        @if ($otorisasi && $otorisasi->tanggal_approval)
                                            <div id="garis_bawah" class="tgl-otorisasi">
                                                {{ date('d', strtotime($otorisasi->tanggal_approval)) }}
                                            </div>
                                            <div>/</div>
                                            <div id="garis_bawah" class="tgl-otorisasi">
                                                {{ date('m', strtotime($otorisasi->tanggal_approval)) }}
                                            </div>
                                            <div>/</div>
                                            <div id="garis_bawah" class="tahun-otorisasi">
                                                {{ date('Y', strtotime($otorisasi->tanggal_approval)) }}
                                            </div>
                                        @else
                                            <div id="garis_bawah" class="tgl-otorisasi">-</div>
                                            <div>/</div>
                                            <div id="garis_bawah" class="tgl-otorisasi">-</div>
                                            <div>/</div>
                                            <div id="garis_bawah" class="tahun-otorisasi">-</div>
                                        @endif
                                        <div>&nbsp; &nbsp; (dd/mm/yyyy)</div>
                                    </div>
                                </td>

                            </tr>


                        </table>
                        <div class="pembungkus-manager">
                            <div class="tabel_ttd_admin">
                                {{-- ttd admin --}}
                                <div class="kolom_ttd_admin">
                                    @if (
                                        !empty($otorisasi->ttd_manager) &&
                                            file_exists(public_path('/tandatangan/instalasi_software/manager/' . $otorisasi->ttd_manager)))
                                        <div class="kotak-ttd-manager">
                                            <img class="gambar_ttd"
                                                src="{{ asset('tandatangan/instalasi_software/manager/' . $otorisasi->ttd_manager) }}"
                                                title="Tanda tangan {{ $otorisasi->nama }}">
                                            <figcaption>{{ $otorisasi->nama }}</figcaption>
                                        </div>
                                    @else
                                        <div class="kotak-ttd-manager"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
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
