<?php

use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\DetailPeminjamanController;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Models\DetailPeminjaman;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class,'register']);
Route::post('/login', [UserController::class,'login']);

Route::middleware('auth:sanctum')->post('/logout', [UserController::class, 'logout']);


Route::middleware(['auth:api'])->group(function () {
    //Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class,'index']);
    Route::post('/peminjaman/create', [PeminjamanController::class,'store']);
    Route::post('/peminjaman/update/{id}', [PeminjamanController::class, 'update']);
    Route::delete('/peminjaman/delete/{id}', [PeminjamanController::class,'destroy']);
    //Peminjaman

    //Buku
    Route::get('/buku', [BukuController::class,'index']);
    Route::get('/buku/{id}', [BukuController::class, 'show']);
    Route::post('/buku/create', [BukuController::class,'store']);
    Route::post('/buku/update/{id}', [BukuController::class,'update']);
    Route::delete('/buku/delete/{id}', [BukuController::class,'destroy']);
    //Buku

    //DetailPeminjaman
    Route::get('/detailPeminjaman', [DetailPeminjamanController::class,'index']);
    Route::get('/detailPeminjaman/peminjaman/{id}', [DetailPeminjamanController::class,'getByPeminjaman']);
    Route::post('/detailPeminjaman/create', [DetailPeminjamanController::class,'store']);
    Route::post('/detailPeminjaman/update/{id}', [DetailPeminjamanController::class,'update']);
    Route::delete('/detailPeminjaman/delete/{id}', [DetailPeminjamanController::class,'delete']);
    //DetailPeminjaman

});