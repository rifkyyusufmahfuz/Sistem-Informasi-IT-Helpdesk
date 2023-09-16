<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegisterModel extends Model
{
    use HasFactory;

    public function data_stasiun()
    {
        return DB::table('stasiun')->get();
    }

    public function getIdStasiun($nama_stasiun)
    {
        $stasiun = DB::table('stasiun')->where('nama_stasiun', $nama_stasiun)->first();
        if ($stasiun) {
            return $stasiun->id_stasiun;
        } else {
            return null;
        }
    }

    public function registrasi_pegawai($data)
    {
        return DB::table('pegawai')->insert($data);
    }

    public function registrasi_user($data2)
    {
        return DB::table('users')->insert($data2);
    }

    public function kirim_notifikasi($data_notifikasi)
    {
        return DB::table('notifikasi')->insert($data_notifikasi);
    }
}
