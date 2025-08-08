<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eligibility extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'license_title',
        'rating',
        'date_examination',
        'place_examination',
        'license_number',
        'date_validity',
        'type',

    ];
}
