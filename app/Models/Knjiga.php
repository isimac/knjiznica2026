<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; #zato što imamo HasMany

class Knjiga extends Model
{
    protected $table='knjiga';#iz migracija pronalazi o kojoj tablici se radi u bazi
    protected $fillable=['naslov', 'autor', 'isbn','godinaIzdanja'];#ono što mi punimo, ostalo puni sustav

    public function primjerak(): HasMany#nazivamo po tablici s kojom imamo vezu , 1 knjiga ima više primjeraka, : HasMany->deklaracija povratnog tipa metode (najavili da ćemo vratiti više toga, da Laravel očekuje više podataka)
    {
        return $this->hasMany(Primjerak::class, 'knjiga_id');#hasMany->metoda koja definira vezu
    }
}
