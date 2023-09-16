@extends('layouts.main')

@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-3">
                    <div class="row">
                        <h4 class="card-title mx-2">Data Stasiun</h4>
                        <p class="small text-gray-800">Daftar stasiun terdaftar di sistem</p>
                    </div>
                </div>
                <div class="row ml-2 mt-2">
                    <div class="col-md-12">
                        <button type="button" class="btn-primary btn-sm float-left" data-bs-toggle="modal"
                            data-bs-target="#modalTambahStasiun">
                            <i class="fa fa-plus"></i> Tambah Stasiun
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>ID Stasiun</th>
                                    <th>Nama Stasiun</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data_stasiun as $data)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data->id_stasiun }}</td>
                                        <td>{{ $data->nama_stasiun }}</td>
                                        <td class="text-center">
                                            <button title="Update Stasiun" class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                                data-bs-target="#modal_update_stasiun{{ $data->id_stasiun }}"><i
                                                    class="fa fa-edit"></i>
                                            </button>
                                            <form id="form-delete-{{ $data->id_stasiun }}"
                                                action="/superadmin/crud/{{ $data->id_stasiun }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="hapus_stasiun" id="hapus_stasiun">
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ $data->id_stasiun }}', 'Hapus data stasiun {{ $data->nama_stasiun }}?','Data stasiun {{ $data->nama_stasiun }} akan dihapus!')">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
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

    @include('superadmin.master_stasiun.modal.input_stasiun')
    @include('superadmin.master_stasiun.modal.update_stasiun')
@endsection
