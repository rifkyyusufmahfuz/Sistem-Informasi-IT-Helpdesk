@foreach ($permintaan as $data)
    <!-- Modal permintaan instalasi software -->
    <div class="modal fade" id="setujui_permintaan_{{ $data->id_permintaan }}" tabindex="-1" role="dialog"
        aria-labelledby="setujui_permintaan_label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="setujui_permintaan_label">Setujui Permintaan Instalasi Software</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="signature_pad_manager_{{ $data->id_permintaan }}">
                    <form action="/manager/crud/{{ $data->id_permintaan }}" method="POST"
                        id="setujui_{{ $data->id_permintaan }}" data-id-permintaan="{{ $data->id_permintaan }}">
                        @csrf
                        @method('PUT')
                        <input hidden name="otorisasi_manager" value="disetujui">
                        <input hidden id="id_permintaan" name="id_permintaan" value="{{ $data->id_permintaan }}">
                        <input hidden id="id_otorisasi" name="id_otorisasi" value="{{ $data->id_otorisasi }}">

                        <h5>Setujui Permintaan</h5>
                        <span>Permintaan instalasi software berikut ini akan disetujui:</span><br>
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
                            <label for="catatan_manager_{{ $data->id_permintaan }}">Catatan</label>
                            <textarea class="form-control catatan-manager" name="catatan_manager_{{ $data->id_permintaan }}"
                                id="catatan_manager_{{ $data->id_permintaan }}" cols="30" rows="5"></textarea>
                        </div>
                        <hr>
                        <div class="form-group text-center">
                            <label for="">Tanda tangan Manager</label>
                            <div>
                                <div id="catatan_ttd_manager_{{ $data->id_permintaan }}">Silakan tanda tangan di area
                                    kolom ini</div>
                                <canvas onmouseover="my_function3('{{ $data->id_permintaan }}')"
                                    class="form-ttd isi-ttd" id="the_canvas_manager_{{ $data->id_permintaan }}"
                                    height="150px"></canvas>
                            </div>
                            <div style="margin:10px;">
                                <input type="hidden" id="ttd_manager_{{ $data->id_permintaan }}"
                                    name="ttd_manager_{{ $data->id_permintaan }}">
                                <button type="button" class="btn btn-danger clear-btn"
                                    data-id="{{ $data->id_permintaan }}">Clear</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input konfirmasi-checkbox" type="checkbox"
                                    id="konfirmasi_{{ $data->id_permintaan }}">
                                <label class="form-check-label text-justify"
                                    for="konfirmasi_{{ $data->id_permintaan }}">
                                    Setujui permintaan <b>{{ $data->id_permintaan }}</b> dan akan diteruskan ke Admin
                                    untuk melanjutkan proses instalasi.
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer p-0">
                            <button type="reset" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button disabled type="submit" class="btn btn-sm btn-primary btn-simpan"
                                id="btn-simpan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- untuk tanda tangan --}}
    <script>
        var wrapper = document.getElementById("signature_pad_manager_{{ $data->id_permintaan }}");
        var clearButtons = document.getElementsByClassName("clear-btn");
        var catatan_ttd = document.getElementById("catatan_ttd_manager_{{ $data->id_permintaan }}");
        var signaturePad;

        for (var i = 0; i < clearButtons.length; i++) {
            clearButtons[i].addEventListener('click', function() {
                var id_permintaan = this.getAttribute('data-id');
                clearSignature(id_permintaan);
            });
        }

        function clearSignature(id_permintaan) {
            var canvas = document.getElementById("the_canvas_manager_" + id_permintaan);
            var catatan_ttd = document.getElementById("catatan_ttd_manager_" + id_permintaan);
            var context = canvas.getContext("2d");

            context.clearRect(0, 0, canvas.width, canvas.height);
            catatan_ttd.innerHTML = "Silakan tanda tangan di area kolom ini";

            // Reset value in hidden input
            document.getElementById("ttd_manager_" + id_permintaan).value = "";
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
            // var canvas = document.getElementById("the_canvas_manager_" + id_permintaan);
            signaturePad = new SignaturePad(canvas, {
                minWidth: 1,
                maxWidth: 1,
            });

            var setujuiForm = canvas.closest("form");

            setujuiForm.addEventListener('submit', function(event) {
                event.preventDefault();
                var id_permintaan = this.getAttribute('data-id-permintaan');
                var dataUrl3 = canvas.toDataURL();

                if (!signaturePad.isEmpty()) {
                    setujuiForm.querySelector("#ttd_manager_" + id_permintaan).value = dataUrl3;
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

        function my_function3(id_permintaan) {
            var el_note = document.getElementById("catatan_ttd_manager_" + id_permintaan);
            el_note.innerHTML = "";
        }

        // Tangani peristiwa "shown.bs.modal" untuk inisialisasi tanda tangan setiap kali modal ditampilkan
        $('#setujui_permintaan_{{ $data->id_permintaan }}').on('shown.bs.modal', function() {
            var canvasElements = document.querySelectorAll(
                '#setujui_permintaan_{{ $data->id_permintaan }} .isi-ttd');
            canvasElements.forEach(function(canvas) {
                initializeSignature(canvas);
            });
        });
    </script>

    <script>
        var checkboxes = document.getElementsByClassName('konfirmasi-checkbox');
        var textareas = document.getElementsByClassName('catatan-manager');
        var submitBtns = document.getElementsByClassName('btn-simpan');

        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].addEventListener('change', validateForm);
        }

        for (var j = 0; j < textareas.length; j++) {
            textareas[j].addEventListener('input', validateForm);
        }

        function validateForm() {
            for (var k = 0; k < checkboxes.length; k++) {
                var checkbox = checkboxes[k];
                var textarea = textareas[k];
                var submitBtn = submitBtns[k];

                if (checkbox.checked && textarea.value.trim() !== '') {
                    submitBtn.disabled = false;
                } else {
                    submitBtn.disabled = true;
                }
            }
        }
    </script>
@endforeach
