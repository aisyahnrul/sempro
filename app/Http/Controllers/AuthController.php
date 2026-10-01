<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin(){
        return view('auth.login');
    }
    public function login(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            return match ($user->role) {
                'admin'=> redirect()->route('admin.dashboard'),
                'dosen'=> redirect()->route('dosen.dashboard'),
                'mahasiswa'=> redirect()->route('mahasiswa.dashboard'),
                default => redirect()->route('login')->withErrors(['username' => 'Pengguna tidak valid']),
            };
            // return redirect()->route('dashboard');

            // return response()->json([
            //     'message'=>'Login berhasil',
            //     'user' => $user,
            // ]);
        }
        return back()->withErrors([
            'username' => 'Username atau password salah',
        ])->onlyInput('username');
        // return response()->json([
        //     'message'=>'Username atau password salah',], 400
        // );
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
