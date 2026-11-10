<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clan extends Model
{
    protected $table="clan";
    protected $fillable=['ime', 'prezime', 'brojMobitela', 'email', 'clanskiBroj'];

    public function posudba(): HasMany 
    {   //jedan clan ima vise posubdi
        return $this->hasMany(Posudba::class, 'clan_id');
    }
}


