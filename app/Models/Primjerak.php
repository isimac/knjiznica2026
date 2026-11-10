<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Primjerak extends Model
{
    protected $table="primjerak";
    protected $fillable=['inventarniBroj', 'knjiga_id'];

    public function knjiga(): BelongsTo
    {
        return $this->belongsTo(Knjiga::class, 'knjiga_id');
    }

    public function posudba(): HasMany
    {
        return $this->hasMany(Posudba::class, 'primjerak_id');
    }
}
