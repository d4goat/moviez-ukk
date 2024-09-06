<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowTime extends Model
{
    use HasFactory, Uuid;

    public function films(){
        return $this->belongsTo(Film::class);
    }

    public function studios(){
        return $this->belongsTo(Studio::class);
    }
}
