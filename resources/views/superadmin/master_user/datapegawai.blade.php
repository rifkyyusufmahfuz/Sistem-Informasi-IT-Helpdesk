@extends('layouts.main')

@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-3">
                    <div class="row">
                        <h4 class="card-title mx-2">Data Pegawai</h4>
                        <p class="small text-gray-800">Daftar pegawai terdaftar di sistem</p>
                    </div>
                </div>
                <div class="row ml-2 mt-2">
                    <div class="col-md-12">
                        <button type="button" class="btn-primary btn-sm float-left" data-bs-toggle="modal"
                            data-bs-target="#modalTambahPegawai">
                            <i class="fa fa-user-plus"></i> Tambah Data Pegawai
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>NIPP</th>
                                    <th>Nama</th>
                                    <th>Bagian</th>
                                    <th>Jabatan</th>
                                    <th>Lokasi</th>
                                    <th class="text-center">Akses Sistem</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data_pegawai as $pegawai)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $pegawai->nip }}</td>
                                        <td>{{ $pegawai->nama }}</td>
                                        <td>{{ $pegawai->bagian }}</td>
                                        <td>{{ $pegawai->jabatan }}</td>
                                        <td>{{ $pegawai->nama_stasiun }}</td>
                                        <td class="text-center">
                                            @if ($pegawai->status != false)
                                                <i class="fas fa-check text-success"></i>
                                            @else
                                                <i class="fas fa-times text-danger"></i>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-warning text-white mr-1"
                                                    data-bs-toggle="modal" title="Update data pegawai"
                                                    data-bs-target="#modal_update_pegawai{{ $pegawai->nip }}"><i
                                                        class="fa fa-edit"></i>
                                                </button>
                                                <form id="form-delete-{{ $pegawai->nip }}"
                                                    action="/superadmin/crud/{{ $pegawai->nip }}" method="POST"
                                                    style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="hapus_pegawai" id="hapus_pegawai">
                                                    <button type="button" class="btn btn-sm btn-danger" title="Hapus data pegawai"
                                                        onclick="confirmDelete('{{ $pegawai->nip }}', 'Hapus data pegawai ini?', 'Data pegawai {{ $pegawai->nama }} ({{ $pegawai->nip }}) termasuk akun user pegawai ini akan dihapus!')">
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

    @include('superadmin.modal.input_pegawai')
    @include('superadmin.modal.update_datapegawai')
@endsection
