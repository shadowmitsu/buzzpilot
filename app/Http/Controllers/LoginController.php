<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'login' => 'required|string', // Bisa username atau email
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cek apakah 'login' adalah email atau username
        $loginType = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Cek kredensial dengan email atau username
        $credentials = [
            $loginType => $request->input('login'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($credentials)) {
            // Jika login berhasil, redirect ke dashboard atau halaman yang diinginkan
            return redirect()->intended('dashboard')->with('success', 'Login successful!');
        }

        // Jika login gagal, redirect kembali ke halaman login dengan pesan error
        return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out.');
    }
}