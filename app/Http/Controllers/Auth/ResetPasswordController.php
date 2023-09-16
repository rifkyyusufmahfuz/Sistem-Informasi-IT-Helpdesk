<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function konfirmasi_email()
    {
        return view('auth.password.kirim_email_reset_password');
    }

    public function permintaan_reset_password(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users',
            ],
            [
                'email.required' => 'Email wajid diisi!',
                'email.exists' => 'Email tidak ditemukan!',
            ]
        );
        $token = Str::random(64);

        $expires_at = now()->addMinutes(5); // waktu kadaluwarsa token 5 menit sejak disubmit

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => \Carbon\Carbon::now(),
            'expires_at' => $expires_at,
        ]);

        Mail::send('auth.password.email.token-reset-password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });
  
        return redirect('/')->with('toast_info', 'Tautan reset password telah dikirimkan, silakan cek email Anda!');
    }

    //halaman yang diakses dari link email tautan dengan token reset email
    public function halaman_reset_password($token)
    {
        $resetToken = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->where('expires_at', '>', now()) // hanya ambil token yang masih berlaku
            ->first();

        if (!$resetToken) {
            return redirect()->route('login')->with('toast_warning', 'Token reset password tidak valid atau telah kadaluarsa.');
        } else {
            return view('auth.password.resetpassword', ['token' => $token]);
        }
    }

    public function submit_reset_password(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users',
                'password' => 'required|string|min:6|confirmed',
                'password_confirmation' => 'required'
            ],
            [
                'password.confirmed' => 'Konfirmasi password tidak cocok!',
                'password.required' => 'Password wajib diisi!',
                'password.min' => 'Password minimal 6 karakter!',
                'password_confirmation.required' => 'Password wajib diisi!',
            ]
        );
        $resetToken = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->where('expires_at', '>=', now())
            ->first();
        if (!$resetToken) {
            return back()->withInput()->with('toast_error', 'Invalid or expired token!');
        } else {

            $email = $request->email;

            $pegawai = DB::table('pegawai')
                ->join('users', 'pegawai.nip', '=', 'users.nip')
                ->join('roles', 'users.id_role', '=', 'roles.id_role')
                ->where('users.email', $email)
                ->select('pegawai.nama', 'roles.nama_role', 'users.id AS user_id')
                ->first();

            $user_id = $pegawai->user_id;

            $namaPegawai = $pegawai->nama;
            $role = $pegawai->nama_role;

            // Lanjutkan dengan menambahkan notifikasi ke tabel notifikasi
            $pesan = "" . $email . " (" . $namaPegawai  . " - " . ucwords($role) .  ") telah melakukan reset password.";

            $pesan_2 = 'Anda telah melakukan reset password.';

            DB::table('notifikasi')->insert([
                'user_id' => null,
                'role_id' => 1,
                'pesan' => $pesan,
                'tautan' => '/superadmin/datauseraktif',
                'read_at' => null,
                'created_at' => now(),
            ]);

            DB::table('notifikasi')->insert([
                'user_id' => $user_id,
                'role_id' => null,
                'pesan' => $pesan_2,
                'tautan' => '/pegawai',
                'read_at' => null,
                'created_at' => now(),
            ]);


            $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

            DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();

            return redirect('/')->with('toast_info', 'Password Anda berhasil di-Reset!');
        }
    }
}
