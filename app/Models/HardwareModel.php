<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareModel extends Model
{
    use HasFactory;

    protected $table = 'hardware';
    protected $primaryKey = 'id_hardware';
    public $timestamps = true;

    protected $fillable = [
        'komponen',
        'status_hardware',
        'problem',
        'id_permintaan',
    ];

    public function permintaan()
    {
        return $this->belongsTo(PermintaanModel::class, 'id_permintaan', 'id_permintaan');
    }
}
