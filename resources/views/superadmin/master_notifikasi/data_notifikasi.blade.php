@extends('layouts.main')

@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-3">
                    <div class="row">
                        <h4 class="card-title mx-2">Data Notifikasi</h4>
                        <p class="small text-gray-800">Daftar notifikasi sistem</p>
                    </div>
                </div>
                <div class="row ml-2 mt-2">
                    <div class="col-md-12">
                        <button type="button" class="btn-primary btn-sm float-left" data-toggle="modal"
                            data-target="#modalTambahPegawai">
                            <i class="fa fa-user-plus"></i> Kirim Notifikasi
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Isi Pesan</th>
                                    <th>Tautan</th>
                                    <th>Dikirim</th>
                                    <th>Dibaca</th>
                                    <th>Tujuan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data_notifikasi as $data)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data->pesan }}</td>
                                        <td>{{ $data->tautan }}</td>
                                        <td>{{ $data->created_at }}</td>
                                        <td>{{ $data->read_at }}</td>
                                        <td>{{ $data->user_id }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                                data-bs-target="#modal_update_pegawai{{ $data->id_notifikasi }}"><i
                                                    class="fa fa-edit"></i>
                                            </button>
                                            <form id="form-delete-{{ $data->id_notifikasi }}"
                                                action="/superadmin/crud/{{ $data->id_notifikasi }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="hapus_notifikasi" id="hapus_notifikasi">
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirm_delete_pegawai('{{ $data->id_notifikasi }}')">
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
@endsection
