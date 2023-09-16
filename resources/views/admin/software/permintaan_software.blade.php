@extends('layouts.main')

@section('contents')
    <!-- HTML -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <h4 class="card-title mx-2">Permintaan Instalasi Software</h4>
                <p class="small text-gray-800">Daftar permintaan instalasi software</p>
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#cetak_laporan_permintaan"><i
                        class="fas fa-print"></i> Laporan Periodik</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>ID Permintaan</th>
                            <th>Waktu Pengajuan</th>
                            {{-- <th>Kebutuhan</th> --}}
                            <th>Status Otorisasi</th>
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
                                {{-- <td>{{ $data->keluhan_kebutuhan }}</td> --}}
                                <td>
                                    <span
                                        class="p-2 badge badge-{{ $data->status_approval == 'pending'
                                            ? 'danger'
                                            : ($data->status_approval == 'waiting' || $data->status_approval == 'revision'
                                                ? 'warning'
                                                : ($data->status_approval == 'approved'
                                                    ? 'success'
                                                    : ($data->status_approval == 'rejected'
                                                        ? 'danger'
                                                        : ''))) }}">
                                        {{ ucwords($data->status_approval) }}
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
                                                ? 'Menunggu persetujuan'
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

                                        <form id="instalasi_selesai-{{ $data->id_permintaan }}"
                                            action="/admin/crud/{{ $data->id_permintaan }}" method="POST"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('PUT')
                                            <input hidden name="selesaikan_permintaan" value="permintaan_software">
                                            <input hidden name="id_permintaan" value="{{ $data->id_permintaan }}">
                                            <input hidden name="kode_barang" value="{{ $data->kode_barang }}">
                                            <button {{ $data->status_permintaan != '4' ? 'disabled' : '' }}
                                                title="Instalasi selesai" type="button" class="btn btn-sm btn-success"
                                                onclick="instalasi_selesai('{{ $data->id_permintaan }}')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        <button class="btn btn-sm btn-warning rounded text-white mx-1" data-toggle="modal"
                                            data-target="#detail_permintaan_software_{{ $data->id_permintaan }}"
                                            title="Detail Permintaan"><i class="fas fa-eye"></i>
                                        </button>

                                        @if ($data->status_permintaan != '1' && $data->status_approval != 'revision')
                                            <button {{ $data->status_permintaan != '4' ? 'disabled' : '' }}
                                                class="btn btn-sm btn-primary rounded text-white mr-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#estimasi_penyelesaian_{{ $data->id_permintaan }}"
                                                title="Estimasi Penyelesaian"><i class="fas fa-clock"></i>
                                            </button>
                                        @elseif ($data->status_permintaan == '1' || $data->status_approval == 'revision')
                                            <form
                                                action="/admin/permintaan_software/tambah_software/{{ $data->id_permintaan }}"
                                                method="GET" style="display: inline-block;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary text-white mr-1"
                                                    title="Pengajuan Software"
                                                    {{ $data->status_permintaan != '1' && $data->status_approval != 'revision' ? 'disabled' : '' }}>
                                                    <i class="fas fa-cogs"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <form action="/admin/permintaan_software/bast_software/{{ $data->id_permintaan }}"
                                            method="GET" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success text-white" title="BAST"
                                                {{ $data->status_permintaan != '3' && $data->status_permintaan != '5' && $data->status_permintaan != '0' ? 'disabled' : '' }}>
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
        @include('admin.software.modal.proses_software')
        @include('admin.software.modal.detail_permintaan_software')
        @include('admin.laporan_permintaan.cetak_laporan_permintaan_software')
        @include('admin.software.modal.input_estimasi_penyelesaian')
    @endif
@endsection
