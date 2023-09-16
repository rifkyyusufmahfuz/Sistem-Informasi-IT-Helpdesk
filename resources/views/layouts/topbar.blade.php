<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Alerts -->
        <li id="menu_dropdown" class="nav-item dropdown no-arrow mx-1">

            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                {{-- jumlah notifikasi di-load dari notifikasi.js --}}
                <span class="badge badge-danger badge-counter"></span>
            </a>

            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Pusat Notifikasi
                </h6>
                <div id="notifications">
                    {{-- kolom ini di-load secara otomatis dari notifikasi.js --}}
                </div>


                {{-- <div class="dropdown-item text-center small" href="#">
                    <a href="#" class="text-gray-500" id="read_all_notifikasi">Tandai semua telah dibaca</a>
                </div> --}}
                @if (Auth::user()->id_role == 4)
                    <!-- Tombol untuk pegawai -->
                    <div class="dropdown-item text-center small" href="#">
                        <a href="" class="text-gray-500" id="read_all_notifikasi"
                            data-id="{{ Auth::user()->id }}">Tandai semua telah dibaca</a>
                    </div>
                @else
                    <!-- Tombol untuk admin, manajer, atau superadmin -->
                    <div class="dropdown-item text-center small" href="#">
                        <a href="" class="text-gray-500" id="read_all_notifikasi"
                            data-id="{{ Auth::user()->id_role }}">Tandai semua telah dibaca</a>
                    </div>
                @endif





            </div>
        </li>

        <!-- end of Nav Item - Alerts -->


        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->pegawai->nama }} -
                    {{ ucwords(Auth::user()->role->nama_role) }}</span>
                <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                {{-- <a class="dropdown-item" href="">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a> --}}
                {{-- <div class="dropdown-divider"></div> --}}
                <a id="logout-link" class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); confirmLogout();">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>
</nav>
