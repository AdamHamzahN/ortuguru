<?php

/** 
 *  Nama file : ExportController.php
 *  Tujuan : file ini berfungsi untuk meng export data.
 */

namespace App\Http\Controllers;

use App\Exports\SiswaExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function siswaExport()
    {
        return Excel::download(new SiswaExport, 'siswa.xlsx');
    }
}
