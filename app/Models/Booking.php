<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'name',
        'phone_number',
        'booking_date',
        'booking_time',
        'status',
    ];
}
