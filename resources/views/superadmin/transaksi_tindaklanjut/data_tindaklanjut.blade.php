@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h4 class="card-title mx-2">Tindak Lanjut</h4>
                <p class="small text-gray-800">Daftar tindak lanjut permintaan layanan</p>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Tindak Lanjut</th>
                            <th>ID Permintaan</th>
                            <th>Tanggal Penanganan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN TINDAK LANJUT --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($data_tindaklanjut as $data)
                            <tr>
                                <td>{{ $data->id_tindak_lanjut }}</td>
                                <td>{{ $data->id_permintaan }}</td>
                                <td>{{ $data->tanggal_penanganan }}</td>

                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-warning rounded text-white mr-1" data-toggle="modal"
                                            data-target="#detail_tindaklanjut{{ $data->id_tindak_lanjut }}"
                                            title="Detail Permintaan"><i class="fas fa-eye"></i>
                                        </button>

                                        <form id="form-delete-{{ $data->id_tindak_lanjut }}"
                                            action="/superadmin/crud/{{ $data->id_tindak_lanjut }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <input hidden name="hapus_tindaklanjut" id="hapus_tindaklanjut">
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('{{ $data->id_tindak_lanjut }}', 'Hapus data tindak lanjut ini?', 'Menghapus data tindak lanjut akan menghapus data yang terkait pada tindak lanjut ini dan Admin harus menindaklanjuti ulang permintaan.')">
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

    @if (isset($data))
        @include('superadmin.transaksi_tindaklanjut.modal.detail_tindaklanjut')
    @endif
@endsection
