<?php

namespace App\Http\Controllers;

use App\Models\AdminModel;
use App\Models\PermintaanModel;
use Illuminate\Http\Request;
use App\Utils\RomanNumberConverter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $modeladmin;

    public function __construct()
    {
        $this->modeladmin = new AdminModel();
    }


    public function index()
    {
        $permintaanData = DB::table('permintaan')
            ->select('tipe_permintaan', DB::raw('COUNT(id_permintaan) as jumlah_permintaan'))
            ->groupBy('tipe_permintaan')
            ->get();


        $statusPermintaanData = DB::table('permintaan')
            ->select('status_permintaan', DB::raw('COUNT(id_permintaan) as jumlah_permintaan'))
            ->groupBy('status_permintaan')
            ->get();

        // Mapping status_permintaan ke label sesuai spesifikasi
        $statusMapping = [
            1 => 'Pending',
            2 => 'Ditinjau',
            3 => 'Menunggu Unit',
            4 => 'Diproses',
            5 => 'Unit Siap Diambil',
            6 => 'Permintaan Selesai',
            0 => 'Ditolak'
        ];
        $statusPermintaanLabels = [
            'Pending',
            'Ditinjau',
            'Menunggu Unit',
            'Diproses',
            'Unit Siap Diambil',
            'Permintaan Selesai',
            'Ditolak'
        ];

        // Membuat array untuk menyimpan data yang akan digunakan di view
        $chartData = [];
        foreach ($statusPermintaanData as $data) {
            $status = $statusMapping[$data->status_permintaan] ?? 'Tidak Diketahui';
            $chartData[$status] = $data->jumlah_permintaan;
        }

        // Mengurutkan data sesuai urutan statusPermintaanLabels
        $sortedChartData = [];
        foreach ($statusPermintaanLabels as $label) {
            $sortedChartData[$label] = $chartData[$label] ?? 0;
        }


        $allData = PermintaanModel::where('id', auth()->user()->id)
            ->groupBy(['tipe_permintaan', 'status_permintaan'])
            ->selectRaw('tipe_permintaan, status_permintaan, COUNT(*) as count')
            ->get()
            ->groupBy('tipe_permintaan')
            ->map(function ($group) {
                return $group->pluck('count', 'status_permintaan')->toArray();
            })
            ->toArray();

        return view('admin.index', compact(
            'permintaanData',
            'sortedChartData',
            'allData'
        ));
    }

    public function permintaan_software()
    {
        $permintaan = $this->modeladmin->get_permintaan_software();
        $list_software = $this->modeladmin->get_list_software();

        return view(
            'admin.software.permintaan_software',
            [
                'permintaan' => $permintaan,
                'list_software' => $list_software,
                'now' => \Carbon\Carbon::now()->format('Y-m-d')
            ]
        );
    }

    public function tambah_software($id_permintaan)
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

        $permintaan = $this->modeladmin->get_permintaan_software_by_id($id_permintaan);
        $software = $this->modeladmin->get_software_by_id($id_permintaan);

        $isSoftwareFilled = true; // Anggap awalnya semuanya terisi

        if ($software) {
            foreach ($software as $sw) {
                if (empty($sw->versi_software) || empty($sw->notes)) {
                    $isSoftwareFilled = false;
                    break;
                }
            }
        } else {
            $isSoftwareFilled = false; // Tidak ada data software
        }

        return view(
            'admin.software.tindak_lanjut_software',
            [
                'permintaan' => $permintaan,
                'software' => $software,
                'list_software' => $list_software,
                'isSoftwareFilled' => $isSoftwareFilled,
            ]
        );
    }


    public function bast_software($id_permintaan)
    {
        $permintaan = $this->modeladmin->get_permintaan_software_by_id($id_permintaan);
        $barang = $this->modeladmin->get_barang_by_id_permintaan($id_permintaan);
        // $bast = $this->modeladmin->get_bast_by_id_permintaan($id_permintaan);
        return view(
            'admin.software.bast_software',
            [
                'permintaan' => $permintaan,
                'barang' => $barang,
                // 'bast' => $bast,
            ]
        );
    }

    public function tindak_lanjut_software(Request $request)
    {
        if ($this->modeladmin->tindak_lanjut_permintaan_software($request)) {
            return redirect('/admin/permintaan_software')->with('toast_success', 'Permintaan berhasil diajukan ke Manajer!');
        } else {
            return redirect('/admin/permintaan_software')->with('toast_error', 'Permintaan gagal ditambahkan!');
        }
    }

    public function permintaan_hardware()
    {
        $permintaan = $this->modeladmin->get_permintaan_hardware();
        $list_hardware = $this->modeladmin->get_list_hardware();

        return view(
            'admin.hardware.permintaan_hardware',
            [
                'permintaan' => $permintaan,
                'list_hardware' => $list_hardware,
                'now' => \Carbon\Carbon::now()->format('Y-m-d')
            ]
        );
    }

    public function cek_hardware($id_permintaan)
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

        $permintaan = $this->modeladmin->get_permintaan_hardware_by_id($id_permintaan);
        $hardware = $this->modeladmin->get_hardware_by_id($id_permintaan);

        $isHardwareFilled = false;
        if ($hardware) {
            foreach ($hardware as $hw) {
                if (!empty($hw->status_hardware) && !empty($hw->problem)) {
                    $isHardwareFilled = true;
                    break;
                }
            }
        }
        return view(
            'admin.hardware.tindak_lanjut_hardware',
            [
                'permintaan' => $permintaan,
                'hardware' => $hardware,
                'list_hardware' => $list_hardware,
                'isHardwareFilled' => $isHardwareFilled,
            ]
        );
    }

    public function bast_hardware($id_permintaan)
    {
        $permintaan = $this->modeladmin->get_permintaan_hardware_by_id($id_permintaan);
        $barang = $this->modeladmin->get_barang_by_id_permintaan($id_permintaan);
        // $bast = $this->modeladmin->get_bast_by_id_permintaan($id_permintaan);

        return view(
            'admin.hardware.bast_hardware',
            [
                'permintaan' => $permintaan,
                'barang' => $barang,
                // 'bast' => $bast,
            ]
        );
    }

    public function tindak_lanjut_hardware(Request $request)
    {
        if ($this->modeladmin->tindak_lanjut_permintaan_hardware($request)) {
            return redirect('/admin/permintaan_hardware')->with('toast_success', 'Rekomendasi berhasil diajukan ke Manajer!');
        } else {
            return redirect('/admin/permintaan_hardware')->with('toast_error', 'Permintaan gagal ditambahkan!');
        }
    }

    public function halaman_barang_masuk_admin()
    {
        $nip = auth()->user()->pegawai->nip;

        // $bast = $this->modeladmin->get_bast_by_nip($nip);
        $bast_barang_masuk = $this->modeladmin->get_bast_barang_masuk();
        // $barang = $this->modeladmin->get_barang_by_id_permintaan();
        // $bast = $this->modeladmin->get_bast_by_id_permintaan($id_permintaan);

        return view(
            'halaman_bast.barang_masuk',
            [
                'bast_barang_masuk' => $bast_barang_masuk,
            ]
        );
    }

    public function halaman_barang_keluar_admin()
    {
        $bast_barang_keluar = $this->modeladmin->get_bast_barang_keluar();

        return view(
            'halaman_bast.barang_keluar',
            [
                'bast_barang_keluar' => $bast_barang_keluar,
            ]
        );
    }

    public function halaman_cetak_laporan_permintaan()
    {
        $laporan_permintaan = $this->modeladmin->get_laporan_permintaan();

        return view(
            'admin.laporan_permintaan.halaman_cetak_laporan',
            compact(
                'laporan_permintaan'
            )
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // fungsi untuk tambah software 
        if ($request->has('nama_software')) {
            $request->validate(
                // validasi form 
                [
                    'id_permintaan' => 'required',
                    // 'nama_software' => 'required',
                    'nama_software' => 'required|unique:software,nama_software,NULL, permintaan,id_permintaan,' . $request->id_permintaan,
                    'versi_software' => 'required',
                    // 'notes' => 'required',
                ],
                // custom error notifikasi
                [
                    'id_permintaan.required' => 'ID Permintaan wajib diisi!',
                    'nama_software.required' => 'Nama software wajib diisi!',
                    'nama_software.unique' => 'Software ini sudah diinput!',
                    'versi_software.required' => 'Versi software wajib diisi!',
                    // 'notes' => 'Notes wajib diisi!',
                ]
            );

            $catatan = $request->notes ?: '-';

            $data = [
                'id_permintaan' => $request->id_permintaan,
                'nama_software' => $request->nama_software,
                'versi_software' => $request->versi_software,
                'notes' => $catatan,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ];

            if ($this->modeladmin->input_software($data)) {
                return back()->with('toast_success', 'Tambah software berhasil!');
            } else {
                return back()->with('toast_error', 'Tambah software gagal!');
            }
        }
        //fungsi untuk BAST Barang Masuk
        else if ($request->input('jenis_bast') == 'barang_masuk') {
            $id_permintaan = $request->id_permintaan;

            //generate id_bast 
            $bast_terbaru =  $this->modeladmin->cari_id_bast();

            if ($bast_terbaru) {
                $latestId = $bast_terbaru->id_bast;
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
            $id_bast_baru = sprintf('%04d', $urutanBaru) . '-KCI-BAST-' . $kodeBulanSekarang . '-' . $tahunSekarang;

            //Tanda tangan yang menyerahkan barang / Pihak Pertama / P1
            $folderPath_p1 = public_path('tandatangan/bast/barang_masuk/yang_menyerahkan/');
            if (!is_dir($folderPath_p1)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($folderPath_p1, 0777, true);
            }
            $filename_ttd_p1 = "bast_pihakpertama_" . $id_bast_baru . ".png";
            $nama_file_ttd_p1 = $folderPath_p1 . $filename_ttd_p1;
            file_put_contents($nama_file_ttd_p1, file_get_contents($request->input('signature')));

            //Tanda tangan yang menerima barang / Pihak kedua / P2
            $folderPath_p2 = public_path('tandatangan/bast/barang_masuk/yang_menerima/');
            if (!is_dir($folderPath_p2)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($folderPath_p2, 0777, true);
            }

            $filename_ttd_p2 = "bast_pihakkedua_" . $id_bast_baru . ".png";
            $nama_file_ttd_p2 = $folderPath_p2 . $filename_ttd_p2;
            file_put_contents($nama_file_ttd_p2, file_get_contents($request->input('ttd_bast')));


            if ($request->input('keperluan') == 'pengecekan_hardware') {
                $data_bast = [
                    'id_bast' => $id_bast_baru,
                    'tanggal_bast' => now(),
                    'jenis_bast' => $request->jenis_bast,
                    'perihal' => 'Pengecekan hardware',
                    'ttd_menyerahkan' => $filename_ttd_p1,
                    'yang_menyerahkan' => $request->nip_p1,
                    'ttd_menerima' => $filename_ttd_p2,
                    'yang_menerima' => $request->nip_pegawai,
                    'id_permintaan' => $request->id_permintaan,
                    'id_stasiun' => 'JUA',
                    'created_at' => now(),
                ];
            } elseif ($request->input('keperluan') == 'instalasi_software') {
                $data_bast = [
                    'id_bast' => $id_bast_baru,
                    'tanggal_bast' => now(),
                    'jenis_bast' => $request->jenis_bast,
                    'perihal' => 'Instalasi software',
                    'ttd_menyerahkan' => $filename_ttd_p1,
                    'yang_menyerahkan' => $request->nip_p1,
                    'ttd_menerima' => $filename_ttd_p2,
                    'yang_menerima' => $request->nip_pegawai,
                    'id_permintaan' => $request->id_permintaan,
                    'id_stasiun' => 'JUA',
                    'created_at' => now(),
                ];
            }

            // Mendapatkan ID pegawai dan role_id dari tabel permintaan
            $id_permintaan = $request->id_permintaan;

            $permintaan = PermintaanModel::find($id_permintaan);
            $pegawaiId = $permintaan->id;

            $notifikasi = [
                'pesan' => 'Anda baru saja melakukan Serah Terima Barang dengan Nomor BAST : ' . $id_bast_baru . '.',
                'tautan' => '/pegawai/halaman_bast_barang_diserahkan',
                'created_at' => now(),
                'user_id' => $pegawaiId,
            ];

            $data_permintaan = [
                'status_permintaan' => 4,
                'updated_at' => now(),
            ];

            $kode_barang = $request->kode_barang;

            $data_barang = [
                'status_barang' => 'diterima',
                'updated_at' => now(),
            ];

            $update_permintaan = $this->modeladmin->update_permintaan($data_permintaan, $id_permintaan);
            $update_barang = $this->modeladmin->update_barang($data_barang, $kode_barang);
            // $update_tindak_lanjut = $this->modeladmin->update_tindak_lanjut($data_tindak_lanjut, $id_tindak_lanjut);
            $input_bast_barang_masuk = $this->modeladmin->input_bast($data_bast);
            $kirim_notifikasi = $this->modeladmin->input_notifikasi($notifikasi);



            // menggunakan operator ternary (pengganti kondisi dengan if else)
            //untuk mengembalikan pesan apakah berhasil atau tidak
            return ($input_bast_barang_masuk && $kirim_notifikasi && $update_permintaan && $update_barang)
                ? back()->with('toast_success', 'Input BAST berhasil!')
                : back()->with('toast_error', 'Input BAST gagal!');
        } else if ($request->input('jenis_bast') == 'barang_keluar') {
            $id_permintaan = $request->id_permintaan;

            //generate id_bast 
            $bast_terbaru =  $this->modeladmin->cari_id_bast();

            if ($bast_terbaru) {
                $latestId = $bast_terbaru->id_bast;
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
            $id_bast_baru = sprintf('%04d', $urutanBaru) . '-KCI-BAST-' . $kodeBulanSekarang . '-' . $tahunSekarang;

            //Tanda tangan yang menyerahkan barang / Pihak Pertama / P1
            $folderPath_p1 = public_path('tandatangan/bast/barang_keluar/yang_menyerahkan/');
            if (!is_dir($folderPath_p1)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($folderPath_p1, 0777, true);
            }
            $filename_ttd_p1 = "bast_pihakpertama_" . $id_bast_baru . ".png";
            $nama_file_ttd_p1 = $folderPath_p1 . $filename_ttd_p1;
            file_put_contents($nama_file_ttd_p1, file_get_contents($request->input('signature')));

            //Tanda tangan yang menerima barang / Pihak kedua / P2
            $folderPath_p2 = public_path('tandatangan/bast/barang_keluar/yang_menerima/');
            if (!is_dir($folderPath_p2)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($folderPath_p2, 0777, true);
            }

            $filename_ttd_p2 = "bast_pihakkedua_" . $id_bast_baru . ".png";
            $nama_file_ttd_p2 = $folderPath_p2 . $filename_ttd_p2;
            file_put_contents($nama_file_ttd_p2, file_get_contents($request->input('ttd_bast')));


            if ($request->input('keperluan') == 'pengecekan_hardware') {
                $data_bast = [
                    'id_bast' => $id_bast_baru,
                    'tanggal_bast' => now(),
                    'jenis_bast' => $request->jenis_bast,
                    'perihal' => 'Pengembalian unit yang telah dilakukan pengecekan hardware',
                    'ttd_menyerahkan' => $filename_ttd_p1,
                    'yang_menyerahkan' => $request->nip_p1,
                    'ttd_menerima' => $filename_ttd_p2,
                    'yang_menerima' => $request->nip_pegawai,
                    'id_permintaan' => $request->id_permintaan,
                    'id_stasiun' => 'JUA',
                    'created_at' => now(),
                ];
            } elseif ($request->input('keperluan') == 'instalasi_software') {
                $data_bast = [
                    'id_bast' => $id_bast_baru,
                    'tanggal_bast' => now(),
                    'jenis_bast' => $request->jenis_bast,
                    'perihal' => 'Pengembalian unit yang telah dilakukan instalasi software',
                    'ttd_menyerahkan' => $filename_ttd_p1,
                    'yang_menyerahkan' => $request->nip_p1,
                    'ttd_menerima' => $filename_ttd_p2,
                    'yang_menerima' => $request->nip_pegawai,
                    'id_permintaan' => $request->id_permintaan,
                    'id_stasiun' => 'JUA',
                    'created_at' => now(),
                ];
            }

            // Mendapatkan ID pegawai dan role_id dari tabel permintaan
            $id_permintaan = $request->id_permintaan;

            $permintaan = PermintaanModel::find($id_permintaan);
            $pegawaiId = $permintaan->id;

            $notifikasi = [
                'pesan' => 'Anda baru saja melakukan Serah Terima Barang dengan Nomor BAST : ' . $id_bast_baru . '.',
                'tautan' => '/pegawai/halaman_bast_barang_diterima',
                'created_at' => now(),
                'user_id' => $pegawaiId,
            ];

            $data_permintaan = [
                'status_permintaan' => 6,
                'updated_at' => now(),
            ];

            $kode_barang = $request->kode_barang;

            $data_barang = [
                'status_barang' => 'dikembalikan',
                'updated_at' => now(),
            ];

            $update_permintaan = $this->modeladmin->update_permintaan($data_permintaan, $id_permintaan);
            $update_barang = $this->modeladmin->update_barang($data_barang, $kode_barang);
            $input_bast_barang_masuk = $this->modeladmin->input_bast($data_bast);
            $kirim_notifikasi = $this->modeladmin->input_notifikasi($notifikasi);

            // menggunakan operator ternary (pengganti kondisi dengan if else)
            //untuk mengembalikan pesan apakah berhasil atau tidak
            return ($input_bast_barang_masuk && $kirim_notifikasi && $update_permintaan && $update_barang)
                ? back()->with('toast_success', 'BAST Pengembalian barang berhasil!')
                : back()->with('toast_error', 'BAST pengembalian barang gagal!');
        }
        //fungsi untuk input cek hardware
        else if ($request->has('komponen')) {

            $request->validate([
                'id_permintaan' => 'required',
                'komponen' => 'required|unique:hardware,komponen,NULL, permintaan,id_permintaan,' . $request->id_permintaan,
                'status_hardware' => 'required',
            ], [
                'komponen.required' => 'Nama software wajib diisi!',
                'komponen.unique' => 'Komponen ini sudah diinput!',
                'status_hardware.required' => 'Versi software wajib diisi!',
            ]);


            $problem = $request->problem ?: '-';

            $data = [
                'id_permintaan' => $request->id_permintaan,
                'komponen' => $request->komponen,
                'status_hardware' => $request->status_hardware,
                'problem' => $problem,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ];

            if ($this->modeladmin->input_hardware($data)) {
                return back()->with('toast_success', 'Komponen hardware berhasil diinput!');
            } else {
                return back()->with('toast_error', 'Komponen hardware gagal diinput, silakan coba lagi!');
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->has('selesaikan_permintaan')) {
            //update table permintaan
            $data = [
                'status_permintaan' => 5,
                'updated_at' => now()
            ];
            // Mendapatkan ID pegawai dan role_id dari tabel permintaan
            $id_permintaan = $request->id_permintaan;

            //update table barang
            $kode_barang = $request->kode_barang;
            $data_barang = [
                'status_barang' => 'siap diambil',
                'updated_at' => now()
            ];

            $permintaan = PermintaanModel::find($id_permintaan);
            $pegawaiId = $permintaan->id;

            if ($request->selesaikan_permintaan == 'permintaan_software') {
                $notifikasi = [
                    'pesan' => 'Permintaan instalasi software Anda dengan ID Permintaan = ' . $id_permintaan . ' telah selesai. Silakan ambil PC / Laptop Anda di NOC. Terima kasih!',
                    'tautan' => '/pegawai/permintaan_software',
                    'created_at' => now(),
                    'user_id' => $pegawaiId,
                ];

                //kirim notifikasi ke requestor / pegawai melalui email
                $email = DB::table('permintaan')
                    ->join('users', 'permintaan.id', '=', 'users.id')
                    ->where('permintaan.id_permintaan', $id_permintaan)
                    ->value('users.email');

                $data_unit = DB::table('barang')
                    ->join('permintaan', 'barang.kode_barang', '=', 'permintaan.kode_barang')
                    ->where('permintaan.id_permintaan', $id_permintaan)
                    ->select('barang.*')
                    ->get();

                $data_tindak_lanjut = DB::table('tindak_lanjut')
                    ->join('permintaan', 'tindak_lanjut.id_permintaan', '=', 'permintaan.id_permintaan')
                    ->where('permintaan.id_permintaan', $id_permintaan)
                    ->select('tindak_lanjut.*')
                    ->get();

                $data_software = DB::table('permintaan')
                    ->join('software', 'permintaan.id_permintaan', '=', 'software.id_permintaan')
                    ->where('permintaan.id_permintaan', $id_permintaan)
                    ->select(
                        'permintaan.*',
                        'software.*',
                    )
                    ->get();

                $permintaan = PermintaanModel::find($id_permintaan);
                $keluhan = $permintaan->keluhan_kebutuhan;

                $formatted_id_permintaan = Str::replace('-', '/', $id_permintaan);

                Mail::send(
                    'notifikasi_email.requestor.permintaan_software_selesai',
                    [
                        'id_permintaan' => $id_permintaan,
                        'id_permintaan_formatted' => $formatted_id_permintaan,
                        'data_unit' => $data_unit,
                        'keluhan' => $keluhan,
                        'data_software' => $data_software
                    ],
                    function ($message) use ($email, $formatted_id_permintaan) {
                        $message->to($email);
                        $message->subject('Instalasi Software Selesai: ' . $formatted_id_permintaan);
                    }
                );
            } elseif ($request->selesaikan_permintaan == 'permintaan_hardware') {
                $notifikasi = [
                    'pesan' => 'Permintaan pengecekan hardware Anda dengan ID Permintaan = ' . $id_permintaan . ' telah selesai. Silakan ambil unit di NOC. Terima kasih!',
                    'tautan' => '/pegawai/permintaan_hardware',
                    'created_at' => now(),
                    'user_id' => $pegawaiId,
                ];

                //kirim notifikasi ke requestor / pegawai melalui email
                $email = DB::table('permintaan')
                    ->join('users', 'permintaan.id', '=', 'users.id')
                    ->where('permintaan.id_permintaan', $id_permintaan)
                    ->value('users.email');

                $data_unit = DB::table('barang')
                    ->join('permintaan', 'barang.kode_barang', '=', 'permintaan.kode_barang')
                    ->where('permintaan.id_permintaan', $id_permintaan)
                    ->select('barang.*')
                    ->get();

                $data_tindak_lanjut = DB::table('tindak_lanjut')
                    ->join('permintaan', 'tindak_lanjut.id_permintaan', '=', 'permintaan.id_permintaan')
                    ->where('permintaan.id_permintaan', $id_permintaan)
                    ->select('tindak_lanjut.*')
                    ->get();

                $permintaan = PermintaanModel::find($id_permintaan);
                $keluhan = $permintaan->keluhan_kebutuhan;

                $formatted_id_permintaan = Str::replace('-', '/', $id_permintaan);

                Mail::send(
                    'notifikasi_email.requestor.permintaan_hardware_selesai',
                    [
                        'id_permintaan' => $id_permintaan,
                        'id_permintaan_formatted' => $formatted_id_permintaan,
                        'data_unit' => $data_unit,
                        'tindak_lanjut' => $data_tindak_lanjut,
                        'keluhan' => $keluhan
                    ],
                    function ($message) use ($email, $formatted_id_permintaan) {
                        $message->to($email);
                        $message->subject('Pengecekan Hardware Selesai: ' . $formatted_id_permintaan);
                    }
                );
            }


            $update_permintaan = $this->modeladmin->update_permintaan($data, $id);
            $update_barang = $this->modeladmin->update_barang($data_barang, $kode_barang);
            $kirim_notifikasi = $this->modeladmin->input_notifikasi($notifikasi);

            return $update_permintaan && $update_barang && $kirim_notifikasi
                ? back()->with('toast_success', 'Proses permintaan telah diselesaikan, requestor telah diberitahukan untuk mengambil unit!')
                : back()->with('toast_error', 'Status permintaan gagal diubah!');
        } else if ($request->has('acc_permintaan')) {
            //update table permintaan
            $data = [
                'status_permintaan' => $request->status_permintaan,
                'updated_at' => now()
            ];
            // Mendapatkan ID pegawai dan role_id dari tabel permintaan
            $id_permintaan = $request->id_permintaan;

            $permintaan = PermintaanModel::find($id_permintaan);
            $pegawaiId = $permintaan->id;

            $notifikasi = [
                'pesan' => 'Permintaan pengecekan hardware Anda dengan ID Permintaan = ' . $id_permintaan . ' telah diterima. Silakan bawa unit yang akan dicek ke NOC. Terima kasih!',
                'tautan' => '/pegawai/permintaan_hardware',
                'created_at' => now(),
                'user_id' => $pegawaiId,
            ];


            //kirim notifikasi ke requestor / pegawai melalui email
            $email = DB::table('permintaan')
                ->join('users', 'permintaan.id', '=', 'users.id')
                ->where('permintaan.id_permintaan', $id_permintaan)
                ->value('users.email');

            $data_unit = DB::table('barang')
                ->join('permintaan', 'barang.kode_barang', '=', 'permintaan.kode_barang')
                ->where('permintaan.id_permintaan', $id_permintaan)
                ->select('barang.*')
                ->get();
            $formatted_id_permintaan = Str::replace('-', '/', $id_permintaan);
            $keluhan = $permintaan->keluhan_kebutuhan;

            Mail::send(
                'notifikasi_email.requestor.permintaan_diterima',
                [
                    'id_permintaan' => $id_permintaan,
                    'id_permintaan_formatted' => $formatted_id_permintaan,
                    'data_unit' => $data_unit,
                    'keluhan' => $keluhan
                ],
                function ($message) use ($email, $formatted_id_permintaan) {
                    $message->to($email);
                    $message->subject('Permintaan Pengecekan Hardware Diterima: ' . $formatted_id_permintaan);
                }
            );

            $update_permintaan = $this->modeladmin->update_permintaan($data, $id);
            $kirim_notifikasi = $this->modeladmin->input_notifikasi($notifikasi);


            return $update_permintaan && $kirim_notifikasi
                ? back()->with('toast_success', 'Permintaan pengecekan hardware diterima, requestor telah diberikan notifikasi untuk menyerahkan barang.')
                : back()->with('toast_success', 'Permintaan gagal diupdate, silakan coba lagi!');
        }
        // untuk update hardware 
        else if ($request->has('status_hardware')) {
            $request->validate(
                [
                    'status_hardware' => 'required',
                ],
                [
                    'status_hardware.required' => 'Pilih status hardware!',
                ]
            );

            $problem = $request->problem ?: '-';
            $data = [
                'status_hardware' => $request->status_hardware,
                'problem' => $problem,
                'updated_at' => now(),
            ];
            return $this->modeladmin->update_hardware($data, $id)
                ? back()->with('toast_success', 'Status hardware dan problem berhasil diubah!')
                : back()->with('toast_error', 'Status hardware dan problem gagal diubah!');
        }
        //untuk estimasi penyelesaian
        elseif ($request->has('estimasi_penyelesaian')) {
            $request->validate(
                [
                    'tanggal_penyelesaian' => 'required',
                ],
                [
                    'tanggal_penyelesaian.required' => 'Pilih tanggal penyelesaian!',
                ]
            );

            $data = [
                'tanggal_penyelesaian' => $request->tanggal_penyelesaian
            ];

            return $this->modeladmin->update_permintaan($data, $id)
                ? back()->with('toast_success', 'Estimasi waktu penyelesaian telah ditetapkan!')
                : back()->with('toast_error', 'Estimasi waktu penyelesaian gagal diinput!');
        }
        // untuk update software 
        else {
            $request->validate(
                [
                    'versi_software_update' => 'required',

                ],
                [
                    'versi_software_update.required' => 'Isi versi software!',
                ]
            );

            $catatan = $request->notes_update ?: '-';
            $data = [
                'versi_software' => $request->versi_software_update,
                'notes' => $catatan,
                'updated_at' => now(),
            ];
            return $this->modeladmin->update_software($data, $id)
                ? back()->with('toast_success', 'Versi software dan catatan berhasil diupdate!')
                : back()->with('toast_success', 'Update versi software dan catatan gagal!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        if ($request->has('hapus_hardware')) {
            return $this->modeladmin->hapus_hardware($id)
                ? back()->with('toast_success', 'Komponen hardware berhasil dihapus!')
                : back()->with('toast_error', 'Komponen hardware gagal dihapus!');
        } elseif ($request->has('hapus_software')) {
            return $this->modeladmin->hapus_software($id)
                ? back()->with('toast_success', 'Software berhasil dihapus!')
                : back()->with('toast_error', 'Software gagal dihapus!');
        }
    }
}
