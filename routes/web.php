<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('kategori-barangs', App\Http\Controllers\KategoriBarangController::class);

Route::resource('barangs', App\Http\Controllers\BarangController::class);

Route::resource('peminjamen', App\Http\Controllers\PeminjamanController::class);

Route::resource('pengembalians', App\Http\Controllers\PengembalianController::class);
