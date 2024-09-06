<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory, Uuid;

    public function seats(){
        return $this->hasMany(Seats::class);
    }

    public function show_times(){
        return $this->hasMany(ShowTime::class);
    }
}
