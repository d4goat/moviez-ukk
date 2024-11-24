<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seats extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at'];

    public function studio(){
        return $this->belongsTo(Studio::class);
    }
    
    public function booked_seat(){
        return $this->hasMany(BookedSeat::class);
    }
}
