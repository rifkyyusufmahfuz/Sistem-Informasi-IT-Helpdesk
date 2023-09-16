@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h4 class="card-title mx-2">Informasi Permintaan</h4>
                <p class="small text-gray-800">Permintaan yang telah divalidasi & diotorisasi Manajer</p>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Otorisasi / Validasi</th>
                            <th>Tanggal Otorisasi / Validasi</th>
                            <th>ID Permintaan</th>
                            <th>Tipe Permintaan</th>
                            <th>Catatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN TINDAK LANJUT --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($data_tindaklanjut as $data)
                            <tr>
                                <td>{{ $data->id_otorisasi }}</td>
                                <td>{{ $data->otorisasi_created_at }}</td>
                                <td>{{ $data->id_permintaan }}</td>
                                <td>{{ $data->tipe_permintaan }}</td>
                                <td>{{ $data->catatan }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-warning rounded text-white mr-1" data-toggle="modal"
                                            data-target="#detail_otorisasi{{ $data->id_otorisasi }}"
                                            title="Detail Permintaan"><i class="fas fa-eye"></i>
                                        </button>

                                        <form id="form-delete-{{ $data->id_otorisasi }}"
                                            action="/superadmin/crud/{{ $data->id_otorisasi }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <input hidden name="hapus_otorisasi" id="hapus_otorisasi">
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('{{ $data->id_otorisasi }}', 'Hapus data otorisasi ini?', 'Menghapus data otorisasi akan menghapus data permintaan, tindak lanjut Admin/Executor, BAST Barang, dan data terkait lainnya.')">
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
        @include('superadmin.transaksi_otorisasi.modal.detail_otorisasi')
    @endif
@endsection
