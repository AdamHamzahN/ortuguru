<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SuperAdminController extends Controller
{
    public $dataadmin;

    public function __construct()
    {
        $adminrole = Role::where('nama', '=', 'Admin')->value('id');
        $this->dataadmin = User::where('role_id', '=', $adminrole)->get();
    }

    public function dashboard()
    {
        $adminrole = Role::where('nama', '=', 'Admin')->value('id');
        $data = [
            'admin' => User::where('role_id', '=', $adminrole)->get()
        ];

        return view('super-admin.dashboard', $data);
    }

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
                return $user->created_at ? $user->created_at->format('d-m-Y H:i:s') : 'N/A';
            })
            ->make(true); // 🔥 FIX: Gunakan make(true) untuk mengembalikan JSON yang valid
    }
}
