<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracker extends Model
{
    protected $fillable = [
        'uid', 'lat', 'lng'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
