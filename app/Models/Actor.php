<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Actor extends Model
{
    /** @use HasFactory<\Database\Factories\ActorFactory> */
    use HasFactory;

    protected $fillable=['name', 'natioanlity'];

    public function movies():BelongsToMany //N:M
    {
        return $this->belongsToMany(Movie::class)
            ->withPivot('role') //atributo pivot en las dos
            ->withTimestamps();
    }
}
