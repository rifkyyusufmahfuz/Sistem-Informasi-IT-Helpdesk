@foreach ($laporan_permintaan as $data)
    <!-- Modal permintaan instalasi software -->
    <div class="modal fade" id="setujui_permintaan_{{ $data->id_laporan }}" tabindex="-1" role="dialog"
        aria-labelledby="setujui_permintaan_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setujui_permintaan_label">Validasi Laporan Permintaan Periodik</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="signature_pad_manager_{{ $data->id_laporan }}">
                    <form action="/manager/crud/{{ $data->id_laporan }}" method="POST"
                        id="setujui_{{ $data->id_laporan }}" data-id-permintaan="{{ $data->id_laporan }}">
                        @csrf
                        @method('PUT')
                        <input hidden name="validasi_laporan">
                        {{-- <input hidden id="id_laporan" name="id_laporan" value="{{ $data->id_laporan }}"> --}}

                        <h5>Validasi Laporan</h5>
                        <span>Laporan permintaan periodik berikut ini akan divalidasi:</span><br>
                        <span>Nomor Permintaan: <b>{{ $data->id_laporan }}</b></span>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Periode</th>
                                        @if ($data->periode_laporan == 'harian')
                                            <th>Tanggal</th>
                                        @elseif ($data->periode_laporan == 'mingguan')
                                            <th>Tanggal Awal</th>
                                            <th>Tanggal Akhir</th>
                                        @elseif ($data->periode_laporan == 'bulanan')
                                            <th>Bulan</th>
                                        @elseif ($data->periode_laporan == 'tahunan')
                                            <th>Tahun</th>
                                        @endif
                                        <th>Status Laporan</th>
                                        <th>Dibuat oleh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Mengubah string tanggal menjadi objek Carbon
                                        $format_date = \Carbon\Carbon::parse($data->tanggal_awal);
                                    @endphp
                                    <tr>
                                        <td>{{ ucwords($data->periode_laporan) }}</td>
                                        @if ($data->periode_laporan == 'harian')
                                            <td>{{ $data->tanggal_awal }}</td>
                                        @elseif ($data->periode_laporan == 'mingguan')
                                            <td>{{ $data->tanggal_awal }}</td>
                                            <td>{{ $data->tanggal_akhir }}</td>
                                        @elseif ($data->periode_laporan == 'bulanan')
                                            {{-- tampilkan hanya bulan saja --}}
                                            <td>{{ $format_date->isoFormat('MMMM') }}</td>
                                        @elseif ($data->periode_laporan == 'tahunan')
                                            {{-- tampilkan hanya tahun --}}
                                            <td>{{ $format_date->isoFormat('Y') }}</td>
                                        @endif
                                        <td>{{ ucwords($data->status_laporan) }}</td>
                                        <td>{{ $data->nama }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- <div>
                            <button type="button" class="btn btn-sm btn-primary"><i class="fas fa-print"></i> Lihat
                                Laporan</button>
                        </div> --}}
                        <hr>
                        <div class="form-group text-center">
                            <label for="">Tanda tangan Manager</label>
                            <div>
                                <div id="catatan_ttd_manager_{{ $data->id_laporan }}">Silakan tanda tangan di area
                                    kolom ini</div>
                                <canvas onmouseover="my_function3('{{ $data->id_laporan }}')" class="form-ttd isi-ttd"
                                    id="the_canvas_manager_{{ $data->id_laporan }}" height="150px"></canvas>
                            </div>
                            <div style="margin:10px;">
                                <input type="hidden" id="ttd_manager_{{ $data->id_laporan }}"
                                    name="ttd_manager_{{ $data->id_laporan }}">
                                <button type="button" class="btn btn-danger clear-btn"
                                    data-id="{{ $data->id_laporan }}">Clear</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input konfirmasi-checkbox" type="checkbox"
                                    id="konfirmasi_{{ $data->id_laporan }}">
                                <label class="form-check-label text-justify" for="konfirmasi_{{ $data->id_laporan }}">
                                    Laporan permintaan periodik dengan nomor laporan "<b>{{ $data->id_laporan }}</b>"
                                    sudah dicek dan telah sesuai ketentuan. Laporan ini akan divalidasi.
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer p-0">
                            <button type="reset" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button disabled type="submit" class="btn btn-sm btn-primary btn-simpan"
                                id="btn-simpan">Validasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- untuk tanda tangan --}}
    <script>
        var wrapper = document.getElementById("signature_pad_manager_{{ $data->id_laporan }}");
        var clearButtons = document.getElementsByClassName("clear-btn");
        var catatan_ttd = document.getElementById("catatan_ttd_manager_{{ $data->id_laporan }}");
        var signaturePad;

        for (var i = 0; i < clearButtons.length; i++) {
            clearButtons[i].addEventListener('click', function() {
                var id_laporan = this.getAttribute('data-id');
                clearSignature(id_laporan);
            });
        }

        function clearSignature(id_laporan) {
            var canvas = document.getElementById("the_canvas_manager_" + id_laporan);
            var catatan_ttd = document.getElementById("catatan_ttd_manager_" + id_laporan);
            var context = canvas.getContext("2d");

            context.clearRect(0, 0, canvas.width, canvas.height);
            catatan_ttd.innerHTML = "Silakan tanda tangan di area kolom ini";

            // Reset value in hidden input
            document.getElementById("ttd_manager_" + id_laporan).value = "";
            signaturePad.clear();
            // Call tanda tangan function again
            initializeSignature(canvas);
        }

        //fungsi tanda tangan
        var canvasElements = document.getElementsByClassName('isi-ttd');

        for (var i = 0; i < canvasElements.length; i++) {
            initializeSignature(canvasElements[i]);
        }

        function initializeSignature(canvas) {
            // var canvas = document.getElementById("the_canvas_manager_" + id_laporan);
            signaturePad = new SignaturePad(canvas, {
                minWidth: 1,
                maxWidth: 1,
            });

            var setujuiForm = canvas.closest("form");

            setujuiForm.addEventListener('submit', function(event) {
                event.preventDefault();
                var id_laporan = this.getAttribute('data-id-permintaan');
                var dataUrl3 = canvas.toDataURL();

                if (!signaturePad.isEmpty()) {
                    setujuiForm.querySelector("#ttd_manager_" + id_laporan).value = dataUrl3;
                    setujuiForm.submit();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Tanda tangan belum diisi!',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            });
        }

        function my_function3(id_laporan) {
            var el_note = document.getElementById("catatan_ttd_manager_" + id_laporan);
            el_note.innerHTML = "";
        }

        // Tangani peristiwa "shown.bs.modal" untuk inisialisasi tanda tangan setiap kali modal ditampilkan
        $('#setujui_permintaan_{{ $data->id_laporan }}').on('shown.bs.modal', function() {
            var canvasElements = document.querySelectorAll(
                '#setujui_permintaan_{{ $data->id_laporan }} .isi-ttd');
            canvasElements.forEach(function(canvas) {
                initializeSignature(canvas);
            });
        });
    </script>

    <script>
        var checkboxes = document.getElementsByClassName('konfirmasi-checkbox');
        var submitBtns = document.getElementsByClassName('btn-simpan');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].addEventListener('change', validateForm);
        }

        function validateForm() {
            for (var k = 0; k < checkboxes.length; k++) {
                var checkbox = checkboxes[k];
                var submitBtn = submitBtns[k];

                if (checkbox.checked) {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            }
        }
    </script>
@endforeach
