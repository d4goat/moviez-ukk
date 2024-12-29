<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at'];

    public function studios(){
        return $this->hasMany(Studio::class);
    }

    public function show_times(){
        return $this->hasManyThrough(ShowTime::class, Studio::class);
    }

}
