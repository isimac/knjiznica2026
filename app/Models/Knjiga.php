<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Knjiga extends Model
{
    protected $table="knjiga";
    protected $fillable=['naslov', 'autor', 'isbn', 'godinaIzdanja'];

    public function primjerak(): HasMany
    {
        return $this->hasMany(Primjerak::class, 'knjiga_id');
    }
}
