<!DOCTYPE html>
<html>

<head>
    <title>Permintaan Instalasi Software Ditolak</title>
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
            <h4>PERMINTAAN INSTALASI SOFTWARE</h4>
            <p>Permintaan Instalasi Software dengan ID Permintaan <strong>"{{ $id_permintaan_formatted }}"</strong>
                belum dapat dilanjutkan.</p>
            <p>Catatan:</p>
            @foreach ($otorisasi_data as $otorisasi)
                <p>{{ $otorisasi->catatan }}.</p>
            @endforeach

            <br>
            <p>Terima kasih.</p>
        </div>
        <div class="footer">
            <p>
                Anda menerima email ini sebagai pemberitahuan tentang perubahan penting pada layanan IT Helpdesk yang
                Anda ajukan.
            </p>
            <p>© 2023 Layanan IT Helpdesk, Kantor Pusat, Jl. Ir H. Juanda I, Stasiun Juanda, Jakarta Pusat, 10120
            </p>
        </div>
    </div>
</body>

</html>
