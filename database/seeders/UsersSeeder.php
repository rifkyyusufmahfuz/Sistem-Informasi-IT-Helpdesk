<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\RoleModel;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'email' => 'superadmin@krl.co.id',
                'password' => Hash::make('123'),
                'status' => true,
                'id_role' => RoleModel::where('nama_role', 'superadmin')->first()->id_role,
                'nip' => '12121',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'email' => 'admin@krl.co.id',
                'password' => Hash::make('123'),
                'status' => true,
                'id_role' => RoleModel::where('nama_role', 'admin')->first()->id_role,
                'nip' => '12122',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'email' => 'admin_2@krl.co.id',
                'password' => Hash::make('123'),
                'status' => true,
                'id_role' => RoleModel::where('nama_role', 'admin')->first()->id_role,
                'nip' => '12123',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'email' => 'manager@krl.co.id',
                'password' => Hash::make('123'),
                'status' => true,
                'id_role' => RoleModel::where('nama_role', 'manager')->first()->id_role,
                'nip' => '12124',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'email' => 'pegawai@krl.co.id',
                'password' => Hash::make('123'),
                'status' => false,
                'id_role' => RoleModel::where('nama_role', 'pegawai')->first()->id_role,
                'nip' => '12125',
                'created_at' => \Carbon\Carbon::now(),
            ],
            [
                'email' => 'rifkyyusufmahfud@gmail.com',
                'password' => Hash::make('123'),
                'status' => true,
                'id_role' => RoleModel::where('nama_role', 'pegawai')->first()->id_role,
                'nip' => '12126',
                'created_at' => \Carbon\Carbon::now(),
            ],
        ];

        // Memasukkan data user ke dalam tabel users
        User::insert($users);
    }
}
