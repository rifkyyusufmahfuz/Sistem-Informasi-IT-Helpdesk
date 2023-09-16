<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPermintaanModel extends Model
{
    use HasFactory;

    protected $table = 'laporan_permintaan';
    protected $primaryKey = 'id_laporan';
    public $timestamps = true;

    protected $fillable = [
        'periode_laporan',
        'jenis_laporan',
        'tanggal_awal',
        'tanggal_akhir',
        'bulan',
        'tahun',
        'nip_admin',
        'ttd_admin',
        'nip_manager',
        'ttd_manager',
    ];

    public function admin()
    {
        return $this->belongsTo(PegawaiModel::class, 'nip_admin', 'nip');
    }

    public function manager()
    {
        return $this->belongsTo(PegawaiModel::class, 'nip_manager', 'nip');
    }
}
