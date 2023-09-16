<?php

namespace App\Http\Controllers;

use App\Models\CetakDokumenModel;
use App\Models\HardwareModel;
use App\Models\LaporanPermintaanModel;
use App\Models\PermintaanModel;
use App\Models\SoftwareModel;
use Illuminate\Http\Request;
use Nasution\Terbilang;
use App\Utils\RomanNumberConverter;

class CetakDokumenController extends Controller
{
    //untuk mendefinisikan model pegawai
    protected $modelcetak;

    public function __construct()
    {
        $this->modelcetak = new CetakDokumenModel();
    }

    public function cetak_bast_barang_masuk($id_permintaan)
    {
        $terbilang = new Terbilang();

        $data_bast_masuk = $this->modelcetak->get_bast_by_id_permintaan($id_permintaan);
        // $data_software = $this->modelcetak->get_software_by_id_permintaan($id_permintaan);

        if ($data_bast_masuk->isNotEmpty()) {
            $tanggal_bast = $data_bast_masuk[0]->tanggal_bast;
            $date = \Carbon\Carbon::parse($tanggal_bast);
            $namahari = $date->isoFormat('dddd');

            $tanggal = ucfirst($terbilang->convert($date->isoFormat('DD')));
            $bulan = $date->isoFormat('MMMM');
            $tahun = ucfirst($terbilang->convert($date->isoFormat('Y')));

            $tanggal_ttd = $date->isoFormat('DD MMMM YYYY');
        }


        return view('cetak.form_bast_barang_masuk', [
            'data_bast_masuk' => $data_bast_masuk,
            'hari' => $namahari,
            'tanggal' => $tanggal,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal_ttd' => $tanggal_ttd,
            // 'data_software' => $data_software
        ]);
    }


    public function cetak_bast_barang_keluar($id_permintaan)
    {
        $terbilang = new Terbilang();

        $data_bast_masuk = $this->modelcetak->get_bast_by_id_permintaan_2($id_permintaan);
        // $data_software = $this->modelcetak->get_software_by_id_permintaan($id_permintaan);

        if ($data_bast_masuk->isNotEmpty()) {
            $tanggal_bast = $data_bast_masuk[0]->tanggal_bast;
            $date = \Carbon\Carbon::parse($tanggal_bast);
            $namahari = $date->isoFormat('dddd');

            $tanggal = ucfirst($terbilang->convert($date->isoFormat('DD')));
            $bulan = $date->isoFormat('MMMM');
            $tahun = ucfirst($terbilang->convert($date->isoFormat('Y')));

            $tanggal_ttd = $date->isoFormat('DD MMMM YYYY');
        }


        return view('cetak.form_bast_barang_keluar', [
            'data_bast_masuk' => $data_bast_masuk,
            'hari' => $namahari,
            'tanggal' => $tanggal,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal_ttd' => $tanggal_ttd,
            // 'data_software' => $data_software
        ]);
    }



    // fungsi untuk form permintaan instalasi software
    public function cetak_form_instalasi_software($id_permintaan)
    {
        $list_software = array(
            "Microsoft Windows",
            "Microsoft Office Standar",
            "Microsoft Visio",
            "Microsoft Project",
            "Autocad",
            "Corel Draw",
            "Adobe Photoshop",
            "Adobe Premiere",
            "Adobe Ilustrator",
            "Adobe After Effect",
            "Antivirus",
            "Sketch Up Pro",
            "Vray Fr Sketchup",
            "Nitro PDF Pro",
            "Linux OS",
            "Open Office",
            "Mac OS",
            "Microsoft Office For Mac",
            "SAP",
            "Software Lainnya"
        );

        //BARU
        // Ambil data permintaan
        $permintaan = $this->modelcetak->get_table_permintaan_by_id($id_permintaan);

        // Ambil data pegawai berdasarkan nip pada tabel users
        $get_nip = $permintaan->nip;
        $pegawai = $this->modelcetak->get_pegawai_by_nip($get_nip);


        $get_id_kategori = $permintaan->id_kategori;
        $kategori = $this->modelcetak->get_kategori_by_id_kategori($get_id_kategori);

        $table_software = $this->modelcetak->get_software_by_id_permintaan($id_permintaan);

        $get_id_otorisasi = $permintaan->id_otorisasi;
        $otorisasi = $this->modelcetak->get_otorisasi_by_id_otorisasi($get_id_otorisasi);

        // Ambil data software yang telah dipilih
        $selectedSoftware = $table_software->pluck('nama_software')->toArray();

        // Ambil data dari table tindak lanjut admin
        $tindaklanjut = $this->modelcetak->get_tindak_lanjut_by_id_permintaan($id_permintaan);

        // Ambil data admin berdasarkan id pada tabel users
        $data_admin = null;
        if ($tindaklanjut) {
            $get_nip_tindak_lanjut = $tindaklanjut->nip;
            $data_admin = $this->modelcetak->get_data_admin($get_nip_tindak_lanjut);
        }


        return view('cetak.form_permintaan_instalasi_software', [
            'id_permintaan' => $id_permintaan,
            'tanggal_permintaan' => $permintaan->tanggal_permintaan,
            'nama' => $pegawai->nama,
            'nip' => $pegawai->nip,
            'bagian' => $pegawai->bagian,
            'jabatan' => $pegawai->jabatan,
            'kategori' => $kategori,
            'keluhan' => $permintaan->keluhan_kebutuhan,
            'kode_barang' => $permintaan->kode_barang,
            'ttd_requestor' => $permintaan->ttd_requestor,
            'list_software' => $list_software,
            'table_software' => $table_software,
            'otorisasi' => $otorisasi,
            'selectedSoftware' => $selectedSoftware, // Untuk Tambahkan data software yang telah dipilih
            'ttd_tindak_lanjut' => $tindaklanjut ? $tindaklanjut->ttd_tindak_lanjut : null,
            'nama_admin' => $data_admin ? $data_admin->nama : null,
        ]);
    }


    // fungsi untuk form permintaan instalasi software
    public function cetak_form_pengecekan_hardware($id_permintaan)
    {
        $list_hardware = array(
            "Hardisk",
            "Memory",
            "Monitor",
            "Keyboard",
            "Mouse",
            "Software",
            "Adaptor/Power Supply",
            "Processor",
            "Fan/Heatsink",
            "Lainnya"
        );

        //BARU
        // Ambil data permintaan
        $permintaan = $this->modelcetak->get_table_permintaan_by_id($id_permintaan);

        // Ambil data pegawai berdasarkan nip pada tabel users
        $get_nip = $permintaan->nip;
        $pegawai = $this->modelcetak->get_pegawai_by_nip($get_nip);


        $table_hardware = $this->modelcetak->get_hardware_by_id_permintaan($id_permintaan);

        $get_id_otorisasi = $permintaan->id_otorisasi;
        $otorisasi = $this->modelcetak->get_otorisasi_by_id_otorisasi($get_id_otorisasi);

        // Ambil data software yang telah dipilih
        $selectedHardware = $table_hardware->pluck('komponen')->toArray();

        // Ambil data dari table tindak lanjut admin
        $tindaklanjut = $this->modelcetak->get_tindak_lanjut_by_id_permintaan($id_permintaan);

        // Ambil data admin berdasarkan id pada tabel users
        $data_admin = null;
        if ($tindaklanjut) {
            $get_nip_tindak_lanjut = $tindaklanjut->nip;
            $data_admin = $this->modelcetak->get_data_admin($get_nip_tindak_lanjut);
        }


        return view('cetak.form_pengecekan_hardware', [
            'id_permintaan' => $id_permintaan,
            'tanggal_permintaan' => $permintaan->tanggal_permintaan,
            'nama' => $pegawai->nama,
            'nip' => $pegawai->nip,
            'bagian' => $pegawai->bagian,
            'jabatan' => $pegawai->jabatan,
            'keluhan' => $permintaan->keluhan_kebutuhan,
            'kode_barang' => $permintaan->kode_barang,
            'ttd_requestor' => $permintaan->ttd_requestor,
            'list_hardware' => $list_hardware,
            'table_hardware' => $table_hardware,
            'otorisasi' => $otorisasi,

            'ttd_tindak_lanjut' => $tindaklanjut ? $tindaklanjut->ttd_tindak_lanjut : null,
            'rekomendasi' => $tindaklanjut ? $tindaklanjut->rekomendasi : null,
            'nama_admin' => $data_admin ? $data_admin->nama : null,
        ]);
    }


    //user role admin yang bisa melakukan create laporan
    public function create_laporan_permintaan(Request $request)
    {

        $request->validate(
            [
                'jenis_filter' => 'required',
            ]
        );

        //generate id_bast 
        $cari_id_laporan =  $this->modelcetak->cari_id_laporan();

        if ($cari_id_laporan) {
            $latestId = $cari_id_laporan->id_laporan;
            $lastIdParts = explode('-', $latestId);
            $lastUrutan = intval($lastIdParts[0]);
            $lastBulan = $lastIdParts[3];
            $lastTahun = $lastIdParts[4];

            $bulanSekarang = date('n');
            $kodeBulanSekarang = RomanNumberConverter::convertMonthToRoman($bulanSekarang);
            $tahunSekarang = date('Y');

            if ($lastBulan !== $kodeBulanSekarang || $lastTahun !== $tahunSekarang) {
                $urutanBaru = 1;
            } else {
                $urutanBaru = $lastUrutan + 1;
            }
        } else {
            $urutanBaru = 1;
            $kodeBulanSekarang = RomanNumberConverter::convertMonthToRoman(date('n'));
            $tahunSekarang = date('Y');
        }
        $id_laporan_baru = sprintf('%04d', $urutanBaru) . '-KCI-LP-' . $kodeBulanSekarang . '-' . $tahunSekarang;

        //Tanda tangan yang menyerahkan barang / Pihak Pertama / P1
        $folderPath_p1 = public_path('tandatangan/laporan_permintaan/admin/');
        if (!is_dir($folderPath_p1)) {
            //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
            mkdir($folderPath_p1, 0777, true);
        }

        $filename_ttd_p1 = "lp_admin_" . $id_laporan_baru . ".png";
        $nama_file_ttd_p1 = $folderPath_p1 . $filename_ttd_p1;
        file_put_contents($nama_file_ttd_p1, file_get_contents($request->input('ttd_bast')));

        $nip = auth()->user()->pegawai->nip;

        if ($request->jenis_filter == 'harian') {
            $data = [
                'id_laporan' => $id_laporan_baru,
                'jenis_laporan' => $request->jenis_laporan,
                'periode_laporan' => $request->jenis_filter,
                'tanggal_awal' => $request->tanggal,
                'status_laporan' => 'belum divalidasi',
                'nip_admin' => $nip,
                'ttd_admin' => $filename_ttd_p1,
                'created_at' => now()
            ];
        } elseif ($request->jenis_filter == 'mingguan') {
            $data = [
                'id_laporan' => $id_laporan_baru,
                'jenis_laporan' => $request->jenis_laporan,
                'periode_laporan' => $request->jenis_filter,
                'tanggal_awal' =>  $request->tanggal_awal,
                'tanggal_akhir' =>  $request->tanggal_akhir,
                'status_laporan' => 'belum divalidasi',
                'nip_admin' => $nip,
                'ttd_admin' => $filename_ttd_p1,
                'created_at' => now()
            ];
        } elseif ($request->jenis_filter == 'bulanan') {
            $bulan = $request->bulan; // Nilai bulan dari input form (misalnya, "2023-06")
            $bulanDenganTanggal = $bulan . '-01'; // Gabungkan bulan dan tanggal (misalnya, "2023-06-01")

            $data = [
                'id_laporan' => $id_laporan_baru,
                'jenis_laporan' => $request->jenis_laporan,
                'periode_laporan' => $request->jenis_filter,
                'tanggal_awal' =>  $bulanDenganTanggal,
                'status_laporan' => 'belum divalidasi',
                'nip_admin' => $nip,
                'ttd_admin' => $filename_ttd_p1,
                'created_at' => now()
            ];
        } elseif ($request->jenis_filter == 'tahunan') {
            $tahun = $request->tahun . '-01-01'; // Gabungkan bulan dan tanggal (misalnya, "2023-01-01")

            $data = [
                'id_laporan' => $id_laporan_baru,
                'jenis_laporan' => $request->jenis_laporan,
                'periode_laporan' => $request->jenis_filter,
                'tanggal_awal' => $tahun,
                'status_laporan' => 'belum divalidasi',
                'nip_admin' => $nip,
                'ttd_admin' => $filename_ttd_p1,
                'created_at' => now()
            ];
        }

        $nama_admin = auth()->user()->pegawai->nama;

        $filter = $request->jenis_filter;

        $notifikasi = [
            'pesan' => 'Admin ' . $nama_admin . ' telah membuat laporan permintaan ' . $filter . ' dengan Nomor Laporan: "' . $id_laporan_baru . '" dan menunggu divalidasi oleh Manajer.',
            'tautan' => '/manager/laporan_periodik',
            'created_at' => now(),
            'role_id' => 3, //role manager
        ];

        $kirim_notifikasi = $this->modelcetak->input_notifikasi($notifikasi);

        $input_laporan = $this->modelcetak->input_laporan($data);


        return $input_laporan && $kirim_notifikasi ? back()->with('toast_success', 'Laporan ' . $filter . ' berhasil dibuat. Menunggu validasi dari Manajer!') : back()->with('toast_error', 'Laporan gagal dibuat');
    }

    public function cetak_laporan_periodik($id_laporan)
    {
        $laporan = LaporanPermintaanModel::findOrFail($id_laporan);
        $data_laporan = $this->modelcetak->get_laporan_by_id_laporan($id_laporan);

        // Hitung total permintaan
        $totalPermintaanSoftware = 0;
        $totalPermintaanHardware = 0;
        // Hitung jumlah software dan hardware berdasarkan jenis_laporan
        $softwareCounts = collect();
        $hardwareCounts = collect();

        if ($laporan->periode_laporan === 'harian') {
            // Hitung total permintaan dan jumlah software/hardware harian
            $totalPermintaanSoftware = PermintaanModel::where('tipe_permintaan', 'software')
                ->whereDate('tanggal_permintaan', $laporan->tanggal_awal)->count();
            $totalPermintaanHardware = PermintaanModel::where('tipe_permintaan', 'hardware')
                ->whereDate('tanggal_permintaan', $laporan->tanggal_awal)->count();

            $softwareCounts = SoftwareModel::whereHas('permintaan', function ($query) use ($laporan) {
                $query->whereDate('permintaan.tanggal_permintaan', $laporan->tanggal_awal);
            })->groupBy('software.nama_software')->selectRaw('software.nama_software, count(*) as total')->get();

            $hardwareCounts = HardwareModel::whereHas('permintaan', function ($query) use ($laporan) {
                $query->whereDate('permintaan.tanggal_permintaan', $laporan->tanggal_awal);
            })->groupBy('hardware.komponen')->selectRaw('hardware.komponen, count(*) as total')->get();
        } elseif ($laporan->periode_laporan === 'mingguan') {
            // Hitung total permintaan dan jumlah software/hardware mingguan
            $totalPermintaanSoftware = PermintaanModel::where('tipe_permintaan', 'software')
                ->whereBetween('tanggal_permintaan', [$laporan->tanggal_awal, $laporan->tanggal_akhir])->count();
            $totalPermintaanHardware = PermintaanModel::where('tipe_permintaan', 'hardware')
                ->whereBetween('tanggal_permintaan', [$laporan->tanggal_awal, $laporan->tanggal_akhir])->count();

            $softwareCounts = SoftwareModel::whereHas('permintaan', function ($query) use ($laporan) {
                $query->whereBetween('permintaan.tanggal_permintaan', [$laporan->tanggal_awal, $laporan->tanggal_akhir]);
            })->groupBy('software.nama_software')->selectRaw('software.nama_software, count(*) as total')->get();

            $hardwareCounts = HardwareModel::whereHas('permintaan', function ($query) use ($laporan) {
                $query->whereBetween('permintaan.tanggal_permintaan', [$laporan->tanggal_awal, $laporan->tanggal_akhir]);
            })->groupBy('hardware.komponen')->selectRaw('hardware.komponen, count(*) as total')->get();
        } elseif ($laporan->periode_laporan === 'bulanan') {
            $tanggal_parts = explode('-', $laporan->tanggal_awal);
            $tahun = $tanggal_parts[0];
            $bulan = $tanggal_parts[1];
            
            // Hitung total permintaan dan jumlah software/hardware bulanan
            $totalPermintaanSoftware = PermintaanModel::where('tipe_permintaan', 'software')
                ->whereMonth('tanggal_permintaan', $bulan)->count();
            $totalPermintaanHardware = PermintaanModel::where('tipe_permintaan', 'hardware')
                ->whereMonth('tanggal_permintaan', $bulan)->count();
            
            $softwareCounts = SoftwareModel::whereHas('permintaan', function ($query) use ($bulan) {
                $query->whereMonth('permintaan.tanggal_permintaan', $bulan);
            })->groupBy('software.nama_software')->selectRaw('software.nama_software, count(*) as total')->get();
            
            $hardwareCounts = HardwareModel::whereHas('permintaan', function ($query) use ($bulan) {
                $query->whereMonth('permintaan.tanggal_permintaan', $bulan);
            })->groupBy('hardware.komponen')->selectRaw('hardware.komponen, count(*) as total')->get();
        } elseif ($laporan->periode_laporan === 'tahunan') {
            // Hitung total permintaan dan jumlah software/hardware tahunan
            $totalPermintaanSoftware = PermintaanModel::where('tipe_permintaan', 'software')
                ->whereYear('tanggal_permintaan', $laporan->tanggal_awal)->count();
            $totalPermintaanHardware = PermintaanModel::where('tipe_permintaan', 'hardware')
                ->whereYear('tanggal_permintaan', $laporan->tanggal_awal)->count();

            $softwareCounts = SoftwareModel::whereHas('permintaan', function ($query) use ($laporan) {
                $query->whereYear('permintaan.tanggal_permintaan', $laporan->tanggal_awal);
            })->groupBy('software.nama_software')->selectRaw('software.nama_software, count(*) as total')->get();

            $hardwareCounts = HardwareModel::whereHas('permintaan', function ($query) use ($laporan) {
                $query->whereYear('permintaan.tanggal_permintaan', $laporan->tanggal_awal);
            })->groupBy('hardware.komponen')->selectRaw('hardware.komponen, count(*) as total')->get();
        }

        // Cari software dengan total permintaan terbanyak
        $softwareTerbanyak = $softwareCounts->max('total');
        $softwareTerbanyakData = $softwareCounts->where('total', $softwareTerbanyak)->first();

        $namaSoftwareTerbanyak = $softwareTerbanyakData ? $softwareTerbanyakData->nama_software : null;
        $totalPermintaanSoftwareTerbanyak = $softwareTerbanyakData ? $softwareTerbanyakData->total : 0;

        // Cari hardware dengan total pengecekan terbanyak
        $hardwareTerbanyak = $hardwareCounts->max('total');
        $hardwareTerbanyakData = $hardwareCounts->where('total', $hardwareTerbanyak)->first();

        $namaHardwareTerbanyak = $hardwareTerbanyakData ? $hardwareTerbanyakData->komponen : null;
        $totalPermintaanHardwareTerbanyak = $hardwareTerbanyakData ? $hardwareTerbanyakData->total : 0;


        // Pass data ke view cetak_laporan_permintaan
        return view('cetak.form_laporan_permintaan', compact(
            'laporan',
            'totalPermintaanSoftware',
            'totalPermintaanHardware',
            'softwareCounts',
            'hardwareCounts',
            'data_laporan',
            'namaSoftwareTerbanyak',
            'totalPermintaanSoftwareTerbanyak',
            'namaHardwareTerbanyak',
            'totalPermintaanHardwareTerbanyak'

        ));
    }
}
