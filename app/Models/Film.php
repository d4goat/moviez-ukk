<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use Uuid;

    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at'];
    protected $appends = ['genre_film_id'];

    public function show_times()
    {
        return $this->hasMany(ShowTime::class);
    }

    public function genreFilms(){
        return $this->belongsToMany(Genre::class, 'pivot_genre_films');
    }

    public function getGenreFilmIdAttribute(){
        return $this->genreFilms->pluck('genre_film_is');
    }
}
