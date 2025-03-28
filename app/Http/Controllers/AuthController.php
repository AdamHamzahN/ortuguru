<?php

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

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($validated['password'], $user->password)) {
            Auth::login($user);
            $role = Role::where('id', '=', $user->role_id)->value('nama');

            if ($role == 'Super Admin') {
                return redirect()->to('/super-admin');
            } else if ($role == 'Admin') {
                return redirect()->to('/admin');
            } else if ($role == 'Guru') {
                return redirect()->to('/guru');
            } else if ($role == 'Orang Tua Siswa') {
                return redirect()->to('/ortu-siswa');
            } else {
                return redirect()->to('/login');
            }
        } else {
            return redirect()->back()->with('error', 'Email atau password salah!');
        }
    }
}
