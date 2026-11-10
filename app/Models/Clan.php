<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloqeuent\Relations\HasMany;

class Clan extends Model
{
    protected $table = "clan";
    protected $fillable = ['ime', 'prezime', 'brojMobitela', 'email', 'clanskiBroj'];

    public function posudba(): HasMany
    {
        return $this->hasMany(Posudba::class, 'clan_id');
    }
}
