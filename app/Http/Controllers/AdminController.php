<?php

/**
 *  Nama file : AdminController.php
 *  Tujuan : file ini berfungsi untuk mengelola data admin dalam database.
 */

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    public function dataAdmin(Request $request)
    {
        $adminrole = Role::where('nama', 'Admin')->value('id');

        if (!$adminrole) {
            return response()->json(['error' => 'Role Admin tidak ditemukan!'], 400);
        }

        $data = User::where('role_id', $adminrole)
            ->select('id', 'nama', 'email', 'status', 'created_at');

        return DataTables::of($data)
            ->editColumn('created_at', function ($user) {
                return $user->created_at ? $user->created_at->format('d-m-Y') : 'N/A';
            })
            ->make(true);
    }

    public function tambahAdmin()
    {
        return view('super-admin.tambah_admin');
    }

    public function simpan(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'nama' => ['required'],
        ]);

        $data['password'] = Hash::make(env('DEFAULT_PASSWORD'));
        $data['role_id'] =  Role::where('nama', 'Admin')->value('id');

        $adminExist = User::where('email', $data['email'])->exists();

        if ($adminExist) {
            return response()->json(['error' => 'Admin sudah terdaftar!'], 400);
        } else {
            $adminCreate = User::create($data);

            if ($adminCreate) {
                return response()->json([
                    'status' => 'success',
                    'pesan' => 'Data Berhasil Ditambahkan'
                ], 201);
            } else {
                return response()->json([
                    'status' => 'failed',
                    'pesan' => 'Data Gagal Ditambahkan'
                ], 200);
            }
        }
    }

    public function updateStatusAdmin(Request $request)
    {
        $data = $request->validate([
            'id' => ['required'],
            'status' => ['required']
        ]);

        // $adminUpdate = User::where('id', $data['id'])->update($data['status']);

        $update = User::where('id', '=', $request->id)->update($data);

        if ($update) {
            return response()->json([
                'status' => 'success',
                'pesan' => 'Status Berhasil Diubah'
            ], 201);
        } else {
            return response()->json([
                'status' => 'failded',
                'pesan' => 'Status Gagal Diubah'
            ], 200);
        }
    }
}
