<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory, Uuid;

    public function show_times(){
        return $this->hasMany(ShowTime::class);
    }

    public function seats(){
        return $this->hasMany(Seats::class);
    }

    public function studios (){
        return $this->hasMany(Studio::class);
    }

}
