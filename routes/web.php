<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnjigaController;
use App\Http\Controllers\PrimjerakController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\PosudbaController;


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

Route::get('knjige/{knjiga}', [KnjigaController::class, 'show'])->name('knjige.show');


Route::resource('clan', ClanController::class)->parameters(['clanovi'=>'clan']);

//POSUDBA

Route::get('/posudbe',[PosudbaController::class, 'index'])
->name('posudbe.index');

Route::get('/posudbe/create', [PosudbaController::class, 'create'])
->name('posudbe.create');

Route::post('/posudbe', [PosudbaController::class, 'store'])->name('posudbe.store');

Route::patch('/posudbe/{posudba}/povrat', [PosudbaController::class, 'povrat'])->name('posudbe.povrat');

Route::get('\posudbe\zakasnjele', [PosudbaController::class, 'zakasnjele'])->name('posudbe.zakasnjele');

Route::get('/posudbe/povijest', [PosudbeController::class, 'povijest'])->name('posudbe.povijest');