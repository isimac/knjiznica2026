<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Posudba extends Model
{
    protected $table="posudba";
    protected $fillable=['id_clan', 'id_primjerak','datumPosudbe', 'datumPovrata', 'brojDanaKasnjenja', 'zakasninaPlacena'];


    //ovdje nadodati cast

    public function clan(): BelongsTo
    {
        return $this->belongsTo(Clan::class, 'clan_id');
    }

    public function primjerak(): BelongsTo
    {
        return $this->belongsTo(Primjerak::class, 'primjerak_id');
    }



}
