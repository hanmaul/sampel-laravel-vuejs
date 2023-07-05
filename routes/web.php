<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\KonsumenController;
use App\Http\Controllers\AlamatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect("/login");
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
});

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix("/konsumen")->group(function(){
        Route::get('/data', [KonsumenController::class, 'getData'])->name('konsumen.data');
        Route::post('/simpan', [KonsumenController::class, 'simpanData'])->name('konsumen.simpan');
        Route::delete('/hapus', [KonsumenController::class, 'hapusData'])->name('konsumen.hapus');
    });
    Route::prefix("/alamat")->group(function(){
        Route::get('/kota', [AlamatController::class, 'getDataKota'])->name('alamat.kota');
        Route::post('/kecamatan', [AlamatController::class, 'getDataKecamatan'])->name('alamat.kecamatan');
        Route::post('/kelurahan', [AlamatController::class, 'getDataKelurahan'])->name('alamat.kelurahan');
    });

});


require __DIR__.'/auth.php';
