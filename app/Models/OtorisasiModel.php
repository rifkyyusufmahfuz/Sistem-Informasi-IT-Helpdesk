<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtorisasiModel extends Model
{
    use HasFactory;

    protected $table = 'otorisasi';

    protected $primaryKey = 'id_otorisasi';

    protected $fillable = [
        'tanggal_approval',
        'status_approval',
        'catatan',
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function permintaan()
    {
        return $this->hasMany(PermintaanModel::class, 'id_otorisasi');
    }
}
