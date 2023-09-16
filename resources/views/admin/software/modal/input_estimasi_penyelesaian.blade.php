@foreach ($permintaan as $data)
    <!-- Modal -->
    <div class="modal fade" id="estimasi_penyelesaian_{{ $data->id_permintaan }}" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="estimasi_penyelesaian_{{ $data->id_permintaan }}Label">Estimasi
                        Penyelesaian
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6 class="modal-title mb-2">
                        Estimasi Penyelesaian
                        @if (Request::is('admin/permintaan_software*'))
                            Instalasi Software
                        @elseif(Request::is('admin/permintaan_hardware*'))
                            Pengecekan Hardware
                        @endif
                    </h6>



                    <form method="POST" action="/admin/crud/{{ $data->id_permintaan }}">
                        @csrf
                        @method('PUT')
                        <input hidden name="estimasi_penyelesaian" id="estimasi_penyelesaian" value="software">
                        <div class="form-group">
                            <input class="form-control" type="date" name="tanggal_penyelesaian"
                                value="{{ $data->tanggal_penyelesaian ? date('Y-m-d', strtotime($data->tanggal_penyelesaian)) : '' }}"
                                id="tanggal_penyelesaian_{{ $data->id_permintaan }}" min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" id="btn_close_estimasi_{{ $data->id_permintaan }}"
                                class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            {{-- <button id="submit_estimasi_{{ $data->id_permintaan }}" type="submit"
                                class="btn btn-sm btn-primary">Simpan</button> --}}
                            <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        $(document).ready(function() {
            const tanggalInput = document.getElementById('tanggal_penyelesaian_{{ $data->id_permintaan }}');
            const tombolSimpan = document.getElementById('submit_estimasi_{{ $data->id_permintaan }}');

            tanggalInput.addEventListener('change', function() {
                const selectedDate = new Date(tanggalInput.value);
                // const today = new Date();

                if (tanggalInput.value != '') {
                    tombolSimpan.disabled = false;
                } else {
                    tombolSimpan.disabled = true;
                }
            });

            tanggalInput.dispatchEvent(new Event('change'));
        });
    </script> --}}


    {{-- <script>
        $("#submit_estimasi_{{ $data->id_permintaan }}").prop("disabled", true);

        function toggleSubmitButton() {
            var tanggal = $("#tanggal_penyelesaian_{{ $data->id_permintaan }}").val();

            // Periksa kondisi dan atur status tombol "Submit"
            if ((tanggal !== "")) {
                $("#submit_estimasi_{{ $data->id_permintaan }}").prop("disabled", false);
            } else {
                $("#submit_estimasi_{{ $data->id_permintaan }}").prop("disabled", true);
            }
        }

        // Tampilkan opsi filter yang sesuai berdasarkan jenis filter yang dipilih
        $(document).ready(function() {


            $("#tanggal_{{ $data->id_permintaan }}").change(function() {
                toggleSubmitButton(); // Panggil fungsi untuk memeriksa kondisi tombol "Submit"

            });

            $("#btn_close_estimasi_{{ $data->id_permintaan }}").click(function() {
                $("#submit_estimasi_{{ $data->id_permintaan }}").prop("disabled", true);
            });
        });
    </script> --}}
@endforeach
