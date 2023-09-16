@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h4 class="card-title mx-2">Berita Acara Serah Terima</h4>
                <p class="small text-gray-800">Barang Diterima</p>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID BAST</th>
                            <th>Waktu BAST</th>
                            <th>Perihal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($bast_barang_diterima as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->id_bast }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>{{ $data->perihal }}</td>

                                <td class="text-center">
                                    {{-- UNTUK MENAMPILKAN VIEW CETAK FORM INSTALASI SOFTWARE --}}
                                    <div class="overlay" id="overlay_{{ $data->id_permintaan }}">
                                        <div class="iframe-container">
                                            <a id="tombol_print_{{ $data->id_permintaan }}" href="#" target="_blank"
                                                class="btn btn-sm bg-primary text-white tombol-print"
                                                title="Cetak Form Permintaan Instalasi Software"
                                                onclick="cetakPDF(event, '/cetak_bast/barang_keluar/{{ $data->id_permintaan }}')">
                                                <i class="fas fa-file-pdf"></i> Cetak Dokumen
                                            </a>
                                            <button id="tutup_form_software_{{ $data->id_permintaan }}"
                                                class="btn btn-sm bg-danger text-white tutup-form-software"
                                                title="Tutup Iframe">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <iframe id="myIframe_{{ $data->id_permintaan }}" src=""
                                                style="display: none;"></iframe>
                                        </div>
                                    </div>
                                    {{-- END OF OVERLAY --}}


                                    {{-- TAMPILKAN TIGA TOMBOL BERIKUT --}}
                                    <div class="btn-group" role="group">
                                        <button id="view_bast_barang_keluar_{{ $data->id_permintaan }}"
                                            class="btn btn-sm bg-primary text-white rounded ml-2"
                                            title="Cetak Form Permintaan Instalasi Software"
                                            onclick="loadIframe('{{ $data->id_permintaan }}')">
                                            <i class="fa fa-print"></i>
                                        </button>

                                        {{-- <button class="btn btn-sm btn-warning rounded text-white mx-1" data-toggle="modal"
                                            data-target="#detail_bast_masuk_{{ $data->id_bast }}"
                                            title="Detail Permintaan"><i class="fas fa-eye"></i>
                                        </button> --}}

                                    </div>

                                </td>
                            </tr>

                            <script>
                                function loadIframe(id_permintaan) {
                                    var iframe = document.getElementById("myIframe_" + id_permintaan);
                                    var overlay = document.getElementById("overlay_" + id_permintaan);

                                    iframe.src = "/cetak_bast/barang_keluar/" + id_permintaan;
                                    iframe.style.display = "block";
                                    overlay.style.display = "block";
                                }

                                // Event listener untuk tombol "Cetak Form Permintaan Instalasi Software"
                                document.getElementById("view_bast_barang_keluar_{{ $data->id_permintaan }}").addEventListener("click",
                                    function() {
                                        loadIframe('{{ $data->id_permintaan }}');
                                    });

                                // Event listener untuk tombol "Tutup Iframe"
                                document.getElementById("tutup_form_software_{{ $data->id_permintaan }}").addEventListener("click", function() {
                                    var iframe = document.getElementById("myIframe_{{ $data->id_permintaan }}");
                                    var overlay = document.getElementById("overlay_{{ $data->id_permintaan }}");

                                    iframe.style.display = "none";
                                    overlay.style.display = "none";
                                });
                            </script>

                            {{-- script untuk cetak --}}
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
                                document.getElementById('view_bast_barang_keluar_{{ $data->id_permintaan }}').addEventListener('click',
                                    function() {
                                        // Tampilkan overlay
                                        document.getElementById('overlay_{{ $data->id_permintaan }}').style.display = 'block';
                                    });

                                // Tangani klik tombol Tutup Iframe
                                document.getElementById('tutup_form_software_{{ $data->id_permintaan }}').addEventListener('click', function() {
                                    // Sembunyikan overlay_{{ $data->id_permintaan }}
                                    document.getElementById('overlay_{{ $data->id_permintaan }}').style.display = 'none';
                                });
                            </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- @if (isset($data))
        @include('admin.hardware.modal.detail_permintaan_hardware')
    @endif --}}
@endsection
