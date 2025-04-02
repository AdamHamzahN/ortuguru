<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

/**
 * Default
 * berfungsi untuk apabila user hanya mengakses url "/" maka akan diarahkan ke halaman login
 * url = http://localhost:8000/
 */ 
Route::get('/', function () {
    return redirect()->route('login.index');
});


/**
 * Login
 * berfungsi untuk user login
 * url = http://localhost:8000/login
 */ 
Route::prefix('/login')->group(function(){
    Route::get('/',[AuthController::class,'index'])->name('login.index');
    Route::post('/check',[AuthController::class,'check'])->name('login.check');
});


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
    Route::get('/',function () { return redirect()->route('super-admin.dashboard');});
    Route::get('/dashboard',[DashboardController::class,'AdminDashboard'])->name('admin.dashboard');
    Route::prefix('/export')->group(function(){
        Route::get('/siswa',[ExportController::class,'siswaExport'])->name('export.siswa');
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