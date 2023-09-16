<!-- Modal -->
@foreach ($hardware as $data2)
    <div class="modal fade" id="editModal{{ $data2->id_hardware }}" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel{{ $data2->id_hardware }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $data2->id_hardware }}">Update Hardware</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-edit-{{ $data2->id_hardware }}" action="/admin/crud/{{ $data2->id_hardware }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Isi form edit software di sini -->

                        <!-- Tambahkan input fields untuk mengedit software -->
                        <div class="form-group">
                            <label for="komponen">Komponen</label>
                            <input type="text" class="form-control" id="komponen" name="komponen"
                                value="{{ $data2->komponen }}" readonly>
                        </div>

                        <div class="form-group mt-3">
                            <label for="status_hardware">Status Komponen</label> <br>
                            <div class="form-check-inline">
                                <input class="form-check-input @error('status_hardware') is-invalid @enderror"
                                    type="radio" name="status_hardware" id="OK" value="OK"
                                    {{ $data2->status_hardware == 'OK' ? 'checked' : '' }}>
                                <label class="form-check-label" for="OK">OK</label>
                            </div>
                            <div class="form-check-inline">
                                <input class="form-check-input @error('status_hardware') is-invalid @enderror"
                                    type="radio" name="status_hardware" id="NOK" value="NOK"
                                    {{ $data2->status_hardware == 'NOK' ? 'checked' : '' }}>
                                <label class="form-check-label" for="NOK">NOK</label>
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
                                rows="5">{{ $data2->problem }}</textarea>
                            <span class="small">*Kosongkan apabila tidak ada problem</span>
                            @error('problem')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endforeach
