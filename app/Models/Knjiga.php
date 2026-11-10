<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; //onaj od doli 

class Knjiga extends Model
{
    protected $table="knjiga"; //odnosi se na $table iz migracije
    protected $fillable=['naslov', 'autor', 'isbn', 'godinaIzdanja'];

    public function primjerak(): HasMany //dodati u importove
    {
        return $this->hasMany(Primjerak::class, 'knjiga_id');
    }
}
