<?php

namespace App\Http\Controllers;

class RedirectController extends Controller
{
    public function cek()
    {
        if (auth()->user()->id_role === 1) {
            return redirect('/superadmin');
        } else if (auth()->user()->id_role === 2) {
            return redirect('/admin');
        } else if (auth()->user()->id_role === 3) {
            return redirect('/manager');
        } else if (auth()->user()->id_role === 4) {
            return redirect('/pegawai');
        } else {
            return redirect('/')->with('toast_warning', 'Silakan Login terlebih dahulu!');
        }
    }
}
