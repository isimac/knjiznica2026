<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Primjerak extends Model
{
    protected $table="primjerak";
    protected $fillable=['inventarniBroj','knjiga_id'];#ionako mi nećemo ručno postavljati knjiga_id ali ćemo ga puniti preko relacija

    public function knjiga(): BelongsTo
    {
        return $this->belongsTo(Knjiga::class, "knjiga_id");#knjiga_id spaja knjiga i primjerak i zato ide 
    }

    public function posudba(): HasMany
    {
        return $this->hasMany(Posudba::class, "primjerak_id");
    }

}
