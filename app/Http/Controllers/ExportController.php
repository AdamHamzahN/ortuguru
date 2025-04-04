<?php

/** 
 *  Nama file : ExportController.php
 *  Tujuan : file ini berfungsi untuk meng export data.
 */

namespace App\Http\Controllers;

use App\Exports\AkunGuruExport;
use App\Exports\DataGuruExport;
use App\Exports\SiswaExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function siswaExport()
    {
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }

    public function dataGuruExport()
    {
        return Excel::download(new DataGuruExport, 'data_guru.xlsx');
    }

    public function akunGuruExport()
    {
        return Excel::download(new AkunGuruExport, 'akun_guru.xlsx');
    }
}
