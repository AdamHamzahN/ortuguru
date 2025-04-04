<?php

/**
 *  Nama file : DashboardController.php
 *  Tujuan : file ini berfungsi untuk menampilkan dashboard
 */

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Role;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function SuperAdminDashboard()
    {
        return view('super-admin.dashboard');
    }

    public function AdminDashboard()
    {
        $data = [
            'total_guru' => DB::table('guru')
                ->join('user', 'user.id', '=', 'guru.user_id')
                ->where('user.status', 'aktif')
                ->count(),

            'total_siswa' => DB::table('siswa')
                ->join('orang_tua_siswa', 'orang_tua_siswa.id', '=', 'siswa.orang_tua_id')
                ->join('user', 'user.id', '=', 'orang_tua_siswa.user_id')
                ->where('user.status', 'aktif')
                ->count(),

            'total_jurusan' => Jurusan::all()->count(),

            'total_kelas' => Kelas::where('status', 'belum lulus')->count(),

            'detail_jurusan' => DB::table('jurusan')
                ->leftJoin('kelas', function ($join) {
                    $join->on('jurusan.id', '=', 'kelas.jurusan_id')
                        ->where('kelas.status', 'belum lulus');
                })
                ->leftJoin('siswa', function ($join) {
                    $join->on('kelas.id', '=', 'siswa.kelas_id');
                })
                ->leftJoin('orang_tua_siswa', 'orang_tua_siswa.id', '=', 'siswa.orang_tua_id')
                ->leftJoin('user', 'user.id', '=', 'orang_tua_siswa.user_id')
                ->select(
                    'jurusan.id',
                    'jurusan.nama_jurusan',
                    DB::raw('COUNT(DISTINCT kelas.id) as total_kelas'),
                    DB::raw('COUNT(DISTINCT CASE WHEN user.status = "aktif" THEN siswa.id END) as total_siswa')
                )
                ->groupBy('jurusan.id', 'jurusan.nama_jurusan')
                ->get(),


        ];
        return view('admin.dashboard', $data);
    }
}
