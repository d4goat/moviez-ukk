<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedSeat extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at'];

    public function bookings (){
        return $this->belongsTo(Booking::class);
    }

    public function seats (){
        return $this->belongsTo(Seats::class);
    }
}
