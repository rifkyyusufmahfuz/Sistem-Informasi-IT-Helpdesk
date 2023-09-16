<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\ManagerModel;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RoleModel;
use App\Models\SuperadminModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SuperadminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $modeluser;
    protected $modelsuperadmin;
    protected $modeladmin;
    protected $modelmanager;

    public function __construct()
    {
        $this->modeluser = new User();
        $this->modelsuperadmin = new SuperadminModel();
        $this->modeladmin = new AdminModel();
        $this->modelmanager = new ManagerModel();
    }

    public function index()
    {
        $activeUsersCount = DB::table('users')->where('status', 1)->count();
        $inactiveUsersCount = DB::table('users')->where('status', 0)->count();

        $pegawaiByRole = DB::table('roles')
            ->join('users', 'roles.id_role', '=', 'users.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->select('roles.nama_role', DB::raw('COUNT(pegawai.nip) as pegawai_count'))
            ->groupBy('roles.nama_role')
            ->get();

        $stasiunCount = DB::table('stasiun')
            ->join('pegawai', 'stasiun.id_stasiun', '=', 'pegawai.id_stasiun')
            ->select('stasiun.nama_stasiun', DB::raw('COUNT(pegawai.nip) as pegawai_count'))
            ->groupBy('stasiun.nama_stasiun')
            ->get();

        $pegawaiTerdaftar = DB::table('users')->whereNotNull('nip')->count();
        $totalPegawai = DB::table('pegawai')->count();

        $barangCounts = DB::table('barang')
            ->select('status_barang', DB::raw('COUNT(kode_barang) as jumlah_barang'))
            ->groupBy('status_barang')
            ->get();

        $statusPermintaanData = DB::table('permintaan')
            ->select('status_permintaan', DB::raw('COUNT(id_permintaan) as jumlah_permintaan'))
            ->groupBy('status_permintaan')
            ->get();

        // Mapping status_permintaan ke label sesuai spesifikasi
        $statusMapping = [
            1 => 'Pending',
            2 => 'Ditinjau',
            3 => 'Menunggu Unit',
            4 => 'Diproses',
            5 => 'Unit Siap Diambil',
            6 => 'Permintaan Selesai',
            0 => 'Ditolak'
        ];
        $statusPermintaanLabels = [
            'Pending',
            'Ditinjau',
            'Menunggu Unit',
            'Diproses',
            'Unit Siap Diambil',
            'Permintaan Selesai',
            'Ditolak'
        ];

        // Membuat array untuk menyimpan data yang akan digunakan di view
        $chartData = [];
        foreach ($statusPermintaanData as $data) {
            $status = $statusMapping[$data->status_permintaan] ?? 'Tidak Diketahui';
            $chartData[$status] = $data->jumlah_permintaan;
        }

        // Mengurutkan data sesuai urutan statusPermintaanLabels
        $sortedChartData = [];
        foreach ($statusPermintaanLabels as $label) {
            $sortedChartData[$label] = $chartData[$label] ?? 0;
        }

        // Query untuk menghitung jumlah permintaan berdasarkan tipe_permintaan
        $permintaanCountsByType = DB::table('permintaan')
            ->select('tipe_permintaan', DB::raw('COUNT(id_permintaan) as jumlah_permintaan'))
            ->groupBy('tipe_permintaan')
            ->get();

        // Query untuk menghitung jumlah BAST berdasarkan jenis_bast
        $bastCountsByType = DB::table('bast')
            ->select('jenis_bast', DB::raw('COUNT(id_bast) as jumlah_bast'))
            ->groupBy('jenis_bast')
            ->get();


        return view('superadmin.index')->with(compact(
            'activeUsersCount',
            'inactiveUsersCount',
            'pegawaiByRole',
            'stasiunCount',
            'pegawaiTerdaftar',
            'totalPegawai',
            'barangCounts',
            'sortedChartData',
            'permintaanCountsByType',
            'bastCountsByType'
        ));
    }




    public function halaman_datauser()
    {
        $data = [
            'data_user' => $this->modelsuperadmin->data_user_aktif(),
            'data_role' => $this->modelsuperadmin->get_data_role(),
            'roleCounts' => $this->modelsuperadmin->hitung_user_by_role(),
            'nip_pegawai' => $this->modelsuperadmin->get_nip_unregistered(),
        ];

        return view('superadmin.master_user.datauser', $data);
    }

    public function halaman_datauser_nonaktif()
    {
        $data = [
            'data_user' => $this->modelsuperadmin->data_user_nonaktif(),
            'data_role' => $this->modelsuperadmin->get_data_role(),
            'roleCounts' => $this->modelsuperadmin->hitung_user_by_role(),
            'nip_pegawai' => $this->modelsuperadmin->get_nip_unregistered(),
        ];

        return view('superadmin.master_user.datauser_nonaktif', $data);
    }

    public function halaman_datapegawai()
    {
        $data = [
            'data_pegawai' => $this->modelsuperadmin->data_pegawai(),
            'data_stasiun' => $this->modelsuperadmin->data_stasiun(),
        ];

        return view('superadmin.master_user.datapegawai', $data);
    }

    public function master_notifikasi()
    {
        $data_notifikasi = $this->modelsuperadmin->get_data_notifikasi();

        return view(
            'superadmin.master_notifikasi.data_notifikasi',
            [
                'data_notifikasi' => $data_notifikasi,
            ]
        );
    }

    public function master_stasiun()
    {
        $data_stasiun = $this->modelsuperadmin->get_data_stasiun();

        return view(
            'superadmin.master_stasiun.data_stasiun',
            [
                'data_stasiun' => $data_stasiun,
            ]
        );
    }

    public function master_barang()
    {
        $data_barang = $this->modelsuperadmin->get_data_barang();

        return view(
            'superadmin.master_barang.data_barang',
            [
                'data_barang' => $data_barang,
            ]
        );
    }

    public function transaksi_permintaan_software()
    {
        $data_permintaan = $this->modeladmin->get_permintaan_software();
        $list_software = $this->modeladmin->get_list_software();

        return view(
            'superadmin.transaksi_permintaan.data_permintaan_software',
            [
                'permintaan' => $data_permintaan,
                'list_software' => $list_software
            ]
        );
    }

    public function transaksi_permintaan_hardware()
    {
        $permintaan = $this->modeladmin->get_permintaan_hardware();
        $list_hardware = $this->modeladmin->get_list_hardware();

        return view(
            'superadmin.transaksi_permintaan.data_permintaan_hardware',
            [
                'permintaan' => $permintaan,
                'list_hardware' => $list_hardware
            ]
        );
    }

    public function transaksi_tindaklanjut()
    {
        $data_tindaklanjut = $this->modelsuperadmin->get_tindak_lanjut();

        $list_hardware = $this->modelmanager->get_list_hardware();
        $list_software = $this->modelmanager->get_list_software();

        return view(
            'superadmin.transaksi_tindaklanjut.data_tindaklanjut',
            [
                'data_tindaklanjut' => $data_tindaklanjut,
                'list_hardware' => $list_hardware,
                'list_software' => $list_software
            ]
        );
    }

    public function transaksi_otorisasi()
    {
        $data_otorisasi = $this->modelsuperadmin->get_otorisasi();
        $list_hardware = $this->modelmanager->get_list_hardware();
        $list_software = $this->modelmanager->get_list_software();

        return view(
            'superadmin.transaksi_otorisasi.data_otorisasi',
            [
                'data_tindaklanjut' => $data_otorisasi,
                'list_hardware' => $list_hardware,
                'list_software' => $list_software
            ]
        );
    }

    public function transaksi_bast_barang_masuk()
    {
        $bast_barang_masuk = $this->modeladmin->get_bast_barang_masuk();

        return view(
            'superadmin.transaksi_bast.data_barang_masuk',
            [
                'bast_barang_masuk' => $bast_barang_masuk,
            ]
        );
    }


    public function transaksi_bast_barang_keluar()
    {
        $bast_barang_keluar = $this->modeladmin->get_bast_barang_keluar();

        return view(
            'superadmin.transaksi_bast.data_barang_keluar',
            [
                'bast_barang_keluar' => $bast_barang_keluar,
            ]
        );
    }

    public function transaksi_laporan_permintaan()
    {
        $laporan_permintaan = $this->modeladmin->get_laporan_permintaan();

        return view(
            'superadmin.transaksi_laporan_periodik.laporan_periodik',
            compact(
                'laporan_permintaan'
            )
        );
    }



    public function getPegawaiData($nip)
    {
        $pegawai = $this->modelsuperadmin->data_pegawai_by_nip($nip);

        if ($pegawai) {
            $nama = $pegawai['nama'];
            $bagian = $pegawai['bagian'];
            $jabatan = $pegawai['jabatan'];
            $lokasi = $pegawai['lokasi'];

            return response()->json([
                'nama' => $nama,
                'bagian' => $bagian,
                'jabatan' => $jabatan,
                'lokasi' => $lokasi
            ]);
        } else {
            return response()->json(null);
        }
    }

    // fungsi untuk mengaktivasi semua user yang nonaktif
    public function aktivasi_semua_user()
    {
        $users = User::where('status', false)->get();
        User::where('status', false)->update(['status' => true]);

        foreach ($users as $user) {
            // Ambil data nama dari tabel pegawai
            $pegawai = $this->modelsuperadmin->get_data_pegawai($user->nip);
            $nama = $pegawai->nama;

            // Buat entri notifikasi untuk pengguna yang diaktifkan
            $pesan = "Halo " . $nama . "! Selamat datang di Sistem Informasi IT Helpdesk! Akun Anda telah aktif dan dapat menggunakan fitur-fitur yang telah disediakan. Terima kasih!";

            $notifikasi = [
                'pesan' => $pesan,
                'tautan' => '#',
                'user_id' => $user->id,
                'created_at' => now()
            ];

            $this->modelsuperadmin->input_notifikasi($notifikasi);
        }

        return redirect()->back()->with('toast_success', 'Semua user berhasil diaktivasi!');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->has('email')) {
            $request->validate(
                [
                    //data user
                    'email' => 'required|unique:users,email',
                    'password' => 'required',
                    'confirm_password' => 'required',
                    'role' => 'required',

                    //data pegawai
                    'nip_pegawai'  => 'required',

                ],
                [
                    'email.unique' => 'Email sudah digunakan!',
                    'password.required' => 'Password tidak boleh kosong!',
                    'confirm_password.required' => 'Konfirmasi Password tidak boleh kosong!',
                    'confirm_password.same' => 'Password tidak cocok!',
                    'role.required' => 'Role tidak boleh kosong!',
                    'nip_pegawai.required' => 'NIP tidak boleh kosong!',
                ]
            );

            $data_user = [
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_role' => $request->role,
                'status' => true,
                'nip'  => $request->nip_pegawai,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ];

            // melakukan proses penyimpanan data user
            if ($this->modelsuperadmin->insert_datauser($data_user)) {
                return redirect('/superadmin/datauseraktif')->with('toast_success', 'Data user berhasil ditambahkan!');
            } else {
                return redirect('/superadmin/datauseraktif')->with('toast_error', 'Data user gagal ditambahkan!');
            }
        } elseif ($request->input('jenis_input') == 'data_stasiun') {
            $request->validate(
                [
                    'id_stasiun' => 'required|unique:stasiun,id_stasiun',
                    'nama_stasiun' => 'required|unique:stasiun,nama_stasiun'
                ],
                [
                    'id_stasiun.required' => 'ID stasiun wajib diisi!',
                    'id_stasiun.unique' => 'ID stasiun sudah ada!',
                    'nama_stasiun.required' => 'Nama stasiun wajib diisi!',
                    'nama_stasiun.unique' => 'Nama stasiun sudah ada!',
                ]
            );

            $nama_stasiun =  ucwords(strtolower($request->nama_stasiun));

            $data_stasiun = [
                'id_stasiun' => $request->id_stasiun,
                'nama_stasiun' => $nama_stasiun
            ];

            $input_stasiun = $this->modelsuperadmin->input_stasiun($data_stasiun);

            return $input_stasiun
                ? redirect('/superadmin/master_stasiun')->with('toast_success', 'Data stasiun berhasil ditambahkan!')
                : redirect('/superadmin/master_stasiun')->with('toast_error', 'Input data stasiun gagal, silakan coba lagi!');
        } elseif ($request->input('jenis_input') == 'data_barang') {
            $request->validate(
                [
                    'kode_barang' => 'required|unique:barang,kode_barang',
                    'nama_barang' => 'required'
                ],
                [
                    'kode_barang.required' => 'Kode barang wajib diisi!',
                    'kode_barang.unique' => 'Kode barang sudah ada!',
                    'nama_barang.required' => 'Nama barang wajib diisi!',
                ]
            );

            $nama_barang =  ucwords(strtolower($request->nama_barang));
            $kode_barang = strtoupper($request->kode_barang);

            $request->prosesor == null ? $prosesor = '-' : $prosesor = strtoupper($request->prosesor);
            $request->ram == null ? $ram = '-' : $ram = strtoupper($request->ram);
            $request->penyimpanan == null ? $penyimpanan = '-' : $penyimpanan = strtoupper($request->penyimpanan);

            $data_barang = [
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'prosesor' => $prosesor,
                'ram' => $ram,
                'penyimpanan' => $penyimpanan,
                'status_barang' => $request->status_barang,
                'jumlah_barang' => 1,
            ];

            $input_barang = $this->modelsuperadmin->input_barang($data_barang);

            return $input_barang
                ? redirect('/superadmin/master_barang')->with('toast_success', 'Data barang berhasil ditambahkan!')
                : redirect('/superadmin/master_barang')->with('toast_error', 'Input barang gagal, silakan coba lagi!');
        } else {
            // jika jenis input tidak valid, lakukan sesuai kebutuhan
            $request->validate([
                //data pegawai
                'nip_pegawai'  => 'required|unique:pegawai,nip|numeric|digits_between:1,5',
                'nama_pegawai' => 'required',
                'bagian_pegawai' => 'required',
                'jabatan_pegawai' => 'required',
                'lokasi_pegawai' => 'required',
            ], [
                'nip_pegawai.unique' => 'NIP sudah terdaftar!',
                'nip_pegawai.required' => 'NIP tidak boleh kosong!',
                'nip_pegawai.numeric' => 'NIP harus angka!',
                'nip_pegawai.digits_between' => 'Jumlah NIP minimal 4 dan maksimal 5 digit!',

                'nama_pegawai.required' => 'Nama tidak boleh kosong!',
                'bagian_pegawai.required' => 'Bagian tidak boleh kosong!',
                'jabatan_pegawai.required' => 'Jabatan tidak boleh kosong!',
                'lokasi_pegawai.required' => 'Lokasi tidak boleh kosong!',
            ]);

            // untuk mengubah nama stasiun menjadi id_stasiun
            $nama_stasiun = $request->input('lokasi_pegawai');
            $id_stasiun = $this->modelsuperadmin->getIdStasiun($nama_stasiun);


            $data = [
                'nip'  => $request->input('nip_pegawai'),
                'nama' => $request->input('nama_pegawai'),
                'bagian' => $request->input('bagian_pegawai'),
                'jabatan' => $request->input('jabatan_pegawai'),
                'id_stasiun' => $id_stasiun,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ];
            // melakukan proses penyimpanan data pegawai
            if ($this->modelsuperadmin->insert_datapegawai($data)) {
                return redirect('/superadmin/datapegawai')->with('toast_success', 'Data pegawai berhasil ditambahkan!');
            } else {
                return redirect('/superadmin/datapegawai')->with('toast_error', 'Data pegawai gagal ditambahkan!');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        $nip = $user->nip;
        $pegawai = $this->modelsuperadmin->data_pegawai_by_nip($nip);

        // $role = RoleModel::find($user->id_role);

        return response()->json([
            'nip' => $nip,
            'nama' => $pegawai['nama'],
            'bagian' => $pegawai['bagian'],
            'jabatan' => $pegawai['jabatan'],
            'nama_stasiun' => $pegawai['lokasi'],
            // 'role' => $role->nama_role
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // COPYRIGHT OF RIFKY YUSUF MAHFUZ - UNIVERSITAS BINA INSANI - PROJECT AKHIR SKRIPSI

    public function update(Request $request, $id)
    {
        // Ambil data user yang akan diupdate
        $user = $this->modelsuperadmin->get_user_by_id($id);

        // Jika melakukan update data user
        if ($request->has('email2') || $request->has('role')) {

            // Pencegahan jika superadmin mencoba mengupdate rolenya sendiri
            if ($user->id == Auth::user()->id && $request->has('role')) {
                $superadminRoleId = RoleModel::where('nama_role', 'superadmin')->first()->id_role;
                if (Auth::user()->id_role == $superadminRoleId && $request->input('role') != $superadminRoleId) {
                    return redirect('/superadmin/datauseraktif')->with('toast_error', 'Tidak dapat mengubah role sendiri menjadi role selain superadmin!');
                }
            }

            // Validasi form
            $request->validate(
                [
                    'email2' => 'required|unique:users,email,' . $id,
                    'role' => $request->filled('role') ? 'required|exists:roles,id_role' : ''
                ],
                [
                    'email2.required' => 'Email wajib diisi!',
                    'email2.unique' => 'Email sudah terdaftar!',
                    'role.required' => 'Role wajib dipilih!'
                ]

            );
            // data yang telah divalidasi
            $data = [
                'email' => $request->input('email2'),
                'id_role' => $user->id_role, // nilai awal diambil dari user yang diupdate
                'updated_at' => \Carbon\Carbon::now(),
            ];

            // Jika superadmin mengubah role user lain
            if ($request->has('role') && Auth::user()->id_role == 1 && $user->id_role != $request->input('role')) {
                $data['id_role'] = $request->input('role');
            }

            // Kirim data ke model update data user
            if ($this->modelsuperadmin->update_user($data, $id)) {
                return redirect('/superadmin/datauseraktif')->with('toast_success', 'Data user berhasil diupdate!');
            } else {
                return redirect('/superadmin/datauseraktif')->with('toast_error', 'Data user gagal diupdate!');
            }
        }

        // Jika melakukan update password
        if ($request->has('ganti_password')) {
            $request->validate(
                [
                    'ganti_password' => 'required|min:6',
                    'konfirmasi_password2' => 'required|same:ganti_password'
                ],
                [
                    'ganti_password.required' => 'Password wajib diisi!',
                    'ganti_password.min' => 'Password minimal 5 karakter!',
                    'ganti_password.confirmed' => 'Konfirmasi password tidak cocok!',
                    'konfirmasi_password2.required' => 'Konfirmasi password wajib diisi!',
                    'konfirmasi_password2.same' => 'Konfirmasi password tidak cocok!',
                ]

            );

            // input data yang telah divalidasi
            $data = [
                'password' => Hash::make($request->input('ganti_password')),
                'updated_at' => \Carbon\Carbon::now(),
            ];

            // Kirim data ke model update data user
            if ($this->modelsuperadmin->update_user($data, $id)) {
                return redirect('/superadmin/datauseraktif')->with('toast_success', 'Password user berhasil diupdate!');
            } else {
                return redirect('/superadmin/datauseraktif')->with('toast_error', 'Password user gagal diupdate!');
            }
        }

        // aktivasi atau nonaktifkan user
        if ($request->has('aktivasi')) {
            $aktivasi = $request->input('aktivasi');
            $data = [
                'status' => $aktivasi,
                'updated_at' => \Carbon\Carbon::now(),
            ];
            $user = $this->modelsuperadmin->get_user_by_id($id);

            // kondisi untuk memeriksa pengguna yang sedang login sama dengan pengguna yang akan diaktifkan atau dinonaktifkan
            if ($user->id == Auth::user()->id) {
                return back()->with('toast_error', 'Akun Anda tidak bisa dinonaktifkan!');
            }

            // kirim data ke model update user 
            if ($this->modelsuperadmin->update_user($data, $id)) {
                if ($aktivasi == 1) {
                    // Ambil data nama dari tabel pegawai
                    $pegawai = $this->modelsuperadmin->get_data_pegawai($user->nip);
                    $nama = $pegawai->nama;
                    // Buat entri notifikasi untuk pengguna yang diaktifkan
                    $pesan = "Halo " . $nama . "! Selamat datang di Sistem Informasi IT Helpdesk! Akun Anda telah aktif dan dapat menggunakan fitur-fitur yang telah disediakan. Terima kasih!";

                    $notifikasi = [
                        'pesan' => $pesan,
                        'tautan' => '#',
                        'user_id' => $user->id,
                        'created_at' => now()
                    ];

                    $this->modelsuperadmin->input_notifikasi($notifikasi);

                    return redirect('/superadmin/datausernonaktif')->with('toast_success', 'User telah diaktivasi!');
                } elseif ($aktivasi == 0) {
                    return redirect('/superadmin/datauseraktif')->with('toast_success', 'User telah dinonaktifkan!');
                }
            } else {
                return back()->with('toast_error', 'Ubah status user gagal dilakukan!');
            }
        }

        //Untuk update data pegawai
        if ($request->has('nip_pegawai_update')) {

            $request->validate(
                [
                    'nip_pegawai_update' => [
                        'required',
                        'min:4',
                        Rule::unique('pegawai', 'nip')->ignore($id, 'nip'),
                    ],
                    // 'nip_pegawai_update' => 'required|min:4',
                    'nama_pegawai_update' => 'required',
                    'bagian_pegawai_update' => 'required',
                    'jabatan_pegawai_update' => 'required',
                    'lokasi_pegawai_update' => 'required',

                ],
                [
                    'nip_pegawai_update.unique' => 'NIP sudah digunakan!',
                    'nip_pegawai_update.required' => 'NIP wajib diisi!',
                    'nip_pegawai_update.min' => 'NIP minimal 4 angka!',
                    'nama_pegawai_update.required' => 'Nama pegawai wajib diisi!',
                    'bagian_pegawai_update.required' => 'Unit/bagian pegawai wajib diisi!',
                    'jabatan_pegawai_update.required' => 'Jabatan pegawai wajib diisi!',
                    'lokasi_pegawai_update.required' => 'Pilih lokasi pegawai!',
                ]

            );

            // untuk mengubah nama stasiun menjadi id_stasiun
            $nama_stasiun = $request->input('lokasi_pegawai_update');
            $id_stasiun = $this->modelsuperadmin->getIdStasiun($nama_stasiun);

            // input data yang telah divalidasi
            $data = [
                'nip' => $request->nip_pegawai_update,
                'nama' => $request->nama_pegawai_update,
                'bagian' => $request->bagian_pegawai_update,
                'jabatan' => $request->jabatan_pegawai_update,
                'id_stasiun' => $id_stasiun,

                'updated_at' => \Carbon\Carbon::now(),
            ];

            // Kirim data ke model update data user
            if ($this->modelsuperadmin->update_pegawai($data, $id)) {
                return redirect('/superadmin/datapegawai')->with('toast_success', 'Data pegawai berhasil diupdate!');
            } else {
                return redirect('/superadmin/datapegawai')->with('toast_error', 'Data pegawai gagal diupdate!');
            }
        }

        // untuk update data stasiun
        if ($request->input('jenis_input') == 'data_stasiun') {
            $request->validate(
                [
                    'id_stasiun_update' => 'required|unique:stasiun,id_stasiun,' . $id . ',id_stasiun',
                    'nama_stasiun_update' => 'required|unique:stasiun,nama_stasiun,' . $id . ',id_stasiun'
                ],
                [
                    'id_stasiun_update.required' => 'ID stasiun wajib diisi!',
                    'id_stasiun_update.unique' => 'ID stasiun sudah ada!',
                    'nama_stasiun_update.required' => 'Nama stasiun wajib diisi!',
                    'nama_stasiun_update.unique' => 'Nama stasiun sudah ada!',
                ]
            );

            $nama_stasiun =  ucwords(strtolower($request->nama_stasiun_update));

            $data_stasiun = [
                'id_stasiun' => $request->id_stasiun_update,
                'nama_stasiun' => $nama_stasiun
            ];

            $update_stasiun = $this->modelsuperadmin->update_stasiun($data_stasiun, $id);

            return $update_stasiun
                ? redirect('/superadmin/master_stasiun')->with('toast_success', 'Data stasiun berhasil diupdate!')
                : redirect('/superadmin/master_stasiun')->with('toast_error', 'Update data stasiun gagal, silakan coba lagi!');
        }

        // untuk update data barang
        if ($request->input('jenis_input') == 'data_barang') {
            $request->validate(
                [
                    'kode_barang_update' => 'required|unique:barang,kode_barang,' . $id . ',kode_barang',
                    'nama_barang' => 'required'
                ],
                [
                    'kode_barang_update.required' => 'Kode barang wajib diisi!',
                    'kode_barang_update.unique' => 'Kode barang sudah ada!',
                    'nama_barang.required' => 'Nama barang wajib diisi!',
                ]
            );

            $nama_barang =  ucwords(strtolower($request->nama_barang));
            $kode_barang = strtoupper($request->kode_barang_update);

            $request->prosesor == null ? $prosesor = '-' : $prosesor = strtoupper($request->prosesor);
            $request->ram == null ? $ram = '-' : $ram = strtoupper($request->ram);
            $request->penyimpanan == null ? $penyimpanan = '-' : $penyimpanan = strtoupper($request->penyimpanan);

            $data_barang = [
                'kode_barang' => $kode_barang,
                'nama_barang' => $nama_barang,
                'prosesor' => $prosesor,
                'ram' => $ram,
                'penyimpanan' => $penyimpanan,
                'status_barang' => $request->status_barang
            ];

            $update_barang = $this->modelsuperadmin->update_barang($data_barang, $id);

            return $update_barang
                ? redirect('/superadmin/master_barang')->with('toast_success', 'Data barang berhasil diupdate!')
                : redirect('/superadmin/master_barang')->with('toast_error', 'Update barang gagal, silakan coba lagi!');
        }



        return back()->with('toast_error', 'Gagal melakukan update data!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if ($request->has('hapus_user')) {
            //fungsi untuk mencegah superadmin menghapus akunnya sendiri
            $superadminlogin = Auth::user()->id;
            if ($id == $superadminlogin) {
                return redirect('/superadmin/datauseraktif')->with('toast_error', 'Akun Anda tidak diizinkan untuk dihapus!');
            }

            // Periksa apakah ada pegawai yang menggunakan data permintaan
            $pegawaiCount = DB::table('permintaan')->where('id', $id)->count();

            if ($pegawaiCount > 0) {
                // Jika ada pegawai yang menggunakan data permintaan, kembalikan respons dengan pesan peringatan
                return back()->with('toast_error', 'Tidak dapat menghapus user karena masih terkait pada data permintaan!');
            }

            //hapus user jika tidak ada permintaan dan bukan superadmin
            $hapus_user  = $this->modeluser->delete_datauser($id);

            //jika hapus user lain maka diizinkan termasuk superadmin lain
            return $hapus_user
                ? back()->with('toast_success', 'User berhasil dihapus!')
                : back()->with('toast_error', 'User gagal dihapus!');

            // end of condition
        } else if ($request->has('hapus_pegawai')) {
            //fungsi untuk mencegah pegawai menghapus datanya sendiri
            $pegawaiLogin = Auth::user()->nip;
            if ($id == $pegawaiLogin) {
                return back()->with('toast_error', 'Data Anda tidak diizinkan untuk dihapus!');
            }


            // Periksa apakah ada pegawai yang menggunakan data permintaan
            $pegawaiCount = DB::table('pegawai')
                ->join('users', 'pegawai.nip', '=', 'users.nip')
                ->join('permintaan', 'users.id', '=', 'permintaan.id')
                ->where('pegawai.nip', $id)
                ->count();


            if ($pegawaiCount > 0) {
                // Jika ada pegawai yang menggunakan data permintaan, kembalikan respons dengan pesan peringatan
                return back()->with('toast_error', 'Tidak bisa hapus pegawai karena masih terkait pada data permintaan!');
            }

            $hapus_pegawai = $this->modelsuperadmin->delete_datapegawai($id);

            //jika hapus data pegawai lain maka diizinkan termasuk superadmin lain
            return $hapus_pegawai
                ? back()->with('toast_success', 'Pegawai berhasil dihapus!')
                : back()->with('toast_error', 'Pegawai gagal dihapus!');

            // end of condition
        } elseif ($request->has('hapus_stasiun')) {
            // return $this->modelsuperadmin->delete_stasiun($id)
            //     ? back()->with('toast_success', 'Stasiun berhasil dihapus!')
            //     : back()->with('toast_error', 'Stasiun gagal dihapus!');

            // Periksa apakah ada pegawai yang menggunakan stasiun
            $pegawaiCount = DB::table('pegawai')->where('id_stasiun', $id)->count();

            if ($pegawaiCount > 0) {
                // Jika ada pegawai yang menggunakan stasiun, kembalikan respons dengan pesan peringatan
                return back()->with('toast_error', 'Tidak dapat menghapus stasiun karena masih digunakan oleh data pegawai!');
            }

            // Jika tidak ada pegawai yang menggunakan stasiun, lakukan penghapusan
            $deleted = $this->modelsuperadmin->delete_stasiun($id);

            return $deleted
                ? back()->with('toast_success', 'Data stasiun berhasil dihapus!')
                : back()->with('toast_error', 'Data stasiun gagal dihapus!');

            // end of condition
        } elseif ($request->has('hapus_barang')) {
            return $this->modelsuperadmin->delete_barang($id)
                ? back()->with('toast_success', 'Data barang berhasil dihapus!')
                : back()->with('toast_error', 'Barang gagal dihapus!');

            // end of condition
        } elseif ($request->has('hapus_permintaan')) {


            $permintaan = DB::table('permintaan')->where('id_permintaan', $id)->first();

            if ($permintaan) {
                if ($permintaan->tipe_permintaan == 'software') {
                    $tipe_permintaan = 'instalasi software';
                } elseif ($permintaan->tipe_permintaan == 'hardware') {
                    $tipe_permintaan = 'pengecekan hardware';
                }

                // Hapus file tanda tangan dari folder public
                // Dapatkan nama file tanda tangan dari kolom ttd_requestor
                $namaFileTandaTangan = $permintaan->ttd_requestor;

                // Hapus file tanda tangan dari folder public
                $filePaths = [
                    public_path('tandatangan/instalasi_software/requestor/' . $namaFileTandaTangan),
                    public_path('tandatangan/pengecekan_hardware/requestor/' . $namaFileTandaTangan)
                ];

                foreach ($filePaths as $filePath) {
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                // Hapus data permintaan dari tabel
                $hapus_permintaan = $this->modelsuperadmin->delete_permintaan($id);


                if ($hapus_permintaan) {
                    $kode_barang = $request->kode_barang;

                    // $data_barang = [
                    //     'status_barang' => 'dikembalikan',
                    //     'updated_at' => now(),
                    // ];

                    // $this->modelsuperadmin->update_barang($data_barang, $kode_barang);

                    //metode jika hapus permintaan maka data barang juga dihapus
                    $this->modelsuperadmin->delete_barang($kode_barang);

                    return back()->with('toast_success', 'Permintaan ' . $tipe_permintaan . ' dengan nomor "' . $id . '" berhasil dihapus!');
                } else {
                    return back()->with('toast_error', 'Permintaan gagal dihapus!');
                }
            } else {
                return back()->with('toast_error', 'Data Permintaan tidak ditemukan!');
            }

            // end of condition
        } elseif ($request->has('hapus_tindaklanjut')) {


            $tindakLanjut = DB::table('tindak_lanjut')->where('id_tindak_lanjut', $id)->first();

            if ($tindakLanjut) {
                $id_permintaan = $tindakLanjut->id_permintaan;

                // Hapus file tanda tangan dari folder public
                // Dapatkan nama file tanda tangan dari kolom ttd_tindak_lanjut
                $namaFileTandaTangan = $tindakLanjut->ttd_tindak_lanjut;

                // Hapus file tanda tangan dari folder public
                $filePaths = [
                    public_path('tandatangan/instalasi_software/admin/' . $namaFileTandaTangan),
                    public_path('tandatangan/pengecekan_hardware/executor/' . $namaFileTandaTangan)
                ];

                foreach ($filePaths as $filePath) {
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                // Hapus data tindak_lanjut dari tabel
                $hapus_tindaklanjut = $this->modelsuperadmin->delete_tindaklanjut($id);

                if ($hapus_tindaklanjut) {
                    $permintaan = DB::table('permintaan')->where('id_permintaan', $id_permintaan)->first();

                    if ($permintaan) {
                        $tipePermintaan = $permintaan->tipe_permintaan;
                        $id_otorisasi = $permintaan->id_otorisasi;

                        $data_otorisasi = [
                            'status_approval' => 'pending',
                            'updated_at' => now(),
                        ];
                        $this->modelsuperadmin->update_otorisasi($data_otorisasi, $id_otorisasi);

                        // Ubah status_permintaan dan status_otorisasi
                        if ($tipePermintaan == 'hardware') {
                            $data_permintaan = [
                                'status_permintaan' => 4,
                                'updated_at' => now(),
                            ];
                        } elseif ($tipePermintaan == 'software') {
                            $data_permintaan = [
                                'status_permintaan' => 1,
                                'updated_at' => now(),
                            ];
                        }
                        $this->modelsuperadmin->update_permintaan($id_permintaan, $data_permintaan);
                    }
                    return back()->with('toast_success', 'Tindak lanjut berhasil dihapus!');
                } else {
                    return back()->with('toast_error', 'Tindak lanjut gagal dihapus!');
                }
            } else {
                return back()->with('toast_error', 'Data tindak lanjut tidak ditemukan!');
            }


            // end of condition
        } elseif ($request->has('hapus_otorisasi')) {

            $otorisasi = DB::table('otorisasi')->where('id_otorisasi', $id)->first();
            $permintaan = DB::table('permintaan')->where('id_otorisasi', $id)->first();

            if ($otorisasi && $permintaan) {
                $id_permintaan = $permintaan->id_permintaan;

                // Hapus file tanda tangan manager dari folder public
                // Dapatkan nama file tanda tangan dari kolom ttd_tindak_lanjut
                $namaFileTandaTangan = $otorisasi->ttd_manager;

                // Hapus file tanda tangan manager dari folder public
                $filePaths = [
                    public_path('tandatangan/instalasi_software/manager/' . $namaFileTandaTangan),
                    public_path('tandatangan/pengecekan_hardware/manager/' . $namaFileTandaTangan)
                ];

                foreach ($filePaths as $filePath) {
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                // Hapus file tanda tangan admin / executor dari folder public
                $tindakLanjut = DB::table('tindak_lanjut')->where('id_permintaan', $id_permintaan)->first();
                // Dapatkan nama file tanda tangan dari kolom ttd_tindak_lanjut
                $namaFileTandaTangan = $tindakLanjut->ttd_tindak_lanjut;

                // Hapus file tanda tangan dari folder public
                $filePaths_admin = [
                    public_path('tandatangan/instalasi_software/admin/' . $namaFileTandaTangan),
                    public_path('tandatangan/pengecekan_hardware/executor/' . $namaFileTandaTangan)
                ];

                foreach ($filePaths_admin as $filePath_2) {
                    if (file_exists($filePath_2)) {
                        unlink($filePath_2);
                    }
                }


                // Hapus file tanda tangan requestor dari folder public
                // Dapatkan nama file tanda tangan dari kolom ttd_requestor
                $namaFileTandaTangan = $permintaan->ttd_requestor;

                // Hapus file tanda tangan dari folder public
                $filePaths_requestor = [
                    public_path('tandatangan/instalasi_software/requestor/' . $namaFileTandaTangan),
                    public_path('tandatangan/pengecekan_hardware/requestor/' . $namaFileTandaTangan)
                ];

                foreach ($filePaths_requestor as $filePath_3) {
                    if (file_exists($filePath_3)) {
                        unlink($filePath_3);
                    }
                }


                // Hapus data tindak_lanjut dari tabel
                $hapus_otorisasi = $this->modelsuperadmin->delete_otorisasi($id);

                if ($hapus_otorisasi) {
                    return back()->with('toast_success', 'Otorisasi berhasil dihapus!');
                } else {
                    return back()->with('toast_error', 'Otorisasi gagal dihapus!');
                }
            } else {
                return back()->with('toast_error', 'Data otorisasi tidak ditemukan!');
            }

            // end of condition
        } elseif ($request->has('hapus_bast')) {

            $bast = DB::table('bast')->where('id_bast', $id)->first();
            $permintaan = DB::table('bast')->where('id_bast', $id)
                ->join('permintaan', 'bast.id_permintaan', '=', 'permintaan.id_permintaan')
                ->first();

            if ($bast && $permintaan) {
                $id_permintaan = $permintaan->id_permintaan;

                // Hapus file tanda tangan manager dari folder public
                // Dapatkan nama file tanda tangan dari kolom ttd_tindak_lanjut
                $namaFileTandaTangan_1 = $bast->ttd_menyerahkan;

                // Hapus file tanda tangan manager dari folder public
                $filePaths = [
                    public_path('tandatangan/bast/barang_masuk/yang_menyerahkan/' . $namaFileTandaTangan_1),
                    public_path('tandatangan/bast/barang_masuk/yang_menerima/' . $namaFileTandaTangan_1),
                    public_path('tandatangan/bast/barang_keluar/yang_menyerahkan/' . $namaFileTandaTangan_1),
                    public_path('tandatangan/bast/barang_keluar/yang_menerima/' . $namaFileTandaTangan_1)
                ];

                foreach ($filePaths as $filePath) {
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                $namaFileTandaTangan_2 = $bast->ttd_menerima;
                // Hapus file tanda tangan dari folder public
                $filePaths_admin = [
                    public_path('tandatangan/bast/barang_masuk/yang_menyerahkan/' . $namaFileTandaTangan_2),
                    public_path('tandatangan/bast/barang_masuk/yang_menerima/' . $namaFileTandaTangan_2),
                    public_path('tandatangan/bast/barang_keluar/yang_menyerahkan/' . $namaFileTandaTangan_2),
                    public_path('tandatangan/bast/barang_keluar/yang_menerima/' . $namaFileTandaTangan_2)
                ];

                foreach ($filePaths_admin as $filePath_2) {
                    if (file_exists($filePath_2)) {
                        unlink($filePath_2);
                    }
                }

                // Hapus data tindak_lanjut dari tabel
                $hapus_bast = $this->modelsuperadmin->delete_bast($id);

                if ($hapus_bast) {

                    // $jenis_bast = $bast->jenis_bast;
                    $id_otorisasi = $permintaan->id_otorisasi;
                    $kode_barang = $permintaan->kode_barang;

                    $data_otorisasi = [
                        'status_approval' => 'pending',
                        'updated_at' => now(),
                    ];
                    $this->modelsuperadmin->update_otorisasi($data_otorisasi, $id_otorisasi);


                    $data_permintaan = [
                        'status_permintaan' => 5,
                        'updated_at' => now(),
                    ];

                    $data_barang = [
                        'status_barang' => 'siap diambil',
                        'updated_at' => now(),
                    ];


                    $this->modelsuperadmin->update_permintaan($id_permintaan, $data_permintaan);
                    $this->modelsuperadmin->update_barang($data_barang, $kode_barang);




                    return back()->with('toast_success', 'BAST berhasil dihapus!');
                } else {
                    return back()->with('toast_error', 'BAST gagal dihapus!');
                }
            } else {
                return back()->with('toast_error', 'Data BAST tidak ditemukan!');
            }

            // end of condition
        } elseif ($request->has('hapus_bast_barang_masuk')) {

            $bast = DB::table('bast')->where('id_permintaan', $id)->first();
            $permintaan = DB::table('permintaan')->where('id_permintaan', $id)
                ->first();

            if ($bast && $permintaan) {
                $id_permintaan = $bast->id_permintaan;

                $bastBarangMasuk = DB::table('bast')->where('id_permintaan', $id)->where('jenis_bast', 'barang_masuk')->first();
                $bastBarangKeluar = DB::table('bast')->where('id_permintaan', $id)->where('jenis_bast', 'barang_keluar')->first();

                if ($bastBarangMasuk) {
                    // Hapus file tanda tangan untuk BAST jenis barang_masuk dari folder public
                    $namaFilettdmasuk_1 = $bastBarangMasuk->ttd_menyerahkan;
                    $namaFilettdmasuk_2 = $bastBarangMasuk->ttd_menerima;

                    $filePathsBarangMasuk = [
                        public_path('tandatangan/bast/barang_masuk/yang_menyerahkan/' . $namaFilettdmasuk_1),
                        public_path('tandatangan/bast/barang_masuk/yang_menerima/' . $namaFilettdmasuk_2)
                    ];

                    foreach ($filePathsBarangMasuk as $filePathBarangMasuk) {
                        if (file_exists($filePathBarangMasuk)) {
                            unlink($filePathBarangMasuk);
                        }
                    }
                }

                if ($bastBarangKeluar) {
                    // Hapus file tanda tangan untuk BAST jenis barang_keluar dari folder public
                    $namaFilettd_keluar_1 = $bastBarangKeluar->ttd_menyerahkan;
                    $namaFilettd_keluar_2 = $bastBarangKeluar->ttd_menerima;

                    $filePathsBarangKeluar = [
                        public_path('tandatangan/bast/barang_keluar/yang_menyerahkan/' . $namaFilettd_keluar_1),
                        public_path('tandatangan/bast/barang_keluar/yang_menerima/' . $namaFilettd_keluar_2)
                    ];

                    foreach ($filePathsBarangKeluar as $filePathBarangKeluar) {
                        if (file_exists($filePathBarangKeluar)) {
                            unlink($filePathBarangKeluar);
                        }
                    }
                }

                // Hapus data bast berdasarkan id_permintaan dari tabel
                $hapus_bast = $this->modelsuperadmin->delete_bast_by_id_permintaan($id);

                if ($hapus_bast) {

                    $jenis_bast = $bast->jenis_bast;
                    $id_otorisasi = $permintaan->id_otorisasi;
                    $kode_barang = $permintaan->kode_barang;

                    $data_otorisasi = [
                        'status_approval' => 'pending',
                        'updated_at' => now(),
                    ];
                    $this->modelsuperadmin->update_otorisasi($data_otorisasi, $id_otorisasi);

                    // Ubah status_permintaan dan status_otorisasi

                    $data_permintaan = [
                        'status_permintaan' => 3,
                        'updated_at' => now(),
                    ];

                    $data_barang = [
                        'status_barang' => 'belum diterima',
                        'updated_at' => now(),

                    ];

                    $this->modelsuperadmin->update_permintaan($id_permintaan, $data_permintaan);
                    $this->modelsuperadmin->update_barang($data_barang, $kode_barang);

                    return back()->with('toast_success', 'BAST berhasil dihapus!');
                } else {
                    return back()->with('toast_error', 'BAST gagal dihapus!');
                }
            } else {
                return back()->with('toast_error', 'Data BAST tidak ditemukan!');
            }

            // end of condition
        } elseif ($request->has('hapus_laporan_periodik')) {

            $laporan = DB::table('laporan_permintaan')->where('id_laporan', $id)->first();

            // Hapus file tanda tangan admin dari folder public tanda tangan laporan permintaan
            $ttd_admin = $laporan->ttd_admin;
            $tanda_tangan_admin = public_path('tandatangan/laporan_permintaan/admin/' . $ttd_admin);
            file_exists($tanda_tangan_admin) ? unlink($tanda_tangan_admin) : null;

            // Hapus file tanda tangan manager dari folder public tanda tangan laporan permintaan
            $ttd_manager = $laporan->ttd_manager;
            if (isset($ttd_manager)) {
                $tanda_tangan_manager = public_path('tandatangan/laporan_permintaan/manager/' . $ttd_manager);
                file_exists($tanda_tangan_manager) ? unlink($tanda_tangan_manager) : null;
            }

            // Hapus data laporan berdasarkan id_laporan dari tabel
            $hapus_laporan_periodik = $this->modelsuperadmin->delete_laporan_periodik_by_id_laporan($id);

            return $hapus_laporan_periodik
                ? back()->with('toast_success', 'Laporan periodik ' . $id . ' berhasil dihapus!')
                : back()->with('toast_error', 'Laporan periodik gagal dihapus!');


            // end of condition
        } else {
            return back()->with('toast_error', 'Tidak ada data yang dihapus!');
        }
    }
}
