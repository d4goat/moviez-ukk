<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory, Uuid;

    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function show_time(){
        return $this->belongsTo(ShowTime::class);
    }

    public function booked_seats(){
        return $this->HasMany(BookedSeat::class);
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function promotions(){
        return $this->belongsTo(Promotion::class);
    }

}
