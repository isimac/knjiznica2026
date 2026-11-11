<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnjigaController;

Route::get('/', function () {
    return redirect()->route('knjige.index');
});

Route::get('/knjige', [KnjigaController::class, 'index'])->name('knjige.index');

Route::get('/knjige/create', [KnjigaController::class, 'create'])->name('knjige.create');
Route::post('/knjige', [KnjigaController::class, 'store'])->name('knjige.store');
//Tu nastavljamo dalje
Route::get('/knjige/{knjiga}/edit', [KnjigaController::class, 'edit'])->name('knjige.edit');
Route::put('/knjige/{knjiga}', [KnjigaController::class, 'update'])->name('knjige.update');
Route::delete('/knjige{knjiga}', [KnjigaController::class, 'destroy'])->name('knjige.destroy');