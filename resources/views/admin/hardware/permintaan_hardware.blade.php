@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h4 class="card-title mx-2">Permintaan Pengecekan Hardware</h4>
                <p class="small text-gray-800">Daftar permintaan pengecekan hardware</p>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#cetak_laporan_permintaan"><i
                        class="fas fa-print"></i> Laporan Periodik</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>ID Permintaan</th>
                            <th>Waktu Pengajuan</th>
                            <th>Status Validasi</th>
                            <th>Status Permintaan</th>
                            <th>Waktu Penyelesaian</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    {{-- PERMINTAAN SOFTWARE VIEW ADMIN --}}
                    <tbody class="small">
                        <?php $no = 1; ?>
                        @foreach ($permintaan as $data)
                            <tr class="text-center">
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


                                <td>
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

                                <td>
                                    @if ($data->tanggal_penyelesaian != '')
                                        {{ date('Y-m-d', strtotime($data->tanggal_penyelesaian)) }}
                                        @php
                                            $tanggal_penyelesaian = \Carbon\Carbon::parse($data->tanggal_penyelesaian);
                                            $sekarang = \Carbon\Carbon::now();
                                            $selisihHari = $sekarang->diffInDays($tanggal_penyelesaian) + 1;
                                        @endphp
                                        @if ($tanggal_penyelesaian->isPast())
                                            <br> *Selesai*
                                        @else
                                            <br> *{{ $selisihHari }} Hari*
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>


                                <td>
                                    {{-- TAMPILKAN TIGA TOMBOL BERIKUT --}}
                                    <div class="btn-group" role="group">
                                        @if ($data->status_permintaan != '1')
                                            <form id="instalasi_selesai-{{ $data->id_permintaan }}"
                                                action="/admin/crud/{{ $data->id_permintaan }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <input hidden name="selesaikan_permintaan" value="permintaan_hardware">
                                                <input hidden name="id_permintaan" value="{{ $data->id_permintaan }}">
                                                <input hidden name="kode_barang" value="{{ $data->kode_barang }}">
                                                <button
                                                    {{ $data->status_permintaan == '4' && $data->status_approval == 'approved' ? '' : 'disabled' }}
                                                    title="Pengecekan Selesai" type="button" class="btn btn-sm btn-success"
                                                    onclick="instalasi_selesai('{{ $data->id_permintaan }}')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form id="terima_permintaan-{{ $data->id_permintaan }}"
                                                action="/admin/crud/{{ $data->id_permintaan }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('PUT')
                                                <input hidden name="acc_permintaan" id="acc_permintaan">
                                                <input hidden name="status_permintaan" value="3">
                                                <input hidden name="id_permintaan" value="{{ $data->id_permintaan }}">
                                                <input hidden name="kode_barang" value="{{ $data->kode_barang }}">
                                                <button {{ $data->status_permintaan != '1' ? 'disabled' : '' }}
                                                    title="Terima Permintaan" type="button" class="btn btn-sm btn-success"
                                                    onclick="terima_permintaan('{{ $data->id_permintaan }}')">
                                                    <i class="fas fa-reply"></i>
                                                </button>
                                            </form>
                                        @endif


                                        <button class="btn btn-sm btn-warning rounded text-white mx-1" data-toggle="modal"
                                            data-target="#detail_permintaan_hardware_{{ $data->id_permintaan }}"
                                            title="Detail Permintaan"><i class="fas fa-eye"></i>
                                        </button>

                                        <button
                                            {{ $data->status_permintaan == '4' && $data->status_approval != 'approved' ? '' : 'disabled' }}
                                            class="btn btn-sm btn-primary rounded text-white mr-1" data-bs-toggle="modal"
                                            data-bs-target="#estimasi_penyelesaian_{{ $data->id_permintaan }}"
                                            title="Estimasi Penyelesaian"><i class="fas fa-clock"></i>
                                        </button>


                                        <form action="/admin/permintaan_hardware/cek_hardware/{{ $data->id_permintaan }}"
                                            method="GET" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-primary text-white mr-1"
                                                title="Tindak Lanjut Pengecekan"
                                                {{ $data->status_permintaan == '4' && $data->status_approval == 'pending' ? '' : 'disabled' }}>
                                                <i class="fas fa-tools"></i>
                                            </button>

                                        </form>

                                        <form action="/admin/permintaan_hardware/bast_hardware/{{ $data->id_permintaan }}"
                                            method="GET" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success text-white" title="BAST"
                                                {{ $data->status_permintaan != '3' && $data->status_permintaan != '5' ? 'disabled' : '' }}>
                                                <i class="fas fa-file-contract"></i>
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
        @include('admin.software.modal.input_estimasi_penyelesaian')
        @include('admin.hardware.modal.detail_permintaan_hardware')
        @include('admin.laporan_permintaan.cetak_laporan_permintaan_hardware')
    @endif
@endsection
