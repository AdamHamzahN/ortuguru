<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

/**
 * Default
 * berfungsi untuk apabila user hanya mengakses url "/" maka akan diarahkan ke halaman login
 * url = http://localhost:8000/
 */ 
Route::get('/', function () {
    return redirect()->route('login');
});


/**
 * Login
 * berfungsi untuk user login
 * url = http://localhost:8000/login
 */ 
Route::prefix('/login')->group(function(){
    Route::get('/',[AuthController::class,'index'])->name('login');
    Route::post('/check',[AuthController::class,'check'])->name('login.check');
});

/**
 * Logout
 * berfungsi untuk user logout
 * url = http://localhost:8000/logot
 */ 
Route::post('/logout',[AuthController::class,'logout'])->name('logout');


/**
 * Super Admin
 * Url untuk role Super Admin
 * url = http://localhost:8000/super-admin
 */
Route::prefix('/super-admin')->middleware(['role:Super Admin'])->group(function(){
    Route::get('/',function () { return redirect()->route('super-admin.dashboard');});
    Route::get('/dashboard',[DashboardController::class,'SuperAdminDashboard'])->name('super-admin.dashboard');
    Route::prefix('/admin')->group(function(){
        Route::get('/data',[AdminController::class,'dataAdmin'])->name('admin.data');
        Route::get('/tambah',[AdminController::class,'tambahAdmin'])->name('admin.tambah');
        Route::post('/simpan',[AdminController::class,'simpan'])->name('admin.simpan');
        Route::post('/{id}/update-status',[AdminController::class,'updateStatusAdmin'])->name('admin.updateStatus');
    });
});


/**
 * Admin
 * Url untuk role Admin
 * url = http://localhost:8000/admin
 */
Route::prefix('/admin')->middleware(['role:Admin'])->group(function(){
    Route::get('/',function () { return redirect()->route('admin.dashboard');});
    Route::get('/dashboard',[DashboardController::class,'AdminDashboard'])->name('admin.dashboard');
    Route::prefix('/guru')->group(function(){
        Route::get('/',function () { return redirect()->route('guru.daftar-guru');});
        Route::get('/data',[GuruController::class,'dataGuru'])->name('guru.data');
        Route::get('/tambah',[GuruController::class,'tambahGuru'])->name('guru.tambah');
        Route::get('/detail/{id}',[GuruController::class,'detailGuru'])->name('guru.detail');
        Route::get('/edit/{id}',[GuruController::class,'editGuru'])->name('guru.edit');
        Route::get('/daftar-guru',[GuruController::class,'adminDaftarGuru'])->name('guru.daftar-guru');
        Route::post('/simpan',[GuruController::class,'simpanGuru'])->name('guru.simpan');
    });
    Route::prefix('/siswa')->group(function(){

    });
    Route::prefix('/jurusan')->group(function(){

    });
    Route::prefix('/mata-pelajaran')->group(function(){

    });
    Route::prefix('/export')->group(function(){
        Route::get('/siswa',[ExportController::class,'siswaExport'])->name('export.siswa');
        Route::get('/data-guru',[ExportController::class,'dataGuruExport'])->name('export.data-guru');
        Route::get('/akun-guru',[ExportController::class,'akunGuruExport'])->name('export.akun-guru');

    });
});


 /**
 * Guru
 * Url untuk role Guru
 * url = http://localhost:8000/guru
 */ 
Route::prefix('/guru')->group(function(){
   //
});


 /**
 * Login
 * Url untuk role Orang tua Siswa
 * url = http://localhost:8000/ortu-siswa
 */ 
Route::prefix('/ortu-siswa')->group(function(){
   //
});