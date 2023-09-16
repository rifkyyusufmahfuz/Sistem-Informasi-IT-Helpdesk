<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form BAST Barang Masuk</title>
    <link href="{{ asset('custom_script/css/form-bast.css') }}" rel="stylesheet">
</head>

<body>
    <div class="header">
        <img src="{{ asset('custom_script/img/logo_kci.png') }}" alt="Logo Perusahaan">
        <br>
        <p id="alamat">Kantor Pusat (Stasiun Juanda)</p>
        <p id="alamat">Jl. Ir. H. Djuanda I Kota Jakarta Pusat</p>
        <p id="alamat">Daerah Khusus Ibukota Jakarta 10120</p>
    </div>

    <div class="title">
        <h2>BERITA ACARA SERAH TERIMA BARANG</h2>
    </div>

    <div>
        @foreach ($data_bast_masuk as $data)
            @php
                $nomorBast = str_replace('-', '/', $data->id_bast);
            @endphp
            <div>
                <p id="nomor_bast">Nomor: {{ $nomorBast }}</p>
            </div>


            <div>
                <p class="text-indent">Pada hari ini <b>{{ $hari }}</b>, tanggal <b>{{ $tanggal }}</b>
                    bulan
                    <b>{{ $bulan }}</b> tahun <b>{{ $tahun }}</b>, di Kantor Pusat Stasiun Juanda, kami
                    yang
                    bertanda tangan di bawah ini:
                </p>
            </div>
            <div class="subtitle">
                <span>Pihak Pertama:</span>
                <table class="tabel-data-pegawai">
                    <tr>
                        <td id="kolom-1">Nama Lengkap</td>
                        <td id="kolom-2">:</td>
                        <td>{{ $data->nama_p1 }}</td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td>{{ $data->nip_p1 }}</td>
                    </tr>
                    <tr>
                        <td>Bagian/Divisi</td>
                        <td>:</td>
                        <td>{{ $data->bagian_p1 }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>{{ $data->jabatan_p1 }}</td>
                    </tr>
                    <tr>
                        <td>Lokasi Kerja</td>
                        <td>:</td>
                        <td>Stasiun {{ $data->lokasi_p1 }}</td>
                    </tr>
                </table>
            </div>

            <div class="subtitle">
                <span>Pihak Kedua:</span>
                <table class="tabel-data-pegawai">
                    <tr>
                        <td id="kolom-1">Nama Lengkap</td>
                        <td id="kolom-2">:</td>
                        <td>{{ $data->nama_p2 }}</td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td>{{ $data->nip_p2 }}</td>
                    </tr>
                    <tr>
                        <td>Bagian/Divisi</td>
                        <td>:</td>
                        <td>{{ $data->bagian_p2 }}</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>{{ $data->jabatan_p2 }}</td>
                    </tr>
                    <tr>
                        <td>Lokasi Kerja</td>
                        <td>:</td>
                        <td>Stasiun {{ $data->lokasi_p2 }}</td>
                    </tr>
                </table>
            </div>

            <div>
                <p class="text-indent">Dengan ini menyatakan bahwa PIHAK PERTAMA telah menyerahkan barang kepada PIHAK
                    KEDUA dengan detail berikut:
                </p>
            </div>

            <div class="table-data-barang">
                <table>
                    <tr>
                        <th>No.</th>
                        <th id="kode_barang">Kode Barang</th>
                        <th id="nama_barang">Nama Barang</th>
                        <th id="jumlah_barang">Jumlah Barang</th>
                        <th id="keperluan">Keperluan</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>{{ $data->kode_barang }}</td>
                        <td>{{ $data->nama_barang }}</td>
                        <td>{{ $data->jumlah_barang }} Unit</td>
                        @php
                            $nomorpermintaan = str_replace('-', '/', $data->id_permintaan);
                        @endphp

                        @if ($data->tipe_permintaan === 'hardware')
                            @php
                                $keperluan = 'Pengecekan hardware sesuai permintaan pada Formulir Pengecekan Hardware';
                            @endphp
                        @elseif ($data->tipe_permintaan === 'software')
                            @php
                                $keperluan = 'Instalasi software sesuai permintaan pada Formulir Permintaan Instalasi Software';
                            @endphp
                        @endif



                        <td>
                            {{ $keperluan }} dengan nomor: <b>{{ $nomorpermintaan }}</b>
                            {{-- @foreach ($data_software as $data2)
                                <p>- {{ $data2->nama_software }}</p>
                                <p>- {{ $data2->nama_software }}</p>
                                <p>- {{ $data2->nama_software }}</p>
                            @endforeach --}}
                        </td>

                    </tr>
                </table>
            </div>

            @if ($data->tipe_permintaan === 'hardware')
                @php
                    $keterangan = 'Layanan IT <i>Helpdesk</i> pengecekan <i>hardware</i>';
                    $keterangan_2 = 'pengecekan <i>hardware</i>';
                @endphp
            @elseif ($data->tipe_permintaan === 'software')
                @php
                    $keterangan = 'Layanan IT <i>Helpdesk</i> instalasi <i>software</i>';
                    $keterangan_2 = 'instalasi <i>software</i>';
                @endphp
            @endif

            <div>
                <p class="text-indent">
                    Pihak kedua telah menerima barang tersebut dalam kondisi baik, lengkap, dan sesuai dengan deskripsi
                    yang
                    tertera pada tabel di atas dan kedua belah pihak setuju bahwa barang yang diserahkan oleh pihak
                    pertama
                    telah diterima dengan baik oleh pihak kedua untuk keperluan {!! $keterangan !!}. Selanjutnya,
                    pihak
                    kedua bertanggung jawab atas penggunaan barang tersebut sesuai
                    dengan keperluan yang telah disepakati dan akan dikembalikan segera setelah proses
                    {!! $keterangan_2 !!} selesai.
                </p>
                <p>Demikian Berita Acara Serah Terima Barang ini dibuat untuk dipergunakan sebagaimana mestinya.</p>
            </div>

            <div>
                <p class="tanggal_ttd">Jakarta Pusat, {{ $tanggal_ttd }}</p>
            </div>
            <div class="signature-container">
                <div class="yang_menyerahkan">
                    @if (
                        !empty($data->ttd_menerima) &&
                            file_exists(public_path('/tandatangan/bast/barang_masuk/yang_menerima/' . $data->ttd_menerima)))
                        <div>
                            <div class="kotak-ttd">
                                <div class="isi-ttd">
                                    <figcaption>Pihak Pertama,</figcaption>
                                    <img class="gambar_ttd"
                                        src="{{ asset('tandatangan/bast/barang_masuk/yang_menyerahkan/' . $data->ttd_menyerahkan) }}"
                                        title="Tanda tangan {{ $data->nama_p1 }}">
                                    <figcaption>{{ $data->nama_p1 }}</figcaption>
                                </div>
                                <figcaption>Requestor</figcaption>
                            </div>
                        </div>
                    @else
                        <div>
                            <div class="kotak-ttd">
                                <figcaption>Pihak Pertama,</figcaption>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="yang_menerima">
                    @if (
                        !empty($data->ttd_menerima) &&
                            file_exists(public_path('/tandatangan/bast/barang_masuk/yang_menerima/' . $data->ttd_menerima)))
                        <div>
                            <div class="kotak-ttd">
                                <div class="isi-ttd">
                                    <figcaption>Pihak Kedua,</figcaption>
                                    <img class="gambar_ttd"
                                        src="{{ asset('tandatangan/bast/barang_masuk/yang_menerima/' . $data->ttd_menerima) }}"
                                        title="Tanda tangan {{ $data->nama_p2 }}">
                                    <figcaption>{{ $data->nama_p2 }}</figcaption>
                                </div>
                                <figcaption>Admin Layanan IT Helpdesk</figcaption>
                            </div>
                        </div>
                    @else
                        <div>
                            <div class="kotak-ttd">
                                <figcaption>Pihak Kedua,</figcaption>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

</body>

</html>
