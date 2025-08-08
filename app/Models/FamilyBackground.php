<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyBackground extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_number',
        'spouse_lname',
        'spouse_fname',
        'spouse_mname',
        'spouse_extension',
        'occupation',
        'business_name',
        'business_address',
        'telephone_no',
        'father_lname',
        'father_fname',
        'father_mname',
        'father_extension',
        'mother_maiden_name',
        'mother_lname',
        'mother_fname',
        'mother_mname',
        'mother_extension',
    ];
}
