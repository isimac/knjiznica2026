<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnjigaController;#moramo dodati kontroler
use App\Http\Controllers\PrimjerakController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\PosudbaController;
use App\Http\Controllers\AuthController;

Route::middleware('auth')->group(function ()#samo za logirane
{
    Route::get('/', function () {
    return redirect()->route('knjige.index');#nemoj mi pokazivati početnu stranicu, preusmjeri me na rutu knjige.index; redirect->ako negdje zapnemo kada refreshamo preko http protokola šaljemo želju da se ponovno osvježe svi podaci
    });

    Route::get('/knjige', [KnjigaController::class, 'index'])->name('knjige.index');# sa name smo dali naziv ruti knjige.index
    Route::get('/knjige/create', [KnjigaController::class, 'create'])->name('knjige.create');
    Route::post('/knjige', [KnjigaController::class, 'store'])->name('knjige.store');

    Route::get('/knjige/{knjiga}/edit', [KnjigaController::class, 'edit'])->name('knjige.edit');
    Route::put('/knjige/{knjiga}', [KnjigaController::class, 'update'])->name('knjige.update');
    Route::delete('/knjige/{knjiga}', [KnjigaController::class, 'destroy'])->name('knjige.destroy');

    Route::get('/knjige/{knjiga}', [KnjigaController::class, 'show'])->name('knjige.show');

    Route::get('/knjige/{knjiga}/primjerci/create', [PrimjerakController::class, 'create'])->name('primjerci.create');
    Route::post('/knjige/{knjiga}', [PrimjerakController::class, 'store'])->name('primjerci.store');
    Route::get('/primjerci/{primjerak}/edit', [PrimjerakController::class, 'edit'])->name('primjerci.edit');
    Route::put('/primjerci/{primjerak}', [PrimjerakController::class, 'update'])->name('primjerci.update');
    Route::delete('/primjerci/{primjerak}', [PrimjerakController::class, 'destroy'])->name('primjerci.destroy');


    Route::get('/clanovi', [ClanController::class, 'index'])->name('clanovi.index');
    Route::get('/clanovi/create', [ClanController::class, 'create'])->name('clanovi.create');
    Route::post('/clanovi', [ClanController::class, 'store'])->name('clanovi.store');
    Route::get('/clanovi/{clan}/edit', [ClanController::class, 'edit'])->name('clanovi.edit');
    Route::put('/clanovi/{clan}', [ClanController::class, 'update'])->name('clanovi.update');
    Route::delete('/clanovi/{clan}', [ClanController::class, 'destroy'])->name('clanovi.destroy');

    Route::get('/posudbe', [PosudbaController::class, 'index'])->name('posudbe.index');
    Route::get('/posudbe/create', [PosudbaController::class, 'create'])->name('posudbe.create');
    Route::post('/posudbe', [PosudbaController::class, 'store'])->name('posudbe.store');

    Route::patch('/posudbe/{posudba}/povrat', [PosudbaController::class, 'povrat'])->name('posudbe.povrat');#kada želimo promijeniti 1 atribut
    Route::get('/posudbe/povijest', [PosudbaController::class, 'povijest'])->name('posudbe.povijest');
    Route::get('/posudbe/zakasnjele', [PosudbaController::class, 'zakasnjele'])->name('posudbe.zakasnjele');
});


Route::middleware('guest')->group(function()#prikazuje se korisnicima koji nisu prijavljeni
{
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.store');#throttle je middleware koji ograničava 5 zahtjeva u 1minuti
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout',[AuthController::class, 'logout'])->middleware('auth')->name('logout');