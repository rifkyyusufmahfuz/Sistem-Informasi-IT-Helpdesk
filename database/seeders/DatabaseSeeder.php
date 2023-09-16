<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Utils\RomanNumberConverter;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            StasiunSeeder::class,
            PegawaiSeeder::class,
            RolesSeeder::class,
            UsersSeeder::class,
            NotifikasiSeeder::class,

            // PermintaanSeeder::class,
            // BarangSeeder::class
        ]);
    }
}
