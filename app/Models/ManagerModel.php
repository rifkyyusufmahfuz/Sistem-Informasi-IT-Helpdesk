<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class ManagerModel extends Model
{
    use HasFactory;


    public function get_data_permintaan()
    {
        return DB::table('permintaan')->get();
    }

    public function get_permintaan_software_by_otorisasi()
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            // ->join('software', 'permintaan.id_permintaan', '=', 'software.id_permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->join('tindak_lanjut', 'permintaan.id_permintaan', '=', 'tindak_lanjut.id_permintaan')
            ->join('users AS users_admin', 'tindak_lanjut.id', '=', 'users_admin.id')
            ->join('pegawai AS pegawai_admin', 'users_admin.nip', '=', 'pegawai_admin.nip')
            ->join('stasiun AS stasiun_admin', 'pegawai_admin.id_stasiun', '=', 'stasiun_admin.id_stasiun')
            ->select(
                'permintaan.*',
                'permintaan.created_at as permintaan_created_at',
                // 'software.*',
                'otorisasi.*',
                'kategori_software.*',
                'users.*',
                'pegawai.*',
                'stasiun.*',
                'barang.*',
                'tindak_lanjut.*',
                'users_admin.nip AS nip_admin',
                'pegawai_admin.nama AS nama_admin',
                'pegawai_admin.bagian AS bagian_admin',
                'pegawai_admin.jabatan AS jabatan_admin',
                'stasiun_admin.nama_stasiun AS lokasi_admin'
            )
            ->where('status_approval', '=', 'waiting')
            ->where('tipe_permintaan', '=', 'software')
            ->orderBy('permintaan.updated_at', 'asc')
            ->get()
            ->toArray();
    }

    public function get_riwayat_permintaan_software()
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            // ->join('software', 'permintaan.id_permintaan', '=', 'software.id_permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->join('tindak_lanjut', 'permintaan.id_permintaan', '=', 'tindak_lanjut.id_permintaan')
            ->join('users AS users_admin', 'tindak_lanjut.id', '=', 'users_admin.id')
            ->join('pegawai AS pegawai_admin', 'users_admin.nip', '=', 'pegawai_admin.nip')
            ->join('stasiun AS stasiun_admin', 'pegawai_admin.id_stasiun', '=', 'stasiun_admin.id_stasiun')
            ->select(
                'permintaan.*',
                'permintaan.created_at as permintaan_created_at',
                // 'software.*',
                'otorisasi.*',
                'kategori_software.*',
                'users.*',
                'pegawai.*',
                'stasiun.*',
                'barang.*',
                'tindak_lanjut.*',
                'users_admin.nip AS nip_admin',
                'pegawai_admin.nama AS nama_admin',
                'pegawai_admin.bagian AS bagian_admin',
                'pegawai_admin.jabatan AS jabatan_admin',
                'stasiun_admin.nama_stasiun AS lokasi_admin'
            )
            ->where('status_approval', '!=', 'pending')
            ->where('status_approval', '!=', 'waiting')
            ->where('tipe_permintaan', 'software')
            ->orderBy('permintaan.updated_at', 'desc')
            ->get()
            ->toArray();
    }

    public function get_list_software()
    {
        return DB::table('permintaan')
            ->join('software', 'permintaan.id_permintaan', '=', 'software.id_permintaan')
            ->select(
                'permintaan.*',
                'software.*',
            )
            ->get();
    }

    public function get_admin_by_id_tindaklanjut($id_permintaan)
    {
        return DB::table('tindak_lanjut')
            ->where('id_permintaan', $id_permintaan)
            ->select('id')
            ->first();
    }

    public function update_otorisasi($data_otorisasi, $id_otorisasi)
    {
        return DB::table('otorisasi')->where('id_otorisasi', $id_otorisasi)->update($data_otorisasi) ? true : false;
    }

    public function update_permintaan($data_permintaan, $id_permintaan)
    {
        return DB::table('permintaan')->where('id_permintaan', $id_permintaan)->update($data_permintaan) ? true : false;
    }

    public function input_notifikasi($notifikasi)
    {
        return DB::table('notifikasi')->insert($notifikasi) ? true : false;
    }

    public function cari_requestor($id_permintaan)
    {
        return DB::table('permintaan')->where('id_permintaan', $id_permintaan)->first();
    }

    public function get_permintaan_hardware_by_otorisasi()
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            // ->join('software', 'permintaan.id_permintaan', '=', 'software.id_permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            // ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->join('tindak_lanjut', 'permintaan.id_permintaan', '=', 'tindak_lanjut.id_permintaan')
            ->join('users AS users_admin', 'tindak_lanjut.id', '=', 'users_admin.id')
            ->join('pegawai AS pegawai_admin', 'users_admin.nip', '=', 'pegawai_admin.nip')
            ->join('stasiun AS stasiun_admin', 'pegawai_admin.id_stasiun', '=', 'stasiun_admin.id_stasiun')
            ->select(
                'permintaan.*',
                'permintaan.created_at as permintaan_created_at',
                // 'software.*',
                'otorisasi.*',
                // 'kategori_software.*',
                'users.*',
                'pegawai.*',
                'stasiun.*',
                'barang.*',
                'tindak_lanjut.*',
                'users_admin.nip AS nip_admin',
                'pegawai_admin.nama AS nama_admin',
                'pegawai_admin.bagian AS bagian_admin',
                'pegawai_admin.jabatan AS jabatan_admin',
                'stasiun_admin.nama_stasiun AS lokasi_admin'
            )
            ->where('status_approval', '=', 'waiting')
            ->where('tipe_permintaan', '=', 'hardware')
            ->orderBy('permintaan.updated_at', 'asc')
            ->get()
            ->toArray();
    }

    public function get_list_hardware()
    {
        return DB::table('permintaan')
            ->join('hardware', 'permintaan.id_permintaan', '=', 'hardware.id_permintaan')
            ->select(
                'permintaan.*',
                'hardware.*',
            )
            ->get();
    }

    public function get_riwayat_permintaan_hardware()
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->join('tindak_lanjut', 'permintaan.id_permintaan', '=', 'tindak_lanjut.id_permintaan')
            ->join('users AS users_admin', 'tindak_lanjut.id', '=', 'users_admin.id')
            ->join('pegawai AS pegawai_admin', 'users_admin.nip', '=', 'pegawai_admin.nip')
            ->join('stasiun AS stasiun_admin', 'pegawai_admin.id_stasiun', '=', 'stasiun_admin.id_stasiun')
            ->select(
                'permintaan.*',
                'permintaan.created_at as permintaan_created_at',
                'otorisasi.*',
                'users.*',
                'pegawai.*',
                'stasiun.*',
                'barang.*',
                'tindak_lanjut.*',
                'users_admin.nip AS nip_admin',
                'pegawai_admin.nama AS nama_admin',
                'pegawai_admin.bagian AS bagian_admin',
                'pegawai_admin.jabatan AS jabatan_admin',
                'stasiun_admin.nama_stasiun AS lokasi_admin'
            )
            ->where('status_approval', '!=', 'pending')
            ->where('status_approval', '!=', 'waiting')
            ->where('tipe_permintaan', 'hardware')
            ->orderBy('permintaan.updated_at', 'desc')
            ->get()
            ->toArray();
    }

    public function update_barang($data_barang, $kode_barang)
    {
        return DB::table('barang')->where('kode_barang', $kode_barang)->update($data_barang) ? true : false;
    }

    public function get_laporan_permintaan()
    {
        return DB::table('laporan_permintaan')
            ->join('pegawai', 'laporan_permintaan.nip_admin', '=', 'pegawai.nip')
            ->select(
                'laporan_permintaan.*',
                'laporan_permintaan.created_at AS laporan_created',
                'pegawai.*'
            )
            ->orderBy('status_laporan', 'asc')
            ->get();
    }

    public function update_laporan($data_laporan, $id_laporan)
    {
        return DB::table('laporan_permintaan')->where('id_laporan', $id_laporan)->update($data_laporan) ? true : false;
    }
}
