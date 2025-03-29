<?php

use App\Http\Controllers\AuthController;
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
Route::prefix('/super-admin')->group(function(){
    Route::get('/',function () { return redirect()->route('super-admin.dashboard');});
    Route::get('/dashboard',[SuperAdminController::class,'dashboard'])->name('super-admin.dashboard');
    Route::prefix('/admin')->group(function(){
        Route::get('/data',[SuperAdminController::class,'dataAdmin'])->name('admin.data');
        Route::get('/tambah',[SuperAdminController::class,'tambahAdmin'])->name('admin.tambah');
    });
});

/**
 * Admin
 * Url untuk role Admin
 * url = http://localhost:8000/admin
 */
Route::prefix('/admin')->group(function(){
    //
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