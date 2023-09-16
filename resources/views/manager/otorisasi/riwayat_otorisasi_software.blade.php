@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h4 class="card-title mx-2">Riwayat Otorisasi</h4>
                <p class="small text-gray-800">Permintaan Instalasi Software</p>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Permintaan</th>
                            <th>Waktu Pengajuan</th>
                            <th>Status Otorisasi</th>
                            <th class="text-center">Status Permintaan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($permintaan as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->id_permintaan }}</td>
                                <td>{{ $data->permintaan_created_at }}</td>
                                <td>{{ ucwords($data->status_approval) }}</td>


                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $data->status_permintaan == '1'
                                            ? 'danger'
                                            : ($data->status_permintaan == '2'
                                                ? 'warning'
                                                : ($data->status_permintaan == '3'
                                                    ? 'primary'
                                                    : ($data->status_permintaan == '4'
                                                        ? 'primary'
                                                        : ($data->status_permintaan == '5'
                                                            ? 'success'
                                                            : ($data->status_permintaan == '0'
                                                                ? 'danger'
                                                                : ($data->status_permintaan == '6'
                                                                    ? 'success'
                                                                    : 'success')))))) }} p-2">

                                        {{ $data->status_permintaan == '1'
                                            ? 'Pending'
                                            : ($data->status_permintaan == '2'
                                                ? 'Menunggu persetujuan'
                                                : ($data->status_permintaan == '3'
                                                    ? 'Diterima'
                                                    : ($data->status_permintaan == '4'
                                                        ? 'Diproses'
                                                        : ($data->status_permintaan == '5'
                                                            ? 'Instalasi selesai'
                                                            : ($data->status_permintaan == '0'
                                                                ? 'Ditolak'
                                                                : ($data->status_permintaan == '6'
                                                                    ? 'Selesai'
                                                                    : 'Selesai')))))) }}
                                    </span>
                                </td>

                                {{-- KOLOM AKSI --}}
                                <td class="text-center">
                                    {{-- UNTUK MENAMPILKAN VIEW CETAK FORM INSTALASI SOFTWARE --}}
                                    <div class="overlay" id="overlay_{{ $data->id_permintaan }}">
                                        <div class="iframe-container">
                                            <a id="tombol_print_{{ $data->id_permintaan }}" href="#" target="_blank"
                                                class="btn btn-sm bg-primary text-white tombol-print"
                                                title="Cetak Form Permintaan Instalasi Software"
                                                onclick="cetakPDF(event, '/form_instalasi_software/{{ $data->id_permintaan }}')">
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

                                    <div class="btn-group" role="group">
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning rounded text-white dropdown-toggle"
                                                data-toggle="dropdown" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                    data-target="#detail_permintaan_pegawai_{{ $data->id_permintaan }}">
                                                    Detail Permintaan
                                                </a>
                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                    data-target="#detail_permintaan_admin_{{ $data->id_permintaan }}">
                                                    Detail Software
                                                </a>
                                            </div>
                                        </div>
                                        <button id="view_form_software_{{ $data->id_permintaan }}"
                                            class="btn btn-sm bg-primary text-white rounded ml-2"
                                            title="Cetak Form Permintaan Instalasi Software"
                                            onclick="loadIframe('{{ $data->id_permintaan }}')">
                                            <i class="fa fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- script untuk fungsi iframe diload hanya saat tombol print diklik --}}
                            <script>
                                function loadIframe(id_permintaan) {
                                    var iframe = document.getElementById("myIframe_" + id_permintaan);
                                    var overlay = document.getElementById("overlay_" + id_permintaan);

                                    iframe.src = "/form_instalasi_software/" + id_permintaan;
                                    iframe.style.display = "block";
                                    overlay.style.display = "block";
                                }

                                // Event listener untuk tombol "Cetak Form Permintaan Instalasi Software"
                                document.getElementById("view_form_software_{{ $data->id_permintaan }}").addEventListener("click", function() {
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
                                document.getElementById('view_form_software_{{ $data->id_permintaan }}').addEventListener('click', function() {
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

    @if (isset($data))
        @include('manager.modal.detail_permintaan_software')
        @include('manager.modal.detail_software')
    @endif
@endsection
