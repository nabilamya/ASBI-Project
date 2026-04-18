<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller {
   public function dashboard()
{
    return view('admin-dashboard');
}

public function pengguna()
{
    return view('admin_akun');
}

public function modul()
{
    return view('admin-modul');
}

public function kuis()
{
    return view('admin_kuis');
}
}
