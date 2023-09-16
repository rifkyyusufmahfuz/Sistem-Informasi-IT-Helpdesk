@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h4 class="card-title mx-2">Permintaan Pengecekan Hardware</h4>
                <p class="small text-gray-800">Validasi Rekomendasi Hasil Pengecekan Hardware</p>
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
                            {{-- <th>Kategori Software</th> --}}
                            {{-- <th>Uraian Kebutuhan</th> --}}
                            {{-- <th>Nama Pegawai</th> --}}
                            <th>Status Validasi</th>
                            <th class="text-center">Status Permintaan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody>
                        @foreach ($permintaan as $data)
                            <?php $no = 1; ?>
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $data->id_permintaan }}</td>
                                <td>{{ $data->permintaan_created_at }}</td>
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
                                                    ? 'primary'
                                                    : ($data->status_permintaan == '4'
                                                        ? 'primary'
                                                        : ($data->status_permintaan == '5'
                                                            ? 'success'
                                                            : ($data->status_permintaan == '0'
                                                                ? 'danger'
                                                                : ($data->status_permintaan == '6'
                                                                    ? 'success'
                                                                    : 'success')))))) }} p-2">

                                        {{ $data->status_permintaan == '1'
                                            ? 'Pending'
                                            : ($data->status_permintaan == '2'
                                                ? 'Menunggu validasi'
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

                                        <button class="btn btn-sm btn-success rounded mr-1" data-bs-toggle="modal"
                                            data-bs-target="#validasi_rekomendasi_{{ $data->id_permintaan }}"
                                            title="Validasi Rekomendasi">
                                            <i class="fas fa-check"></i>
                                        </button>

                                        {{-- <button class="btn btn-sm btn-primary rounded text-white mx-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal_revisi_permintaan_{{ $data->id_permintaan }}"><i
                                                class="fa fa-undo"></i>
                                        </button> --}}

                                        {{-- tombol view detail --}}
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning rounded text-white dropdown-toggle"
                                                data-toggle="dropdown" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                    data-target="#detail_permintaan_pegawai_{{ $data->id_permintaan }}">
                                                    Detail Permintaan
                                                </a>
                                                <a class="dropdown-item" href="#" data-toggle="modal"
                                                    data-target="#detail_permintaan_admin_{{ $data->id_permintaan }}">
                                                    Detail Hardware
                                                </a>
                                            </div>
                                        </div>
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
        @include('manager.modal.detail_permintaan_hardware')
        @include('manager.modal.detail_hardware')
        @include('manager.modal.validasi_rekomendasi')
    @endif
@endsection
