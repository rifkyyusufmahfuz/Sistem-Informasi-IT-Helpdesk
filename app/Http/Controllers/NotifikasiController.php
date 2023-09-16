<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiModel;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $notifikasi = null;
        $totalnotifikasi = 0;

        if ($user) {
            $idRole = $user->id_role;

            if ($idRole === 4) {
                $userId = $user->id;

                $notifikasi = DB::table('notifikasi')
                    ->where(function ($query) use ($idRole, $userId) {
                        $query->where('role_id', $idRole)
                            ->orWhereNull('role_id')
                            ->Where('user_id', $userId);
                    })
                    ->orderByDesc('created_at')
                    // ->whereNull('read_at')
                    ->get();
                $totalnotifikasi = $user->unreadNotifications->count();
            } elseif ($idRole === 1 || $idRole === 2 || $idRole === 3) {
                $notifikasi = DB::table('notifikasi')
                    ->where(function ($query) use ($idRole) {
                        $query->where('role_id', $idRole);
                        // ->orWhereNull('role_id');
                    })
                    // ->whereNull('read_at')
                    ->orderByDesc('created_at')
                    ->get();

                $totalnotifikasi = DB::table('notifikasi')
                    ->where('role_id', $idRole)
                    ->whereNull('read_at')
                    ->count();
            }
        }
        return response()->json([
            'notifikasi' => $notifikasi,
            'totalnotifikasi' => $totalnotifikasi,
        ]);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id_notifikasi)
    {
        $notification = NotifikasiModel::find($id_notifikasi);
        if ($notification) {
            $notification->delete();
        }
        $notifications = NotifikasiModel::orderBy('created_at', 'desc')->whereNull('read_at')->get();
        return response()->json(['notifikasi' => $notifications]);
    }

    public function tandai_telah_dibaca(string $id_notifikasi)
    {
        $notifikasi = NotifikasiModel::find($id_notifikasi);
        if ($notifikasi) {
            $notifikasi->update([
                'read_at' => now(),
                'updated_at' => now()
            ]);
        }
        // $notifications = NotifikasiModel::orderBy('created_at', 'desc')->whereNull('read_at')->get();
        // return response()->json(['notifikasi' => $notifications]);
        $user = Auth::user();
        $notifikasi = $user ? $user->allNotifications : null;
        // $totalnotifikasi = $user ? $user->unreadNotifications->count() : 0;

        return response()->json([
            'notifikasi' => $notifikasi,
            // 'totalnotifikasi' => $totalnotifikasi,
        ]);
    }

    public function tandai_semua_telah_dibaca()
    {
        $user_id = Auth::user()->id;
        DB::table('notifikasi')
            ->where('user_id', '=', $user_id)
            ->where('read_at', '=', null)
            ->update([
                'read_at' => now(),
                'updated_at' => now()
            ]);

        // $notifications = NotifikasiModel::orderBy('created_at', 'desc')->whereNull('read_at')->get();
        // return response()->json(['notifikasi' => $notifications]);
        $user = Auth::user();
        $notifikasi = $user ? $user->allNotifications : null;
        $totalnotifikasi = $user ? $user->unreadNotifications->count() : 0;

        return response()->json([
            'notifikasi' => $notifikasi,
            'totalnotifikasi' => $totalnotifikasi,
        ]);
    }


    public function read_all_notif_pegawai(string $id)
    {
        // Temukan notifikasi berdasarkan user_id
        $notifications = NotifikasiModel::where('user_id', $id)->get();

        // Tandai notifikasi sebagai telah dibaca
        foreach ($notifications as $notification) {
            $notification->read_at = now();
            $notification->save();
        }

        $user = Auth::user();
        $notifikasi = $user ? $user->allNotifications : null;
        return response()->json([
            'notifikasi' => $notifikasi,
        ]);
    }

    public function read_all_notif_admin(string $id_role)
    {
        // Temukan notifikasi berdasarkan role_id
        $notifications = NotifikasiModel::where('role_id', $id_role)->get();

        // Tandai notifikasi sebagai telah dibaca
        foreach ($notifications as $notification) {
            $notification->read_at = now();
            $notification->save();
        }

        $user = Auth::user();
        $notifikasi = $user ? $user->allNotifications : null;
        return response()->json([
            'notifikasi' => $notifikasi,
        ]);
    }
}
