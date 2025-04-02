<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->to('/login');
        }

        return match ($user->role->nama ?? '') {
            'Super Admin' => redirect()->to('/super-admin'),
            'Admin' => redirect()->to('/admin'),
            'Guru' => redirect()->to('/guru'),
            'Orang Tua Siswa' => redirect()->to('/ortu-siswa'),
            default => redirect()->to('/login'),
        };
    }
}
