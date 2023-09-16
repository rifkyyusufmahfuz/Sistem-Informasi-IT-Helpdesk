@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h4 class="card-title mx-2">Laporan Permintaan Periodik</h4>
                <p class="small text-gray-800">Daftar laporan permintaan</p>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Laporan</th>
                            <th>Tanggal Laporan</th>
                            <th class="text-center">Permintaan</th>
                            <th class="text-center">Periode</th>
                            <th class="text-center">Status Laporan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($laporan_permintaan as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->id_laporan }}</td>
                                <td>{{ $data->laporan_created }}</td>
                                <td class="text-center">{{ ucwords($data->jenis_laporan) }}</td>
                                <td class="text-center">{{ ucwords($data->periode_laporan) }}</td>
                                <td class="text-center">{{ ucwords($data->status_laporan) }}</td>


                                <td class="text-center">

                                    {{-- UNTUK MENAMPILKAN VIEW CETAK FORM INSTALASI SOFTWARE --}}
                                    <div class="overlay" id="overlay_{{ $data->id_laporan }}">
                                        <div class="iframe-container">
                                            <a id="tombol_print_{{ $data->id_laporan }}" href="#" target="_blank"
                                                class="btn btn-sm bg-primary text-white tombol-print"
                                                title="Cetak Form Permintaan Instalasi Software"
                                                onclick="cetakPDF(event, '/form_laporan_permintaan_periodik/{{ $data->id_laporan }}')">
                                                <i class="fas fa-file-pdf"></i> Cetak Dokumen
                                            </a>
                                            <button id="tutup_form_laporan_{{ $data->id_laporan }}"
                                                class="btn btn-sm bg-danger text-white tutup-form-software"
                                                title="Tutup Iframe">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <iframe id="myIframe_{{ $data->id_laporan }}" src=""
                                                style="display: none;"></iframe>
                                        </div>
                                    </div>
                                    {{-- END OF OVERLAY --}}

                                    <div class="btn-group" role="group">
                                        <button {{ $data->status_laporan === 'sudah divalidasi' ? 'disabled' : '' }}
                                            class="btn btn-sm btn-success rounded" data-bs-toggle="modal"
                                            data-bs-target="#setujui_permintaan_{{ $data->id_laporan }}"
                                            title="Validasi Laporan">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        <button id="view_form_laporan_{{ $data->id_laporan }}"
                                            class="btn btn-sm bg-primary text-white rounded ml-2"
                                            title="Cetak Form Laporan Permintaan"
                                            onclick="loadIframe('{{ $data->id_laporan }}')">
                                            <i class="fa fa-print"></i>
                                        </button>

                                    </div>
                                </td>
                            </tr>

                            {{-- script untuk fungsi iframe diload hanya saat tombol print diklik --}}
                            <script>
                                function loadIframe(id_laporan) {
                                    var iframe = document.getElementById("myIframe_" + id_laporan);
                                    var overlay = document.getElementById("overlay_" + id_laporan);

                                    iframe.src = "/form_laporan_permintaan_periodik/" + id_laporan;
                                    iframe.style.display = "block";
                                    overlay.style.display = "block";
                                }

                                // Event listener untuk tombol "Cetak Form Permintaan Instalasi Software"
                                document.getElementById("view_form_laporan_{{ $data->id_laporan }}").addEventListener("click", function() {
                                    loadIframe('{{ $data->id_laporan }}');
                                });

                                // Event listener untuk tombol "Tutup Iframe"
                                document.getElementById("tutup_form_laporan_{{ $data->id_laporan }}").addEventListener("click", function() {
                                    var iframe = document.getElementById("myIframe_{{ $data->id_laporan }}");
                                    var overlay = document.getElementById("overlay_{{ $data->id_laporan }}");

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
                                document.getElementById('view_form_laporan_{{ $data->id_laporan }}').addEventListener('click', function() {
                                    // Tampilkan overlay
                                    document.getElementById('overlay_{{ $data->id_laporan }}').style.display = 'block';
                                });

                                // Tangani klik tombol Tutup Iframe
                                document.getElementById('tutup_form_laporan_{{ $data->id_laporan }}').addEventListener('click', function() {
                                    // Sembunyikan overlay_{{ $data->id_laporan }}
                                    document.getElementById('overlay_{{ $data->id_laporan }}').style.display = 'none';
                                });
                            </script>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if (isset($data))
        @include('manager.laporan_permintaan.modal.validasi_laporan_permintaan')
    @endif
@endsection
