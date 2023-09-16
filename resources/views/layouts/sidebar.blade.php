<ul class="navbar-nav bg-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <img src="{{ asset('custom_script/img/logo.webp') }}" width="100px">
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->

    <div class="sidebar-heading">
        Menu
    </div>

    <!-- Nav Item - Beranda -->

    <!-- Nav Item - Superadmin -->
    @if (auth()->user()->id_role == '1')
        <li class="nav-item {{ request()->is('superadmin') ? 'active' : '' }}">
            <a class="nav-link" href="/superadmin">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span></a>
        </li>

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            DATA MASTER
        </div>

        <li
            class="nav-item {{ request()->is('superadmin/datauseraktif') | request()->is('superadmin/datausernonaktif') | request()->is('superadmin/datapegawai') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('superadmin/datauseraktif') || request()->is('superadmin/datausernonaktif') || request()->is('superadmin/datapegawai') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseSuperadmin" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-user-gear"></i>
                <span>User & Pegawai</span>
            </a>
            <div id="collapseSuperadmin"
                class="collapse {{ request()->is('superadmin/datauseraktif') || request()->is('superadmin/datausernonaktif') || request()->is('superadmin/datapegawai') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data User & Pegawai:</h6>

                    <a class="collapse-item {{ request()->is('superadmin/datauseraktif') ? 'active' : '' }}"
                        href="/superadmin/datauseraktif">
                        <i class="fas fa-fw fa-user-check"></i>
                        <span>User Aktif</span>
                    </a>
                    <a class="collapse-item {{ request()->is('superadmin/datausernonaktif') ? 'active' : '' }}"
                        href="/superadmin/datausernonaktif">
                        <i class="fas fa-fw fa-user-times"></i>
                        <span>User Nonaktif</span>
                    </a>
                    <a class="collapse-item {{ request()->is('superadmin/datapegawai') ? 'active' : '' }}"
                        href="/superadmin/datapegawai"><i class="fas fa-fw fa-user-group"></i>
                        <span>Pegawai</span>
                    </a>
                </div>
            </div>
        </li>

        {{-- master notifikasi --}}
        {{-- <li class="nav-item {{ request()->is('superadmin/master_notifikasi') || request()->is('') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('superadmin/master_notifikasi') ? '' : 'collapsed' }}" href="#"
                data-toggle="collapse" data-target="#collapseMasterNotifikasi" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-mail-bulk"></i>
                <span>Notifikasi</span>
            </a>
            <div id="collapseMasterNotifikasi"
                class="collapse {{ request()->is('superadmin/master_notifikasi') || request()->is('') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Notifikasi:</h6>

                    <a class="collapse-item {{ request()->is('superadmin/master_notifikasi') ? 'active' : '' }}"
                        href="/superadmin/master_notifikasi">
                        <i class="fas fa-fw fa-history"></i>
                        <span>Riwayat Notifikasi</span>
                    </a>
                </div>
            </div>
        </li> --}}

        {{-- master stasiun --}}
        <li class="nav-item {{ request()->is('superadmin/master_stasiun') || request()->is('') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('superadmin/master_stasiun') ? '' : 'collapsed' }}" href="#"
                data-toggle="collapse" data-target="#collapseMasterStasiun" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-subway"></i>
                <span>Stasiun</span>
            </a>
            <div id="collapseMasterStasiun"
                class="collapse {{ request()->is('superadmin/master_stasiun') || request()->is('') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Stasiun:</h6>
                    <a class="collapse-item {{ request()->is('superadmin/master_stasiun') ? 'active' : '' }}"
                        href="/superadmin/master_stasiun">
                        <i class="fas fa-fw fa-tower-observation"></i>
                        <span>Data Stasiun</span>
                    </a>
                </div>
            </div>
        </li>

        {{-- master barang --}}
        {{-- <li class="nav-item {{ request()->is('superadmin/master_barang') || request()->is('') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('superadmin/master_barang') ? '' : 'collapsed' }}" href="#"
                data-toggle="collapse" data-target="#collapseMasterBarang" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-boxes"></i>
                <span>Barang</span>
            </a>
            <div id="collapseMasterBarang"
                class="collapse {{ request()->is('superadmin/master_barang') || request()->is('') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Barang:</h6>
                    <a class="collapse-item {{ request()->is('superadmin/master_barang') ? 'active' : '' }}"
                        href="/superadmin/master_barang">
                        <i class="fas fa-fw fa-boxes-packing"></i>
                        <span>Data Barang</span>
                    </a>
                </div>
            </div>
        </li> --}}

        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            DATA TRANSAKSI
        </div>

        {{-- transaksi permintaan --}}
        <li
            class="nav-item {{ request()->is('superadmin/transaksi_permintaan_software') || request()->is('superadmin/transaksi_permintaan_hardware') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('superadmin/transaksi_permintaan_software') || request()->is('superadmin/transaksi_permintaan_hardware') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseTransaksiPermintaan"
                aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Permintaan Layanan</span>
            </a>
            <div id="collapseTransaksiPermintaan"
                class="collapse {{ request()->is('superadmin/transaksi_permintaan_software') || request()->is('superadmin/transaksi_permintaan_hardware') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Transaksi Permintaan:</h6>
                    <a class="collapse-item {{ request()->is('superadmin/transaksi_permintaan_software') ? 'active' : '' }}"
                        href="/superadmin/transaksi_permintaan_software">
                        <i class="fas fa-fw fa-laptop-code"></i>
                        <span>Instalasi Software</span>
                    </a>
                    <a class="collapse-item {{ request()->is('superadmin/transaksi_permintaan_hardware') ? 'active' : '' }}"
                        href="/superadmin/transaksi_permintaan_hardware">
                        <i class="fas fa-fw fa-tools"></i>
                        <span>Pengecekan Hardware</span>
                    </a>
                </div>
            </div>
        </li>


        {{-- transaksi tindak lanjut --}}
        <li
            class="nav-item {{ request()->is('superadmin/transaksi_tindaklanjut') || request()->is('superadmin/transaksi_otorisasi') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('superadmin/transaksi_tindaklanjut') || request()->is('superadmin/transaksi_otorisasi') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseTransaksiTindaklanjut"
                aria-controls="collapseTwo">
                <i class="fas fa-fw fa-file-contract"></i>
                <span>Tindak Lanjut Layanan</span>
            </a>
            <div id="collapseTransaksiTindaklanjut"
                class="collapse {{ request()->is('superadmin/transaksi_tindaklanjut') || request()->is('superadmin/transaksi_otorisasi') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Admin & Executor:</h6>
                    <a class="collapse-item {{ request()->is('superadmin/transaksi_tindaklanjut') ? 'active' : '' }}"
                        href="/superadmin/transaksi_tindaklanjut">
                        <i class="fas fa-fw fa-wrench"></i>
                        <span>Tindak Lanjut</span>
                    </a>
                    <h6 class="collapse-header">Manager:</h6>

                    <a class="collapse-item {{ request()->is('superadmin/transaksi_otorisasi') ? 'active' : '' }}"
                        href="/superadmin/transaksi_otorisasi">
                        <i class="fas fa-fw fa-stamp"></i>
                        <span>Otorisasi & Validasi</span>
                    </a>
                </div>
            </div>
        </li>

        <li
            class="nav-item {{ request()->is('superadmin/transaksi_bast_barang_keluar') || request()->is('') | request()->is('superadmin/transaksi_bast_barang_masuk') ? 'active' : '' }}">

            <a class="nav-link {{ request()->is('superadmin/transaksi_bast_barang_keluar') || request()->is('superadmin/transaksi_bast_barang_masuk') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseDataTransaksi" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-user-gear"></i>
                <span>BAST</span>
            </a>
            <div id="collapseDataTransaksi"
                class="collapse {{ request()->is('superadmin/transaksi_bast_barang_keluar') || request()->is('superadmin/transaksi_bast_barang_masuk') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Serah Terima Barang:</h6>

                    {{-- BARANG KELUAR --}}
                    <a class="collapse-item {{ request()->is('superadmin/transaksi_bast_barang_keluar') ? 'active' : '' }}"
                        href="/superadmin/transaksi_bast_barang_keluar">
                        <i class="fas fa-fw fa-box"></i>
                        <i class="fas fa-fw fa-arrow-up"></i>
                        <span>Barang Keluar</span>
                    </a>
                    {{-- BARANG MASUK --}}
                    <a class="collapse-item {{ request()->is('superadmin/transaksi_bast_barang_masuk') ? 'active' : '' }}"
                        href="/superadmin/transaksi_bast_barang_masuk">
                        <i class="fas fa-fw fa-box"></i>
                        <i class="fas fa-fw fa-arrow-down"></i>
                        <span>Barang Masuk</span>
                    </a>
                </div>
            </div>
        </li>

        {{-- MENU CETAK LAPORAN --}}
        <li class="nav-item {{ request()->is('superadmin/laporan_periodik*') || request()->is('') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('superadmin/laporan_periodik*') || request()->is('') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseLaporanPeriodik"
                aria-controls="collapseTwo">
                <i class="fas fa-fw fa-file-invoice"></i>
                <span>Laporan Permintaan</span>
            </a>
            <div id="collapseLaporanPeriodik"
                class="collapse {{ request()->is('superadmin/laporan_periodik*') || request()->is('') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- PERMINTAAN INSTALASI SOFTWARE --}}
                    <a class="collapse-item {{ request()->is('superadmin/laporan_periodik*') ? 'active' : '' }}"
                        href="/superadmin/laporan_periodik">
                        <i class="fas fa-fw fa-print"></i>
                        <span>Laporan Periodik</span>
                    </a>

                </div>
            </div>
        </li>
    @endif




    {{-- MENU UNTUK USER PEGAWAI --}}
    @if (auth()->user()->id_role == '4')
        <li class="nav-item {{ request()->is('pegawai') ? 'active' : '' }}">
            <a class="nav-link" href="/pegawai">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li
            class="nav-item {{ request()->is('pegawai/permintaan_software') || request()->is('pegawai/permintaan_hardware') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('pegawai/permintaan_software') || request()->is('pegawai/permintaan_hardware') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseSuperadmin" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>Permintaan Layanan</span>
            </a>
            <div id="collapseSuperadmin"
                class="collapse {{ request()->is('pegawai/permintaan_software') || request()->is('pegawai/permintaan_hardware') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->is('pegawai/permintaan_software') ? 'active' : '' }}"
                        href="/pegawai/permintaan_software">
                        <i class="fas fa-fw fa-laptop-code"></i>
                        <span>Instalasi Software</span>
                    </a>
                    <a class="collapse-item {{ request()->is('pegawai/permintaan_hardware') ? 'active' : '' }}"
                        href="/pegawai/permintaan_hardware">
                        <i class="fas fa-fw fa-tools"></i>
                        <span>Pengecekan Hardware</span>
                    </a>
                </div>
            </div>
        </li>


        {{-- MENU BAST --}}
        <li
            class="nav-item {{ request()->is('pegawai/halaman_bast_barang_diterima') || request()->is('pegawai/halaman_bast_barang_diserahkan') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('pegawai/halaman_bast_barang_diterima') || request()->is('pegawai/halaman_bast_barang_diserahkan') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseBAST_Admin" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-handshake"></i>
                <span>BAST</span>
            </a>
            <div id="collapseBAST_Admin"
                class="collapse {{ request()->is('pegawai/halaman_bast_barang_diterima') || request()->is('pegawai/halaman_bast_barang_diserahkan') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- BARANG KELUAR --}}
                    <a class="collapse-item {{ request()->is('pegawai/halaman_bast_barang_diserahkan') ? 'active' : '' }}"
                        href="/pegawai/halaman_bast_barang_diserahkan">
                        <i class="fas fa-fw fa-box"></i>
                        <i class="fas fa-fw fa-arrow-up"></i>
                        <span>Barang Diserahkan</span>
                    </a>
                    {{-- BARANG MASUK --}}
                    <a class="collapse-item {{ request()->is('pegawai/halaman_bast_barang_diterima') ? 'active' : '' }}"
                        href="/pegawai/halaman_bast_barang_diterima">
                        <i class="fas fa-fw fa-box"></i>
                        <i class="fas fa-fw fa-arrow-down"></i>
                        <span>Barang Diterima</span>
                    </a>
                </div>
            </div>
        </li>
    @endif



    {{-- MENU UNTUK USER ADMIN --}}
    @if (auth()->user()->id_role == '2')
        <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}">
            <a class="nav-link" href="/admin">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- MENU PERMINTAAN LAYANAN --}}
        <li
            class="nav-item {{ request()->is('admin/permintaan_software*') || request()->is('admin/permintaan_hardware*') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('admin/permintaan_software*') || request()->is('admin/permintaan_hardware*') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseSuperadmin" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cogs"></i>
                <span>Permintaan Layanan</span>
                @php
                    $permintaan_count = DB::table('permintaan')
                        ->where('status_permintaan', '1')
                        ->count();
                @endphp
                @if ($permintaan_count > 0)
                    <span class="badge badge-danger badge-pill badge-counter">{{ $permintaan_count }}</span>
                @endif
            </a>
            <div id="collapseSuperadmin"
                class="collapse {{ request()->is('admin/permintaan_software*') || request()->is('admin/permintaan_hardware*') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- PERMINTAAN INSTALASI SOFTWARE --}}
                    <a class="collapse-item {{ request()->is('admin/permintaan_software*') ? 'active' : '' }}"
                        href="/admin/permintaan_software">
                        <i class="fas fa-fw fa-laptop-code"></i>
                        <span>Instalasi Software</span>
                        @php
                            $permintaan_software_count = DB::table('permintaan')
                                ->where('status_permintaan', '1')
                                ->where('tipe_permintaan', 'software')
                                ->count();
                        @endphp
                        @if ($permintaan_software_count > 0)
                            <span
                                class="badge badge-danger badge-pill badge-counter">{{ $permintaan_software_count }}</span>
                        @endif
                    </a>
                    {{-- PERMINTAAN PENGECEKAN HARDWARE --}}
                    <a class="collapse-item {{ request()->is('admin/permintaan_hardware*') ? 'active' : '' }}"
                        href="/admin/permintaan_hardware">
                        <i class="fas fa-fw fa-tools"></i>
                        <span>Pengecekan Hardware</span>
                        @php
                            $permintaan_hardware_count = DB::table('permintaan')
                                ->where('status_permintaan', '1')
                                ->where('tipe_permintaan', 'hardware')
                                ->count();
                        @endphp
                        @if ($permintaan_hardware_count > 0)
                            <span
                                class="badge badge-danger badge-counter badge-pill">{{ $permintaan_hardware_count }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </li>

        {{-- MENU CETAK LAPORAN --}}
        <li class="nav-item {{ request()->is('admin/laporan_periodik*') || request()->is('') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('admin/laporan_periodik*') || request()->is('') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseLaporanPeriodik"
                aria-controls="collapseTwo">
                <i class="fas fa-fw fa-file-invoice"></i>
                <span>Laporan Permintaan</span>
            </a>
            <div id="collapseLaporanPeriodik"
                class="collapse {{ request()->is('admin/laporan_periodik*') || request()->is('') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- PERMINTAAN INSTALASI SOFTWARE --}}
                    <a class="collapse-item {{ request()->is('admin/laporan_periodik*') ? 'active' : '' }}"
                        href="/admin/laporan_periodik">
                        <i class="fas fa-fw fa-print"></i>
                        <span>Laporan Periodik</span>
                    </a>

                </div>
            </div>
        </li>
    @endif



    {{-- MENU UNTUK USER MANAGER --}}
    @if (auth()->user()->id_role == '3')
        <li class="nav-item {{ request()->is('manager') ? 'active' : '' }}">
            <a class="nav-link" href="/manager">
                <i class="fas fa-fw fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- MENU PERMINTAAN Software --}}
        <li
            class="nav-item {{ request()->is('manager/permintaan_software*') || request()->is('manager/riwayat_otorisasi*') || request()->is('') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('manager/permintaan_software*') || request()->is('manager/riwayat_otorisasi*') || request()->is('') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseSoftware" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-laptop-code"></i>
                <span>Permintaan Software</span>
                @php
                    $permintaan_count = DB::table('permintaan')
                        ->join('otorisasi', 'otorisasi.id_otorisasi', '=', 'permintaan.id_otorisasi')
                        ->where('status_approval', 'waiting')
                        ->where('tipe_permintaan', 'software')
                        ->count();
                @endphp
                @if ($permintaan_count > 0)
                    <span class="badge badge-danger badge-pill badge-counter">{{ $permintaan_count }}</span>
                @endif
            </a>
            <div id="collapseSoftware"
                class="collapse {{ request()->is('manager/permintaan_software*') || request()->is('manager/riwayat_otorisasi*') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- PERMINTAAN INSTALASI SOFTWARE --}}
                    <a class="collapse-item {{ request()->is('manager/permintaan_software*') ? 'active' : '' }}"
                        href="/manager/permintaan_software">
                        <i class="fas fa-fw fa-check"></i>
                        <span class="custom-span">Otorisasi Permintaan</span>
                        @php
                            $permintaan_software_count = DB::table('permintaan')
                                ->join('otorisasi', 'otorisasi.id_otorisasi', '=', 'permintaan.id_otorisasi')
                                ->where('status_approval', 'waiting')
                                ->where('tipe_permintaan', 'software')
                                ->count();
                        @endphp
                        @if ($permintaan_software_count > 0)
                            <span
                                class="badge badge-danger badge-pill badge-counter">{{ $permintaan_software_count }}</span>
                        @endif
                    </a>

                    {{-- PERMINTAAN REVISI --}}
                    <a class="collapse-item {{ request()->is('manager/riwayat_otorisasi*') ? 'active' : '' }}"
                        href="/manager/riwayat_otorisasi">
                        <i class="fas fa-fw fa-history"></i>
                        <span class="custom-span">Riwayat Otorisasi</span>
                    </a>
                </div>
            </div>
        </li>

        {{-- Permintaan hardware --}}
        <li
            class="nav-item {{ request()->is('manager/permintaan_hardware*') || request()->is('manager/riwayat_validasi*') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('manager/permintaan_hardware*') || request()->is('manager/riwayat_validasi*') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseHardware" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-tools"></i>
                <span>Pengecekan Hardware</span>
                @php
                    $permintaan_count = DB::table('permintaan')
                        ->join('otorisasi', 'otorisasi.id_otorisasi', '=', 'permintaan.id_otorisasi')
                        ->where('status_approval', 'waiting')
                        ->where('tipe_permintaan', 'hardware')
                        ->count();
                @endphp
                @if ($permintaan_count > 0)
                    <span class="badge badge-danger badge-pill badge-counter">{{ $permintaan_count }}</span>
                @endif
            </a>
            <div id="collapseHardware"
                class="collapse {{ request()->is('manager/permintaan_hardware*') || request()->is('manager/riwayat_validasi*') || request()->is('/manager/permintaan_hardware') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- PERMINTAAN INSTALASI SOFTWARE --}}
                    <a class="collapse-item {{ request()->is('manager/permintaan_hardware*') ? 'active' : '' }}"
                        href="/manager/permintaan_hardware">
                        <i class="fas fa-fw fa-stamp"></i>
                        <span class="custom-span">Validasi Rekomendasi</span>
                        @php
                            $permintaan_software_count = DB::table('permintaan')
                                ->join('otorisasi', 'otorisasi.id_otorisasi', '=', 'permintaan.id_otorisasi')
                                ->where('status_approval', 'waiting')
                                ->where('tipe_permintaan', 'hardware')
                                ->count();
                        @endphp
                        @if ($permintaan_software_count > 0)
                            <span
                                class="badge badge-danger badge-pill badge-counter">{{ $permintaan_software_count }}</span>
                        @endif
                    </a>

                    {{-- PERMINTAAN REVISI --}}
                    <a class="collapse-item {{ request()->is('manager/riwayat_validasi*') ? 'active' : '' }}"
                        href="/manager/riwayat_validasi">
                        <i class="fas fa-fw fa-history"></i>
                        <span class="custom-span">Riwayat Validasi</span>
                    </a>
                </div>
            </div>
        </li>


        {{-- MENU CETAK LAPORAN --}}
        <li class="nav-item {{ request()->is('manager/laporan_periodik*') || request()->is('') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('manager/laporan_periodik*') || request()->is('') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseLaporanPeriodik"
                aria-controls="collapseTwo">
                <i class="fas fa-fw fa-file-invoice"></i>
                <span>Laporan Permintaan</span>
                @php
                    $laporan_count = DB::table('laporan_permintaan')
                        ->where('status_laporan', 'belum divalidasi')
                        ->count();
                @endphp
                @if ($laporan_count > 0)
                    <span class="badge badge-danger badge-pill badge-counter">{{ $laporan_count }}</span>
                @endif
            </a>
            <div id="collapseLaporanPeriodik"
                class="collapse {{ request()->is('manager/laporan_periodik*') || request()->is('') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- PERMINTAAN INSTALASI SOFTWARE --}}
                    <a class="collapse-item {{ request()->is('manager/laporan_periodik*') ? 'active' : '' }}"
                        href="/manager/laporan_periodik">
                        <i class="fas fa-fw fa-print"></i>
                        <span>Laporan Periodik</span>
                        @php
                            $laporan_count = DB::table('laporan_permintaan')
                                ->where('status_laporan', 'belum divalidasi')
                                ->count();
                        @endphp
                        @if ($laporan_count > 0)
                            <span class="badge badge-danger badge-pill badge-counter">{{ $laporan_count }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </li>
    @endif


    @if (auth()->user()->id_role == '2' || auth()->user()->id_role == '3')
        {{-- MENU BAST --}}
        <li
            class="nav-item {{ request()->is('halaman_bast') || request()->is('halaman_bast_barang_masuk') || request()->is('halaman_bast_barang_keluar') ? 'active' : '' }}">
            <a class="nav-link {{ request()->is('halaman_bast') || request()->is('halaman_bast_barang_masuk') || request()->is('halaman_bast_barang_keluar') ? '' : 'collapsed' }}"
                href="#" data-toggle="collapse" data-target="#collapseBAST_Admin" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-handshake"></i>
                <span>BAST</span>
            </a>
            <div id="collapseBAST_Admin"
                class="collapse {{ request()->is('halaman_bast_barang_masuk') || request()->is('halaman_bast_barang_keluar') ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- BARANG KELUAR --}}
                    <a class="collapse-item {{ request()->is('halaman_bast_barang_keluar') ? 'active' : '' }}"
                        href="/halaman_bast_barang_keluar">
                        <i class="fas fa-fw fa-box"></i>
                        <i class="fas fa-fw fa-arrow-up"></i>
                        <span>Barang Keluar</span>
                    </a>
                    {{-- BARANG MASUK --}}
                    <a class="collapse-item {{ request()->is('halaman_bast_barang_masuk') ? 'active' : '' }}"
                        href="/halaman_bast_barang_masuk">
                        <i class="fas fa-fw fa-box"></i>
                        <i class="fas fa-fw fa-arrow-down"></i>
                        <span>Barang Masuk</span>
                    </a>
                </div>
            </div>
        </li>
    @endif




    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
