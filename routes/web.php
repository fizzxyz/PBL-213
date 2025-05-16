<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PenerimaanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\UnitPendidikanController;

Route::middleware('web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/galeri', [HomeController::class, 'getGaleri'])->name('home.galeri');
    Route::get('/artikel', [HomeController::class, 'getArtikel'])->name('home.artikel');
    Route::get('/kegiatan', [HomeController::class, 'getKegiatan'])->name('home.kegiatan');
    Route::get('/yayasan', [HomeController::class, 'getYayasan'])->name('home.yayasan');
    Route::get('/register', [PenerimaanController::class, 'register'])->name('register');
});

Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('artikel.show');
Route::get('/galeri/{slug}', [GaleriController::class, 'show'])->name('galeri.show');
Route::get('/video/{slug}', [VideoController::class, 'show'])->name('video.show');
Route::get('/unit/{slug}', [UnitPendidikanController::class, 'show'])->name('unit.show');

// Route::get('/penerimaan', function () {
//     return view('penerimaan');
// })->middleware(['auth', 'verified'])->name('penerimaan');

Route::middleware('auth')->group(function () {
    Route::get('/penerimaan', function () {
        return view('penerimaan');
    })->name('penerimaan');
    // Route::get('/penerimaan/daftar', function () {
    //     return view('penerimaan.form');
    // })->name('pendaftaran');
    Route::get('/penerimaan/list', [PenerimaanController::class, 'index'])->name('penerimaan.list');
    Route::get('/penerimaan/{id}/wizard', [PenerimaanController::class, 'wizard'])->name('penerimaan.wizard');
    Route::post('/pendaftaran/store', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/profile', [ProfileController::class, 'show'])->name('show.profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/checkout/success', [TransaksiController::class, 'checkout_success'])->name('front.checkout.success');

require __DIR__.'/auth.php';
