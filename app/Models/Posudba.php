<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Posudba extends Model
{
    protected $table="posudba";
    protected $fillable=['clan_id', 'primjerak_id', 'datumPosudbe', 'datumPovrata', 'brojDanaKasnjenja', 'zakasninaPlacena'];

    public function clan(): BelongsTo 
    {
        return $this->belongsTo(Clan::class, 'clan_id');
    }

    public function primjerak(): BelongsTo
    {
        return $this->belongsTo(Primjerak::class, 'primjerak_id');
    }
}
