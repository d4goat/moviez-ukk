<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use Uuid;

    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at'];
    protected $appends = ['genre_film_id'];
    protected $with = ['casts'];

    public function show_times()
    {
        return $this->hasMany(ShowTime::class);
    }

    public function genreFilms(){
        return $this->belongsToMany(Genre::class, 'pivot_genre_films');
    }

    public function getGenreFilmIdAttribute(){
        return $this->genreFilms->pluck('id');
    }

    public function casts(){
        return $this->hasMany(FilmCast::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute(){
        return Attribute::get(fn () => $this->reviews()->avg('rating') ?? 0);
    }
}
