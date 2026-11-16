<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnjigaController;
use App\Http\Controllers\PrimjerakController;

Route::get('/', function () {
    return redirect()->route('knjige.index');
});

Route::get('/knjige', [KnjigaController::class, 'index'])->name('knjige.index');
Route::get('/knjige/create', [KnjigaController::class, 'create'])->name('knjige.create');
Route::post('/knjige', [KnjigaController::class, 'store'])->name('knjige.store');

Route::get('/knjige/{knjiga}/edit', [KnjigaController::class, 'edit'])->name('knjige.edit');
Route::put('/knjige/{knjiga}', [KnjigaController::class, 'update'])->name('knjige.update');
Route::delete('knjige/{knjiga}', [KnjigaController::class, 'destroy'])->name('knjige.destroy');

Route::get('knjige/{knjiga}', [KnjigaController::class, 'show'])->name('knjige.show');

///////////////////////////////////////

Route::get('/knjige/{knjiga}/primjerci/create',[PrimjerakController::class, 'create'])->name('primjerak.create');

Route::post('/knjige/{knjiga}/primjerci',[PrimjerakController::class, 'store'])->name('primjerci.store');


Route::get('/primjerci',[PrimjerakController::class, 'index'])->name('primjerci.index');

Route::get('/primjerci/{primjerak}',[PrimjerakController::class, 'show'])->name('primjerci.show');


Route::get('/primjerci/{primjerak}/edit', [PrimjerakController::class, 'edit'])->name('primjerci.edit');


Route::put('/primjerci/{primjerak}',[PrimjerakController::class, 'update'])->name('primjerci.update');


Route::delete('/primjerci/{primjerak}',[PrimjerakController::class, 'destroy'])->name('primjerci.destroy');