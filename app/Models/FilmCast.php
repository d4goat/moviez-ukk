<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmCast extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at']; 

    public function film(){
        return $this->belongsTo(Film::class);
    }
}
