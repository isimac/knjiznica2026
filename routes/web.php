<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnjigaController;#moramo dodati kontroler

Route::get('/', function () {
    return redirect()->route('knjige.index');#nemoj mi pokazivati početnu stranicu, preusmjeri me na rutu knjige.index; redirect->ako negdje zapnemo kada refreshamo preko http protokola šaljemo želju da se ponovno osvježe svi podaci
});

Route::get('/knjige', [KnjigaController::class, 'index'])->name('knjige.index');# sa name smo dali naziv ruti knjige.index
Route::get('/knjige/create', [KnjigaController::class, 'create'])->name('knjige.create');
Route::post('/knjige', [KnjigaController::class, 'store'])->name('knjige.store');