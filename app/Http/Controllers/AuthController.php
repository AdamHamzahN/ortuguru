<?php

/**
 *  Nama file : AuthController.php
 *  Tujuan : file ini berfungsi untuk mengatur autentikasi (login & logout) user.
 */

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function check(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();

            $role = $user->role->nama;

            switch ($role) {
                case 'Super Admin':
                    return redirect()->to('/super-admin');
                case 'Admin':
                    return redirect()->to('/admin');
                case 'Guru':
                    return redirect()->to('/guru');
                case 'Orang Tua Siswa':
                    return redirect()->to('/ortu-siswa');
                default:
                    return redirect()->to('/login');
            }
        }
        return redirect()->back()->with('error', 'Email atau password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah logout.')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
    }
}
