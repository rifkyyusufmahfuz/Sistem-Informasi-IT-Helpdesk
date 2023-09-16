<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoleModel;
class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat data roles
        $roles = [
            ['id_role' => '1', 'nama_role' => 'superadmin'],
            ['id_role' => '2', 'nama_role' => 'admin'],
            ['id_role' => '3', 'nama_role' => 'manager'],
            ['id_role' => '4', 'nama_role' => 'pegawai'],
        ];

        // Memasukkan data roles ke dalam tabel roles
        RoleModel::insert($roles);
    }
}
