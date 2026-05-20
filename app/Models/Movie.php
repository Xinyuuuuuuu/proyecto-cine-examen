<?php

namespace App\Models;

use Directory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    use HasFactory;

    protected $fillable =['title', 'year', 'director_id'];

    public function director():BelongsTo //1:N  1->belongTo
    {
        return $this ->belongsTo(Director::class);
    }

    public function actors():BelongsToMany //N:M belongToMany
    {
        return $this->belongsToMany(Actor::class) 
            ->withPivot('role') //atributo extra PIVOT 
            ->withTimestamps();
    }
}
