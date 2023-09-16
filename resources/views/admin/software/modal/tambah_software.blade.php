<!-- Modal add Software -->
<div class="modal fade" id="tambah_software" tabindex="-1" aria-labelledby="tambah_software" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title">Tambah Software</h4>
                    <button type="button red" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>

            <div class="modal-body">
                <form action="/admin/crud" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="id_permintaan"
                            value="{{ old('id_permintaan', $data->id_permintaan) }}" hidden>
                        <label for="nama_software">Software</label>
                        <select required class="form-control @error('nama_software') is-invalid @enderror"
                            name="nama_software" id="nama_software">
                            <option selected disabled value="">-- Pilih Software --</option>
                            @foreach ($list_software as $option)
                                <option value="{{ $option }}" @if (old('nama_software') == $option) selected @endif>
                                    {{ $option }}</option>
                            @endforeach
                        </select>
                        @error('nama_software')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="versi_software">Versi Software</label>
                        <input required class="form-control @error('versi_software') is-invalid @enderror"
                            type="text" name="versi_software" id="versi_software"
                            value="{{ old('versi_software') }}">
                        @error('versi_software')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label for="notes">*Catatan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" cols="20"
                            rows="5">{{ old('notes') }}</textarea>
                        <span class="small">*Kosongkan apabila tidak ada catatan</span>
                        @error('notes')
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
<?php $listError = ['nama_software', 'versi_software', 'notes']; ?>
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
