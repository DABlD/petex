<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $fillable = [
        'name', 'value'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
