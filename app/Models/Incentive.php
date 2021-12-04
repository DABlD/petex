<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incentive extends Model
{
    protected $fillable = [
        'user_id', 'amount'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
