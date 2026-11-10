<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Primjerak extends Model
{
    protected $table="primjerak";
    protected $fillable=['inventarniBroj', 'knjiga_id']; 
    //knjiga_id je vanjski kljuc, ali u fillable stvaramo sve sto ce stvoriti automatski
    //ako je to automatski al u nekoj drugoj tablici

    public function knjiga(): BelongsTo //Ne zaboraviti import
    {   //primjerak pripada jednoj knjizi, dakle belongsTo
        return $this->belongsTo(Knjiga::class, 'knjiga_id');
        //i u metodu knjiga i primjerak ostaje ovaj 'knjiga_id', on je poveznica
    }

    public function posudba(): HasMany //Ne zaboraviti import 
    {   //primjerak ima vise posudbi, dakle hasMany
        return $this->hasMany(Posudba::class, 'primjerak_id');
        //i u metodu posudba i primjerak ostaje ovaj 'primjerak_id', on je poveznica
    }
}
