<?php

use App\Http\Controllers\KuotaController;
use App\Http\Controllers\PendaftarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/pendaftars', PendaftarController::class);
Route::resource('/kuotas', KuotaController::class);