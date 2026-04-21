<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\HistoriController;


Route::get('/', function () {
    return view('landing');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::get('/beranda', function () {
    return view('beranda');
})->name('beranda');
Route::get('/pembelajaran', function () {
    return view('pembelajaran');
})->name('pembelajaran');

Route::get('/latihan', function () {
    return view('latihan');
})->name('latihan');

Route::get('/histori', function () {
    return view('histori');
})->name('histori');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/pembelajaran/sibi', function () {
    return view('pembelajaran.sibi');
})->name('pembelajaran.sibi');

Route::get('/pembelajaran/bisindo', function () {
    return view('pembelajaran.bisindo');
})->name('pembelajaran.bisindo');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/profil', function () {
    return view('profil');
})->name('profil.index');


Route::get('/pembelajaran.index', [PembelajaranController::class, 'index'])->name('pembelajaran.index');
Route::get('/pembelajaran/{modul}/{huruf}', [PembelajaranController::class, 'showHuruf'])->name('pembelajaran.huruf');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pengguna', [AdminController::class, 'pengguna'])->name('pengguna');
    Route::get('/modul', [AdminController::class, 'modul'])->name('modul');
    Route::get('/kuis', [AdminController::class, 'kuis'])->name('kuis');
});

Route::get('/histori', [HistoriController::class, 'index'])->name('histori');
