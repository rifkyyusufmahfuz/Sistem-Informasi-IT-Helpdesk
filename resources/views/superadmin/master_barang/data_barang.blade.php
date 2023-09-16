@extends('layouts.main')

@section('contents')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-3">
                    <div class="row">
                        <h4 class="card-title mx-2">Data Barang</h4>
                        <p class="small text-gray-800">Daftar barang terinput di sistem</p>
                    </div>
                </div>
                <div class="row ml-2 mt-2">
                    <div class="col-md-12">
                        <button type="button" class="btn-primary btn-sm float-left" data-bs-toggle="modal"
                            data-bs-target="#modalTambahBarang">
                            <i class="fa fa-user-plus"></i> Tambah Barang
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Status Barang</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($data_barang as $data)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $data->kode_barang }}</td>
                                        <td>{{ $data->nama_barang }}</td>
                                        <td>{{ ucwords($data->status_barang) }}</td>

                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                                data-bs-target="#modal_detail_barang{{ $data->kode_barang }}"><i
                                                    class="fa fa-eye"></i>
                                            </button>

                                            <button class="btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                                data-bs-target="#modal_update_barang{{ $data->kode_barang }}"><i
                                                    class="fa fa-edit"></i>
                                            </button>
                                            <form id="form-delete-{{ $data->kode_barang }}"
                                                action="/superadmin/crud/{{ $data->kode_barang }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="hapus_barang" id="hapus_barang">
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ $data->kode_barang }}', 'Hapus data {{ $data->nama_barang }}?', 'Menghapus data barang akan menghapus permintaan yang terkait pada barang ini!')">
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

    @include('superadmin.master_barang.modal.detail_barang')
    @include('superadmin.master_barang.modal.input_barang')
    @include('superadmin.master_barang.modal.update_barang')
@endsection
