<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnjigaController;
use App\Http\Controllers\PrimjerakController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\PosudbaController;

Route::get('/', function () {
    return redirect()->route('knjige.index');
});

//__________________Rute za knjige________________________________________________________

Route::get('/knjige', [KnjigaController::class, 'index'])->name('knjige.index');

Route::get('/knjige/create', [KnjigaController::class, 'create'])->name('knjige.create');
Route::post('/knjige', [KnjigaController::class, 'store'])->name('knjige.store');
//Tu nastavljamo dalje
Route::get('/knjige/{knjiga}/edit', [KnjigaController::class, 'edit'])->name('knjige.edit');
Route::put('/knjige/{knjiga}', [KnjigaController::class, 'update'])->name('knjige.update');
Route::delete('/knjige{knjiga}', [KnjigaController::class, 'destroy'])->name('knjige.destroy');

Route::get('knjige/{knjiga}', [KnjigaController::class, 'show'])->name('knjige.show');

//___________________Rute za primjerke___________________________________________________

Route::get('/primjerci/{knjiga}/create', [PrimjerakController::class, 'create'])->name('primjerci.create');
Route::post('/primjerci', [PrimjerakController::class, 'store'])->name('primjerci.store');
Route::get('/primjerci/{primjerak}/edit', [PrimjerakController::class, 'edit'])->name('primjerci.edit');
Route::put('/primjerci/{primjerak}', [PrimjerakController::class, 'update'])->name('primjerci.update');
Route::delete('/primjerci/{primjerak}', [PrimjerakController::class, 'destroy'])->name('primjerci.destroy');

//___________________Rute za Clana_______________________________________________________________

Route::resource('clan', ClanController::class)->parameters(['clanovi'=>'clan']);

//_____________________Rute za Posudbu___________________________________________________

Route::get('posudbe/index', [PosudbaController::class, 'index'])->name('posudba.index');
Route::post('posudbe/index', [PosudbaController::class, 'indexFilter'])->name('posudba.index.filter');

Route::get('posudbe/{primjerak}/create', [PosudbaController::class, 'create'])->name('posudba.create');
Route::post('posudbe', [PosudbaController::class, 'store'])->name('posudba.store');

Route::get('posudbe/index/{posudba}', [PosudbaController::class, 'edit'])->name('posudba.edit');
Route::put('/posudbe/{trazenaPosudba}', [PosudbaController::class, 'update'])->name('posudba.update');




Route::delete('posudbe/{posudba_id}/{primjerak_id}', [PosudbaController::class, 'destroy'])->name('posudba.destroy');

