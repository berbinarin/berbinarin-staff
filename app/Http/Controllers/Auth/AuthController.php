<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{


    public function authenticated(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard.index')->with([
                'alert' => true,
                'type' => 'success',
                'title' => 'Login Berhasil',
                'message' => 'Silahkan masuk',
                'icon' => asset('assets/dashboard/svg-icon/success.webp'),
            ]);
        } else {
            return redirect()->route('auth.index')->with([
                'alert' => true,
                'type' => 'error',
                'title' => 'Gagal!',
                'message' => 'Username atau Password salah',
                'icon' => asset('assets/dashboard/svg-icon/error.webp'),
            ]);
        }
    }

    public function Logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('auth.index')->with([
            'alert' => true,
            'type' => 'success',
            'title' => 'Logout Berhasil',
            'message' => 'Sampai jumpa lagi 😘',
            'icon' => asset('assets/dashboard/svg-icon/success.webp'),
        ]);
    }

    public function index()
    {
        return view('auth.login');
    }
}
