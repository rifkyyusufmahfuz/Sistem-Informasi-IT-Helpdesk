@foreach ($permintaan as $data)
    <!-- Modal permintaan instalasi software -->
    <div class="modal fade" id="tolak_permintaan_{{ $data->id_permintaan }}" tabindex="-1" role="dialog"
        aria-labelledby="tolak_permintaan_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tolak_permintaan_label">Tolak Permintaan Instalasi Software</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="signature_pad_manager_2_{{ $data->id_permintaan }}">
                    <form action="/manager/crud/{{ $data->id_permintaan }}" method="POST"
                        id="tolak_{{ $data->id_permintaan }}" data-id-permintaan-2="{{ $data->id_permintaan }}">
                        @csrf
                        @method('PUT')
                        <input hidden name="otorisasi_manager" value="ditolak">
                        <input hidden id="id_permintaan" name="id_permintaan" value="{{ $data->id_permintaan }}">
                        <input hidden id="id_otorisasi" name="id_otorisasi" value="{{ $data->id_otorisasi }}">
                        <input hidden name="kode_barang" value="{{ $data->kode_barang }}">

                        <h5>Tolak Permintaan</h5>
                        <span>Permintaan instalasi software berikut ini akan ditolak:</span><br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Software</th>
                                    <th>Versi</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
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
                        <p class="text-center">Nomor Permintaan: <b>{{ $data->id_permintaan }}</b></p>
                        <hr>
                        <div class="form-group text-center">
                            <label for="catatan_manager_2_{{ $data->id_permintaan }}">Catatan</label>
                            <textarea class="form-control catatan-manager-2" name="catatan_manager_2_{{ $data->id_permintaan }}"
                                id="catatan_manager_2_{{ $data->id_permintaan }}" cols="30" rows="5"></textarea>
                        </div>
                        <hr>
                        <div class="form-group text-center">
                            <label for="">Tanda tangan Manager</label>
                            <div>
                                <div id="catatan_ttd_manager_2_{{ $data->id_permintaan }}">Silakan tanda tangan di area
                                    kolom ini</div>
                                <canvas onmouseover="my_function4('{{ $data->id_permintaan }}')"
                                    class="form-ttd isi-ttd-2" id="the_canvas_manager_2_{{ $data->id_permintaan }}"
                                    height="150px"></canvas>
                            </div>
                            <div style="margin:10px;">
                                <input type="hidden" id="ttd_manager_2_{{ $data->id_permintaan }}"
                                    name="ttd_manager_2_{{ $data->id_permintaan }}">
                                <button type="button" class="btn btn-danger clear-btn-2"
                                    data-id-clear_2="{{ $data->id_permintaan }}">Clear</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input konfirmasi-checkbox-2" type="checkbox"
                                    id="konfirmasi_tolak{{ $data->id_permintaan }}">
                                <label class="form-check-label text-justify"
                                    for="konfirmasi_tolak{{ $data->id_permintaan }}">
                                    Tolak permintaan <b>{{ $data->id_permintaan }}</b> dan akan mengakhiri permintaan
                                    dengan status ditolak.
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer p-0">
                            <button type="reset" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button disabled type="submit" class="btn btn-sm btn-primary btn-simpan-2"
                                id="btn-simpan-2">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- untuk tanda tangan --}}
    <script>
        var wrapper = document.getElementById("signature_pad_manager_2_{{ $data->id_permintaan }}");
        var clearButtons_2 = document.getElementsByClassName("clear-btn-2");
        var catatan_ttd = document.getElementById("catatan_ttd_manager_2_{{ $data->id_permintaan }}");
        var signaturePad_2;

        for (var i = 0; i < clearButtons_2.length; i++) {
            clearButtons_2[i].addEventListener('click', function() {
                var id_permintaan = this.getAttribute('data-id-clear_2');
                clearSignature_2(id_permintaan);
            });
        }

        function clearSignature_2(id_permintaan) {
            var canvas = document.getElementById("the_canvas_manager_2_" + id_permintaan);
            var catatan_ttd = document.getElementById("catatan_ttd_manager_2_" + id_permintaan);
            var context = canvas.getContext("2d");

            context.clearRect(0, 0, canvas.width, canvas.height);
            catatan_ttd.innerHTML = "Silakan tanda tangan di area kolom ini";

            // Reset value in hidden input
            document.getElementById("ttd_manager_2_" + id_permintaan).value = "";
            signaturePad_2.clear();
            // Call tanda tangan function again
            initializeSignature_2(canvas);
        }

        //fungsi tanda tangan
        var canvasElements = document.getElementsByClassName('isi-ttd-2');

        for (var i = 0; i < canvasElements.length; i++) {
            initializeSignature_2(canvasElements[i]);
        }

        function initializeSignature_2(canvas) {
            // var canvas = document.getElementById("the_canvas_manager_2_" + id_permintaan);
            signaturePad_2 = new SignaturePad(canvas, {
                minWidth: 1,
                maxWidth: 1,
            });

            var tolakForm = canvas.closest("form");

            tolakForm.addEventListener('submit', function(event) {
                event.preventDefault();
                var id_permintaan = this.getAttribute('data-id-permintaan-2');
                var dataUrl3 = canvas.toDataURL();

                if (!signaturePad_2.isEmpty()) {
                    tolakForm.querySelector("#ttd_manager_2_" + id_permintaan).value = dataUrl3;
                    tolakForm.submit();
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

        function my_function4(id_permintaan) {
            var el_note = document.getElementById("catatan_ttd_manager_2_" + id_permintaan);
            el_note.innerHTML = "";
        }

        // Tangani peristiwa "shown.bs.modal" untuk inisialisasi tanda tangan setiap kali modal ditampilkan
        $('#tolak_permintaan_{{ $data->id_permintaan }}').on('shown.bs.modal', function() {
            var canvasElements = document.querySelectorAll(
                '#tolak_permintaan_{{ $data->id_permintaan }} .isi-ttd-2');
            canvasElements.forEach(function(canvas) {
                initializeSignature_2(canvas);
            });
        });
    </script>

    <script>
        var checkboxes_2 = document.getElementsByClassName('konfirmasi-checkbox-2');
        var textareas_2 = document.getElementsByClassName('catatan-manager-2');
        var submitBtns_2 = document.getElementsByClassName('btn-simpan-2');

        for (var i = 0; i < checkboxes_2.length; i++) {
            checkboxes_2[i].addEventListener('change', validateForm_2);
        }

        for (var j = 0; j < textareas_2.length; j++) {
            textareas_2[j].addEventListener('input', validateForm_2);
        }

        function validateForm_2() {
            for (var k = 0; k < checkboxes_2.length; k++) {
                var checkbox_2 = checkboxes_2[k];
                var textarea_2 = textareas_2[k];
                var submitBtn_2 = submitBtns_2[k];

                if (checkbox_2.checked && textarea_2.value.trim() !== '') {
                    submitBtn_2.disabled = false;
                } else {
                    submitBtn_2.disabled = true;
                }
            }
        }
    </script>
@endforeach
