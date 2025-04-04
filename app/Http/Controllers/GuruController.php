<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class GuruController extends Controller
{
    public function adminDaftarGuru()
    {
        return view('admin.guru.index');
    }

    public function dataGuru()
    {
        $gururole = Role::where('nama', 'Guru')->value('id');

        if (!$gururole) {
            return response()->json(['error' => 'Role Guru tidak ditemukan!'], 400);
        }

        $data = User::where('role_id', $gururole)
            ->leftJoin('guru', 'guru.user_id', '=', 'user.id')
            ->select('user.id', 'user.nama', 'user.status', 'guru.id', 'guru.nip');

        return DataTables::of($data)
            ->editColumn('created_at', function ($user) {
                return $user->created_at ? $user->created_at->format('d-m-Y') : 'N/A';
            })
            ->make(true);
    }
}
