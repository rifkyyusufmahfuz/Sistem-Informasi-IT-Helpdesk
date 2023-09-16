@extends('layouts.main')
@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row px-3">
                <h4 class="card-title">Serah Terima Barang</h4>
                <p class="small text-gray-800 px-1">Permintaan pengecekan hardware</p>
            </div>
            <div class="row px-3">
                <p>Serah terima barang untuk :</p>
            </div>
            @foreach ($permintaan as $data_permintaan)
                <div class="row">
                    <div class="form-group px-3">
                        <div><b>ID Permintaan</b></div>
                        <div>{{ $data_permintaan->id_permintaan }}</div>
                    </div>

                    <div class="form-group px-3">
                        <div><b>Tanggal Permintaan</b></div>
                        <div>{{ $data_permintaan->tanggal_permintaan }}</div>
                    </div>

                    <div class="form-group px-3">
                        <div><b>Requestor</b></div>
                        <div>{{ $data_permintaan->nama }}</div>
                    </div>

                    <div class="form-group px-3">
                        <div><b>Lokasi</b></div>
                        <div>{{ $data_permintaan->nama_stasiun }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Barang</th>
                            <th>Nama Barang</th>
                            <th>Status Barang</th>
                            <th>Diserahkan Oleh</th>
                            <th>Diterima Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody>
                        @foreach ($barang as $data_barang)
                            <div class="overlay" id="overlay">
                                <div class="iframe-container">
                                    <a id="tombol-print_masuk" href="#" target="_blank"
                                        class="btn btn-sm bg-primary text-white tombol-print"
                                        title="Cetak BAST Barang Masuk"
                                        onclick="cetakPDF(event, '/cetak_bast/barang_masuk/{{ $data_barang->id_permintaan }}')">
                                        <i class="fas fa-file-pdf"></i> Cetak Dokumen
                                    </a>
                                    <button id="tutup_bast_masuk" class="btn btn-sm bg-danger text-white"
                                        title="Tutup Iframe">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <iframe id="myIframe_masuk" src="" style="display: none;"></iframe>
                                </div>
                            </div>

                            <div class="view_cetak_bast_barang_keluar" id="view_cetak_bast_barang_keluar">
                                <div class="iframe-container">
                                    <a id="tombol-print_keluar" href="#" target="_blank"
                                        class="btn btn-sm bg-primary text-white tombol-print"
                                        title="Cetak BAST Barang Keluar"
                                        onclick="cetakPDF(event, '/cetak_bast/barang_keluar/{{ $data_barang->id_permintaan }}')">
                                        <i class="fas fa-file-pdf"></i> Cetak Dokumen
                                    </a>
                                    <button id="tutup_bast_keluar" class="btn btn-sm bg-danger text-white"
                                        title="Tutup Iframe">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <iframe id="myIframe_keluar" src="" style="display: none;"></iframe>
                                </div>
                            </div>

                            <?php $no = 1; ?>
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data_barang->kode_barang }}</td>
                                <td>{{ $data_barang->nama_barang }}</td>
                                {{-- <td>{{ $data_barang->perihal }}</td> --}}
                                <td>
                                    @if ($data_barang->status_barang == 'belum diterima')
                                        <span class="p-2 badge badge-secondary">Belum Diterima</span>
                                    @elseif ($data_barang->status_barang == 'diterima')
                                        <span class="p-2 badge badge-success">Diterima</span>
                                    @elseif ($data_barang->status_barang == 'siap diambil')
                                        <span class="p-2 badge badge-warning">Siap Diambil</span>
                                    @elseif ($data_barang->status_barang == 'dikembalikan')
                                        <span class="p-2 badge badge-success">Telah Dikembalikan</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $data_barang->nama_menyerahkan != null ? $data_barang->nama_menyerahkan : '-' }}
                                </td>
                                <td class="text-center">
                                    {{ $data_barang->nama_menerima != null ? $data_barang->nama_menerima : '-' }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        {{-- <button class="btn btn-sm btn-warning text-white rounded" data-bs-toggle="modal"
                                            data-bs-target="#detail_barang_{{ $data_barang->kode_barang }}"
                                            title="Detail barang">
                                            <i class="fas fa-eye"></i>
                                        </button> --}}

                                        @if ($data_barang->status_barang != 'belum diterima')
                                            <button id="view_bast_masuk"
                                                class="btn btn-sm bg-primary text-white rounded mx-1"
                                                title="Cetak BAST Barang Masuk" onclick="loadIframe('masuk')">
                                                <i class="fa fa-print"></i>&nbsp;<i class="fas fa-arrow-down"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-primary text-white rounded mx-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modal_input_barang_masuk_hardware{{ $data_barang->id_bast }}"
                                                title="Terima barang">
                                                <i class="fas fa-arrow-down"></i>
                                            </button>
                                        @endif

                                        @if ($data_barang->status_barang != 'dikembalikan')
                                            <button {{ $data_barang->status_barang != 'siap diambil' ? 'disabled' : '' }}
                                                class="btn btn-sm btn-danger text-white rounded" data-bs-toggle="modal"
                                                data-bs-target="#modal_input_bast_keluar_{{ $data_barang->id_bast }}"
                                                title="Serahkan barang"><i class="fas fa-arrow-up"></i>
                                            </button>
                                        @else
                                            <button id="view_bast_keluar" class="btn btn-sm bg-primary text-white rounded"
                                                title="Cetak BAST Barang Keluar" onclick="loadIframe('keluar')">
                                                <i class="fa fa-print"></i>&nbsp;<i class="fas fa-arrow-up"></i>
                                            </button>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function loadIframe(type) {
            var iframe;

            if (type === 'masuk') {
                iframe = document.getElementById("myIframe_masuk");
                iframe.src = "/cetak_bast/barang_masuk/{{ $data_barang->id_permintaan }}";
                document.getElementById("overlay").style.display = "block";
            } else if (type === 'keluar') {
                iframe = document.getElementById("myIframe_keluar");
                iframe.src = "/cetak_bast/barang_keluar/{{ $data_barang->id_permintaan }}";
                document.getElementById("view_cetak_bast_barang_keluar").style.display = "block";
            }

            iframe.style.display = "block";
        }

        // Event listener untuk tombol "Cetak BAST Barang Masuk"
        document.getElementById("tombol-print_masuk").addEventListener("click", function(event) {
            event.preventDefault();
            loadIframe('masuk');
        });

        // Event listener untuk tombol "Cetak BAST Barang Keluar"
        document.getElementById("tombol-print_keluar").addEventListener("click", function(event) {
            event.preventDefault();
            loadIframe('keluar');
        });

        // Event listener untuk tombol "Tutup Iframe" pada BAST Barang Masuk
        document.getElementById("tutup_bast_masuk").addEventListener("click", function() {
            document.getElementById("overlay").style.display = "none";
            document.getElementById("myIframe_masuk").style.display = "none";
        });

        // Event listener untuk tombol "Tutup Iframe" pada BAST Barang Keluar
        document.getElementById("tutup_bast_keluar").addEventListener("click", function() {
            document.getElementById("view_cetak_bast_barang_keluar").style.display = "none";
            document.getElementById("myIframe_keluar").style.display = "none";
        });
    </script>



    <script>
        function cetakPDF(event, url) {
            event.preventDefault(); // Mencegah tautan terbuka di tab baru

            // Buat elemen <iframe> dengan URL tujuan cetak
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = url;

            // Tambahkan elemen <iframe> ke dalam dokumen
            document.body.appendChild(iframe);

            // Setelah elemen <iframe> selesai dimuat, lakukan aksi cetak
            iframe.onload = function() {
                iframe.contentWindow.print();
            };

            // Hapus elemen <iframe> setelah cetak selesai
            iframe.onafterprint = function() {
                document.body.removeChild(iframe);
            };
        }
    </script>

    <script>
        // Tangani klik tombol Tampilkan Iframe
        document.getElementById('view_bast_masuk').addEventListener('click', function() {
            // Tampilkan overlay
            document.getElementById('overlay').style.display = 'block';
        });

        // Tangani klik tombol Tutup Iframe
        document.getElementById('tutup_bast_masuk').addEventListener('click', function() {
            // Sembunyikan overlay
            document.getElementById('overlay').style.display = 'none';
        });


        // Tangani klik tombol Tampilkan Iframe
        document.getElementById('view_bast_keluar').addEventListener('click', function() {
            // Tampilkan view_bast_keluar
            document.getElementById('view_cetak_bast_barang_keluar').style.display = 'block';
        });

        // Tangani klik tombol Tutup Iframe
        document.getElementById('tutup_bast_keluar').addEventListener('click', function() {
            // Sembunyikan view_bast_keluar
            document.getElementById('view_cetak_bast_barang_keluar').style.display = 'none';
        });
    </script>



    @include('admin.software.modal.detail_barang')

    @if ($data_barang->status_barang != 'belum diterima')
        @include('admin.hardware.modal.input_barang_keluar_hardware')
    @else
        @include('admin.hardware.modal.input_barang_masuk_hardware')
    @endif
@endsection
