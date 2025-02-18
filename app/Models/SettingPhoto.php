<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingPhoto extends Model
{
    use HasFactory, Uuid;

    protected $fillable = [
        'setting_id',
        'image'
    ];

    public function setting(){
        return $this->belongsTo(Setting::class);
    }
}
