@extends('layouts.main')

@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-3">
                    <div class="row">
                        <h4 class="card-title mx-2">Data User Aktif</h4>
                        <p class="small text-gray-800">Daftar user aktif</p>
                    </div>
                </div>
                <div class="row ml-2 mt-2">
                    <div class="col-md-12">
                        <div class="1">
                            <button class="btn-sm btn-primary float-left mr-2" data-bs-toggle="modal"
                                data-bs-target="#modalTambahUser">
                                <i class="fa fa-user-plus"></i> Tambah User
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>NIPP</th>
                                    <th>Nama</th>
                                    <th class="text-center">Akses Sistem</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data_user as $user)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucwords($user->nama_role) }}</td>
                                        <td>{{ $user->nip }}</td>
                                        <td>{{ $user->nama }}</td>
                                        <td class="text-center">
                                            @if ($user->status != false)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                {{-- tombol edit --}}
                                                <button type="button" class="btn-sm btn-warning text-white"
                                                    data-bs-toggle="modal" title="Update data user"
                                                    data-bs-target="#modalEditUser{{ $user->id }}"><i
                                                        class="fa fa-edit"></i>
                                                </button>
                                                {{-- tombol edit password --}}
                                                <button type="button" class="btn-sm btn-warning text-white"
                                                    data-bs-toggle="modal" title="Update password"
                                                    data-bs-target="#modalEditPassword{{ $user->id }}">
                                                    <i class="fa fa-key"></i>
                                                </button>
                                            </div>

                                            {{-- tombol view --}}
                                            <div class="btn-group">
                                                <button title="Lihat data pegawai"
                                                    class="btn-sm btn-info text-white tombol_lihat_data"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#modal_lihat_data{{ $user->id }}"
                                                    data-id="{{ $user->id }}">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>

                                            <div class="btn-group">
                                                {{-- tombol disable user --}}
                                                <form id="disable_user-{{ $user->id }}"
                                                    action="/superadmin/crud/{{ $user->id }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="aktivasi" value="0">
                                                    <button type="button" class="btn-sm btn-danger"
                                                        title="Nonaktifkan user"
                                                        onclick="disable_user('{{ $user->id }}')">
                                                        <i class="fas fa-user-times"></i>
                                                    </button>
                                                </form>

                                                {{-- tombol hapus user --}}
                                                <form id="form-delete-{{ $user->id }}"
                                                    action="/superadmin/crud/{{ $user->id }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="hapus_user" id="hapus_user">
                                                    <button type="button" class="btn-sm btn-danger" title="Hapus data"
                                                        onclick="confirmDelete('{{ $user->id }}', 'Hapus data user ini?', 'Data user {{ $user->nama }} ({{ $user->email }}) akan dihapus!')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('superadmin.modal.update_password_user')
    @include('superadmin.modal.update_datauser')
    @include('superadmin.modal.input_user')
    @include('superadmin.modal.lihat_data')
@endsection
