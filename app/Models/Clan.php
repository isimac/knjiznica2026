<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clan extends Model
{
      protected $table="clan";
      protected $filable=[ 'ime', 'prezime. brojMobitela', 'email','brojamObitela'];

      public function posudba(): HasMany;

      {
        return $this->hasMany(Posudba::class, 'clan_id');
      }

    //jedan prema više s posudbom 
}
