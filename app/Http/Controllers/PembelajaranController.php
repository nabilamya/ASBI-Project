<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PembelajaranController extends Controller
{
    public function index()
    {
        return view('pembelajaran');
    }

    public function showHuruf($modul, $huruf)
    {
        return view('huruf', [
            'modul' => strtolower($modul),
            'huruf' => strtolower($huruf)
        ]);
    }
    public function showDetail($modul, $huruf)
{
    return view('detail', [
        'modul' => strtolower($modul),
        'huruf' => strtolower($huruf)
    ]);
}
}
