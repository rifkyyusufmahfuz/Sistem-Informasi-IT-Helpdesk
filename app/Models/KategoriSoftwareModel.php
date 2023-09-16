<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSoftwareModel extends Model
{
    use HasFactory;

    protected $table = 'kategori_software';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;
    protected $fillable = [
        'operating_system',
        'microsoft_office',
        'software_design',
        'software_lainnya'
    ];
}
