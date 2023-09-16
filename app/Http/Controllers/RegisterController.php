<?php

namespace App\Http\Controllers;

use App\Models\PegawaiModel;
use App\Models\RegisterModel;
use App\Models\RoleModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{

    protected $modelregister;
    public function __construct()
    {
        $this->modelregister = new RegisterModel();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_stasiun = $this->modelregister->data_stasiun();

        return view('auth.register', [
            'data_stasiun' => $data_stasiun,
        ]);
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
        // validate form input
        $request->validate(
            [
                'nip' => 'required|unique:pegawai',
                'nama' => 'required',
                'bagian' => 'required',
                'jabatan' => 'required',
                'lokasi' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required|min:6',
                'confirm_password' => 'required|same:password'
            ],
            [
                'nip.required' => 'NIP wajib diisi!',
                'nip.unique' => 'NIP sudah terdaftar!',
                'nama.required' => 'Nama wajib diisi!',
                'bagian.required' => 'Bagian wajib diisi!',
                'jabatan.required' => 'Jabatan wajib diisi!',
                'lokasi.required' => 'Lokasi wajib diisi!',

                'email.required' => 'Email wajib diisi!',
                'email.unique' => 'Email sudah terdaftar!',
                'password.required' => 'Password tidak boleh kosong!',
                'password.min' => 'Password minimal 6 karakter!',
                'confirm_password.required' => 'Konfirmasi Password tidak boleh kosong!',
                'confirm_password.same' => 'Password tidak cocok!',
            ]
        );

        // ubah value nama stasiun menjadi id_stasiun
        $nama_stasiun = $request->input('lokasi');
        $id_stasiun = $this->modelregister->getIdStasiun($nama_stasiun);
        $nama_pegawai =  ucwords(strtolower($request->nama));

        // tambah ke tabel pegawai
        $data = [
            'nip' => $request->nip,
            'nama' => $nama_pegawai,
            'bagian' => $request->bagian,
            'jabatan' => $request->jabatan,
            'id_stasiun' => $id_stasiun,
            'created_at' => \Carbon\Carbon::now(),
        ];
        $this->modelregister->registrasi_pegawai($data);


        // tambah ke tabel users
        $data2 = [
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'id_role' => 4,
            'created_at' => \Carbon\Carbon::now(),
        ];


        $email = $request->email;

        // Lanjutkan dengan menambahkan notifikasi ke tabel notifikasi
        $pesan = "" . $email . " (" . $nama_pegawai  .    ") telah melakukan registrasi akun baru.";


        $data_notifikasi = [
            'user_id' => null,
            'role_id' => 1,
            'pesan' => $pesan,
            'tautan' => '/superadmin/datausernonaktif',
            'read_at' => null,
            'created_at' => now(),
        ];


        $registrasi_user =  $this->modelregister->registrasi_user($data2);
        $kirim_notifikasi = $this->modelregister->kirim_notifikasi($data_notifikasi);


        return $registrasi_user && $kirim_notifikasi
            ? redirect('/')->with('toast_success', 'Registrasi berhasil! Akun Anda akan segera diaktifkan!')
            : back()->with('toast_error', 'Registrasi gagal! Silakan coba lagi!');

        // return redirect('/')->with('toast_success', 'Registrasi berhasil! Akun Anda akan segera diaktifkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
