@foreach ($data_user as $user)
    <div class="modal fade" id="modalEditUser{{ $user->id }}" tabindex="-1" role="dialog"
        aria-labelledby="modalEditUser{{ $user->id }}Title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUser{{ $user->id }}Title">Update Data User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/superadmin/crud/{{ $user->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{-- <input type="hidden" name="jenis_update" value="update_data"> --}}
                        <div class="form-group">
                            <label for="email2">Email</label>
                            <input type="email" name="email2" id="email2" class="form-control"
                                value="{{ $user->email }}" required>
                            @error('email2')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" class="form-control" required>
                                @foreach ($data_role as $role)
                                    <option value="{{ $role->id_role }}"
                                        @if ($user->id_role == $role->id_role) selected @endif>
                                        {{ ucwords($role->nama_role) }}</option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<?php $listError = ['email2', 'role']; ?>
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
