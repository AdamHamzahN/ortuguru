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
        return view('super-admin.dashboard');
    }

    public function AdminDashboard(){
        return view('admin.dashboard');
    }
}
