<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabin extends Model
{
    use HasFactory;
    protected $table = "cabins";
    protected $fillable = [
        'cabin_id',
        'site_id',
    ];
}
