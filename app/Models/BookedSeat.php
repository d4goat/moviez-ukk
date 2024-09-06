<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedSeat extends Model
{
    use HasFactory, Uuid;

    public function bookings (){
        return $this->belongsTo(Booking::class);
    }

    public function seats (){
        return $this->belongsTo(Seats::class);
    }
}
