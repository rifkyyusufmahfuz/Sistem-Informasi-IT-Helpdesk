<?php

namespace App\Http\Controllers;

use App\Models\ManagerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PermintaanModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $modelmanager;

    public function __construct()
    {
        $this->modelmanager = new ManagerModel();
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

        // status otorisasi
        // Ambil data otorisasi berdasarkan status
        $otorisasiData = DB::table('otorisasi')
            ->select('status_approval', DB::raw('COUNT(id_otorisasi) as jumlah_otorisasi'))
            ->groupBy('status_approval')
            ->get();

        // Mapping status otorisasi ke label
        $statusMappingOtorisasi = [
            'pending' => 'Belum diajukan',
            'waiting' => 'Menunggu Otorisasi',
            'approved' => 'Disetujui',
            'revision' => 'Revisi',
            'rejected' => 'Ditolak'
        ];

        // Membuat array untuk menyimpan data yang akan digunakan di view
        $chartDataOtorisasi = [];
        foreach ($otorisasiData as $data) {
            $status = $statusMappingOtorisasi[$data->status_approval] ?? 'Tidak Diketahui';
            $chartDataOtorisasi[$status] = $data->jumlah_otorisasi;
        }

        // Mengurutkan data sesuai urutan statusMappingOtorisasi
        $sortedChartDataOtorisasi = [];
        foreach ($statusMappingOtorisasi as $key => $label) {
            $sortedChartDataOtorisasi[$label] = $chartDataOtorisasi[$label] ?? 0;
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

        return view('manager.index', compact(
            'permintaanData',
            'sortedChartData',
            'allData',
            'sortedChartDataOtorisasi'
        ));
    }


    public function getData()
    {
        $softwareRequests = $this->modelmanager->get_data_permintaan();

        return response()->json($softwareRequests);
    }


    public function permintaan_software()
    {
        $permintaan = $this->modelmanager->get_permintaan_software_by_otorisasi();
        $list_software = $this->modelmanager->get_list_software();

        return view(
            'manager.otorisasi.permintaan_software',
            [
                'permintaan' => $permintaan,
                'list_software' => $list_software
            ]
        );
    }

    public function riwayat_otorisasi()
    {
        $permintaan = $this->modelmanager->get_riwayat_permintaan_software();
        $list_software = $this->modelmanager->get_list_software();

        return view(
            'manager.otorisasi.riwayat_otorisasi_software',
            [
                'permintaan' => $permintaan,
                'list_software' => $list_software
            ]
        );
    }


    public function permintaan_hardware()
    {
        $permintaan = $this->modelmanager->get_permintaan_hardware_by_otorisasi();
        $list_hardware = $this->modelmanager->get_list_hardware();

        return view(
            'manager.otorisasi.permintaan_hardware',
            [
                'permintaan' => $permintaan,
                'list_hardware' => $list_hardware
            ]
        );
    }

    public function riwayat_validasi()
    {
        $permintaan = $this->modelmanager->get_riwayat_permintaan_hardware();
        $list_hardware = $this->modelmanager->get_list_hardware();

        return view(
            'manager.otorisasi.riwayat_validasi_hardware',
            [
                'permintaan' => $permintaan,
                'list_hardware' => $list_hardware
            ]
        );
    }

    public function halaman_cetak_laporan_permintaan()
    {
        //
        $laporan_permintaan = $this->modelmanager->get_laporan_permintaan();

        return view(
            'manager.laporan_permintaan.halaman_cetak_laporan',
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
        //
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
    public function update(Request $request, string $id_permintaan)
    {
        //untuk input ke table otorisasi
        $id_manager = auth()->user()->id;
        $id_otorisasi = $request->id_otorisasi;

        if ($request->has('revisi')) {
            $request->validate(
                [
                    'id_otorisasi' => 'required',
                    'catatan_manager' => 'required'
                ]
            );
            $data_otorisasi = [
                'catatan' => $request->catatan_manager,
                'status_approval' => 'revision',
                'id' => $id_manager,
                'updated_at' => now()
            ];

            // untuk input ke table notifikasi
            $id_permintaan = $request->id_permintaan;
            $permintaan = $this->modelmanager->get_admin_by_id_tindaklanjut($id_permintaan);
            // $id_admin = $permintaan->id;
            $notifikasi = [
                'pesan' => 'Manajer mengajukan revisi pada permintaan ' . $id_permintaan . '.',
                'tautan' => '/admin/permintaan_software',
                'created_at' => now(),
                'role_id' => 2,
            ];

            // kirim data ke model
            $update_otorisasi = $this->modelmanager->update_otorisasi($data_otorisasi, $id_otorisasi);
            $kirim_notifikasi = $this->modelmanager->input_notifikasi($notifikasi);

            return $update_otorisasi && $kirim_notifikasi ? back()->with('toast_success', 'Revisi berhasil diajukan ke Admin!') : back()->with('toast_error', 'Pengajuan revisi gagal, silakan coba lagi!');

            // END OF FUNCTION
        } elseif ($request->has('otorisasi_manager')) {
            $request->validate(
                [
                    'otorisasi_manager' => 'required'
                ]
            );

            if ($request->otorisasi_manager == 'disetujui') {
                // Validasi data yang diterima dari form
                $request->validate([
                    'catatan_manager_' . $id_permintaan => 'required',
                    'ttd_manager_' . $id_permintaan => 'required',
                ]);

                //Tanda tangan manager untuk menyetujui permintaan
                $lokasi_simpan_ttd = public_path('tandatangan/instalasi_software/manager/');
                if (!is_dir($lokasi_simpan_ttd)) {
                    //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                    mkdir($lokasi_simpan_ttd, 0777, true);
                }
                $nama_file_ttd_manager = "approve_" . $id_permintaan . ".png";
                $tanda_tangan_manager = $lokasi_simpan_ttd . $nama_file_ttd_manager;
                file_put_contents($tanda_tangan_manager, file_get_contents($request->input('ttd_manager_' . $id_permintaan)));


                $data_permintaan = [
                    'status_permintaan' => '3',
                    'updated_at' => now(),
                ];


                // Update data pada tabel otorisasi
                $data_otorisasi = [
                    'status_approval' => 'approved',
                    'catatan' => $request->input('catatan_manager_' . $id_permintaan),
                    'tanggal_approval' => now(),
                    'ttd_manager' => $nama_file_ttd_manager,
                    'id' => $id_manager,
                    'updated_at' => now(),
                ];

                //kirim notifikasi ke requestor / pegawai
                $permintaan = $this->modelmanager->cari_requestor($id_permintaan);
                $pegawaiId = $permintaan->id;
                $notifikasi = [
                    'pesan' => 'Permintaan Instalasi Software dengan ID Permintaan "' . $id_permintaan . '" telah disetujui. Silakan bawa unit yang akan diinstalasi. Terima kasih!',
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
                $formatted_id_permintaan = Str::replace('-', '/', $id_permintaan);

                Mail::send(
                    'notifikasi_email.requestor.permintaan_disetujui',
                    [
                        'id_permintaan' => $id_permintaan,
                        'id_permintaan_formatted' => $formatted_id_permintaan,
                        'data_unit' => $data_unit
                    ],
                    function ($message) use ($email, $formatted_id_permintaan) {
                        $message->to($email);
                        $message->subject('Permintaan Instalasi Software Disetujui: ' . $formatted_id_permintaan);
                    }
                );

                // kirim notifikasi ke admin
                $id_permintaan = $request->id_permintaan;
                $permintaan = $this->modelmanager->get_admin_by_id_tindaklanjut($id_permintaan);
                $notifikasi_admin = [
                    'pesan' => 'Permintaan Instalasi Software dengan ID Permintaan "' . $id_permintaan . '" telah disetujui oleh Manajer. Requestor telah diberitahukan untuk menyerahkan unit ke NOC.',
                    'tautan' => '/admin/permintaan_software',
                    'created_at' => now(),
                    'role_id' => 2,
                ];
            } elseif ($request->otorisasi_manager == 'ditolak') {
                // Validasi data yang diterima dari form
                $request->validate([
                    'catatan_manager_2_' . $id_permintaan => 'required',
                    'ttd_manager_2_' . $id_permintaan => 'required',
                ]);

                //Tanda tangan manager untuk menyetujui permintaan
                $lokasi_simpan_ttd = public_path('tandatangan/instalasi_software/manager/');
                if (!is_dir($lokasi_simpan_ttd)) {
                    //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                    mkdir($lokasi_simpan_ttd, 0777, true);
                }
                $nama_file_ttd_manager = "rejected_" . $id_permintaan . ".png";
                $tanda_tangan_manager = $lokasi_simpan_ttd . $nama_file_ttd_manager;
                file_put_contents($tanda_tangan_manager, file_get_contents($request->input('ttd_manager_2_' . $id_permintaan)));


                $data_permintaan = [
                    'status_permintaan' => '0',
                    'updated_at' => now(),
                ];


                // Update data pada tabel otorisasi
                $data_otorisasi = [
                    'status_approval' => 'rejected',
                    'catatan' => $request->input('catatan_manager_2_' . $id_permintaan),
                    'tanggal_approval' => now(),
                    'ttd_manager' => $nama_file_ttd_manager,
                    'id' => $id_manager,
                    'updated_at' => now(),
                ];

                // kirim notifikasi ke requestor / pegawai 
                $permintaan = $this->modelmanager->cari_requestor($id_permintaan);
                $pegawaiId = $permintaan->id;
                $notifikasi = [
                    'pesan' => 'Maaf permintaan Instalasi Software dengan ID Permintaan "' . $id_permintaan . '" ditolak karena tidak sesuai ketentuan. Silakan ajukan permintaan lain. Terima kasih!',
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

                $otorisasi_data = DB::table('otorisasi')
                    ->join('permintaan', 'otorisasi.id_otorisasi', '=', 'permintaan.id_otorisasi')
                    ->where('permintaan.id_permintaan', $id_permintaan)
                    ->select('otorisasi.*')
                    ->get();

                $formatted_id_permintaan = Str::replace('-', '/', $id_permintaan);

                Mail::send(
                    'notifikasi_email.requestor.permintaan_ditolak',
                    [
                        'id_permintaan' => $id_permintaan,
                        'id_permintaan_formatted' => $formatted_id_permintaan,
                        'data_unit' => $data_unit,
                        'otorisasi_data' => $otorisasi_data,
                    ],
                    function ($message) use ($email, $formatted_id_permintaan) {
                        $message->to($email);
                        $message->subject('Permintaan Instalasi Software Ditolak: ' . $formatted_id_permintaan);
                    }
                );


                // kirim notifikasi ke admin
                $id_permintaan = $request->id_permintaan;
                $permintaan = $this->modelmanager->get_admin_by_id_tindaklanjut($id_permintaan);
                $notifikasi_admin = [
                    'pesan' => 'Permintaan Instalasi Software dengan ID Permintaan "' . $id_permintaan . '" ditolak oleh Manajer.',
                    'tautan' => '/admin/permintaan_hardware',
                    'created_at' => now(),
                    'role_id' => 2,
                ];

                $kode_barang = $request->kode_barang;
                $data_barang = [
                    'status_barang' => 'dikembalikan',
                    'updated_at' => now()
                ];
                $update_barang = $this->modelmanager->update_barang($data_barang, $kode_barang);
            }

            $update_otorisasi = $this->modelmanager->update_otorisasi($data_otorisasi, $id_otorisasi);
            $update_permintaan = $this->modelmanager->update_permintaan($data_permintaan, $id_permintaan);
            $kirim_notifikasi = $this->modelmanager->input_notifikasi($notifikasi);
            $kirim_notifikasi_admin = $this->modelmanager->input_notifikasi($notifikasi_admin);

            if ($request->otorisasi_manager == 'disetujui') {
                return $update_otorisasi && $update_permintaan && $kirim_notifikasi && $kirim_notifikasi_admin
                    ? back()->with('success', 'Permintaan telah disetujui dan akan segera diproses oleh Admin!')
                    : back()->with('error', 'Otorisasi permintaan gagal, silakan coba lagi!');
            } elseif ($request->otorisasi_manager == 'ditolak') {
                return $update_otorisasi && $update_permintaan && $update_barang && $kirim_notifikasi && $kirim_notifikasi_admin
                    ? back()->with('warning', 'Permintaan telah ditolak dan proses instalasi software tidak akan dilanjutkan.')
                    : back()->with('error', 'Otorisasi permintaan gagal, silakan coba lagi!');
            }

            // END OF FUNCTION
        } elseif ($request->has('divalidasi')) {

            // Validasi data yang diterima dari form
            $request->validate([
                // 'catatan_manager_' . $id_permintaan => 'required',
                'ttd_manager_' . $id_permintaan => 'required',
            ]);

            //Tanda tangan manager untuk menyetujui permintaan
            $lokasi_simpan_ttd = public_path('tandatangan/pengecekan_hardware/manager/');
            if (!is_dir($lokasi_simpan_ttd)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($lokasi_simpan_ttd, 0777, true);
            }
            $nama_file_ttd_manager = "validasi_" . $id_permintaan . ".png";
            $tanda_tangan_manager = $lokasi_simpan_ttd . $nama_file_ttd_manager;
            file_put_contents($tanda_tangan_manager, file_get_contents($request->input('ttd_manager_' . $id_permintaan)));

            $data_permintaan = [
                'status_permintaan' => '4',
                'updated_at' => now(),
            ];

            // Update data pada tabel otorisasi
            $data_otorisasi = [
                'status_approval' => 'approved',
                'catatan' => '-',
                'tanggal_approval' => now(),
                'ttd_manager' => $nama_file_ttd_manager,
                'id' => $id_manager,
                'updated_at' => now(),
            ];

            // untuk input ke table notifikasi
            $id_permintaan = $request->id_permintaan;
            $permintaan = $this->modelmanager->get_admin_by_id_tindaklanjut($id_permintaan);
            // $id_admin = $permintaan->id;
            $notifikasi = [
                'pesan' => 'Rekomendasi pengecekan hardware dengan ID Permintaan "' . $id_permintaan . '" telah divalidasi!',
                'tautan' => '/admin/permintaan_hardware',
                'created_at' => now(),
                'role_id' => 2,
            ];



            $update_otorisasi = $this->modelmanager->update_otorisasi($data_otorisasi, $id_otorisasi);
            $update_permintaan = $this->modelmanager->update_permintaan($data_permintaan, $id_permintaan);
            $kirim_notifikasi = $this->modelmanager->input_notifikasi($notifikasi);

            return $update_otorisasi && $update_permintaan && $kirim_notifikasi ?
                back()->with('success', 'Rekomendasi pengecekan hardware telah divalidasi!')
                : back()->with('error', 'Validasi gagal, silakan coba lagi!');

            // END OF FUNCTION
        } elseif ($request->has('validasi_laporan')) {

            // Validasi data yang diterima dari form
            $request->validate([
                // 'catatan_manager_' . $id_permintaan => 'required',
                'ttd_manager_' . $id_permintaan => 'required',
            ]);

            //Tanda tangan manager untuk menyetujui permintaan
            $lokasi_simpan_ttd = public_path('tandatangan/laporan_permintaan/manager/');
            if (!is_dir($lokasi_simpan_ttd)) {
                //buat folder "tandatangan" jika folder tersebut belum ada di direktori "public"
                mkdir($lokasi_simpan_ttd, 0777, true);
            }
            $nama_file_ttd_manager = "validasilaporan_" . $id_permintaan . ".png";
            $tanda_tangan_manager = $lokasi_simpan_ttd . $nama_file_ttd_manager;
            file_put_contents($tanda_tangan_manager, file_get_contents($request->input('ttd_manager_' . $id_permintaan)));

            $nip_manager = auth()->user()->pegawai->nip;

            $data_laporan = [
                'status_laporan' => 'sudah divalidasi',
                'nip_manager' => $nip_manager,
                'ttd_manager' => $nama_file_ttd_manager,
                'updated_at' => now(),
            ];


            // untuk input ke table notifikasi
            $notifikasi = [
                'pesan' => 'Laporan permintaan dengan nomor laporan "' . $id_permintaan . '" telah divalidasi!',
                'tautan' => '/admin/laporan_periodik',
                'created_at' => now(),
                'role_id' => 2,
            ];

            $update_laporan = $this->modelmanager->update_laporan($data_laporan, $id_permintaan);

            if ($update_laporan) {
                $kirim_notifikasi = $this->modelmanager->input_notifikasi($notifikasi);
                return back()->with('success', 'Laporan permintaan periodik "' . $id_permintaan . '" telah divalidasi!');
            } elseif (!$update_laporan) {
                return back()->with('warning', 'Validasi gagal, silakan coba lagi!');
            }

            // END OF FUNCTION
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
