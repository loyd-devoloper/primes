<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoluntaryWork extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_number',
        'address_organization',
        'name_organization',
        'from',
        'to',
        'number_hours',
        'nature_work',
        'position',
    ];
}
