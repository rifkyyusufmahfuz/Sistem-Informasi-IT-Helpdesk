<!DOCTYPE html>
<html>

<head>
    <title>Permintaan Pengecekan Hardware Diterima</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        .tabel {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }

        .center-table {
            margin: 0 auto;
        }

        .container {
            padding: 20px 50px;
            text-align: center;
        }

        .header {
            border-radius: 10px;
            border-style: solid;
            border-width: thin;
            border-color: #dadce0;
            padding: 20px;
        }

        .gambar-header {
            border-right: solid;
            border-width: thin;
            border-color: #dadce0;
        }

        .spasi-header {
            border-bottom: solid;
            border-width: thin;
            border-color: #dadce0;
        }

        .footer {
            font-size: 11px;
            opacity: 0.7;
            margin-top: 20px;
            line-height: 15px;
        }

        .garis {
            height: 0.5px;
            border-width: 0;
            color: #dadce0;
            background-color: #dadce0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td rowspan="2" class="gambar-header">
                        <img src="https://commuterline.id/img/kci_logo.png">
                    </td>
                    <td class="spasi-header">
                        <h3>SISTEM INFORMASI IT HELPDESK - PT KCI</h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3>LAYANAN IT HELPDESK</h3>
                    </td>
                </tr>
            </table>
            <hr class="garis">
            <h4>PERMINTAAN PENGECEKAN HARDWARE</h4>
            <p>Permintaan Pengecekan Hardware dengan ID Permintaan <strong>"{{ $id_permintaan_formatted }}"</strong>
                telah
                diterima.</p>
            <p>Segera serahkan unit yang akan dilakukan pengecekan ke kantor pusat (NOC).</p>
            <h4>Data Unit Sesuai Permintaan:</h4>
            <table class="center-table tabel">
                <thead>
                    <tr class="tabel">
                        <th class="tabel">No.</th>
                        <th class="tabel">No.Aset/Inventaris/Serial Number</th>
                        <th class="tabel">Unit</th>
                        <th class="tabel">Keluhan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_unit as $barang)
                        <tr class="tabel">
                            <td class="tabel">1.</td>
                            <td class="tabel">{{ $barang->kode_barang }}</td>
                            <td class="tabel">{{ $barang->nama_barang }}</td>
                            <td class="tabel">{{ $keluhan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
            <p>Terima kasih.</p>
        </div>
        <div class="footer">
            <p>
                Anda menerima email ini sebagai pemberitahuan tentang perubahan penting pada layanan IT Helpdesk
                yang
                Anda
                ajukan.
            </p>
            <p>© 2023 Layanan IT Helpdesk, Kantor Pusat, Jl. Ir H. Juanda I, Stasiun Juanda, Jakarta Pusat, 10120
            </p>
        </div>
    </div>
</body>

</html>
