<!-- Modal -->
@foreach ($software as $data2)
    <div class="modal fade" id="editModal{{ $data2->id_software }}" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel{{ $data2->id_software }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $data2->id_software }}">Update Software</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-edit-{{ $data2->id_software }}" action="/admin/crud/{{ $data2->id_software }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_software">Software</label>
                            <input type="text" class="form-control" id="nama_software" name="nama_software"
                                value="{{ $data2->nama_software }}" readonly>
                        </div>

                        <div class="form-group mt-3">
                            <label for="versi_software_update">Versi Software</label>
                            <input required class="form-control @error('versi_software_update') is-invalid @enderror"
                                type="text" name="versi_software_update" id="versi_software_update"
                                value="{{ $data2->versi_software }}">
                            @error('versi_software_update')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mt-3">
                            <label for="notes_update">*Catatan</label>
                            <textarea class="form-control @error('notes_update') is-invalid @enderror" name="notes_update" id="notes_update"
                                cols="20" rows="5">{{ $data2->notes }}</textarea>
                            <span class="small">*Kosongkan apabila tidak ada catatan</span>
                            @error('notes_update')
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

<?php $listError = ['versi_software_update', 'notes_update']; ?>
@foreach ($listError as $err)
    @error($err)
        <script type="text/javascript">
            Swal.fire({
                toast: true,
                icon: 'error',
                title: 'Update Gagal!',
                text: '{{ $message }}',

                animation: true,
                position: 'top-right',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 6000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
    @break
@enderror
@endforeach
