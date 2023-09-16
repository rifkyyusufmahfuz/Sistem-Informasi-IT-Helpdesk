@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h4 class="card-title mx-2">Permintaan Pengecekan Hardware</h4>
                <p class="small text-gray-800">Daftar permintaan pengecekan hardware</p>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Permintaan</th>
                            <th>Waktu Pengajuan</th>
                            <th>Keluhan</th>
                            {{-- <th>Nama Pegawai</th> --}}
                            <th>Status Validasi</th>
                            <th class="text-center">Status Permintaan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody>
                        <?php $no = 1; ?>
                        @foreach ($permintaan as $data)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->id_permintaan }}</td>
                                <td>{{ $data->permintaan_created_at }}</td>
                                <td>{{ $data->keluhan_kebutuhan }}</td>
                                {{-- <td>{{ $data->keluhan_kebutuhan }}</td> --}}
                                {{-- <td>{{ $data->nama }}</td> --}}
                                <td>
                                    <span
                                        class="badge badge-{{ $data->status_approval == 'pending'
                                            ? 'danger'
                                            : ($data->status_approval == 'waiting'
                                                ? 'warning'
                                                : ($data->status_approval == 'approved'
                                                    ? 'success'
                                                    : ($data->status_approval == 'revision'
                                                        ? 'primary'
                                                        : ($data->status_approval == 'rejected'
                                                            ? 'info'
                                                            : ($data->status_approval == 'rejected'
                                                                ? 'secondary'
                                                                : 'secondary'))))) }} p-2">

                                        {{ $data->status_approval == 'pending'
                                            ? 'Belum divalidasi'
                                            : ($data->status_approval == 'waiting'
                                                ? 'Proses validasi'
                                                : ($data->status_approval == 'approved'
                                                    ? 'Telah divalidasi'
                                                    : ($data->status_approval == 'revision'
                                                        ? 'Revisi'
                                                        : ($data->status_approval == 'rejected'
                                                            ? 'Ditolak'
                                                            : 'Ditolak')))) }}
                                    </span>
                                </td>


                                <td class="text-center">
                                    <span
                                        class="badge badge-{{ $data->status_permintaan == '1'
                                            ? 'danger'
                                            : ($data->status_permintaan == '2'
                                                ? 'warning'
                                                : ($data->status_permintaan == '3'
                                                    ? 'success'
                                                    : ($data->status_permintaan == '4'
                                                        ? 'primary'
                                                        : ($data->status_permintaan == '5'
                                                            ? 'info'
                                                            : ($data->status_permintaan == '0'
                                                                ? 'danger'
                                                                : ($data->status_permintaan == '6'
                                                                    ? 'secondary'
                                                                    : 'secondary')))))) }} p-2">

                                        {{ $data->status_permintaan == '1'
                                            ? 'Pending'
                                            : ($data->status_permintaan == '2'
                                                ? 'Menunggu validasi Manajer'
                                                : ($data->status_permintaan == '3'
                                                    ? 'Diterima'
                                                    : ($data->status_permintaan == '4'
                                                        ? 'Diproses'
                                                        : ($data->status_permintaan == '5'
                                                            ? 'Instalasi selesai'
                                                            : ($data->status_permintaan == '0'
                                                                ? 'Ditolak'
                                                                : ($data->status_permintaan == '6'
                                                                    ? 'Selesai'
                                                                    : 'Selesai')))))) }}
                                    </span>
                                </td>


                                <td class="text-center">
                                    {{-- TAMPILKAN TIGA TOMBOL BERIKUT --}}
                                    <div class="btn-group" role="group">

                                        <button class="btn btn-sm btn-warning rounded text-white mx-1" data-toggle="modal"
                                            data-target="#detail_permintaan_hardware_{{ $data->id_permintaan }}"
                                            title="Detail Permintaan"><i class="fas fa-eye"></i>
                                        </button>

                                        <form id="form-delete-{{ $data->id_permintaan }}"
                                            action="/superadmin/crud/{{ $data->id_permintaan }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <input hidden name="hapus_permintaan" id="hapus_permintaan">
                                            <input hidden name="kode_barang" value="{{ $data->kode_barang }}">
                                            <button type="button" class="btn btn-sm btn-danger"
                                                onclick="confirmDelete('{{ $data->id_permintaan }}', 'Hapus permintaan ini?', 'Menghapus data permintaan akan menghapus data lainnya yang terkait pada permintaan ini!')">
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
        {{-- @include('admin.software.modal.proses_software') --}}
        @include('admin.hardware.modal.detail_permintaan_hardware')
    @endif
@endsection
