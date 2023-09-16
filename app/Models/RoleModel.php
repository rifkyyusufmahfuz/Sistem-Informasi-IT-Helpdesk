<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'id_role';
    protected $fillable = [
        'nama_role'
    ];
    // untuk memproteksi field id
    protected $guarded = ['id_role'];

    // untuk relasi one To Many
    public function users() {
        return $this->hasMany(User::class);
    }
}
