<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Director extends Model
{
    /** @use HasFactory<\Database\Factories\DirectorFactory> */
    use HasFactory;
    
    //columnas rellenables
    protected $fillable = ['name', 'country'];

    //relacion
    public function movies(): HasMany  //1:N N->hasMany
    {
        return $this->hasMany(Movie::class); 
    }
}
