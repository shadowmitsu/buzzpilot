<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'whatsapp_number' => 'required|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $verification_token = Str::random(32);
        // Buat user baru
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'full_name' => $request->full_name,
            'whatsapp_number' => $request->whatsapp_number,
            'password' => Hash::make($request->password),
            'verification_token' => $verification_token,
        ]);
        

        UserBalance::create([
            'user_id' => $user->id,
            'balance' => 0,
        ]);

        $this->sendVerificationEmail($user);

        return redirect()->route('login')->with('success', 'Registration successful! Please verify your email.');
    }

    public function resendVerification(Request $request)
    {
        $request->validate([
            'identifier' => 'required', // Mengizinkan username atau email sebagai input
        ]);
    
        // Mencari pengguna berdasarkan email atau username
        $user = User::where('email', $request->identifier)
                    ->orWhere('username', $request->identifier)
                    ->first();
    
        // Jika pengguna tidak ditemukan, kembalikan pesan error
        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found. Please check your email or username.');
        }
    
        // Memeriksa apakah email sudah diverifikasi
        if ($user->email_verified_at) {
            return redirect()->route('login')->with('info', 'Your email is already verified. You can log in.');
        }
    
        // Membuat ulang token verifikasi
        $user->verification_token = Str::random(32);
        $user->save();
    
        // Mengirim ulang email verifikasi
        $this->sendVerificationEmail($user);
    
        return redirect()->route('login')->with('success', 'Verification email has been resent. Please check your inbox.');
    }
    
    protected function sendVerificationEmail($user)
    {
        $verificationUrl = route('verify.email', ['token' => $user->verification_token]);

        Mail::send('emails.verify', ['user' => $user, 'verificationUrl' => $verificationUrl], function($message) use ($user) {
            $message->to($user->email);
            $message->subject('Verify your email address');
        });
    }

    public function verifyEmail($token)
    {
        // Cek apakah ada user dengan token tersebut
        $user = User::where('verification_token', $token)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Invalid verification token.');
        }

        // Verifikasi email dan update status
        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Email verified! You can now log in.');
    }
}
