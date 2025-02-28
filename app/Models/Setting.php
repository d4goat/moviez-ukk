<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use Uuid;

    protected $guarded = ['id', 'uuid', 'created_at', 'updated_at'];

    public function photos(){
        return $this->hasMany(SettingPhoto::class);
    }
}
