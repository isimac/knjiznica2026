<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KnjigaController;
use App\Http\Controllers\PrimjerakController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\PosudbaController;
use App\Http\Controllers\AuthController;

Route::middleware('auth')->group(function() {



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


//Route::resource('clan', ClanController::class)->parameters(['clanovi'=>'clan']);


Route::get('/clanovi', [ClanController::class, 'index'])
    ->name('clanovi.index');

Route::get('/clanovi/create', [ClanController::class, 'create'])
    ->name('clanovi.create');

Route::post('/clanovi', [ClanController::class, 'store'])
    ->name('clanovi.store');

Route::get('/clanovi/{clan}', [ClanController::class, 'show'])
    ->name('clanovi.show');

Route::get('/clanovi/{clan}/edit', [ClanController::class, 'edit'])
    ->name('clanovi.edit');

Route::put('/clanovi/{clan}', [ClanController::class, 'update'])
    ->name('clanovi.update');

Route::delete('/clanovi/{clan}', [ClanController::class, 'destroy'])
    ->name('clanovi.destroy');

    ///////POSUDBA//////
Route::get('/posudbe', [PosudbaController::class, 'index'])
    ->name('posudbe.index');

Route::get('/posudbe/create', [PosudbaController::class, 'create'])
    ->name('posudbe.create');

Route::post('/posudbe', [PosudbaController::class, 'store'])->name('posudbe.store');

Route::patch('/posudbe/{posudba}/povrat', [PosudbaController::class, 'povrat'])->name('posudbe.povrat');

Route::get('/posudbe/zakasnjele', [PosudbaController::class, 'zakasnjele'])->name('posudbe.zakasnjele');

Route::get('/posudbe/povijest', [PosudbaController::class, 'povijest'])->name('posudbe.povijest');

}); //__KRAJ RUTA IZ GRUPE AUTH_________________________________________________________________________________________________

//______________________________Rute za Auth___________________________________

//___GRUPA GUEST
Route::middleware('guest')->group(function () { 
    //middleware guest prikazuje rute neprijavljenim korisnicima 
    //Tu su showLogin i login, naravno da neprijavljeni korisnik triba njih da bi se logira 
    //jednom kad se logiram necu vise dobijat ove rute, sto ce mi login kad sam logiran
    Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');

    Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:5,1')    //ogranicava broj zahtjeva na ovu rutu na 5 puta u minuti maksimalno
    ->name('login');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

}); //_______________KRAJ GRUPE GUEST____________________________

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')            
    ->name('logout');