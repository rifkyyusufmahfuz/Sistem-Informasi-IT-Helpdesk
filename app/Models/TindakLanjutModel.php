<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakLanjutModel extends Model
{
    use HasFactory;
    protected $table = 'tindak_lanjut';
    protected $primaryKey = 'id_tindak_lanjut';

    protected $fillable = [
        'tanggal_penanganan',
        'ttd_tindak_lanjut',
    ];

    //relasi ke table user
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function permintaan()
    {
        return $this->hasMany(PermintaanModel::class, 'id_otorisasi');
    }
}
