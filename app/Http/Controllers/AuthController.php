<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // TAMPILAN HALAMAN LOGIN
    public function showLogin()
    {
        return view('auth.login');
    }

    // TAMPILAN HALAMAN REGISTER
    public function showRegister()
    {
        return view('auth.register');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            return redirect()->route('pembelajaran.index')->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'login' => 'Email/Username atau password salah.',
        ])->withInput();
    }

    // PROSES REGISTER (LANGSUNG REDIRECT KE LOGIN)
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:users,username',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|min:8|confirmed',
            'nomor_telepon'=> 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create([
            'nama_lengkap'   => $request->nama_lengkap,
            'username'       => $request->username,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'nomor_telepon'  => $request->nomor_telepon,
        ]);

        // 👇 INI YANG PENTING: REDIRECT KE HALAMAN LOGIN
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan masuk.');
    }
}
