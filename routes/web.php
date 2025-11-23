<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\Admin\LelangController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MasyarakatController;
use App\Http\Controllers\Masyarakat\RiwayatController;
use App\Http\Controllers\Masyarakat\LalelangController;
use App\Http\Controllers\Masyarakat\ProfileController as UserController;
use App\Http\Controllers\Masyarakat\DashboardController as BerandaController;
use App\Http\Controllers\Admin\Auth\LoginController as PetugasLoginController;
use App\Http\Controllers\Masyarakat\Auth\LoginController as MasyarakatLoginController;
use App\Http\Controllers\Masyarakat\Auth\RegisterController as MasyarakatRegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route halaman utama
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route untuk petugas/admin authentication
Route::prefix('admin')->name('admin.')->group(function () {
    // Route login petugas
    Route::get('login', [PetugasLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [PetugasLoginController::class, 'login'])->name('login.post');
    Route::post('logout', [PetugasLoginController::class, 'logout'])->name('logout');

    // Route untuk dashboard petugas (protected)
    Route::middleware('auth:petugas')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Data Petugas (Admin Only)
        Route::get('petugas', function () {
            return view('admin.petugas.index');
        })->name('petugas.index');

        // Route Petugas (Admin Only)
        Route::get('petugas', [PetugasController::class, 'index'])->name('petugas.index');
        Route::post('petugas/store', [PetugasController::class, 'store'])->name('petugas.store');
        Route::post('petugas/update/{id}', [PetugasController::class, 'update'])->name('petugas.update');
        Route::post('petugas/delete/{id}', [PetugasController::class, 'destroy'])->name('petugas.delete');

        // Route Masyarakat (Admin Only)
        Route::get('masyarakat', [MasyarakatController::class, 'index'])->name('masyarakat.index');
        Route::post('masyarakat/store', [MasyarakatController::class, 'store'])->name('masyarakat.store');
        Route::post('masyarakat/update/{id}', [MasyarakatController::class, 'update'])->name('masyarakat.update');
        Route::post('masyarakat/toggle-status/{id}', [MasyarakatController::class, 'toggleStatus'])->name('masyarakat.toggle');
        Route::post('masyarakat/delete/{id}', [MasyarakatController::class, 'destroy'])->name('masyarakat.delete');


        // Route Barang
        Route::get('barang', [BarangController::class, 'index'])->name('barang.index');
        Route::post('barang/store', [BarangController::class, 'store'])->name('barang.store');
        Route::post('barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
        Route::post('barang/delete/{id}', [BarangController::class, 'destroy'])->name('barang.delete');
        Route::post('barang/delete-image/{id}', [BarangController::class, 'deleteImage'])->name('barang.delete.image');
        Route::post('barang/set-primary/{id}', [BarangController::class, 'setPrimary'])->name('barang.set.primary');


        // Route Lelang (Petugas)
        Route::get('lelang', [LelangController::class, 'index'])->name('lelang.index');
        Route::post('lelang/store', [LelangController::class, 'store'])->name('lelang.store');
        Route::post('lelang/toggle-status/{id}', [LelangController::class, 'toggleStatus'])->name('lelang.toggle');
        Route::post('lelang/delete/{id}', [LelangController::class, 'destroy'])->name('lelang.delete');

        // History Lelang (Petugas Only)
        Route::get('history', [HistoryController::class, 'index'])->name('history.index');


        // Laporan
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');

        // Tentang
        Route::get('tentang', function () {
            return view('admin.pages.tentang');
        })->name('tentang');

        // Profil
        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    });
});

// Route untuk masyarakat authentication
Route::prefix('masyarakat')->name('masyarakat.')->group(function () {
    // Route login masyarakat
    Route::get('login', [MasyarakatLoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [MasyarakatLoginController::class, 'login'])->name('login.post');

    // Route register masyarakat
    Route::get('register', [MasyarakatRegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [MasyarakatRegisterController::class, 'register'])->name('register.post');

    // Route logout masyarakat
    Route::post('logout', [MasyarakatLoginController::class, 'logout'])->name('logout');

    Route::middleware('auth:masyarakat')->group(function () {
        // Dashboard kosongan
        Route::get('dashboard', [BerandaController::class, 'index'])->name('dashboard');

        // Ganti route lelang dengan controller

        Route::get('lelang', [LalelangController::class, 'index'])->name('lelang');
        Route::post('lelang/{id_lelang}/bid', [LalelangController::class, 'bid'])->name('lelang.bid');


        Route::get('history', [RiwayatController::class, 'index'])->name('history');

        Route::get('tentang', function () {
            return view('masyarakat.tentang');
        })->name('tentang');

        // Profile routes
        Route::get('profile', [UserController::class, 'index'])->name('profile');
        Route::put('profile/update', [UserController::class, 'update'])->name('profile.update');

        //riwaya
        Route::get('activity', function () {
            return view('masyarakat.activity');
        })->name('activity');

    });

});
