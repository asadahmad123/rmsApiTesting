<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabinBooking extends Model
{
    use HasFactory;
    protected $table = "booking";
    protected $fillable = [
        'cabin_id',
        'site_id',
        'guest_id',
        'checking',
        'checkout'

    ];
    
}
