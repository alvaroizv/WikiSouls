<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\ObjetoController;
use App\Http\Controllers\EnemigoController;
use App\Http\Controllers\ArmaController;

Route::get('/',[RegionController::class,'landingPage'])->name('regiones.landingPage');


Route::resource('regiones', RegionController::class);

//Ver zonas de una sola region
Route::get('regiones/{region}/zonas',[RegionController::class,'zona'])->name('regiones.zona');

Route::get('areaVip',[RegionController::class,'zonaVip'])->name('regiones.areaVip');


Route::resource('zonas', ZonaController::class);
Route::resource('objetos', ObjetoController::class);
Route::resource('enemigos', EnemigoController::class);
Route::resource('armas', ArmaController::class);
Auth::routes( ['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('home/edit', [App\Http\Controllers\HomeController::class, 'edit'])->name('home.edit');
Route::put('home', [App\Http\Controllers\HomeController::class, 'update'])->name('home.update');

