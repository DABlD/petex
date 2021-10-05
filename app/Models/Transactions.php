<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TransactionAttribute;

class Transactions extends Model
{
    use TransactionAttribute;

    protected $fillable = [
        'sid', 'tid', 'fname', 'lname', 'contact', 'address', 'lat', 'lng', 'price', 'status'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function setTidAttribute($value) {
        $this->attributes['tid'] = now()->format('Ymd') . $value;
    }
}
