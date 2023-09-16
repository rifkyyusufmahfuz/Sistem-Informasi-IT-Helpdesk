<!-- Modal add Software -->
<div class="modal fade" id="tambah_software" tabindex="-1" aria-labelledby="tambah_software" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title">Cek Hardware</h4>
                    <button type="button red" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>

            <div class="modal-body">
                <form action="/admin/crud" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="id_permintaan" value="{{ $data->id_permintaan }}" hidden>
                        <label for="komponen">Komponen</label>
                        <select required class="form-control @error('komponen') is-invalid @enderror" name="komponen"
                            id="komponen">
                            <option selected disabled value="">-- Pilih Komponen --</option>
                            @foreach ($list_hardware as $option)
                                <option value="{{ $option }}" @if (old('komponen') == $option) selected @endif>
                                    {{ $option }}</option>
                            @endforeach
                        </select>
                        @error('komponen')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="status_hardware">Status Hardware</label> <br>
                        <div class="form-check-inline">
                            <input required class="form-check-input @error('status_hardware') is-invalid @enderror"
                                type="radio" name="status_hardware" id="status_hardware_ok" value="OK"
                                {{ old('status_hardware') === 'OK' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_hardware_ok">OK</label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input @error('status_hardware') is-invalid @enderror"
                                type="radio" name="status_hardware" id="status_hardware_nok" value="NOK"
                                {{ old('status_hardware') === 'NOK' ? 'checked' : '' }}>
                            <label class="form-check-label" for="status_hardware_nok">NOK</label>
                        </div>
                        @error('status_hardware')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="problem">*Problem</label>
                        <textarea class="form-control @error('problem') is-invalid @enderror" name="problem" id="problem" cols="20"
                            rows="5">{{ old('problem') }}</textarea>
                        <span class="small">*Kosongkan apabila tidak ada problem</span>
                        @error('problem')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="modal-footer p-1">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- Perulangan untuk cek error --}}
<?php $listError = ['komponen', 'status_hardware', 'problem']; ?>
@foreach ($listError as $err)
    @error($err)
        <script type="text/javascript">
            window.onload = function() {
                OpenBootstrapPopup();
            };

            function OpenBootstrapPopup() {
                $("#tambah_software").modal('show');
            }
        </script>
    @break
@enderror
@endforeach
