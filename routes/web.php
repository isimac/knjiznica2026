<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnjigaController;
use App\Http\Controllers\PrimjerakController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\PosudbaController;
use App\Http\Controllers\AuthController;

Route::middleware('auth')->group(function()
{
Route::get('/', function () {           //ova ruta objavljuje početnu adresu - izbrisali smo welcome ispod
    return redirect()->route('knjige.index');       //redirect je preusmjeravanje
});     //

Route::get('/knjige', [KnjigaController::class, 'index'])->name('knjige.index');   //get je dohvati mi, /knjige je ruta, name je da je ruta dobila naziv
Route::get('/knjige/create', [KnjigaController::class, 'create'])->name('knjige.create');
Route::post('knjige', [KnjigaController::class, 'store'])->name('knjige.store');
//ovdje nastavljamo idući put
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
});
Route::middleware('guest')->group(function()
{
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/register', [AuthController::class, 'showRegister'])->middleware('guest')->name('register');

Route::post('/register', [AuthController::class, 'register'])->middleware('guest')->name('register.store');