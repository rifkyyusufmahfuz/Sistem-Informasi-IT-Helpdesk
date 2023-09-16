@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Permintaan Instalasi Software</h6><br>

            {{-- Menambahkan prosedur --}}
            <div class="form-group" id="informasi_software" tabindex="0">
                <div class="accordion" id="accordionExample">
                    <div class="card border-0 rounded">
                        <div id="informasi_software_header" class="card-header collapsed bg-white p-1" data-toggle="collapse"
                            data-target="#collapseThree" aria-expanded="false">
                            <span class="title text-info">Prosedur Permintaan Instalasi Software</span>
                        </div>
                        <div id="collapseThree" class="collapse" data-parent="#accordionExample">
                            <div class="border rounded">
                                <div class="card-body">
                                    <div class="small">
                                        <h6>Prosedur Permintaan Instalasi Software</h6><br>
                                        <span>Pengajuan Permintaan Instalasi Software</span>
                                        <ol>
                                            <li>Pegawai Mengajukan Permintaan Instalasi Software Melalui Menu Permintaan
                                                Layanan > Instalasi Software > Tombol Ajukan Permintaan.</li>
                                            <li>Melengkapi Form Spesifikasi PC atau Laptop yang akan dilakukan instalasi
                                                software.</li>
                                            <li>Melengkapi detail permintaan dengan memilih kategori software sesuai
                                                kebutuhan.</li>
                                            <li>Menandatangani form secara digital pada kolom input tanda tangan yang telah
                                                disediakan.</li>
                                            <li>Setelah ditandatangani, klik tombol simpan untuk mengajukan permintaan
                                                instalasi software.</li>
                                        </ol>
                                        <span>Proses Permintaan Instalasi Software</span>
                                        <ol>
                                            <li>Menunggu admin memproses permintaan, dapat dicek pada kolom status
                                                permintaan
                                                untuk memantau progres permintaan.</li>
                                            <li>Admin akan memilih software yang sesuai dengan permintaan dan spesifikasi PC
                                                atau Laptop yang Anda ajukan.</li>
                                            <li>Admin akan mengajukan permintaan Anda ke Manajer untuk mendapatkan
                                                persetujuan instalasi software yang diminta</li>
                                            <li>Setelah disetujui, silakan bawa PC/Laptop yang akan dilakukan instalasi ke
                                                NOC kantor Pusat Stasiun Juanda.</li>
                                            <li>Setelah menyerahkan PC/Laptop ke NOC, Anda akan diberikan notifikasi bahwa
                                                telah melakukan serah terima barang.</li>
                                            <li>Proses instalasi software segera dilakukan atau menunggu antrian sesuai
                                                banyaknya permintaan.</li>
                                            <li>Apabila menunggu antrian, maka Admin akan memberikan jangka waktu
                                                penyelesaian permintaan.</li>
                                            <li>Setelah proses instalasi selesai dilakukan, Anda akan diberikan notifikasi
                                                untuk mengambil PC/Laptop di NOC kantor Pusat Stasiun Juanda.</li>
                                            <li>Setelah mengambil PC/Laptop di NOC, Anda akan diberikan notifikasi bahwa
                                                telah melakukan serah terima barang.</li>
                                            <li>Disarankan untuk selalu memantau status permintaan dan notifikasi secara
                                                berkala untuk memantau progres permintaan.</li>
                                        </ol>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            {{-- end of informasi prosedur --}}
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3 btn-sm float-left" data-toggle="modal"
                data-target="#modal_instalasi_software">
                <i class="fa fa-plus"></i> Ajukan Permintaan
            </button>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>ID Permintaan</th>
                            <th>Waktu Pengajuan</th>
                            <th>Status Permintaan</th>
                            <th>Keterangan</th>
                            <th>Waktu Penyelesaian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @foreach ($permintaan as $data)
                            <tr class="text-center">
                                <td>{{ $data->id_permintaan }}</td>
                                <td>{{ $data->created_at }}</td>
                                {{-- kolom status permintaan --}}

                                {{-- status pada saat permintaan diajukan --}}
                                <td>
                                    <span
                                        class="badge badge-{{ $data->status_permintaan == '1'
                                            ? 'danger'
                                            : ($data->status_permintaan == '2'
                                                ? 'warning'
                                                : ($data->status_permintaan == '3'
                                                    ? 'success'
                                                    : ($data->status_permintaan == '4'
                                                        ? 'primary'
                                                        : ($data->status_permintaan == '5'
                                                            ? 'info'
                                                            : ($data->status_permintaan == '0'
                                                                ? 'danger'
                                                                : ($data->status_permintaan == '6'
                                                                    ? 'secondary'
                                                                    : 'secondary')))))) }} p-2">

                                        {{ $data->status_permintaan == '1'
                                            ? 'Pending'
                                            : ($data->status_permintaan == '2'
                                                ? 'Menunggu Persetujuan'
                                                : ($data->status_permintaan == '3'
                                                    ? 'Diterima'
                                                    : ($data->status_permintaan == '4'
                                                        ? 'Diproses'
                                                        : ($data->status_permintaan == '5'
                                                            ? 'Instalasi Selesai'
                                                            : ($data->status_permintaan == '0'
                                                                ? 'Ditolak'
                                                                : ($data->status_permintaan == '6'
                                                                    ? 'Selesai'
                                                                    : 'Selesai')))))) }}
                                    </span>
                                </td>

                                {{-- kolom keterangan diambil dari status permintaan --}}
                                @if ($data->status_permintaan == '1')
                                    <td>Menunggu tanggapan Admin</td>
                                @elseif($data->status_permintaan == '2')
                                    <td>Sedang diajukan ke manajer</td>
                                @elseif ($data->status_permintaan == '3')
                                    <td>Menunggu PC / Laptop diserahkan ke NOC</td>
                                @elseif ($data->status_permintaan == '4')
                                    <td>Unit sudah diterima, dan sedang diproses oleh Admin</td>
                                @elseif ($data->status_permintaan == '5')
                                    <td>Unit siap diambil</td>
                                @elseif ($data->status_permintaan == '6')
                                    <td>Selesai</td>
                                @elseif ($data->status_permintaan == '0')
                                    <td>Permintaan ditolak karena tidak memenuhi persyaratan</td>
                                @endif

                                <td>
                                    @if ($data->tanggal_penyelesaian != '')
                                        {{ date('Y-m-d', strtotime($data->tanggal_penyelesaian)) }}
                                        @php
                                            $tanggal_penyelesaian = \Carbon\Carbon::parse($data->tanggal_penyelesaian);
                                            $sekarang = \Carbon\Carbon::now();
                                            $selisihHari = $sekarang->diffInDays($tanggal_penyelesaian) + 1;
                                        @endphp
                                        @if ($tanggal_penyelesaian->isPast())
                                            <br> *Selesai*
                                        @else
                                            <br> *{{ $selisihHari }} Hari*
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                {{-- kolom aksi --}}
                                <td>
                                    {{-- UNTUK MENAMPILKAN VIEW CETAK FORM INSTALASI SOFTWARE --}}
                                    <div class="overlay" id="overlay_{{ $data->id_permintaan }}">
                                        <div class="iframe-container">
                                            <a id="tombol_print_{{ $data->id_permintaan }}" href="#" target="_blank"
                                                class="btn btn-sm bg-primary text-white tombol-print"
                                                title="Cetak Form Pengecekan Hardware"
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

                                    <div class="btn-group" role="group" aria-label="Tombol Aksi">
                                        <button class="btn btn-sm btn-warning rounded text-white mx-1" data-toggle="modal"
                                            data-target="#detail_permintaan_software_{{ $data->id_permintaan }}"
                                            title="Detail Permintaan"><i class="fas fa-eye"></i>
                                        </button>
                                        <button id="view_form_software_{{ $data->id_permintaan }}"
                                            class="btn btn-sm bg-primary text-white rounded print-software"
                                            title="Cetak Form Permintaan Instalasi Software"
                                            onclick="loadIframe({{ $data->id_permintaan }})"><i class="fa fa-print"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            {{-- script untuk mencegah iframe diload untuk meringankan halaman pada saat load --}}
                            <script>
                                function loadIframe(id_permintaan) {
                                    var iframe = document.getElementById("myIframe_" + id_permintaan);
                                    var iframeSrc = "/form_instalasi_software/" + id_permintaan;
                                    iframe.src = iframeSrc;
                                    iframe.style.display = "block";
                                }

                                // Event listener untuk tombol "Form Pengecekan Hardware"
                                var viewFormSoftwareButtons = document.getElementsByClassName("print-software");
                                for (var i = 0; i < viewFormSoftwareButtons.length; i++) {
                                    viewFormSoftwareButtons[i].addEventListener("click", function() {
                                        var id_permintaan = this.id.split("_")[3];
                                        loadIframe(id_permintaan);
                                    });
                                }
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

    {{-- untuk animasi expand --}}
    <script>
        $(document).ready(function() {
            $('#collapseThree').on('show.bs.collapse', function() {
                $(this).prev('#informasi_software_header').addClass('active');
                $(this).slideDown();
            });
            $('#collapseThree').on('hide.bs.collapse', function() {
                $(this).prev('#informasi_software_header').removeClass('active');
                $(this).slideUp();
            });
        });
    </script>

    @include('pegawai.modal.modal_permintaan_software')

    @if (isset($data))
        @include('pegawai.modal.lihat_permintaan_software')
    @endif
@endsection
