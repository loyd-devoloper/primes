<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentApplicationEligibility extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_code',
        'education',
        'education_remarks',
        'education_status',
        'training_remarks',
        'training_status',
        'experience_remarks',
        'experience_status',
        'eligibility_remarks',
        'eligibility_status',
        'training',
        'experience',
        'eligibility',
    ];
}
