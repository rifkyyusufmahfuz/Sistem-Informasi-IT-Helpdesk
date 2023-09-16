<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StasiunModel extends Model
{
    use HasFactory;
    protected $table = 'stasiun';
    protected $primaryKey = 'id_stasiun';

    protected $fillable = [
        'nama_stasiun',
    ];

    public function pegawai()
    {
        return $this->hasMany(PegawaiModel::class, 'id_stasiun');
    }
}
