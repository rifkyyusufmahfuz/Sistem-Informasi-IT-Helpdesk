<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifikasiModel extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'user_id',
        'role_id',
        'pesan',
        'read_at'
    ];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
