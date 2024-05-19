<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $userSession = session()->get('users');
    if ($userSession) {
        return redirect()->route('dashboard.index');
    }
    return view('pages.auth.login');
})->name('home');


Route::get('login', [AuthController::class, 'index'])->name('login');

Route::post('authorization', [AuthController::class, 'authenticate'])->name('login.process');


Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //laporan route
    Route::prefix('laporan')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/unduh/{id?}', [LaporanController::class, 'download'])->name('laporan.unduh');
    });
    Route::prefix('laporan-bulanan')->group(function () {
        Route::get('/', [LaporanController::class, 'indexBulanan'])->name('laporan_bulanan.index');
        Route::get('/unduh/{id?}', [LaporanController::class, 'downloadBulanan'])->name('laporan_bulanan.unduh');
    });
    //transactional route
    Route::prefix('pengajuan')->group(function () {
        Route::get('/', [PengajuanController::class, 'index'])->name('pengajuan.index');
        Route::get('/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
        Route::post('/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
        Route::get('/edit/{id?}', [PengajuanController::class, 'edit'])->name('pengajuan.edit');
        Route::get('/show/{id?}', [PengajuanController::class, 'show'])->name('pengajuan.show');
        Route::put('/update/{id?}', [PengajuanController::class, 'update'])->name('pengajuan.update');
        Route::get('/delete/{id?}', [PengajuanController::class, 'destroy'])->name('pengajuan.delete');
        Route::get('/wkwk', [PengajuanController::class, 'wkwk'])->name('pengajuan.wkwk');
        Route::get('/tolak-pengajuan/{id?}', [PengajuanController::class, 'tolakPengajuan'])->name('pengajuan.tolak_pengajuan');
        Route::get('/setujui-pengajuan/{id?}', [PengajuanController::class, 'setujuiPengajuan'])->name('pengajuan.setujui_pengajuan');
        Route::get('/selesai-kirim-barang/{id?}', [PengajuanController::class, 'selesaiKirimBarang'])->name('pengajuan.selesai_kirim_barang');
        Route::post('/ulasan-pengajuan/{id?}', [PengajuanController::class, 'ulasanPengajuan'])->name('pengajuan.ulasan');
    });

    // master data route
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/edit/{id?}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/update/{id?}', [UserController::class, 'update'])->name('users.update');
        Route::get('/delete/{id?}', [UserController::class, 'destroy'])->name('users.delete');
        Route::get('/kamar-taruni/{id?}', [UserController::class, 'kamarTaruni'])->name('users.kamar_taruni');
        Route::get('/delete-kamar-taruni/{id?}/{userId?}', [UserController::class, 'deleteKamarTaruni'])->name('users.delete_kamar_taruni');
        Route::get('/profile', [UserController::class, 'profile'])->name('users.profile');
        Route::put('/update-profile', [UserController::class, 'updateProfile'])->name('users.update_profile');
    });
    Route::prefix('kamar')->group(function () {
        Route::get('/', [KamarController::class, 'index'])->name('kamar.index');
        Route::get('/create', [KamarController::class, 'create'])->name('kamar.create');
        Route::post('/store', [KamarController::class, 'store'])->name('kamar.store');
        Route::get('/show/{id?}', [KamarController::class, 'show'])->name('kamar.show');
        Route::get('/edit/{id?}', [KamarController::class, 'edit'])->name('kamar.edit');
        Route::put('/update/{id?}', [KamarController::class, 'update'])->name('kamar.update');
        Route::get('/delete/{id?}', [KamarController::class, 'destroy'])->name('kamar.delete');
        Route::post('/add-taruni/{id?}', [KamarController::class, 'addTaruni'])->name('kamar.add_taruni');
    });
    Route::prefix('barang')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('barang.index');
        Route::get('/create', [BarangController::class, 'create'])->name('barang.create');
        Route::post('/store', [BarangController::class, 'store'])->name('barang.store');
        Route::get('/edit/{id?}', [BarangController::class, 'edit'])->name('barang.edit');
        Route::put('/update/{id?}', [BarangController::class, 'update'])->name('barang.update');
        Route::get('/delete/{id?}', [BarangController::class, 'destroy'])->name('barang.delete');
    });
});
