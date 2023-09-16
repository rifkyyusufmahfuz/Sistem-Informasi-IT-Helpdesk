@foreach ($data_user as $user)
    <div class="modal fade" id="modalEditPassword{{ $user->id }}" tabindex="-1" role="dialog"
        aria-labelledby="modalEditPassword{{ $user->id }}Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPassword{{ $user->id }}Title">Update Password User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/superadmin/crud/{{ $user->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="ganti_password">Password Baru</label>
                            <input type="password" name="ganti_password" id="ganti_password" class="form-control"
                                required>
                            @error('ganti_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="konfirmasi_password2">Konfirmasi Password</label>
                            <input type="password" name="konfirmasi_password2" id="konfirmasi_password2"
                                class="form-control" required>
                            @error('konfirmasi_password2')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<?php $listError = ['ganti_password', 'konfirmasi_password2']; ?>
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
