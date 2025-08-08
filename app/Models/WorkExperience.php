<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'from',
        'to',
        'position_title',
        'company',
        'monthly_salary',
        'salary_grade',
        'salary_step',
        'status_appointment',
        'govt_services',
        'status',
    ];
}
