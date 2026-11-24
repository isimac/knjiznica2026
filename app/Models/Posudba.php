<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Posudba extends Model
{
    protected $table="posudba";
    protected $fillable=['id_clan', 'id_primjerak','datumPosudbe', 'datumPovrata', 'brojDanaKasnjenja', 'zakasninaPlacena'];


    //ovdje nadodati casts ->nalazi se ispod
    protected $casts=[
        'datumPosudbe'=>'date',
        'datumPovrata'=>'date'
    ];

    public function clan(): BelongsTo
    {
        return $this->belongsTo(Clan::class, 'clan_id');
    }

    public function primjerak(): BelongsTo
    {
        return $this->belongsTo(Primjerak::class, 'primjerak_id');
    }



}
