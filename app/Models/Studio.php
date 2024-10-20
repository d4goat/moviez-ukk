<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at'];

    public function cinema(){
        return $this->belongsTo(Cinema::class);
    }

    public function seats(){
        return $this->hasMany(Seats::class);
    }

    public function show_times(){
        return $this->hasMany(ShowTime::class);
    }
}
