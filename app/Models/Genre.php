<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory, Uuid;

    public function films(){
        return $this->belongsToMany(Film::class, 'pivot_genre_films');
    }
}
