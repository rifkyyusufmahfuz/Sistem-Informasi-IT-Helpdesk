<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminModel extends Model
{
    use HasFactory;

    public function get_permintaan_software()
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->select(
                'permintaan.*',
                'permintaan.created_at as permintaan_created_at',
                'otorisasi.*',
                'kategori_software.*',
                'users.*',
                'roles.*',
                'pegawai.*',
                'stasiun.*',
                'barang.*',
            )
            ->where('tipe_permintaan', 'software')
            ->orderBy('permintaan.status_permintaan', 'asc')
            ->get()
            ->toArray();
    }

    public function get_permintaan_software_by_id($id_permintaan)
    {
        return DB::table('permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('kategori_software', 'permintaan.id_kategori', '=', 'kategori_software.id_kategori')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->select('permintaan.*', 'otorisasi.*', 'kategori_software.*', 'users.*', 'roles.*', 'pegawai.*', 'stasiun.*')
            ->where('permintaan.id_permintaan', '=', $id_permintaan)
            ->orderBy('permintaan.updated_at', 'desc')
            ->limit(1)
            ->get();
    }

    public function get_software_by_id($id_permintaan)
    {
        return DB::table('software')
            ->where('id_permintaan', '=', $id_permintaan)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function input_software($data)
    {
        if (DB::table('software')->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function hapus_software($id)
    {
        if (DB::table('software')->where('id_software', $id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public function update_permintaan($data, $id)
    {
        return DB::table('permintaan')->where('id_permintaan', $id)->update($data)
            ? true
            : false;
    }

    public function get_barang_by_id_permintaan($id)
    {
        return DB::table('permintaan')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->leftJoin('bast', 'permintaan.id_permintaan', '=', 'bast.id_permintaan')
            ->leftJoin('pegawai as pegawai_menyerahkan', 'bast.yang_menyerahkan', '=', 'pegawai_menyerahkan.nip')
            ->leftJoin('pegawai as pegawai_menerima', 'bast.yang_menerima', '=', 'pegawai_menerima.nip')
            ->leftJoin('users', 'users.nip', '=', 'pegawai_menyerahkan.nip')
            ->where('permintaan.id_permintaan', $id)
            ->select(
                'permintaan.*',
                'barang.*',
                'bast.*',
                'pegawai_menyerahkan.nama as nama_menyerahkan',
                'pegawai_menerima.nama as nama_menerima'
            )
            ->limit(1)
            ->get();
    }



    public function input_barang($data2)
    {
        if (DB::table('barang')->insert($data2)) {
            return true;
        } else {
            return false;
        }
    }

    public function update_barang($data_barang, $kode_barang)
    {
        return DB::table('barang')->where('kode_barang', $kode_barang)->update($data_barang) ? true : false;
    }

    public function update_software($data, $id)
    {
        return DB::table('software')->where('id_software', $id)->update($data) ? true : false;
    }

    public function tindak_lanjut_permintaan_software(Request $request)
    {
        $id_permintaan = $request->input('id_permintaan');

        if (!DB::table('tindak_lanjut')->where('id_permintaan', $id_permintaan)->exists()) {
            //Tanda tangan
            $folderPath = public_path('tandatangan/instalasi_software/admin/');
            if (!is_dir($folderPath)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($folderPath, 0777, true);
            }

            $filename = "admin_proses_" . $id_permintaan . ".png";
            $nama_file = $folderPath . $filename;
            file_put_contents($nama_file, file_get_contents($request->input('signature')));


            //Mendefinisikan beberapa data utama
            $id_permintaan = $request->input('id_permintaan');
            $id_otorisasi = $request->input('id_otorisasi');
            $id = auth()->user()->id;


            // Mendapatkan ID pegawai dan role_id dari tabel permintaan
            $permintaan = PermintaanModel::find($id_permintaan);
            $pegawaiId = $permintaan->id;

            // Mengirim notifikasi ke pegawai
            $pesan = 'Permintaan instalasi software Anda dengan ID Permintaan "' . $id_permintaan . '" sedang diajukan ke Manajer. Terima kasih!';
            $tautan = '/pegawai/permintaan_software';

            $kirim_notifikasi = DB::table('notifikasi')->insert([
                'pesan' => $pesan,
                'tautan' => $tautan,
                'user_id' => $pegawaiId,
                'created_at' => now()
            ]);

            $tindak_lanjut_software = DB::table('tindak_lanjut')->insert([
                'tanggal_penanganan' => now(),
                'rekomendasi' => '-',
                'ttd_tindak_lanjut' => $filename,
                'id' => $id,
                'id_permintaan' => $id_permintaan,
                'created_at' => now(),
            ]);

            $ajukan_ke_manager = DB::table('otorisasi')->where('id_otorisasi', $id_otorisasi)->update([
                'status_approval' => 'waiting',
                'updated_at' => now()
            ]);

            $update_permintaan = DB::table('permintaan')->where('id_permintaan', $id_permintaan)->update([
                'status_permintaan' => 2,
                'updated_at' => now(),
            ]);

            //kirim notifikasi ke manager
            $nama = ucwords(auth()->user()->pegawai->nama);
            $simpan_notifikasi = DB::table('notifikasi')->insert([
                'role_id' => 3,
                'pesan' => 'Permintaan instalasi software dengan ID Permintaan "' . $id_permintaan . '" diproses oleh ' . $nama . ' dan menunggu otorisasi dari Manajer.',
                'tautan' => '/manager/permintaan_software',
                'created_at' => now()
            ]);


            if ($ajukan_ke_manager && $tindak_lanjut_software && $update_permintaan && $kirim_notifikasi) {
                return true;
            } else {
                return false;
            }
        } elseif (DB::table('tindak_lanjut')->where('id_permintaan', $id_permintaan)->exists()) {
            //Tanda tangan
            $folderPath = public_path('tandatangan/instalasi_software/admin/');
            if (!is_dir($folderPath)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($folderPath, 0777, true);
            }

            $filename = "admin_revisi_" . $id_permintaan . ".png";
            $nama_file = $folderPath . $filename;
            file_put_contents($nama_file, file_get_contents($request->input('signature')));


            //Mendefinisikan beberapa data utama
            $id_permintaan = $request->input('id_permintaan');
            $id_otorisasi = $request->input('id_otorisasi');
            $id = auth()->user()->id;


            // Mendapatkan ID pegawai dan role_id dari tabel permintaan
            $permintaan = PermintaanModel::find($id_permintaan);
            $pegawaiId = $permintaan->id;
            // Mendapatkan ID tindak_lanjut
            $id_tindak_lanjut = DB::table('tindak_lanjut')
                ->where('id_permintaan', $id_permintaan)
                ->select('tindak_lanjut.id_tindak_lanjut')
                ->first()
                ->id_tindak_lanjut;

            $tindak_lanjut_software = DB::table('tindak_lanjut')
                ->where('id_tindak_lanjut', $id_tindak_lanjut)
                ->update([
                    'tanggal_penanganan' => now(),
                    'ttd_tindak_lanjut' => $filename,
                    'id' => $id,
                    // 'updated_at' => now(),
                ]);

            $ajukan_ke_manager = DB::table('otorisasi')->where('id_otorisasi', $id_otorisasi)->update([
                'status_approval' => 'waiting',
                'updated_at' => now()
            ]);

            //kirim notifikasi ke manager
            $nama = ucwords(auth()->user()->pegawai->nama);
            $simpan_notifikasi = DB::table('notifikasi')->insert([
                'role_id' => 3,
                'pesan' => 'Permintaan instalasi software dengan ID Permintaan "' . $id_permintaan . '" telah direvisi oleh ' . $nama . ' dan menunggu otorisasi kembali dari Manajer.',
                'tautan' => '/manager/permintaan_software',
                'created_at' => now()
            ]);


            if ($ajukan_ke_manager && $tindak_lanjut_software && $simpan_notifikasi) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function input_notifikasi($notifikasi)
    {
        return DB::table('notifikasi')->insert($notifikasi) ? true : false;
    }

    public function cari_id_bast()
    {
        return DB::table('bast')->orderByDesc('id_bast')->first();
    }

    public function input_bast($data_bast)
    {
        return DB::table('bast')->insert($data_bast) ? true : false;
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

    public function get_permintaan_hardware()
    {
        // Gunakan DB::table untuk membuat query builder
        return DB::table('permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->join('barang', 'permintaan.kode_barang', '=', 'barang.kode_barang')
            ->select(
                'permintaan.*',
                'permintaan.created_at as permintaan_created_at',
                'otorisasi.*',
                'users.*',
                'roles.*',
                'pegawai.*',
                'stasiun.*',
                'barang.*',
            )
            ->where('tipe_permintaan', 'hardware')
            ->orderBy('status_permintaan', 'asc')
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


    public function get_permintaan_hardware_by_id($id_permintaan)
    {
        return DB::table('permintaan')
            ->join('otorisasi', 'permintaan.id_otorisasi', '=', 'otorisasi.id_otorisasi')
            ->join('users', 'permintaan.id', '=', 'users.id')
            ->join('roles', 'users.id_role', '=', 'roles.id_role')
            ->join('pegawai', 'users.nip', '=', 'pegawai.nip')
            ->join('stasiun', 'pegawai.id_stasiun', '=', 'stasiun.id_stasiun')
            ->select('permintaan.*', 'otorisasi.*', 'users.*', 'roles.*', 'pegawai.*', 'stasiun.*')
            ->where('permintaan.id_permintaan', '=', $id_permintaan)
            ->orderBy('permintaan.updated_at', 'desc')
            ->limit(1)
            ->get();
    }

    public function get_hardware_by_id($id_permintaan)
    {
        return DB::table('hardware')
            ->where('id_permintaan', '=', $id_permintaan)
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function input_hardware($data)
    {
        if (DB::table('hardware')->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update_hardware($data, $id)
    {
        return DB::table('hardware')->where('id_hardware', $id)->update($data)
            ? true
            : false;
    }

    public function hapus_hardware($id)
    {
        if (DB::table('hardware')->where('id_hardware', $id)->delete()) {
            return true;
        } else {
            return false;
        }
    }

    public function tindak_lanjut_permintaan_hardware(Request $request)
    {
        $id_permintaan = $request->input('id_permintaan');

        if (!DB::table('tindak_lanjut')->where('id_permintaan', $id_permintaan)->exists()) {

            $request->validate(
                [
                    'rekomendasi' => 'required'
                ],
                [
                    'rekomendasi.required' => 'Rekomendasi wajib diisi!'
                ]
            );

            //Tanda tangan
            $folderPath = public_path('tandatangan/pengecekan_hardware/executor/');
            if (!is_dir($folderPath)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($folderPath, 0777, true);
            }

            $filename = "executor_proses_" . $id_permintaan . ".png";
            $nama_file = $folderPath . $filename;
            file_put_contents($nama_file, file_get_contents($request->input('signature')));


            //Mendefinisikan beberapa data utama
            $id_permintaan = $request->input('id_permintaan');
            $id_otorisasi = $request->input('id_otorisasi');
            $id = auth()->user()->id;


            // Mendapatkan ID pegawai dan role_id dari tabel permintaan
            $permintaan = PermintaanModel::find($id_permintaan);
            $pegawaiId = $permintaan->id;

            $tindak_lanjut_hardware = DB::table('tindak_lanjut')->insert([
                'tanggal_penanganan' => now(),
                'rekomendasi' => $request->rekomendasi,
                'ttd_tindak_lanjut' => $filename,
                'id' => $id,
                'id_permintaan' => $id_permintaan,
                'created_at' => now(),
            ]);

            $ajukan_ke_manager = DB::table('otorisasi')->where('id_otorisasi', $id_otorisasi)->update([
                'status_approval' => 'waiting',
                'updated_at' => now()
            ]);

            $update_permintaan = DB::table('permintaan')->where('id_permintaan', $id_permintaan)->update([
                'status_permintaan' => 2,
                'updated_at' => now(),
            ]);

            //kirim notifikasi ke manager
            $nama = ucwords(auth()->user()->pegawai->nama);
            $simpan_notifikasi = DB::table('notifikasi')->insert([
                'role_id' => 3,
                'pesan' => 'Pengecekan hardware dengan ID Permintaan "' . $id_permintaan . '" telah diselesaikan oleh ' . $nama . ' dan menunggu validasi dari Manager.',
                'tautan' => '/manager/permintaan_hardware',
                'created_at' => now()
            ]);


            if ($ajukan_ke_manager && $tindak_lanjut_hardware && $update_permintaan && $simpan_notifikasi) {
                return true;
            } else {
                return false;
            }
        } elseif (DB::table('tindak_lanjut')->where('id_permintaan', $id_permintaan)->exists()) {
            //Tanda tangan
            $folderPath = public_path('tandatangan/instalasi_software/admin/');
            if (!is_dir($folderPath)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($folderPath, 0777, true);
            }

            $filename = "admin_revisi_" . $id_permintaan . ".png";
            $nama_file = $folderPath . $filename;
            file_put_contents($nama_file, file_get_contents($request->input('signature')));


            //Mendefinisikan beberapa data utama
            $id_permintaan = $request->input('id_permintaan');
            $id_otorisasi = $request->input('id_otorisasi');
            $id = auth()->user()->id;


            // Mendapatkan ID pegawai dan role_id dari tabel permintaan
            $permintaan = PermintaanModel::find($id_permintaan);
            $pegawaiId = $permintaan->id;
            // Mendapatkan ID tindak_lanjut
            $id_tindak_lanjut = DB::table('tindak_lanjut')
                ->where('id_permintaan', $id_permintaan)
                ->select('tindak_lanjut.id_tindak_lanjut')
                ->first()
                ->id_tindak_lanjut;

            $tindak_lanjut_software = DB::table('tindak_lanjut')
                ->where('id_tindak_lanjut', $id_tindak_lanjut)
                ->update([
                    'tanggal_penanganan' => now(),
                    'ttd_tindak_lanjut' => $filename,
                    'id' => $id,
                    // 'updated_at' => now(),
                ]);

            $ajukan_ke_manager = DB::table('otorisasi')->where('id_otorisasi', $id_otorisasi)->update([
                'status_approval' => 'waiting',
                'updated_at' => now()
            ]);

            //kirim notifikasi ke manager
            $nama = ucwords(auth()->user()->pegawai->nama);
            $simpan_notifikasi = DB::table('notifikasi')->insert([
                'role_id' => 3,
                'pesan' => 'Permintaan instalasi software dengan ID Permintaan "' . $id_permintaan . '" telah direvisi oleh ' . $nama . ' dan menunggu otorisasi kembali dari Manajer.',
                'tautan' => '/manager/permintaan_software',
                'created_at' => now()
            ]);


            if ($ajukan_ke_manager && $tindak_lanjut_software && $simpan_notifikasi) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function get_tindak_lanjut_by_id_permintaan($id_permintaan)
    {
        return DB::table('tindak_lanjut')->where('id_permintaan', $id_permintaan)->get();
    }


    public function update_tindak_lanjut($data_tindak_lanjut, $id_tindak_lanjut)
    {
        return DB::table('tindak_lanjut')->where('id_tindak_lanjut', $id_tindak_lanjut)->update($data_tindak_lanjut)
            ? true
            : false;
    }

    public function get_bast_by_nip($nip)
    {
        return DB::table('bast')
            ->where('yang_menerima', $nip)
            ->orWhere('yang_menyerahkan', $nip)
            ->get();
    }

    public function get_bast_barang_masuk()
    {
        return DB::table('bast')
            ->where('jenis_bast', 'barang_masuk')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function get_bast_barang_keluar()
    {
        return DB::table('bast')
            ->where('jenis_bast', 'barang_keluar')
            ->orderBy('created_at', 'desc')
            ->get();
    }


    public function get_laporan_permintaan()
    {
        return DB::table('laporan_permintaan')
            ->orderByDesc('status_laporan')
            ->get();
    }
}
