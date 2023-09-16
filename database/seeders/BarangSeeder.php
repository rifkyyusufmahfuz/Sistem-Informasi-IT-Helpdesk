<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $statusBarang = ['belum diterima', 'diterima', 'siap diambil', 'dikembalikan'];
        // $statusBarang = ['belum diterima', 'siap diambil'];

        for ($i = 1; $i <= 50; $i++) {
            DB::table('barang')->insert([
                'kode_barang' => 'BRG' . $i,
                'nama_barang' => 'Barang ' . $i,
                'prosesor' => 'Prosesor ' . $i,
                'ram' => $i . 'GB',
                'penyimpanan' => $i . 'GB',
                'jumlah_barang' => rand(1, 10),
                // 'status_barang' => $statusBarang[rand(0, count($statusBarang) - 1)],
                'status_barang' => 'belum diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
