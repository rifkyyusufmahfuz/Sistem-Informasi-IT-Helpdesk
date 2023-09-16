@foreach ($permintaan as $data)
    <!-- Modal permintaan instalasi software -->
    <div class="modal fade" id="detail_permintaan_software_{{ $data->id_permintaan }}" tabindex="-1" role="dialog"
        aria-labelledby="detail_permintaan_software_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detail_permintaan_software_label">Permintaan Instalasi Software</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="signature-pad">
                    <div id="detail_barang_{{ $data->id_permintaan }}">
                        <h6>Spesifikasi PC / Laptop</h6>
                        <div class="form-group">
                            <label for="kode_barang">No. Aset / Inventaris / Serial Number</label>
                            <input id="kode_barang" disabled class="form-control" value="{{ $data->kode_barang }}">
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input id="nama_barang" disabled class="form-control" value="{{ $data->nama_barang }}">
                        </div>
                        <div class="form-group">
                            <label for="prosesor">Prosesor</label>
                            <input id="prosesor" disabled class="form-control" value="{{ $data->prosesor }}">
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="ram">RAM</label>
                                <input id="ram" disabled class="form-control" value="{{ $data->ram }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="penyimpanan">Penyimpanan</label>
                                <input id="penyimpanan" disabled class="form-control" value="{{ $data->penyimpanan }}">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end my-2"
                            id="tombol_detail_barang_{{ $data->id_permintaan }}">
                            <button type="button" class="btn btn-sm btn-primary"
                                id="btn_lanjut_1{{ $data->id_permintaan }}">Lanjut <i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <div id="detail_permintaan_{{ $data->id_permintaan }}">
                        <h6>Detail Permintaan</h6>

                        <div class="form-group">
                            <label>Kategori Software</label>
                            <div class="form-control">
                                @if ($data->operating_system == 1)
                                    <span class="badge badge-primary mr-1 p-1">Sistem Operasi</span>
                                @endif
                                @if ($data->microsoft_office == 1)
                                    <span class="badge badge-primary mr-1 p-1">Microsoft Office</span>
                                @endif
                                @if ($data->software_design == 1)
                                    <span class="badge badge-primary mr-1 p-1">Software Design</span>
                                @endif
                                @if ($data->software_lainnya == 1)
                                    <span class="badge badge-primary p-1">Lainnya</span>
                                @endif
                            </div>
                        </div>
                        <?php $no = 1; ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Software</th>
                                    <th>Versi</th>
                                    <th>Catatan</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list_software->where('id_permintaan', $data->id_permintaan) as $data2)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data2->nama_software }}</td>
                                        <td>{{ $data2->versi_software }}</td>
                                        <td class="text-center">{{ $data2->notes }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label for="uraian_kebutuhan">Uraian Kebutuhan</label>
                            <textarea disabled class="form-control" rows="3">{{ $data->keluhan_kebutuhan }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end my-2"
                            id="tombol_detail_permintaan{{ $data->id_permintaan }}">
                            <button type="button" class="btn btn-sm btn-danger mr-1"
                                id="tombol_kembali{{ $data->id_permintaan }}"><i class="fas fa-arrow-left"></i>
                                Kembali</button>
                            <button type="button" class="btn btn-sm btn-primary"
                                id="btn_lanjut_2_{{ $data->id_permintaan }}">Lanjut <i
                                    class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>

                    <div id="detail_pegawai_{{ $data->id_permintaan }}">
                        <h6>Pengajuan Permintaan</h6>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="nip">NIP</label>
                                <input disabled class="form-control" value="{{ $data->nip }}">
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="nama">Nama</label>
                                <input class="form-control" value="{{ $data->nama }}" disabled>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="bagian">Bagian</label>
                                <input class="form-control" value="{{ $data->bagian }}" disabled>
                            </div>

                            <div class="form-group col-sm-7">
                                <label for="jabatan">Jabatan</label>
                                <input class="form-control" value="{{ $data->jabatan }}" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="lokasi">Lokasi</label>
                            <input class="form-control" value="{{ $data->nama_stasiun }}" disabled>
                        </div>
                        <hr>

                        <div class="form-group text-center">

                            <figcaption class="mb-2">Tanda Tangan</figcaption>
                            <div class="border rounded p-2">
                                <img class="gambar_ttd"
                                    src="{{ asset('tandatangan/instalasi_software/requestor/' . $data->ttd_requestor) }}"
                                    title="Tanda tangan {{ $data->nama }}" oncontextmenu="return false;"
                                    ondragstart="return false;">
                                <figcaption>{{ $data->nama }}</figcaption>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end my-2"
                            id="tombol_detail_pegawai_{{ $data->id_permintaan }}">
                            <button type="button" class="btn btn-sm btn-danger mr-1"
                                id="tombol_kembali_2_{{ $data->id_permintaan }}"><i class="fas fa-arrow-left"></i>
                                Kembali</button>
                        </div>

                    </div>

                    <div id="data_software">
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
                                    class="btn btn-sm bg-danger text-white tutup-form-software" title="Tutup Iframe">
                                    <i class="fas fa-times"></i>
                                </button>
                                <iframe id="myIframe_{{ $data->id_permintaan }}" src=""
                                    style="display: none;"></iframe>
                            </div>
                        </div>
                        {{-- END OF OVERLAY --}}

                    </div>

                    <div class="modal-footer d-flex justify-content-between">
                        <button id="view_form_software_{{ $data->id_permintaan }}"
                            class="btn btn-sm bg-primary text-white rounded print-form-software"
                            title="Cetak Form Permintaan Instalasi Software"
                            onclick="loadIframe({{ $data->id_permintaan }})"><i class="fa fa-print"></i> Form
                            Permintaan Instalasi Software
                        </button>
                        <button data-dismiss="modal" class="btn btn-sm bg-secondary text-white rounded">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- script untuk fungsi iframe agar diload hanya pada saat tombol print diklik --}}
    <script>
        function loadIframe(id_permintaan) {
            var iframe = document.getElementById("myIframe_" + id_permintaan);
            var iframeSrc = "/form_instalasi_software/" + id_permintaan;
            iframe.src = iframeSrc;
            iframe.style.display = "block";
        }

        // Event listener untuk tombol "Form Pengecekan Hardware"
        var viewFormSoftwareButtons = document.getElementsByClassName("print-form-software");
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

    <script>
        $(function() {
            $('#detail_permintaan_{{ $data->id_permintaan }}').hide();
            $('#detail_pegawai_{{ $data->id_permintaan }}').hide();


            $('#tombol_detail_permintaan{{ $data->id_permintaan }}').hide();
            $('#tombol_detail_pegawai_{{ $data->id_permintaan }}').hide();


            // handler untuk tombol lanjut 1
            $('#btn_lanjut_1{{ $data->id_permintaan }}').click(function() {
                $('#detail_barang_{{ $data->id_permintaan }}').hide();
                $('#tombol_detail_barang_{{ $data->id_permintaan }}').hide();

                $('#detail_permintaan_{{ $data->id_permintaan }}').show();
                $('#tombol_detail_permintaan{{ $data->id_permintaan }}').show();
            });

            // handler untuk tombol kembali 1
            $('#tombol_kembali{{ $data->id_permintaan }}').click(function() {
                $('#detail_barang_{{ $data->id_permintaan }}').show();
                $('#detail_permintaan_{{ $data->id_permintaan }}').hide();
                $('#detail_pegawai_{{ $data->id_permintaan }}').hide();

                $('#tombol_detail_barang_{{ $data->id_permintaan }}').show();
                $('#tombol_detail_permintaan{{ $data->id_permintaan }}').hide();
            });

            // handler untuk tombol lanjut 2
            $('#btn_lanjut_2_{{ $data->id_permintaan }}').click(function() {
                $('#detail_barang_{{ $data->id_permintaan }}').hide();
                $('#detail_permintaan_{{ $data->id_permintaan }}').hide();
                $('#detail_pegawai_{{ $data->id_permintaan }}').show();


                $('#tombol_detail_pegawai_{{ $data->id_permintaan }}').show();
            });

            // handler untuk tombol kembali 2
            $('#tombol_kembali_2_{{ $data->id_permintaan }}').click(function() {
                $('#detail_barang_{{ $data->id_permintaan }}').hide();
                $('#detail_permintaan_{{ $data->id_permintaan }}').show();
                $('#detail_pegawai_{{ $data->id_permintaan }}').hide();



                $('#tombol_detail_permintaan{{ $data->id_permintaan }}').show();

                $('#tombol_detail_pegawai_{{ $data->id_permintaan }}').hide();

            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Handler tombol Tutup
            $('#detail_permintaan_software_{{ $data->id_permintaan }}').on('hidden.bs.modal', function() {
                $(this).find('input[type=text]').not(
                    '#detail_pegawai_{{ $data->id_permintaan }} input[type=text]').val('');
                // $(this).find('button[type=submit]').prop('disabled', true);
                $('#detail_barang_{{ $data->id_permintaan }}').show();
                $('#detail_permintaan_{{ $data->id_permintaan }}').hide();
                $('#detail_pegawai_{{ $data->id_permintaan }}').hide();

                // hapus centang pada setiap checkbox
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
                // kosongkan textarea
                uraianKebutuhanTextarea.value = '';

                $('#btn_lanjut_1{{ $data->id_permintaan }}').prop('disabled', true);
                $('#btn_lanjut_2_{{ $data->id_permintaan }}').prop('disabled', true);
            });
        });
    </script>
@endforeach
