<?php

/**
 *  Nama file : DashboardController.php
 *  Tujuan : file ini berfungsi untuk menampilkan dashboard
 */

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function SuperAdminDashboard()
    {
        $adminrole = Role::where('nama', '=', 'Admin')->value('id');
        $data = [
            'admin' => User::where('role_id', '=', $adminrole)->get()
        ];

        return view('super-admin.dashboard', $data);
    }

    public function AdminDashboard(){

    }
}
