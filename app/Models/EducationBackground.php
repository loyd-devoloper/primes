<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'level',
        'school_name',
        'course_education',
        'from',
        'to',
        'unit_earned',
        'year_graduated',
        'academic_honor_received',
    ];
}
