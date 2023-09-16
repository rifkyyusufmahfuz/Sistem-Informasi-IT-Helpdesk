<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class StasiunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stasiun = [
            ['id_stasiun' => 'JKK', 'nama_stasiun' => 'Jakarta Kota'],
            ['id_stasiun' => 'MGB', 'nama_stasiun' => 'Mangga Besar'],
            ['id_stasiun' => 'SWB', 'nama_stasiun' => 'Sawah Besar'],
            ['id_stasiun' => 'JUA', 'nama_stasiun' => 'Juanda'],
            ['id_stasiun' => 'GDD', 'nama_stasiun' => 'Gondangdia'],
            ['id_stasiun' => 'CKI', 'nama_stasiun' => 'Cikini'],
            ['id_stasiun' => 'MGR', 'nama_stasiun' => 'Manggarai'],
            ['id_stasiun' => 'TBT', 'nama_stasiun' => 'Tebet'],
            ['id_stasiun' => 'CWG', 'nama_stasiun' => 'Cawang'],
            ['id_stasiun' => 'DRK', 'nama_stasiun' => 'Duren Kalibata'],
            ['id_stasiun' => 'PSM', 'nama_stasiun' => 'Pasar Minggu'],
            ['id_stasiun' => 'LTA', 'nama_stasiun' => 'Lenteng Agung'],
            ['id_stasiun' => 'UPA', 'nama_stasiun' => 'Universitas Pancasila'],
            ['id_stasiun' => 'TJB', 'nama_stasiun' => 'Tanjung Barat'],
            ['id_stasiun' => 'DPB', 'nama_stasiun' => 'Depok Baru'],
            ['id_stasiun' => 'DPK', 'nama_stasiun' => 'Depok'],
            ['id_stasiun' => 'CTY', 'nama_stasiun' => 'Citayam'],
            ['id_stasiun' => 'BJG', 'nama_stasiun' => 'Bojonggede'],
            ['id_stasiun' => 'CBT', 'nama_stasiun' => 'Cilebut'],
            ['id_stasiun' => 'BGR', 'nama_stasiun' => 'Bogor'],
            ['id_stasiun' => 'CKR', 'nama_stasiun' => 'Cikarang'],
            ['id_stasiun' => 'TBN', 'nama_stasiun' => 'Tambun'],
            ['id_stasiun' => 'BKS', 'nama_stasiun' => 'Bekasi'],
            ['id_stasiun' => 'BRN', 'nama_stasiun' => 'Buaran'],
            ['id_stasiun' => 'KDR', 'nama_stasiun' => 'Klender'],

            ['id_stasiun' => 'JTN', 'nama_stasiun' => 'Jatinegara'],
            ['id_stasiun' => 'KMT', 'nama_stasiun' => 'Kramat'],
            ['id_stasiun' => 'GSG', 'nama_stasiun' => 'Gang Sentiong'],
            ['id_stasiun' => 'KMR', 'nama_stasiun' => 'Kemayoran'],
            ['id_stasiun' => 'RJW', 'nama_stasiun' => 'Rajawali'],
            ['id_stasiun' => 'KBD', 'nama_stasiun' => 'Kampung Bandan'],
            ['id_stasiun' => 'ANG', 'nama_stasiun' => 'Angke'],
            ['id_stasiun' => 'DUR', 'nama_stasiun' => 'Duri'],
            ['id_stasiun' => 'TAA', 'nama_stasiun' => 'Tanah Abang'],
            ['id_stasiun' => 'SDM', 'nama_stasiun' => 'Sudirman'],
            ['id_stasiun' => 'KRT', 'nama_stasiun' => 'Karet'],
            ['id_stasiun' => 'TJP', 'nama_stasiun' => 'Tanjung Priok'],
            ['id_stasiun' => 'KBY', 'nama_stasiun' => 'Kebayoran'],
            ['id_stasiun' => 'PNR', 'nama_stasiun' => 'Pondok Ranji'],
            ['id_stasiun' => 'JRM', 'nama_stasiun' => 'Jurangmangu'],
            ['id_stasiun' => 'RBG', 'nama_stasiun' => 'Rawa Buntu'],
            ['id_stasiun' => 'SRO', 'nama_stasiun' => 'Serpong'],
            ['id_stasiun' => 'CSK', 'nama_stasiun' => 'Cisauk'],
            ['id_stasiun' => 'TGK', 'nama_stasiun' => 'Tigaraksa'],
            ['id_stasiun' => 'RKB', 'nama_stasiun' => 'Rangkasbitung'],
            ['id_stasiun' => 'THT', 'nama_stasiun' => 'Tanah Tinggi'],
            ['id_stasiun' => 'TGR', 'nama_stasiun' => 'Tangerang'],
            ['id_stasiun' => 'ACL', 'nama_stasiun' => 'Ancol'],
            ['id_stasiun' => 'KRJ', 'nama_stasiun' => 'Kranji'],
            ['id_stasiun' => 'BKT', 'nama_stasiun' => 'Bekasi Timur'],

            ['id_stasiun' => 'TLM', 'nama_stasiun' => 'Telaga Murni'],
            ['id_stasiun' => 'CYR', 'nama_stasiun' => 'Cicayur'],
            ['id_stasiun' => 'CTR', 'nama_stasiun' => 'Citeras'],
            ['id_stasiun' => 'MJA', 'nama_stasiun' => 'Maja'],
            ['id_stasiun' => 'PLM', 'nama_stasiun' => 'Palmerah'],
            ['id_stasiun' => 'PRP', 'nama_stasiun' => 'Parung Panjang'],
            ['id_stasiun' => 'CJT', 'nama_stasiun' => 'Cilejit'],
            ['id_stasiun' => 'DAR', 'nama_stasiun' => 'Daru'],
            ['id_stasiun' => 'TNJ', 'nama_stasiun' => 'Tenjo'],
            ['id_stasiun' => 'CKY', 'nama_stasiun' => 'Cikoya'],
            ['id_stasiun' => 'SDA', 'nama_stasiun' => 'Sudimara'],
            ['id_stasiun' => 'KLD', 'nama_stasiun' => 'Kali Deres'],
            ['id_stasiun' => 'BCP', 'nama_stasiun' => 'Batu Ceper'],
            ['id_stasiun' => 'RWB', 'nama_stasiun' => 'Rawa Buaya'],
            ['id_stasiun' => 'BIN', 'nama_stasiun' => 'BNI City'],
            ['id_stasiun' => 'PMR', 'nama_stasiun' => 'Pasar Minggu Baru'],
            ['id_stasiun' => 'UI', 'nama_stasiun' => 'Universitas Indonesia'],
            ['id_stasiun' => 'CBI', 'nama_stasiun' => 'Cibinong'],
            ['id_stasiun' => 'NBO', 'nama_stasiun' => 'Nambo'],
            ['id_stasiun' => 'KLB', 'nama_stasiun' => 'Klender Baru'],
            ['id_stasiun' => 'JKT', 'nama_stasiun' => 'Jayakarta'],
            ['id_stasiun' => 'PDC', 'nama_stasiun' => 'Pondok Cina'],
            ['id_stasiun' => 'CBG', 'nama_stasiun' => 'Cibitung'],
            ['id_stasiun' => 'JMB', 'nama_stasiun' => 'Jambubaru'],
            ['id_stasiun' => 'CRG', 'nama_stasiun' => 'Carang'],
            ['id_stasiun' => 'CKS', 'nama_stasiun' => 'Cikeusal'],
            ['id_stasiun' => 'WLT', 'nama_stasiun' => 'Walantaka'],
            ['id_stasiun' => 'KGT', 'nama_stasiun' => 'Karangantu'],
            ['id_stasiun' => 'TNB', 'nama_stasiun' => 'Tonjongbaru'],
            ['id_stasiun' => 'CLG', 'nama_stasiun' => 'Cilegon'],
            ['id_stasiun' => 'KRC', 'nama_stasiun' => 'Krenceng'],
            ['id_stasiun' => 'MRK', 'nama_stasiun' => 'Merak'],
            ['id_stasiun' => 'BJI', 'nama_stasiun' => 'Bojong Indah'],
            ['id_stasiun' => 'TMN', 'nama_stasiun' => 'Taman Kota'],
            ['id_stasiun' => 'PSG', 'nama_stasiun' => 'Pesing'],
            ['id_stasiun' => 'GGL', 'nama_stasiun' => 'Grogol'],
            ['id_stasiun' => 'PRS', 'nama_stasiun' => 'Poris']
        ];

        foreach ($stasiun as $data) {
            $createdAt = \Carbon\Carbon::now()->subDays(rand(1, 30));

            $data['created_at'] = $createdAt;
            DB::table('stasiun')->insert($data);
        }

        // $jumlah_data_pegawai = 500; // Jumlah data pegawai yang ingin dibuat

        // for ($i = 0; $i < $jumlah_data_pegawai; $i++) {
        //     $random_stasiun = $stasiun[array_rand($stasiun)]; // Memilih stasiun secara acak
        //     $id_stasiun = $random_stasiun['id_stasiun'];

        //     DB::table('pegawai')->insert([
        //         'nip' => Str::random(5), // Fungsi untuk menghasilkan string acak dengan panjang 5 karakter
        //         'nama' => Str::random(10),
        //         'bagian' => Str::random(20),
        //         'jabatan' => Str::random(8),
        //         'id_stasiun' => $id_stasiun
        //     ]);
        // }
    }
}
