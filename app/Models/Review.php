<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory, Uuid;

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function films(){
        return $this->belongsTo(Film::class);
    }
}
