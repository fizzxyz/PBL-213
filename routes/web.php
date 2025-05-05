<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitPendidikanController;

Route::middleware('web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/galeri', [HomeController::class, 'getGaleri'])->name('home.galeri');
    Route::get('/artikel', [HomeController::class, 'getArtikel'])->name('home.artikel');
    Route::get('/kegiatan', [HomeController::class, 'getKegiatan'])->name('home.kegiatan');
    Route::get('/yayasan', [HomeController::class, 'getYayasan'])->name('home.yayasan');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('artikel.show');
Route::get('/galeri/{slug}', [GaleriController::class, 'show'])->name('galeri.show');
Route::get('/video/{slug}', [VideoController::class, 'show'])->name('video.show');
Route::get('/unit/{slug}', [UnitPendidikanController::class, 'show'])->name('unit.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
