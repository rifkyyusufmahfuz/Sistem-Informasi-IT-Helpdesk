@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow">
        <div class="card-header pb-0">
            @foreach ($permintaan as $data)
                Pengecekan hardware untuk :
                <div class="row">
                    <div class="form-group px-3">
                        <div><b>ID Permintaan</b></div>
                        <div>{{ $data->id_permintaan }}</div>
                    </div>

                    <div class="form-group px-4">
                        <div><b>Tanggal Permintaan</b></div>
                        <div>{{ $data->tanggal_permintaan }}</div>
                    </div>

                    <div class="form-group px-4">
                        <div><b>Requestor</b></div>
                        <div>{{ $data->nama }}</div>
                    </div>

                    <div class="form-group px-4">
                        <div><b>Lokasi</b></div>
                        <div>{{ $data->nama_stasiun }}</div>
                    </div>

                    <div class="form-group px-4">
                        <div><b>Keluhan</b></div>
                        <div>{{ $data->keluhan_kebutuhan }}</div>
                    </div>
                </div>
                @if ($data->status_approval == 'revision')
                    <div class="row">
                        <div class="form-group px-3">
                            <div><b>Catatan dari Manager</b></div>
                            <div class="text-danger font-weight-bold">{{ $data->catatan }}</div>
                        </div>
                    </div>
                @else
                @endif
            @endforeach
        </div>

        <div class="card-body">
            <div class="tombol-aksi-hardsoft">
                <p class="text-danger small">*Cek hardware yang bermasalah, setelah itu ajukan hasil pengecekan ke Manajer
                    untuk divalidasi</p>
                <button class="btn btn-md btn-success  mb-3" data-bs-toggle="modal" data-bs-target="#tambah_software"><i
                        class="fas fa-plus fa-sm mr-2"></i>Cek Hardware</button>

                @foreach ($permintaan as $data)
                    <button class="btn btn-md btn-info mb-3" data-bs-toggle="modal"
                        data-bs-target="#ajukan_ke_manager_{{ $data->id_permintaan }}"
                        {{ !$isHardwareFilled ? 'disabled' : '' }}>
                        <i class="fas fa-forward fa-sm mr-2"></i>Ajukan ke Manajer
                    </button>
                @endforeach

            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Komponen</th>
                            <th>Status Komponen</th>
                            <th>Problem</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($hardware as $data2)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data2->komponen }}</td>
                                <td>{{ $data2->status_hardware }}</td>
                                <td>{{ $data2->problem }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                                        data-target="#editModal{{ $data2->id_hardware }}">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <form id="form-delete-{{ $data2->id_hardware }}"
                                        action="/admin/crud/{{ $data2->id_hardware }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="hapus_hardware">
                                        <button type="button" class="btn btn-sm btn-danger"
                                            onclick="confirmDelete('{{ $data2->id_hardware }}', 'Hapus komponen {{ $data2->komponen }}?', 'Komponen {{ $data2->komponen }} akan dihapus dari daftar pengecekan hardware pada permintaan ini.')">
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
    @include('admin.hardware.modal.cek_hardware')
    @include('admin.hardware.modal.ajukan_ke_manager')
    @include('admin.hardware.modal.edit_hardware')
@endsection
