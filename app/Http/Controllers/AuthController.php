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
            
            // $userId = User::where('email','=',$request->email)->value('id');

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
}
