<?php

use App\Http\Controllers\admin\JenisGerejaController;
use App\Http\Controllers\admin\ProfilController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->get('/', function () {
    return view('home');
})->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group([], base_path("routes/admin.php"));
});

Route::view('/home', 'home')->middleware('auth', 'verified');
Route::view('/profile/edit', 'profile.edit')->middleware('auth');
Route::get("/profile/edit", [ProfilController::class, 'index'])->name('profile.index')->middleware('auth');
Route::view('/profile/password', 'profile.password')->middleware('auth');

Route::get('/get-jenis-gereja', [JenisGerejaController::class, "getJGereja"]);
