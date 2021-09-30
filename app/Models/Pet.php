<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\PetAttribute;

class Pet extends Model
{
    use PetAttribute;

    protected $fillable = [
        'tid', 'name', 'birthday', 
        'price', 'status', 'description'
    ];

    protected $dates = [
        'created_at', 'updated_at', 'birthday'
    ];

    public function setTidAttribute($value) {
        $this->attributes['tid'] = now()->format('Ymd') . $value;
    }
}
