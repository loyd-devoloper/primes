<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_number',
        'house_no',
        'street',
        'subdivision',
        'brgy',
        'city',
        'province',
        'zipcode',
        'type',
    ];
}
