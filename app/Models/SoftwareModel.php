<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareModel extends Model
{
    use HasFactory;

    protected $table = 'software';
    protected $primaryKey = 'id_software';
    public $timestamps = true;

    protected $fillable = [
        'nama_software',
        'versi_software',
        'notes',
        'id_permintaan',
    ];

    public function permintaan()
    {
        return $this->belongsTo(PermintaanModel::class, 'id_permintaan', 'id_permintaan');
    }
}
