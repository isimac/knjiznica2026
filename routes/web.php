<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnjigaController;

Route::get('/', function () {           //ova ruta objavljuje početnu adresu - izbrisali smo welcome ispod
    return redirect()->route('knjige.index');       //redirect je preusmjeravanje
});     //

Route::get('/knjige', [KnjigaController::class, 'index'])->name('knjige.index');   //get je dohvati mi, /knjige je ruta, name je da je ruta dobila naziv
Route::get('/knjige/create', [KnjigaController::class, 'create'])->name('knjige.create');
Route::post('knjige', [KnjigaController::class, 'store'])->name('knjige.store');
//ovjde nastavljamo idući put
Route::get('/knjige/{knjiga}/edit', [KnjigaController::class, 'edit'])->name('knjige.edit');
Route::put('/knjige/{knjiga}', [KnjigaController::class, 'update'])->name('knjige.update');
Route::delete('/knjige/{knjiga}', [KnjigaController::class, 'destroy'])->name('knjige.destroy');
